<?php
/**
 * Customer Registration - FindMyCleaner
 */
require_once 'includes/inc_db.php';
require_once 'includes/inc_helpers.php';
require_once 'includes/inc_auth.php';

// Redirect if already logged in
if (is_logged_in()) {
    redirect('/');
}

$page_title = 'Create Account | FindMyCleaner';
$page_description = 'Create a free FindMyCleaner account to save cleaners, request quotes, and leave reviews.';
$page_canonical = '/register';
$active_page = 'register';
$page_noindex = true;
$load_recaptcha = true;
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
                            <h2 class="h4 mb-1">Create Your Account</h2>
                            <p class="text-muted small">Sign up to find and review cleaners</p>
                        </div>

                        <form action="/api/handle_register.php" method="POST" data-ajax data-recaptcha-action="register">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="role" value="customer">

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="first_name">First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="John" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Doe" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="you@example.com" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Min. 8 characters" minlength="8" required>
                            </div>

                            <div class="form-group">
                                <label for="password_confirm">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Re-enter password" minlength="8" required>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="agree_terms" name="agree_terms" value="1" required>
                                    <label class="custom-control-label" for="agree_terms">
                                        I agree to the <a href="/terms" target="_blank">Terms of Service</a> and <a href="/privacy-policy" target="_blank">Privacy Policy</a>
                                    </label>
                                </div>
                            </div>

                            <input type="hidden" name="g-recaptcha-response" id="recaptchaRegister">

                            <button type="submit" class="btn btn-primary btn-block btn-lg">
                                <i class="ti-user mr-1"></i> Create Account
                            </button>
                        </form>

                        <hr class="my-4">

                        <div class="text-center">
                            <p class="mb-2 small text-muted">Already have an account? <a href="/login">Log in here</a></p>
                            <p class="mb-0 small text-muted">Are you a cleaner? <a href="/join">List your business</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/inc_footer.php'; ?>
