<?php
/**
 * Cleaner Registration - FindMyCleaner
 */
require_once 'includes/inc_db.php';
require_once 'includes/inc_helpers.php';
require_once 'includes/inc_auth.php';
require_once 'includes/inc_recaptcha.php';
require_once 'includes/inc_schema.php';

// Redirect if already logged in
if (is_logged_in()) {
    redirect('/dashboard');
}

$db = get_db();

// Fetch categories for multi-select
$categories = $db->query("SELECT id, name FROM categories WHERE is_active = 1 ORDER BY sort_order ASC")->fetchAll();

// Fetch states for dropdown
$states = $db->query("SELECT id, name, code FROM states ORDER BY name ASC")->fetchAll();

$page_title = 'List Your Business | FindMyCleaner';
$page_description = 'Join FindMyCleaner as a cleaner. Create your free profile, get leads from homeowners, and grow your business.';
$page_canonical = '/join';
$active_page = 'join';
$load_select2 = true;
$load_recaptcha = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/inc_head.php'; ?>
    <?php echo schema_organization(); ?>
</head>
<body>
<?php include 'includes/inc_header.php'; ?>

<section class="page-header py-4">
    <div class="container">
        <h1 class="h3 mb-1">List Your Business</h1>
        <p class="mb-0 small opacity-75">Create your cleaner profile and start getting leads today</p>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <h2 class="h4 mb-1">Cleaner Registration</h2>
                            <p class="text-muted small">Fill out the form below to create your free cleaner profile</p>
                        </div>

                        <form action="/api/handle_register.php" method="POST" data-ajax data-recaptcha-action="register">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="role" value="cleaner">

                            <!-- Business Information -->
                            <h6 class="text-uppercase text-muted mb-3 mt-2"><i class="ti-briefcase mr-1"></i> Business Information</h6>

                            <div class="form-group">
                                <label for="business_name">Business Name <span class="text-danger">*</span></label>
                                <input type="text" name="business_name" id="business_name" class="form-control" placeholder="e.g., Sparkle Clean Services" required>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="email">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="you@company.com" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="phone">Phone Number <span class="text-danger">*</span></label>
                                    <input type="tel" name="phone" id="phone" class="form-control" placeholder="(555) 123-4567" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Min. 8 characters" minlength="8" required>
                                    <div class="password-strength mt-1" id="passwordStrength" style="display:none;">
                                        <div class="progress" style="height:4px;">
                                            <div class="progress-bar" id="strengthBar" role="progressbar" style="width:0%"></div>
                                        </div>
                                        <small class="text-muted" id="strengthText"></small>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="password_confirm">Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Re-enter password" minlength="8" required>
                                    <small class="text-danger" id="passwordMatch" style="display:none;">Passwords do not match</small>
                                </div>
                            </div>

                            <!-- Service Categories -->
                            <h6 class="text-uppercase text-muted mb-3 mt-4"><i class="ti-tag mr-1"></i> Service Categories</h6>

                            <div class="form-group">
                                <label for="categories">Select Your Services <span class="text-danger">*</span></label>
                                <select name="categories[]" id="categories" class="form-control select2" multiple="multiple" data-placeholder="Choose one or more categories..." required>
                                    <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>"><?php echo e($cat['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="form-text text-muted">Select all categories that apply to your business</small>
                            </div>

                            <!-- Location -->
                            <h6 class="text-uppercase text-muted mb-3 mt-4"><i class="ti-location-pin mr-1"></i> Location</h6>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="city">City <span class="text-danger">*</span></label>
                                    <input type="text" name="city" id="city" class="form-control" placeholder="Your city" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="state_id">State <span class="text-danger">*</span></label>
                                    <select name="state_id" id="state_id" class="form-control" required>
                                        <option value="">Select a state...</option>
                                        <?php foreach ($states as $st): ?>
                                        <option value="<?php echo $st['id']; ?>"><?php echo e($st['name']); ?> (<?php echo e($st['code']); ?>)</option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Terms & reCAPTCHA -->
                            <div class="form-group mt-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="agree_terms" name="agree_terms" value="1" required>
                                    <label class="custom-control-label" for="agree_terms">
                                        I agree to the <a href="/terms" target="_blank">Terms of Service</a> and <a href="/privacy-policy" target="_blank">Privacy Policy</a> <span class="text-danger">*</span>
                                    </label>
                                </div>
                            </div>

                            <input type="hidden" name="g-recaptcha-response" id="recaptchaJoin">

                            <button type="submit" class="btn btn-primary btn-block btn-lg">
                                <i class="ti-check mr-1"></i> Create My Cleaner Profile
                            </button>
                        </form>

                        <hr class="my-4">

                        <div class="text-center">
                            <p class="mb-0 small text-muted">Already have an account? <a href="/login">Log in here</a></p>
                        </div>
                    </div>
                </div>

                <!-- Benefits -->
                <div class="row mt-5">
                    <div class="col-md-4 mb-3" data-aos="fade-up">
                        <div class="card border-0 shadow-sm h-100">
                            <img src="/images/join-free.webp" alt="Cleaning business owner creating a free professional profile on laptop" width="800" height="600" class="card-img-top" style="height:180px;object-fit:cover;" loading="lazy">
                            <div class="card-body text-center">
                                <h6 class="mt-1">Free to Join</h6>
                                <p class="text-muted small mb-0">List your cleaning business at no cost. Upgrade anytime for more visibility.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3" data-aos="fade-up" data-aos-delay="100">
                        <div class="card border-0 shadow-sm h-100">
                            <img src="/images/join-leads.webp" alt="Cleaning company receiving qualified leads from homeowners" width="800" height="600" class="card-img-top" style="height:180px;object-fit:cover;" loading="lazy">
                            <div class="card-body text-center">
                                <h6 class="mt-1">Get Cleaning Leads</h6>
                                <p class="text-muted small mb-0">Homeowners search for cleaning services like yours every day.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3" data-aos="fade-up" data-aos-delay="200">
                        <div class="card border-0 shadow-sm h-100">
                            <img src="/images/join-grow.webp" alt="Successful cleaning business owner standing in front of growing company" width="800" height="600" class="card-img-top" style="height:180px;object-fit:cover;" loading="lazy">
                            <div class="card-body text-center">
                                <h6 class="mt-1">Grow Your Cleaning Company</h6>
                                <p class="text-muted small mb-0">Build your reputation with verified reviews and showcase your cleaning services.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
