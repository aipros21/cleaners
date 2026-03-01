<?php
/**
 * About Page - FindMyCleaner
 */
require_once 'includes/inc_db.php';
require_once 'includes/inc_helpers.php';
require_once 'includes/inc_schema.php';

$page_title = 'About FindMyCleaner | Trusted Cleaning Professionals Near You';
$page_description = 'Learn about FindMyCleaner, our mission to connect homeowners with trusted local cleaning professionals, and how our platform makes booking cleaning services simple.';
$page_canonical = '/about';
$active_page = 'about';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/inc_head.php'; ?>
    <?php echo schema_organization(); ?>
</head>
<body>
<?php include 'includes/inc_header.php'; ?>

<!-- Hero -->
<section class="page-header py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="h2 mb-2" data-aos="fade-up">About FindMyCleaner</h1>
                <p class="lead mb-0 opacity-75" data-aos="fade-up" data-aos-delay="100">Connecting homeowners with trusted cleaning professionals since 2024</p>
            </div>
        </div>
    </div>
</section>

<!-- Mission -->
<section class="section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                <img src="/images/about-mission.webp" alt="Professional cleaning team preparing for a residential cleaning job" width="1200" height="900" class="img-fluid rounded shadow" loading="lazy" onerror="this.src='/images/default-logo.png'">
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <h2 class="section-title">Our Mission</h2>
                <p class="lead text-muted">To make finding the right cleaning professional simple, transparent, and trustworthy.</p>
                <p>Finding a reliable cleaner shouldn't be a stressful experience. Too often, homeowners are left guessing about quality, pricing, and dependability. FindMyCleaner was built to change that.</p>
                <p>We believe every homeowner deserves access to pre-screened, verified cleaning professionals who deliver spotless results at fair prices. Our platform brings transparency to the cleaning industry by combining verified reviews, background checks, and an easy-to-use matching system.</p>
                <p>Whether you need a one-time deep clean, regular housekeeping, move-in/move-out cleaning, or specialized services like carpet or window cleaning, we make it easy to find, compare, and hire the best cleaning professionals in your area.</p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works for Homeowners -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title" data-aos="fade-up">How It Works for Homeowners</h2>
            <p class="text-muted" data-aos="fade-up" data-aos-delay="100">Get matched with the right cleaning professional in minutes</p>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="0">
                <div class="step-card text-center">
                    <img src="/images/how-it-works-1.webp" alt="Homeowner browsing cleaning professional profiles on laptop" width="800" height="584" class="img-fluid rounded shadow-sm mb-3" loading="lazy">
                    <div class="step-number">1</div>
                    <h5 class="mt-3">Search or Post Your Cleaning Job</h5>
                    <p class="text-muted">Browse cleaning professionals by service type and location, or submit a cleaning request to be matched with qualified pros.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="step-card text-center">
                    <img src="/images/how-it-works-2.webp" alt="Cleaning professional discussing services with homeowner" width="800" height="584" class="img-fluid rounded shadow-sm mb-3" loading="lazy">
                    <div class="step-number">2</div>
                    <h5 class="mt-3">Compare Profiles & Reviews</h5>
                    <p class="text-muted">Review detailed cleaner profiles, check verified credentials, read honest reviews from past customers, and compare quotes.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="step-card text-center">
                    <img src="/images/how-it-works-3.webp" alt="Homeowner welcoming cleaning professional" width="800" height="584" class="img-fluid rounded shadow-sm mb-3" loading="lazy">
                    <div class="step-number">3</div>
                    <h5 class="mt-3">Book with Confidence</h5>
                    <p class="text-muted">Choose the cleaning professional that best fits your needs, budget, and schedule. All with the peace of mind that they've been vetted.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works for Cleaners -->
<section class="section-padding">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title" data-aos="fade-up">How It Works for Cleaning Professionals</h2>
            <p class="text-muted" data-aos="fade-up" data-aos-delay="100">Grow your cleaning business with quality leads</p>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="0">
                <div class="step-card text-center">
                    <img src="/images/about-cleaner-1.webp" alt="Cleaning professional creating a business profile" width="800" height="600" class="img-fluid rounded shadow-sm mb-3" loading="lazy">
                    <div class="step-number">1</div>
                    <h5 class="mt-3">Create Your Free Profile</h5>
                    <p class="text-muted">Sign up for free and build a professional profile showcasing your cleaning services, certifications, photos of your work, and customer reviews.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="step-card text-center">
                    <img src="/images/about-cleaner-2.webp" alt="Cleaning professional receiving a new booking notification" width="800" height="600" class="img-fluid rounded shadow-sm mb-3" loading="lazy">
                    <div class="step-number">2</div>
                    <h5 class="mt-3">Receive Qualified Leads</h5>
                    <p class="text-muted">Get connected with homeowners in your service area who are actively looking for the cleaning services you provide.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="step-card text-center">
                    <img src="/images/about-cleaner-3.webp" alt="Successful cleaning professional with satisfied customer" width="800" height="600" class="img-fluid rounded shadow-sm mb-3" loading="lazy">
                    <div class="step-number">3</div>
                    <h5 class="mt-3">Win More Clients</h5>
                    <p class="text-muted">Respond to leads, showcase your spotless results, build your reputation with reviews, and watch your cleaning business grow.</p>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="/join" class="btn btn-primary btn-lg px-5">List Your Cleaning Business Free</a>
        </div>
    </div>
