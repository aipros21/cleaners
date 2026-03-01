<?php
/**
 * Reset Password - FindMyCleaner
 */
require_once 'includes/inc_db.php';
require_once 'includes/inc_helpers.php';
require_once 'includes/inc_auth.php';

// Redirect if already logged in
if (is_logged_in()) {
    redirect('/');
}

$token = trim($_GET['token'] ?? '');

// Validate token exists and is valid in database
if (empty($token)) {
    redirect('/forgot-password');
}

$db = get_db();
$stmt = $db->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_expires > NOW() AND status = 'active'");
$stmt->execute([$token]);
if (!$stmt->fetch()) {
    redirect('/forgot-password?error=expired');
}

$page_title = 'Reset Password | FindMyCleaner';
$page_description = 'Set a new password for your FindMyCleaner account.';
$page_canonical = '/reset-password';
$active_page = '';
$load_recaptcha = false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/inc_head.php'; ?>
</head>
<body>
<?php include 'includes/inc_header.php'; ?>

<section class="section-padding bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <div class="mb-3">
                                <i class="ti-lock display-4 text-primary"></i>
                            </div>
                            <h2 class="h4 mb-1">Reset Your Password</h2>
                            <p class="text-muted small">Enter your new password below.</p>
                        </div>

                        <form action="/api/handle_login.php?action=reset" method="POST" data-ajax>
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="token" value="<?php echo e($token); ?>">

                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Min. 8 characters" minlength="8" required autofocus>
                            </div>

                            <div class="form-group">
                                <label for="password_confirm">Confirm New Password</label>
                                <input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Re-enter new password" minlength="8" required>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block btn-lg">
                                <i class="ti-check mr-1"></i> Reset Password
                            </button>
                        </form>

                        <hr class="my-4">

                        <div class="text-center">
                            <p class="mb-0 small text-muted">
                                <a href="/login"><i class="ti-arrow-left mr-1"></i> Back to Login</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/inc_footer.php'; ?>