echo schema_breadcrumb([
    ['name' => 'Home', 'url' => 'https://cleaners-247.com/'],
    ['name' => 'List Your Business', 'url' => 'https://cleaners-247.com/join']
]);
?>

<?php
$extra_js = [];
?>
<?php include 'includes/inc_footer.php'; ?>

<script>
(function() {
    var pw = document.getElementById('password');
    var pw2 = document.getElementById('password_confirm');
    var bar = document.getElementById('strengthBar');
    var text = document.getElementById('strengthText');
    var wrap = document.getElementById('passwordStrength');
    var match = document.getElementById('passwordMatch');

    pw.addEventListener('input', function() {
        var val = this.value;
        if (!val) { wrap.style.display = 'none'; return; }
        wrap.style.display = 'block';

        var score = 0;
        if (val.length >= 8) score++;
        if (val.length >= 12) score++;
        if (/[a-z]/.test(val) && /[A-Z]/.test(val)) score++;
        if (/\d/.test(val)) score++;
        if (/[^a-zA-Z0-9]/.test(val)) score++;

        var levels = [
            { w: '20%', c: 'bg-danger', t: 'Weak' },
            { w: '40%', c: 'bg-warning', t: 'Fair' },
            { w: '60%', c: 'bg-info', t: 'Good' },
            { w: '80%', c: 'bg-primary', t: 'Strong' },
            { w: '100%', c: 'bg-success', t: 'Very Strong' }
        ];
        var lvl = levels[Math.min(score, 4)];
        bar.style.width = lvl.w;
        bar.className = 'progress-bar ' + lvl.c;
        text.textContent = lvl.t;
    });

    pw2.addEventListener('input', function() {
        if (this.value && this.value !== pw.value) {
            match.style.display = 'block';
            this.classList.add('is-invalid');
        } else {
            match.style.display = 'none';
            this.classList.remove('is-invalid');
        }
    });
})();
</script>
