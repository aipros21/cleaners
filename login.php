<?php
/**
 * Login Page - FindMyCleaner
 */
require_once 'includes/inc_db.php';
require_once 'includes/inc_helpers.php';
require_once 'includes/inc_auth.php';

// Redirect if already logged in
if (is_logged_in()) {
    $user = current_user();
    redirect($user['role'] === 'cleaner' ? '/dashboard' : '/');
}

$page_title = 'Login | FindMyCleaner';
$page_description = 'Log in to your FindMyCleaner account to manage your profile, view leads, and connect with homeowners.';
$page_canonical = '/login';
$active_page = 'login';
$page_noindex = true;
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
                            <h2 class="h4 mb-1">Welcome Back</h2>
                            <p class="text-muted small">Log in to your account</p>
                        </div>

                        <form action="/api/handle_login.php" method="POST" data-ajax>
                            <?php echo csrf_field(); ?>

                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="you@example.com" required autofocus>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Your password" required>
                            </div>

                            <div class="form-group d-flex justify-content-between align-items-center">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="remember" name="remember" value="1">
                                    <label class="custom-control-label" for="remember">Remember me</label>
                                </div>
                                <a href="/forgot-password" class="small">Forgot password?</a>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block btn-lg">
                                <i class="ti-lock mr-1"></i> Log In
                            </button>
                        </form>

                        <hr class="my-4">

                        <div class="text-center">
                            <p class="mb-2">Don't have an account?</p>
                            <a href="/join" class="btn btn-outline-primary btn-sm mr-2">Join as Cleaner</a>
                            <a href="/register" class="btn btn-outline-secondary btn-sm">Register as Customer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/inc_footer.php'; ?>
