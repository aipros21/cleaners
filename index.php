<?php
/**
 * Homepage - FindMyCleaner
 */
require_once 'includes/inc_db.php';
require_once 'includes/inc_helpers.php';
require_once 'includes/inc_schema.php';

$page_title = 'FindMyCleaner - Find Trusted Local Cleaners Near You';
$page_description = 'Find top-rated local cleaning professionals for house cleaning, commercial cleaning, carpet cleaning, pressure washing, and more. Get free quotes from verified cleaners near you.';
$page_keywords = 'cleaners near me, find cleaners, cleaning services, get quotes, house cleaning, commercial cleaning, carpet cleaning, pressure washing, window cleaning';
$page_canonical = '/';
$active_page = 'home';
$load_slick = true;

// Fetch categories
$categories = get_db()->query("SELECT * FROM categories WHERE is_active = 1 ORDER BY sort_order ASC")->fetchAll();

// Fetch featured cleaners
$featured = get_db()->query("
    SELECT c.*, s.name AS state_name, s.code AS state_code, ci.name AS city_name,
    GROUP_CONCAT(cat.name SEPARATOR ', ') AS category_names
    FROM cleaners c
    LEFT JOIN states s ON c.state_id = s.id
    LEFT JOIN cities ci ON c.city_id = ci.id
    LEFT JOIN cleaner_categories cc ON c.id = cc.cleaner_id
    LEFT JOIN categories cat ON cc.category_id = cat.id
    WHERE c.status = 'active' AND c.is_featured = 1
    GROUP BY c.id
    ORDER BY c.avg_rating DESC
    LIMIT 8
")->fetchAll();

// Fetch recent reviews
$reviews = get_db()->query("
    SELECT r.*, c.business_name, c.slug AS cleaner_slug
    FROM reviews r
    JOIN cleaners c ON r.cleaner_id = c.id
    WHERE r.status = 'approved'
    ORDER BY r.created_at DESC
    LIMIT 6
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/inc_head.php'; ?>
    <?php echo schema_website(); ?>
    <?php echo schema_organization(); ?>
</head>
<body>
<?php include 'includes/inc_header.php'; ?>

<!-- Hero Section -->
<section class="hero-section" role="img" aria-label="Professional cleaner working in a modern home" style="background:url('/images/hero-bg.webp') center/cover no-repeat;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center text-white">
                <h1 class="hero-title mb-3" data-aos="fade-up">Find Trusted Local Cleaning <br>Professionals Near You</h1>
                <p class="hero-subtitle mb-4" data-aos="fade-up" data-aos-delay="100">Compare quotes from top-rated cleaning services. Free, fast, and no obligation.</p>

                <!-- Search Form -->
                <form action="/cleaners" method="GET" data-aos="fade-up" data-aos-delay="200">
                    <div class="d-flex flex-column flex-md-row bg-white rounded-lg shadow-lg p-2 mx-auto" style="max-width:720px;">
                        <select name="category" class="form-control border-0 flex-fill mb-2 mb-md-0" style="min-width:0;">
                            <option value="">What do you need?</option>
                            <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo e($cat['slug']); ?>"><?php echo e($cat['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="text" name="location" id="heroSearch" class="form-control border-0 flex-fill mb-2 mb-md-0" style="min-width:0;" placeholder="City or ZIP code">
                        <button type="submit" class="btn btn-primary px-4 flex-shrink-0" style="white-space:nowrap;"><i class="ti-search mr-1"></i> Find Cleaning Services</button>
                    </div>
                </form>

                <p class="mt-3 small text-white-50" data-aos="fade-up" data-aos-delay="300">
                    <i class="ti-check mr-1"></i> Free quotes <span class="mx-2">|</span>
                    <i class="ti-check mr-1"></i> Verified pros <span class="mx-2">|</span>
                    <i class="ti-check mr-1"></i> No obligation
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title" data-aos="fade-up">Browse by Category</h2>
            <p class="text-muted" data-aos="fade-up" data-aos-delay="100">Find the right cleaning service for your needs</p>
        </div>
        <div class="row">
            <?php foreach ($categories as $i => $cat): ?>
            <div class="col-lg-3 col-md-4 col-6 mb-4" data-aos="fade-up" data-aos-delay="<?php echo ($i % 4) * 50; ?>">
                <a href="/cleaners/<?php echo e($cat['slug']); ?>" class="category-card d-block">
                    <?php if (!empty($cat['image'])): ?>
                    <img src="<?php echo e($cat['image']); ?>" alt="<?php echo e($cat['name']); ?> cleaning services" class="category-card-img" loading="lazy" width="600" height="400">
                    <?php endif; ?>
                    <div class="category-content">
                        <div class="category-icon">
                            <i class="<?php echo e($cat['icon']); ?>"></i>
                        </div>
                        <h6><?php echo e($cat['name']); ?></h6>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="section-padding">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title" data-aos="fade-up">How It Works</h2>
            <p class="text-muted" data-aos="fade-up" data-aos-delay="100">Get matched with top cleaning professionals in 3 easy steps</p>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="0">
                <div class="step-card text-center">
                    <img src="/images/how-it-works-1.webp" alt="Homeowner browsing cleaning service profiles on laptop" width="800" height="584" class="img-fluid rounded shadow-sm mb-3" loading="lazy">
                    <div class="step-number">1</div>
                    <h5 class="mt-3">Tell Us What You Need Cleaned</h5>
                    <p class="text-muted">Select the type of cleaning service you need, enter your location, and describe any special requirements. It takes less than 2 minutes.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="step-card text-center">
                    <img src="/images/how-it-works-2.webp" alt="Cleaning professional reviewing service details with homeowner" width="800" height="584" class="img-fluid rounded shadow-sm mb-3" loading="lazy">
                    <div class="step-number">2</div>
                    <h5 class="mt-3">Get Matched with Cleaners</h5>
                    <p class="text-muted">We match your request with pre-screened, insured cleaning professionals in your area who specialize in the service you need.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="step-card text-center">
                    <img src="/images/how-it-works-3.webp" alt="Satisfied homeowner with a spotless clean home" width="800" height="584" class="img-fluid rounded shadow-sm mb-3" loading="lazy">
                    <div class="step-number">3</div>
                    <h5 class="mt-3">Compare & Book</h5>
                    <p class="text-muted">Review profiles, read verified reviews, compare quotes, and book the best cleaning professional for the job.</p>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="/get-quotes" class="btn btn-primary btn-lg px-5">Get Free Quotes Now</a>
        </div>
    </div>
</section>

<!-- Featured Cleaners -->
<?php if (!empty($featured)): ?>
<section class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title" data-aos="fade-up">Featured Cleaners</h2>
            <p class="text-muted" data-aos="fade-up">Top-rated cleaning professionals trusted by homeowners and businesses</p>
        </div>
        <div class="row">
            <?php foreach ($featured as $i => $c): ?>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="<?php echo ($i % 4) * 50; ?>">
                <div class="cleaner-card h-100 d-flex flex-column">
                    <div class="card-image">
                        <img src="<?php echo e($c['logo'] ?: '/images/default-logo.png'); ?>" alt="<?php echo e($c['business_name']); ?>" loading="lazy">
                        <div class="card-badges" style="position:absolute;top:12px;left:12px;right:12px;display:flex;gap:6px;flex-wrap:wrap;">
                            <?php if ($c['is_verified']): ?><span class="badge-verified"><i class="ti-check"></i> Verified</span><?php endif; ?>
                            <?php if ($c['is_featured']): ?><span class="badge-featured"><i class="ti-star"></i> Featured</span><?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column flex-grow-1">
                        <h6 class="card-title mb-1"><a href="/cleaner/<?php echo e($c['slug']); ?>"><?php echo e($c['business_name']); ?></a></h6>
                        <div class="card-location mb-2">
                            <?php if ($c['city_name'] && $c['state_code']): ?>
                            <i class="ti-location-pin"></i> <?php echo e($c['city_name'] . ', ' . $c['state_code']); ?>
                            <?php endif; ?>
                        </div>
                        <div class="card-rating mb-2">
                            <?php echo format_rating($c['avg_rating']); ?>
                            <span class="rating-count">(<?php echo $c['review_count']; ?>)</span>
                        </div>
                        <p class="card-category mt-auto mb-0"><?php echo e(truncate($c['category_names'] ?? '', 60)); ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-3">
            <a href="/cleaners" class="btn btn-outline-primary">View All Cleaners</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Trust Signals -->
<section class="section-padding">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 col-6 mb-4" data-aos="fade-up">
                <div class="trust-badge">
                    <i class="ti-shield text-primary"></i>
                    <h5>Verified Cleaners</h5>
                    <p class="text-muted small">Every cleaning professional is screened, insured, and verified before listing</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="trust-badge">
                    <i class="ti-thumb-up text-primary"></i>
                    <h5>Real Reviews</h5>
                    <p class="text-muted small">Authentic reviews from real customers you can trust</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="trust-badge">
                    <i class="ti-money text-primary"></i>
                    <h5>Free Quotes</h5>
                    <p class="text-muted small">Get multiple quotes at no cost with zero obligation</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="trust-badge">
                    <i class="ti-headphone-alt text-primary"></i>
                    <h5>24/7 Support</h5>
                    <p class="text-muted small">Our team is here to help you every step of the way</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats -->
<section class="section-padding bg-slate">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 col-6 mb-4 mb-md-0" data-aos="fade-up">
                <h2 class="display-4 font-weight-bold">20+</h2>
                <p class="mb-0 opacity-75">Cleaning Categories</p>
            </div>
            <div class="col-md-3 col-6 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="100">
                <h2 class="display-4 font-weight-bold">50</h2>
                <p class="mb-0 opacity-75">States Covered</p>
            </div>
            <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="200">
                <h2 class="display-4 font-weight-bold">1K+</h2>
                <p class="mb-0 opacity-75">Verified Cleaning Pros</p>
            </div>
            <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="300">
                <h2 class="display-4 font-weight-bold">5K+</h2>
                <p class="mb-0 opacity-75">Satisfied Customers</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<?php if (!empty($reviews)): ?>
<section class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title" data-aos="fade-up">What Our Customers Say</h2>
            <p class="text-muted" data-aos="fade-up">Real reviews from real clients who found their perfect cleaning service</p>
        </div>
        <div class="testimonial-slider">
            <?php foreach ($reviews as $r): ?>
            <div class="px-2">
                <div class="testimonial-card">
                    <div class="testimonial-quote"><i class="ti-quote-left"></i></div>
                    <p class="testimonial-text"><?php echo e(truncate($r['content'] ?? '', 200)); ?></p>
                    <div class="testimonial-rating mb-2"><?php echo format_rating($r['rating'], false); ?></div>
                    <div class="testimonial-author">
                        <strong><?php echo e($r['author_name']); ?></strong>
                        <small class="text-muted d-block">for <a href="/cleaner/<?php echo e($r['cleaner_slug']); ?>"><?php echo e($r['business_name']); ?></a></small>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CTA Section -->
<section class="section-padding bg-slate" style="background:linear-gradient(135deg, rgba(27,40,56,0.88), rgba(44,62,80,0.82)), url('/images/cta-cleaner.webp') center/cover no-repeat !important;">
    <div class="container text-center">
        <h2 data-aos="fade-up">Ready to Get Started?</h2>
        <p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">Whether you need a cleaning service or you're a cleaning professional looking to grow, we're here to help.</p>
        <div data-aos="fade-up" data-aos-delay="200">
            <a href="/get-quotes" class="btn btn-light btn-lg mr-3">Get Free Quotes</a>
            <a href="/join" class="btn btn-outline-light btn-lg">List Your Business</a>
        </div>
    </div>
</section>

<?php include 'includes/inc_footer.php'; ?>
