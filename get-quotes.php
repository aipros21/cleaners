<?php
/**
 * Get Free Quotes - Multi-step Lead Form
 * URL: /get-quotes/ or /get-quotes/{category}/
 */
require_once 'includes/inc_db.php';
require_once 'includes/inc_helpers.php';
require_once 'includes/inc_schema.php';

$db = get_db();

// Fetch all active categories for the form dropdown
$categories = $db->query("SELECT * FROM categories WHERE is_active = 1 ORDER BY sort_order ASC")->fetchAll();

// Check if category slug is in URL and pre-select it
$category_slug = $_GET['category'] ?? '';
$selected_category = null;
if ($category_slug) {
    $stmt = $db->prepare("SELECT * FROM categories WHERE slug = ? AND is_active = 1");
    $stmt->execute([$category_slug]);
    $selected_category = $stmt->fetch();
}

// SEO variables
$cat_label = $selected_category ? e($selected_category['name']) . ' ' : '';
$page_title = 'Get Free ' . $cat_label . 'Quotes | FindMyCleaner';
$page_description = 'Get free quotes from top-rated ' . ($selected_category ? strtolower($selected_category['name']) : '') . ' cleaning services near you. Compare prices, read reviews, and hire the best cleaner for your needs.';
$page_keywords = 'get quotes, free cleaning quotes, ' . ($selected_category ? strtolower($selected_category['name']) . ' quotes, ' : '') . 'cleaning service estimates, house cleaning quotes';
$page_canonical = '/get-quotes' . ($selected_category ? '/' . $selected_category['slug'] : '');
$active_page = 'cleaners';
$load_recaptcha = true;

