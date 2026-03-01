<?php
/**
 * Forgot Password - FindMyCleaner
 */
require_once 'includes/inc_db.php';
require_once 'includes/inc_helpers.php';
require_once 'includes/inc_auth.php';

// Redirect if already logged in
if (is_logged_in()) {
    redirect('/');
}

$page_title = 'Forgot Password | FindMyCleaner';
$page_description = 'Reset your FindMyCleaner password. Enter your email to receive a password reset link.';
$page_canonical = '/forgot-password';
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
                                <i class="ti-key display-4 text-primary"></i>
                            </div>
                            <h2 class="h4 mb-1">Forgot Your Password?</h2>
                            <p class="text-muted small">Enter your email address and we'll send you a link to reset your password.</p>
                        </div>

                        <form action="/api/handle_login.php?action=forgot" method="POST" data-ajax data-reset="true">
                            <?php echo csrf_field(); ?>

                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="you@example.com" required autofocus>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block btn-lg">
                                <i class="ti-email mr-1"></i> Send Reset Link
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
