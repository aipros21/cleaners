<?php
/**
 * AJAX Login, Logout, Forgot Password, Reset Password handler
 */
require_once dirname(__DIR__) . '/includes/inc_db.php';
require_once dirname(__DIR__) . '/includes/inc_auth.php';
require_once dirname(__DIR__) . '/includes/inc_helpers.php';
require_once dirname(__DIR__) . '/includes/inc_mailgun.php';

header('Content-Type: application/json');

// Logout
if (isset($_GET['logout'])) {
    logout_user();
    header('Location: /');
    exit;
}

$action = $_GET['action'] ?? $_POST['action'] ?? 'login';

// ========== LOGIN ==========
if ($action === 'login') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        json_response(['success' => false, 'error' => 'Please enter email and password.'], 400);
    }

    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        json_response(['success' => false, 'error' => 'Invalid session. Please refresh and try again.'], 403);
    }

    // Rate limiting: max 5 failed attempts per IP per 15 minutes
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    $db = get_db();
    $stmt = $db->prepare("SELECT COUNT(*) FROM activity_log WHERE ip_address = ? AND action = 'login_failed' AND created_at > DATE_SUB(NOW(), INTERVAL 15 MINUTE)");
    $stmt->execute([$ip]);
    if ((int)$stmt->fetchColumn() >= 5) {
        json_response(['success' => false, 'error' => 'Too many failed attempts. Please try again in 15 minutes.'], 429);
    }

    $result = login_user($email, $password);

    if ($result['success']) {
        log_activity('login', 'user', $_SESSION['user_id']);
    } else {
        log_activity('login_failed', null, null, "Email: {$email}");
    }

    json_response($result);
}

// ========== FORGOT PASSWORD ==========
if ($action === 'forgot') {
    $email = strtolower(trim($_POST['email'] ?? ''));

    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        json_response(['success' => false, 'error' => 'Please enter a valid email.'], 400);
    }

    $db = get_db();
    $stmt = $db->prepare("SELECT id, first_name FROM users WHERE email = ? AND status = 'active'");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Always show success to prevent email enumeration
    if ($user) {
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $db->prepare("UPDATE users SET reset_token = ?, reset_expires = ? WHERE id = ?")->execute([$token, $expires, $user['id']]);

        $site_url = getenv('SITE_URL') ?: 'https://cleaners-247.com';
        $reset_link = $site_url . '/reset-password?token=' . $token;
        $name = $user['first_name'] ?: 'there';

        send_email(
            $email,
            'Reset Your Password - FindMyCleaner',
            'Password Reset',
            "<p>Hi {$name},</p>
            <p>We received a request to reset your password. Click the button below to set a new password:</p>
            <p style='text-align:center;margin:25px 0;'>
                <a href='{$reset_link}' style='background-color:#00b894;color:#fff;padding:12px 30px;text-decoration:none;border-radius:5px;display:inline-block;'>Reset Password</a>
            </p>
            <p class='small' style='color:#757575;'>This link expires in 1 hour. If you didn't request this, ignore this email.</p>"
        );

        log_activity('password_reset_request', 'user', $user['id']);
    }

    json_response(['success' => true, 'message' => 'If an account exists with that email, you will receive a password reset link.']);
}

// ========== RESET PASSWORD ==========
if ($action === 'reset') {
    $token = $_POST['token'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['password_confirm'] ?? '';

    if (!$token) {
        json_response(['success' => false, 'error' => 'Invalid reset link.'], 400);
    }

    if (strlen($password) < 8) {
        json_response(['success' => false, 'error' => 'Password must be at least 8 characters.'], 400);
    }

    if ($password !== $confirm) {
        json_response(['success' => false, 'error' => 'Passwords do not match.'], 400);
    }

    $db = get_db();
    $stmt = $db->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_expires > NOW() AND status = 'active'");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if (!$user) {
        json_response(['success' => false, 'error' => 'Invalid or expired reset link. Please request a new one.'], 400);
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $db->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?")->execute([$hash, $user['id']]);

    log_activity('password_reset', 'user', $user['id']);

    json_response(['success' => true, 'message' => 'Password updated successfully.', 'redirect' => '/login']);
}

// ========== VERIFY EMAIL ==========
if ($action === 'verify_email') {
    $token = $_GET['token'] ?? '';
    if (!$token) {
        header('Location: /login?error=invalid_token');
        exit;
    }

    $db = get_db();
    $stmt = $db->prepare("SELECT id, email FROM users WHERE email_token = ? AND email_verified = 0");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        $db->prepare("UPDATE users SET email_verified = 1, email_token = NULL WHERE id = ?")->execute([$user['id']]);
        log_activity('email_verified', 'user', $user['id']);
        header('Location: /login?verified=1');
    } else {
        header('Location: /login?error=invalid_token');
    }
    exit;
}

json_response(['success' => false, 'error' => 'Invalid action.'], 400);