</section>

<!-- Stats -->
<section class="section-padding bg-slate">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 col-6 mb-4 mb-md-0" data-aos="fade-up">
                <h2 class="display-4 font-weight-bold">15+</h2>
                <p class="mb-0 opacity-75">Cleaning Services</p>
            </div>
            <div class="col-md-3 col-6 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="100">
                <h2 class="display-4 font-weight-bold">50</h2>
                <p class="mb-0 opacity-75">States Covered</p>
            </div>
            <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="200">
                <h2 class="display-4 font-weight-bold">1K+</h2>
                <p class="mb-0 opacity-75">Verified Cleaners</p>
            </div>
            <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="300">
                <h2 class="display-4 font-weight-bold">5K+</h2>
                <p class="mb-0 opacity-75">Sparkling Homes</p>
            </div>
        </div>
    </div>
</section>

<!-- Our Values -->
<section class="section-padding">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title" data-aos="fade-up">Our Values</h2>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4" data-aos="fade-up">
                <div class="text-center p-4">
                    <img src="/images/about-value-trust.webp" alt="Trust and transparency in hiring cleaning professionals" width="800" height="600" class="img-fluid rounded shadow-sm mb-3" loading="lazy">
                    <h5>Trust & Transparency</h5>
                    <p class="text-muted">We verify cleaner credentials, run background checks, and only publish authentic reviews. No fake profiles, no hidden fees.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="text-center p-4">
                    <img src="/images/about-value-quality.webp" alt="Quality cleaning standards and attention to detail" width="800" height="600" class="img-fluid rounded shadow-sm mb-3" loading="lazy">
                    <h5>Spotless Standards</h5>
                    <p class="text-muted">We hold our cleaning professionals to the highest standards. Our screening process ensures only qualified, reliable cleaners are listed.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="text-center p-4">
                    <img src="/images/about-value-support.webp" alt="Dedicated customer support team" width="800" height="600" class="img-fluid rounded shadow-sm mb-3" loading="lazy">
                    <h5>Support You Can Count On</h5>
                    <p class="text-muted">Our team is here to help both homeowners and cleaning professionals succeed. We're just a call or email away.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title" data-aos="fade-up">Meet Our Team</h2>
            <p class="text-muted" data-aos="fade-up" data-aos-delay="100">The people behind FindMyCleaner</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body p-4">
                        <img src="/images/team-john.webp" alt="John Smith, Founder and CEO" width="400" height="400" class="rounded-circle mb-3" style="width:100px;height:100px;object-fit:cover;" loading="lazy">
                        <h6 class="mb-1">John Smith</h6>
                        <small class="text-muted">Founder & CEO</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body p-4">
                        <img src="/images/team-sarah.webp" alt="Sarah Johnson, Head of Operations" width="400" height="400" class="rounded-circle mb-3" style="width:100px;height:100px;object-fit:cover;" loading="lazy">
                        <h6 class="mb-1">Sarah Johnson</h6>
                        <small class="text-muted">Head of Operations</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body p-4">
                        <img src="/images/team-mike.webp" alt="Mike Davis, Head of Technology" width="400" height="400" class="rounded-circle mb-3" style="width:100px;height:100px;object-fit:cover;" loading="lazy">
                        <h6 class="mb-1">Mike Davis</h6>
                        <small class="text-muted">Head of Technology</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body p-4">
                        <img src="/images/team-emily.webp" alt="Emily Chen, Customer Success" width="400" height="400" class="rounded-circle mb-3" style="width:100px;height:100px;object-fit:cover;" loading="lazy">
                        <h6 class="mb-1">Emily Chen</h6>
                        <small class="text-muted">Customer Success</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="section-padding bg-slate" style="background:linear-gradient(135deg, rgba(27,40,56,0.88), rgba(44,62,80,0.82)), url('/images/cta-cleaner.webp') center/cover no-repeat !important;">
    <div class="container text-center">
        <h2 data-aos="fade-up">Ready to Get Started?</h2>
        <p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">Whether you need a sparkling clean home or want to grow your cleaning business, we're here to help.</p>
        <div data-aos="fade-up" data-aos-delay="200">
            <a href="/get-quotes" class="btn btn-light btn-lg mr-3">Get Free Quotes</a>
            <a href="/join" class="btn btn-outline-light btn-lg">List Your Cleaning Business</a>
        </div>
    </div>
</section>

<?php
echo schema_breadcrumb([
    ['name' => 'Home', 'url' => 'https://cleaners-247.com/'],
    ['name' => 'About Us', 'url' => 'https://cleaners-247.com/about']
]);
?>

<?php include 'includes/inc_footer.php'; ?>
