<?php
/**
 * AJAX Review submission handler
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

// reCAPTCHA v3
$recaptcha = verify_recaptcha($_POST['g-recaptcha-response'] ?? '', 'review');
if (!$recaptcha['success']) {
    json_response(['success' => false, 'error' => $recaptcha['error']], 400);
}

$cleaner_id = intval($_POST['cleaner_id'] ?? 0);
$author_name = trim($_POST['author_name'] ?? '');
$author_email = strtolower(trim($_POST['author_email'] ?? ''));
$rating = intval($_POST['rating'] ?? 0);
$title = trim($_POST['title'] ?? '');
$content = trim($_POST['content'] ?? '');

// Validate
if (!$cleaner_id) json_response(['success' => false, 'error' => 'Invalid cleaner.'], 400);
if (!$author_name) json_response(['success' => false, 'error' => 'Please enter your name.'], 400);
if (!$author_email || !filter_var($author_email, FILTER_VALIDATE_EMAIL)) json_response(['success' => false, 'error' => 'Please enter a valid email.'], 400);
if ($rating < 1 || $rating > 5) json_response(['success' => false, 'error' => 'Please select a rating (1-5 stars).'], 400);
if (!$content) json_response(['success' => false, 'error' => 'Please write your review.'], 400);

$db = get_db();

// Verify cleaner exists
$stmt = $db->prepare("SELECT c.id, c.business_name, c.email, u.email AS user_email FROM cleaners c JOIN users u ON c.user_id = u.id WHERE c.id = ?");
$stmt->execute([$cleaner_id]);
$cleaner = $stmt->fetch();
if (!$cleaner) json_response(['success' => false, 'error' => 'Cleaner not found.'], 404);

// Check for duplicate review from same email
$stmt = $db->prepare("SELECT id FROM reviews WHERE cleaner_id = ? AND author_email = ? AND created_at > DATE_SUB(NOW(), INTERVAL 30 DAY)");
$stmt->execute([$cleaner_id, $author_email]);
if ($stmt->fetch()) {
    json_response(['success' => false, 'error' => 'You have already submitted a review for this cleaner recently.'], 400);
}

$user = current_user();
$user_id = $user ? $user['id'] : null;

$stmt = $db->prepare("INSERT INTO reviews (cleaner_id, user_id, author_name, author_email, rating, title, content, status, is_verified, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', ?, NOW())");
$stmt->execute([
    $cleaner_id, $user_id, $author_name, $author_email, $rating, $title, $content,
    $user_id ? 1 : 0 // Verified if logged in
]);

$review_id = $db->lastInsertId();

// Notify cleaner
$site_url = getenv('SITE_URL') ?: 'https://cleaners-247.com';
send_email(
    $cleaner['user_email'],
    "New Review for {$cleaner['business_name']}",
    'New Review Received',
    "<p>Hi {$cleaner['business_name']},</p>
    <p><strong>{$author_name}</strong> left a {$rating}-star review for your business.</p>
    <p><em>\"" . e(truncate($content, 300)) . "\"</em></p>
    <p>The review is pending moderation. You can respond once it's approved.</p>
    <p style='text-align:center;'><a href='{$site_url}/dashboard/reviews' style='background-color:#00b894;color:#fff;padding:12px 30px;text-decoration:none;border-radius:5px;display:inline-block;'>View Reviews</a></p>"
);

log_activity('review_submitted', 'review', $review_id, "For cleaner: {$cleaner['business_name']}, Rating: {$rating}");

json_response(['success' => true, 'message' => 'Thank you for your review! It will appear after moderation.']);
