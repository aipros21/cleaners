<?php
/**
 * AJAX Lead submission handler
 * Saves lead, auto-assigns to matching cleaners, sends notifications
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
    json_response(['success' => false, 'error' => 'Invalid session. Please refresh.'], 403);
}

// Honeypot
if (!empty($_POST['website'])) {
    json_response(['success' => true, 'message' => 'Thank you! We will match you with cleaners shortly.']);
}

// reCAPTCHA v3
$recaptcha = verify_recaptcha($_POST['g-recaptcha-response'] ?? '', 'get_quote');
if (!$recaptcha['success']) {
    json_response(['success' => false, 'error' => $recaptcha['error']], 400);
}

// Validate required fields
$name = trim($_POST['customer_name'] ?? '');
$email = strtolower(trim($_POST['customer_email'] ?? ''));
$phone = preg_replace('/[^0-9]/', '', $_POST['customer_phone'] ?? '');
$category_id = intval($_POST['category_id'] ?? 0);
$description = trim($_POST['project_description'] ?? '');
$budget = $_POST['budget_range'] ?? '';
$urgency = $_POST['urgency'] ?? 'flexible';
$property_type = $_POST['property_type'] ?? '';
$zip_code = trim($_POST['zip_code'] ?? '');

if (!$name || !$email || !$phone) {
    json_response(['success' => false, 'error' => 'Please fill in your name, email, and phone number.'], 400);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    json_response(['success' => false, 'error' => 'Please enter a valid email address.'], 400);
}

if (!$category_id) {
    json_response(['success' => false, 'error' => 'Please select a service category.'], 400);
}

$db = get_db();

// Verify category exists
$stmt = $db->prepare("SELECT id, name, lead_price FROM categories WHERE id = ?");
$stmt->execute([$category_id]);
$category = $stmt->fetch();
if (!$category) {
    json_response(['success' => false, 'error' => 'Invalid category.'], 400);
}

// Resolve state from ZIP or input
$state_id = null;
$city_id = null;
if (!empty($_POST['state'])) {
    $stmt = $db->prepare("SELECT id FROM states WHERE code = ? OR slug = ?");
    $stmt->execute([$_POST['state'], $_POST['state']]);
    $row = $stmt->fetch();
    if ($row) $state_id = $row['id'];
}

// Insert lead
$stmt = $db->prepare("INSERT INTO leads (category_id, customer_name, customer_email, customer_phone, city_id, state_id, zip_code, project_description, budget_range, urgency, property_type, ip_address, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
$stmt->execute([
    $category_id, $name, $email, $phone, $city_id, $state_id, $zip_code,
    $description, $budget, $urgency, $property_type,
    $_SERVER['REMOTE_ADDR'] ?? ''
]);

$lead_id = $db->lastInsertId();

// ========== Auto-assign to matching cleaners ==========
$match_sql = "SELECT DISTINCT c.id, c.business_name, c.email, c.plan, u.email AS user_email
    FROM cleaners c
    JOIN cleaner_categories cc ON c.id = cc.cleaner_id
    JOIN users u ON c.user_id = u.id
    WHERE cc.category_id = ? AND c.status = 'active'";
$match_params = [$category_id];

if ($state_id) {
    $match_sql .= " AND (c.state_id = ? OR c.state_id IS NULL)";
    $match_params[] = $state_id;
}

$match_sql .= " ORDER BY c.plan DESC, c.avg_rating DESC LIMIT 5";

$stmt = $db->prepare($match_sql);
$stmt->execute($match_params);
$matches = $stmt->fetchAll();

$lead_price = $category['lead_price'];
$assignments = 0;

foreach ($matches as $cleaner) {
    // Assign lead
    $stmt = $db->prepare("INSERT INTO lead_assignments (lead_id, cleaner_id, price, status) VALUES (?, ?, ?, 'sent')");
    $stmt->execute([$lead_id, $cleaner['id'], $lead_price]);

    // Update cleaner lead count
    $db->prepare("UPDATE cleaners SET leads_received = leads_received + 1 WHERE id = ?")->execute([$cleaner['id']]);

    // Send notification email to cleaner
    $site_url = getenv('SITE_URL') ?: 'https://cleaners-247.com';
    send_email(
        $cleaner['user_email'],
        "New Lead: {$category['name']} Project",
        'New Lead Available',
        "<p>Hi {$cleaner['business_name']},</p>
        <p>A homeowner is looking for <strong>{$category['name']}</strong> services in your area.</p>
        <table style='width:100%;border-collapse:collapse;margin:15px 0;'>
            <tr><td style='padding:8px;border-bottom:1px solid #eee;color:#757575;width:120px;'>Project:</td><td style='padding:8px;border-bottom:1px solid #eee;'>" . e(truncate($description, 200)) . "</td></tr>
            <tr><td style='padding:8px;border-bottom:1px solid #eee;color:#757575;'>Budget:</td><td style='padding:8px;border-bottom:1px solid #eee;'>{$budget}</td></tr>
            <tr><td style='padding:8px;border-bottom:1px solid #eee;color:#757575;'>Urgency:</td><td style='padding:8px;border-bottom:1px solid #eee;'>{$urgency}</td></tr>
        </table>
        <p style='text-align:center;'><a href='{$site_url}/dashboard/leads' style='background-color:#00b894;color:#fff;padding:12px 30px;text-decoration:none;border-radius:5px;display:inline-block;'>View Lead Details</a></p>"
    );

    $assignments++;
}

// Send confirmation email to customer
send_email(
    $email,
    'Your Quote Request Has Been Received - FindMyCleaner',
    'Quote Request Received!',
    "<p>Hi {$name},</p>
    <p>Thank you for your request! We've matched your <strong>{$category['name']}</strong> project with <strong>{$assignments}</strong> qualified cleaner" . ($assignments !== 1 ? 's' : '') . " in your area.</p>
    <p>You should hear from them within 24-48 hours. They may contact you by phone or email to discuss your project.</p>
    <p><strong>What's next?</strong></p>
    <ul>
        <li>Compare quotes and credentials from each cleaner</li>
        <li>Check their reviews and photos on their profiles</li>
        <li>Ask about licensing, insurance, and warranties</li>
    </ul>"
);

// Notify admin
$admin_email = getenv('MAILGUN_NOTIFY_EMAIL') ?: 'rogomez@gmail.com';
send_email($admin_email, "New Lead #{$lead_id}: {$category['name']}", 'New Lead', "<p>Lead #{$lead_id} from {$name} ({$email})</p><p>Category: {$category['name']}<br>Budget: {$budget}<br>Assigned to {$assignments} cleaners</p>");

log_activity('lead_submitted', 'lead', $lead_id, "Category: {$category['name']}, Assigned: {$assignments}");

json_response([
    'success' => true,
    'message' => "Thank you! We've matched your project with {$assignments} qualified cleaner" . ($assignments !== 1 ? 's' : '') . ". You'll hear from them within 24-48 hours."
]);
