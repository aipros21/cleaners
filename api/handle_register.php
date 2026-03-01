<?php
/**
 * AJAX Registration handler (Customer + Cleaner)
 */
require_once dirname(__DIR__) . '/includes/inc_db.php';
require_once dirname(__DIR__) . '/includes/inc_auth.php';
require_once dirname(__DIR__) . '/includes/inc_helpers.php';
require_once dirname(__DIR__) . '/includes/inc_recaptcha.php';
require_once dirname(__DIR__) . '/includes/inc_mailgun.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['success' => false, 'error' => 'Invalid request.'], 405);
}

if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response(['success' => false, 'error' => 'Invalid session. Please refresh and try again.'], 403);
}

// Honeypot
if (!empty($_POST['website'])) {
    json_response(['success' => true, 'redirect' => '/']); // Silent reject
}

// reCAPTCHA v3
$recaptcha = verify_recaptcha($_POST['g-recaptcha-response'] ?? '', 'register');
if (!$recaptcha['success']) {
    json_response(['success' => false, 'error' => $recaptcha['error']], 400);
}

$role = $_POST['role'] ?? 'customer';
$email = strtolower(trim($_POST['email'] ?? ''));
$password = $_POST['password'] ?? '';
$confirm = $_POST['password_confirm'] ?? '';

// Validation
if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    json_response(['success' => false, 'error' => 'Please enter a valid email address.'], 400);
}
if (strlen($password) < 8) {
    json_response(['success' => false, 'error' => 'Password must be at least 8 characters.'], 400);
}
if ($password !== $confirm) {
    json_response(['success' => false, 'error' => 'Passwords do not match.'], 400);
}

$data = [
    'email' => $email,
    'password' => $password,
    'role' => in_array($role, ['customer', 'cleaner']) ? $role : 'customer',
    'first_name' => trim($_POST['first_name'] ?? ''),
    'last_name' => trim($_POST['last_name'] ?? ''),
    'phone' => preg_replace('/[^0-9]/', '', $_POST['phone'] ?? '')
];

$result = register_user($data);

if (!$result['success']) {
    json_response($result, 400);
}

$user_id = $result['user_id'];
$db = get_db();

// ========== Create cleaner profile if applicable ==========
if ($role === 'cleaner') {
    $business_name = trim($_POST['business_name'] ?? '');
    if (!$business_name) {
        json_response(['success' => false, 'error' => 'Please enter your business name.'], 400);
    }

    $slug = slugify($business_name);

    // Ensure unique slug
    $stmt = $db->prepare("SELECT id FROM cleaners WHERE slug = ?");
    $stmt->execute([$slug]);
    if ($stmt->fetch()) {
        $slug .= '-' . substr(uniqid(), -4);
    }

    // Resolve state
    $state_id = null;
    if (!empty($_POST['state'])) {
        $stmt = $db->prepare("SELECT id FROM states WHERE code = ? OR slug = ?");
        $stmt->execute([$_POST['state'], $_POST['state']]);
        $row = $stmt->fetch();
        if ($row) $state_id = $row['id'];
    }

    // Resolve city
    $city_id = null;
    if (!empty($_POST['city']) && $state_id) {
        $stmt = $db->prepare("SELECT id FROM cities WHERE (slug = ? OR name = ?) AND state_id = ?");
        $stmt->execute([slugify($_POST['city']), $_POST['city'], $state_id]);
        $row = $stmt->fetch();
        if ($row) $city_id = $row['id'];
    }

    $stmt = $db->prepare("INSERT INTO cleaners (user_id, business_name, slug, phone, email, state_id, city_id, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', NOW())");
    $stmt->execute([
        $user_id,
        $business_name,
        $slug,
        $data['phone'],
        $email,
        $state_id,
        $city_id
    ]);

    $cleaner_id = $db->lastInsertId();

    // Assign categories
    if (!empty($_POST['categories'])) {
        $cat_ids = is_array($_POST['categories']) ? $_POST['categories'] : [$_POST['categories']];
        $insert = $db->prepare("INSERT IGNORE INTO cleaner_categories (cleaner_id, category_id) VALUES (?, ?)");
        foreach ($cat_ids as $cat_id) {
            if (is_numeric($cat_id)) {
                $insert->execute([$cleaner_id, intval($cat_id)]);
            }
        }
    }

    log_activity('cleaner_registered', 'cleaner', $cleaner_id, "Business: $business_name");
}

// Auto-login
$_SESSION['user_id'] = $user_id;
$_SESSION['user_role'] = $role;

// Send welcome email with verification link
$name = $data['first_name'] ?: 'there';
$site_url = getenv('SITE_URL') ?: 'https://cleaners-247.com';
$verify_link = $site_url . '/api/handle_login.php?action=verify_email&token=' . urlencode($result['email_token']);

send_email(
    $email,
    'Welcome to FindMyCleaner - Please Verify Your Email',
    'Welcome!',
    "<p>Hi {$name},</p>
    <p>Thanks for joining FindMyCleaner!</p>
    <p style='text-align:center;margin:20px 0;'><a href='{$verify_link}' style='background-color:#00b894;color:#fff;padding:12px 30px;text-decoration:none;border-radius:5px;display:inline-block;'>Verify Your Email</a></p>
    <p>" .
    ($role === 'cleaner'
        ? "Your cleaner profile is being reviewed and will be active shortly. In the meantime, you can complete your profile from your <a href='{$site_url}/dashboard'>dashboard</a>."
        : "You can now <a href='{$site_url}/get-quotes'>request free quotes</a> from top-rated cleaners in your area."
    ) . "</p>"
);

// Notify admin
$admin_email = getenv('MAILGUN_NOTIFY_EMAIL') ?: 'rogomez@gmail.com';
send_email($admin_email, "New {$role} registered: {$email}", 'New Registration', "<p>A new {$role} has registered: <strong>{$email}</strong></p>" . ($role === 'cleaner' ? "<p>Business: {$business_name}</p>" : ''));

$redirect = $role === 'cleaner' ? '/dashboard' : '/';
json_response(['success' => true, 'redirect' => $redirect]);
