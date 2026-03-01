<?php
/**
 * AJAX Contact form and newsletter handler
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

// CSRF verification (skip for newsletter which may not have a session)
$type = $_POST['type'] ?? 'contact';
if ($type === 'contact' && !verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response(['success' => false, 'error' => 'Invalid session. Please refresh and try again.'], 403);
}

// ========== NEWSLETTER ==========
if ($type === 'newsletter') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        json_response(['success' => false, 'error' => 'Invalid email.'], 400);
    }

    log_activity('newsletter_subscribe', null, null, $email);

    // Send confirmation
    send_email(
        $email,
        'Welcome to FindMyCleaner Newsletter',
        'Thanks for Subscribing!',
        "<p>You've been subscribed to our home improvement tips and cleaner guides newsletter.</p><p>Stay tuned for helpful content!</p>"
    );

    json_response(['success' => true, 'message' => 'Thanks for subscribing!']);
}

// ========== CONTACT FORM ==========
$name = trim($_POST['name'] ?? '');
$email = strtolower(trim($_POST['email'] ?? ''));
$subject = trim($_POST['subject'] ?? 'Contact Form Message');
$message = trim($_POST['message'] ?? '');

if (!$name || !$email || !$message) {
    json_response(['success' => false, 'error' => 'Please fill in all required fields.'], 400);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    json_response(['success' => false, 'error' => 'Please enter a valid email.'], 400);
}

// reCAPTCHA v3
$recaptcha = verify_recaptcha($_POST['g-recaptcha-response'] ?? '', 'contact');
if (!$recaptcha['success']) {
    json_response(['success' => false, 'error' => $recaptcha['error']], 400);
}

$admin_email = getenv('MAILGUN_NOTIFY_EMAIL') ?: 'rogomez@gmail.com';

$result = send_email(
    $admin_email,
    "Contact Form: {$subject}",
    'New Contact Message',
    "<table style='width:100%;'>
        <tr><td style='padding:8px;color:#757575;width:100px;'>From:</td><td style='padding:8px;'>" . e($name) . "</td></tr>
        <tr><td style='padding:8px;color:#757575;'>Email:</td><td style='padding:8px;'><a href='mailto:" . e($email) . "'>" . e($email) . "</a></td></tr>
        <tr><td style='padding:8px;color:#757575;'>Subject:</td><td style='padding:8px;'>" . e($subject) . "</td></tr>
        <tr><td style='padding:8px;color:#757575;vertical-align:top;'>Message:</td><td style='padding:8px;'>" . nl2br(e($message)) . "</td></tr>
    </table>",
    $email
);

log_activity('contact_form', null, null, "From: {$name} ({$email})");

json_response(['success' => true, 'message' => 'Thank you! Your message has been sent. We\'ll get back to you within 24 hours.']);