// Breadcrumbs
$breadcrumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Get Quotes', 'url' => '/get-quotes']
];
if ($selected_category) {
    $breadcrumbs[] = ['name' => $selected_category['name'], 'url' => ''];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/inc_head.php'; ?>
    <?php echo schema_breadcrumb($breadcrumbs); ?>
    <?php echo schema_organization(); ?>
</head>
<body>
<?php include 'includes/inc_header.php'; ?>

<!-- Page Header -->
<section class="page-header py-4">
    <div class="container">
        <?php echo render_breadcrumbs($breadcrumbs); ?>
        <h1 class="h3 mb-1">Get Free <?php echo $cat_label; ?>Quotes</h1>
        <p class="mb-0 small opacity-75">Tell us about your cleaning needs and get matched with top-rated cleaning services in minutes.</p>
    </div>
</section>

<!-- Multi-step Form -->
<section class="section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <!-- Progress Bar -->
                <div class="step-progress mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="step-indicator active" data-step="1"><span class="step-number-sm">1</span> Service</span>
                        <span class="step-indicator" data-step="2"><span class="step-number-sm">2</span> Details</span>
                        <span class="step-indicator" data-step="3"><span class="step-number-sm">3</span> Contact</span>
                    </div>
                    <div class="progress" style="height:6px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width:33.3%;" aria-valuenow="33.3" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <form action="/api/handle_lead.php" method="POST" data-ajax data-recaptcha-action="get_quote">

                    <!-- Step 1: Service Category -->
                    <div class="form-step" data-step="1">
                        <div class="card shadow-sm">
                            <div class="card-body p-4">
                                <h4 class="card-title mb-4"><i class="ti-briefcase text-primary mr-2"></i> What service do you need?</h4>

                                <div class="form-group">
                                    <label for="category_id">Service Category <span class="text-danger">*</span></label>
                                    <select name="category_id" id="category_id" class="form-control" required>
                                        <option value="">-- Select a category --</option>
                                        <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo e($cat['id']); ?>"<?php echo ($selected_category && $selected_category['id'] == $cat['id']) ? ' selected' : ''; ?>><?php echo e($cat['name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Property Type <span class="text-danger">*</span></label>
                                    <div class="d-flex flex-wrap">
                                        <div class="custom-control custom-radio mr-4 mb-2">
                                            <input type="radio" id="prop_residential" name="property_type" value="residential" class="custom-control-input" checked required>
                                            <label class="custom-control-label" for="prop_residential">Residential</label>
                                        </div>
                                        <div class="custom-control custom-radio mr-4 mb-2">
                                            <input type="radio" id="prop_commercial" name="property_type" value="commercial" class="custom-control-input">
                                            <label class="custom-control-label" for="prop_commercial">Commercial</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-2">
                                            <input type="radio" id="prop_both" name="property_type" value="both" class="custom-control-input">
                                            <label class="custom-control-label" for="prop_both">Both</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right mt-4">
                                    <button type="button" class="btn btn-primary px-4 step-next">Next <i class="ti-arrow-right ml-1"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Project Details -->
                    <div class="form-step" data-step="2" style="display:none;">
                        <div class="card shadow-sm">
                            <div class="card-body p-4">
                                <h4 class="card-title mb-4"><i class="ti-clipboard text-primary mr-2"></i> Tell us about your cleaning needs</h4>

                                <div class="form-group">
                                    <label for="description">Describe Your Cleaning Needs <span class="text-danger">*</span></label>
                                    <textarea name="project_description" id="project_description" class="form-control" rows="4" placeholder="Describe the cleaning you need, property size, number of rooms, any special requirements, preferred schedule, etc." required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="budget">Budget Range <span class="text-danger">*</span></label>
                                    <select name="budget_range" id="budget_range" class="form-control" required>
                                        <option value="">-- Select your budget --</option>
                                        <option value="under_100">Under $100</option>
                                        <option value="100_250">$100 - $250</option>
                                        <option value="250_500">$250 - $500</option>
                                        <option value="500_1000">$500 - $1,000</option>
                                        <option value="1000_2500">$1,000 - $2,500</option>
                                        <option value="2500_plus">$2,500+</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="urgency">How soon do you need this done? <span class="text-danger">*</span></label>
                                    <select name="urgency" id="urgency" class="form-control" required>
                                        <option value="">-- Select urgency --</option>
                                        <option value="asap">ASAP</option>
                                        <option value="within_week">Within a week</option>
                                        <option value="within_month">Within a month</option>
                                        <option value="flexible">Flexible</option>
                                    </select>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-outline-secondary px-4 step-prev"><i class="ti-arrow-left mr-1"></i> Back</button>
                                    <button type="button" class="btn btn-primary px-4 step-next">Next <i class="ti-arrow-right ml-1"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Contact Information -->
                    <div class="form-step" data-step="3" style="display:none;">
                        <div class="card shadow-sm">
                            <div class="card-body p-4">
                                <h4 class="card-title mb-4"><i class="ti-user text-primary mr-2"></i> Your Contact Information</h4>

                                <div class="form-group">
                                    <label for="customer_name">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="John Doe" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="customer_email">Email Address <span class="text-danger">*</span></label>
                                            <input type="email" name="customer_email" id="customer_email" class="form-control" placeholder="john@example.com" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="customer_phone">Phone Number <span class="text-danger">*</span></label>
                                            <input type="tel" name="customer_phone" id="customer_phone" class="form-control" placeholder="(555) 123-4567" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="state">City / State <span class="text-danger">*</span></label>
                                            <input type="text" name="state" id="state" class="form-control" placeholder="Miami, FL" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="zip_code">ZIP Code <span class="text-danger">*</span></label>
                                            <input type="text" name="zip_code" id="zip_code" class="form-control" placeholder="33101" maxlength="10" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Honeypot - hidden from real users -->
                                <div style="position:absolute;left:-9999px;" aria-hidden="true">
                                    <label for="website">Website</label>
                                    <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
                                </div>

                                <input type="hidden" name="g-recaptcha-response" id="recaptchaQuote">

                                <!-- CSRF Token -->
                                <?php echo csrf_field(); ?>

                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-outline-secondary px-4 step-prev"><i class="ti-arrow-left mr-1"></i> Back</button>
                                    <button type="submit" class="btn btn-success btn-lg px-5"><i class="ti-check mr-1"></i> Get Free Quotes</button>
                                </div>

                                <p class="text-muted small mt-3 mb-0">
                                    <i class="ti-lock mr-1"></i> Your information is secure and will only be shared with matched cleaners.
                                    By submitting, you agree to our <a href="/terms">Terms of Service</a> and <a href="/privacy-policy">Privacy Policy</a>.
                                </p>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>

<!-- Trust Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                <img src="/images/get-quotes-hero.webp" alt="Homeowner reviewing cleaning service quotes on a tablet at a kitchen table" width="800" height="600" class="img-fluid rounded shadow" loading="lazy">
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <h3 class="mb-3">Why Get Quotes Through Us?</h3>
                <p class="text-muted">We connect you with pre-screened, verified cleaning professionals who compete for your business. That means better prices, better service, and peace of mind.</p>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="ti-check text-success mr-2"></i> 100% free, no obligation</li>
                    <li class="mb-2"><i class="ti-check text-success mr-2"></i> Matched within hours, not days</li>
                    <li class="mb-2"><i class="ti-check text-success mr-2"></i> Only verified professionals</li>
                    <li class="mb-2"><i class="ti-check text-success mr-2"></i> Real reviews from real customers</li>
                </ul>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-md-3 col-6 mb-4" data-aos="fade-up">
                <div class="trust-badge">
                    <i class="ti-shield text-primary"></i>
                    <h5>Verified Pros</h5>
                    <p class="text-muted small">Every cleaning company is screened and verified before listing</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="trust-badge">
                    <i class="ti-money text-primary"></i>
                    <h5>100% Free</h5>
                    <p class="text-muted small">No cost, no obligation. Get quotes from multiple cleaning services</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="trust-badge">
                    <i class="ti-timer text-primary"></i>
                    <h5>Fast Matching</h5>
                    <p class="text-muted small">Get matched with cleaning pros within hours, not days</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="trust-badge">
                    <i class="ti-thumb-up text-primary"></i>
                    <h5>Trusted Reviews</h5>
                    <p class="text-muted small">Read real reviews from homeowners before you hire</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/inc_footer.php'; ?>
