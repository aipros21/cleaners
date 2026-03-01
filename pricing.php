<?php
/**
 * Pricing Page - FindMyCleaner
 */
require_once 'includes/inc_db.php';
require_once 'includes/inc_helpers.php';
require_once 'includes/inc_schema.php';

$page_title = 'Pricing Plans | FindMyCleaner';
$page_description = 'Choose the right plan for your cleaning business. Free, Basic, Pro, and Premium plans available to help cleaning companies grow and get more leads.';
$page_canonical = '/pricing';
$active_page = 'pricing';

$plans = [
    [
        'name'     => 'Free',
        'price'    => 0,
        'period'   => '',
        'featured' => false,
        'features' => [
            ['text' => 'Basic profile listing', 'included' => true],
            ['text' => 'Up to 3 photos', 'included' => true],
            ['text' => '3 leads per month', 'included' => true],
            ['text' => 'Customer reviews', 'included' => true],
            ['text' => 'Priority support', 'included' => false],
            ['text' => 'Verified badge', 'included' => false],
            ['text' => 'Sponsored placement', 'included' => false],
            ['text' => 'Featured listing', 'included' => false],
        ],
        'cta'   => 'Get Started Free',
        'class' => 'btn-outline-primary',
    ],
    [
        'name'     => 'Basic',
        'price'    => 29,
        'period'   => '/mo',
        'featured' => false,
        'features' => [
            ['text' => 'Enhanced profile listing', 'included' => true],
            ['text' => 'Up to 10 photos', 'included' => true],
            ['text' => '10 leads per month', 'included' => true],
            ['text' => 'Customer reviews', 'included' => true],
            ['text' => 'Email support', 'included' => true],
            ['text' => 'Verified badge', 'included' => false],
            ['text' => 'Sponsored placement', 'included' => false],
            ['text' => 'Featured listing', 'included' => false],
        ],
        'cta'   => 'Start Basic',
        'class' => 'btn-outline-primary',
    ],
    [
        'name'     => 'Pro',
        'price'    => 79,
        'period'   => '/mo',
        'featured' => true,
        'features' => [
            ['text' => 'Premium profile listing', 'included' => true],
            ['text' => 'Up to 30 photos', 'included' => true],
            ['text' => '30 leads per month', 'included' => true],
            ['text' => 'Customer reviews', 'included' => true],
            ['text' => 'Priority support', 'included' => true],
            ['text' => 'Verified badge', 'included' => true],
            ['text' => 'Sponsored placement', 'included' => false],
            ['text' => 'Featured listing', 'included' => false],
        ],
        'cta'   => 'Start Pro',
        'class' => 'btn-primary',
    ],
    [
        'name'     => 'Premium',
        'price'    => 149,
        'period'   => '/mo',
        'featured' => false,
        'features' => [
            ['text' => 'Premium profile listing', 'included' => true],
            ['text' => 'Up to 50 photos', 'included' => true],
            ['text' => 'Unlimited leads', 'included' => true],
            ['text' => 'Customer reviews', 'included' => true],
            ['text' => 'Priority support', 'included' => true],
            ['text' => 'Verified badge', 'included' => true],
            ['text' => 'Sponsored placement', 'included' => true],
            ['text' => 'Featured listing', 'included' => true],
        ],
        'cta'   => 'Start Premium',
        'class' => 'btn-outline-primary',
    ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/inc_head.php'; ?>
    <?php echo schema_organization(); ?>
</head>
<body>
<?php include 'includes/inc_header.php'; ?>

<!-- Page Header -->
<section class="page-header py-5">
    <div class="container text-center">
        <h1 class="h2 mb-2" data-aos="fade-up">Simple, Transparent Pricing</h1>
        <p class="lead mb-0 opacity-75" data-aos="fade-up" data-aos-delay="100">Choose the plan that fits your cleaning business. Upgrade or downgrade anytime.</p>
    </div>
</section>

<!-- Pricing Cards -->
<section class="section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <?php foreach ($plans as $i => $plan): ?>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="<?php echo $i * 100; ?>">
                <div class="card h-100 shadow-sm <?php echo $plan['featured'] ? 'border-primary' : ''; ?>" style="<?php echo $plan['featured'] ? 'transform:scale(1.05);z-index:1;' : ''; ?>">
                    <?php if ($plan['featured']): ?>
                    <div class="card-header bg-primary text-white text-center py-2">
                        <small class="font-weight-bold text-uppercase"><i class="ti-star mr-1"></i> Most Popular</small>
                    </div>
                    <?php endif; ?>
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="text-center mb-4">
                            <h5 class="card-title mb-1"><?php echo e($plan['name']); ?></h5>
                            <div class="pricing-amount my-3">
                                <span class="display-4 font-weight-bold">$<?php echo $plan['price']; ?></span>
                                <?php if ($plan['period']): ?>
                                <span class="text-muted"><?php echo $plan['period']; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <ul class="list-unstyled mb-4 flex-grow-1">
                            <?php foreach ($plan['features'] as $feature): ?>
                            <li class="mb-2 <?php echo $feature['included'] ? '' : 'text-muted'; ?>">
                                <?php if ($feature['included']): ?>
                                <i class="ti-check text-success mr-2"></i>
                                <?php else: ?>
                                <i class="ti-close text-muted mr-2"></i>
                                <?php endif; ?>
                                <?php echo e($feature['text']); ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>

                        <a href="/join" class="btn <?php echo $plan['class']; ?> btn-block btn-lg mt-auto"><?php echo e($plan['cta']); ?></a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- FAQ -->
        <div class="row justify-content-center mt-5">
            <div class="col-lg-8">
                <h3 class="text-center mb-4" data-aos="fade-up">Frequently Asked Questions</h3>

                <div class="accordion" id="pricingFaq">
                    <div class="card mb-2" data-aos="fade-up">
                        <div class="card-header p-0" id="faq1">
                            <button class="btn btn-link btn-block text-left p-3" data-toggle="collapse" data-target="#faqAnswer1">
                                Can I switch plans later?
                            </button>
                        </div>
                        <div id="faqAnswer1" class="collapse show" data-parent="#pricingFaq">
                            <div class="card-body text-muted">
                                Yes. You can upgrade or downgrade your plan at any time. When you upgrade, you'll be charged the prorated difference for the remainder of your billing cycle. When you downgrade, your new rate takes effect at the next billing period.
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2" data-aos="fade-up" data-aos-delay="50">
                        <div class="card-header p-0" id="faq2">
                            <button class="btn btn-link btn-block text-left p-3 collapsed" data-toggle="collapse" data-target="#faqAnswer2">
                                Is there a contract or commitment?
                            </button>
                        </div>
                        <div id="faqAnswer2" class="collapse" data-parent="#pricingFaq">
                            <div class="card-body text-muted">
                                No long-term contracts. All paid plans are billed monthly and you can cancel anytime. Your profile will remain active through the end of your billing period.
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2" data-aos="fade-up" data-aos-delay="100">
                        <div class="card-header p-0" id="faq3">
                            <button class="btn btn-link btn-block text-left p-3 collapsed" data-toggle="collapse" data-target="#faqAnswer3">
                                What counts as a lead?
                            </button>
                        </div>
                        <div id="faqAnswer3" class="collapse" data-parent="#pricingFaq">
                            <div class="card-body text-muted">
                                A lead is counted each time a homeowner views your contact information, sends you a message through the platform, or requests a quote from your profile. Profile views do not count as leads.
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2" data-aos="fade-up" data-aos-delay="150">
                        <div class="card-header p-0" id="faq4">
                            <button class="btn btn-link btn-block text-left p-3 collapsed" data-toggle="collapse" data-target="#faqAnswer4">
                                What is the Verified Badge?
                            </button>
                        </div>
                        <div id="faqAnswer4" class="collapse" data-parent="#pricingFaq">
                            <div class="card-body text-muted">
                                The Verified Badge appears on your profile indicating that your insurance, bonding, and business credentials have been verified by our team. It builds trust with homeowners and can significantly increase your lead conversion rate.
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2" data-aos="fade-up" data-aos-delay="200">
                        <div class="card-header p-0" id="faq5">
                            <button class="btn btn-link btn-block text-left p-3 collapsed" data-toggle="collapse" data-target="#faqAnswer5">
                                What payment methods do you accept?
                            </button>
                        </div>
                        <div id="faqAnswer5" class="collapse" data-parent="#pricingFaq">
                            <div class="card-body text-muted">
                                We accept all major credit cards (Visa, Mastercard, American Express, Discover) through our secure Stripe payment processing. All transactions are encrypted and PCI compliant.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="section-padding bg-slate" style="background:linear-gradient(135deg, rgba(27,40,56,0.88), rgba(44,62,80,0.82)), url('/images/pricing-cta.webp') center/cover no-repeat !important;">
    <div class="container text-center">
        <h2 data-aos="fade-up">Ready to Grow Your Cleaning Business?</h2>
        <p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">Join thousands of cleaning professionals who trust FindMyCleaner</p>
        <div data-aos="fade-up" data-aos-delay="200">
            <a href="/join" class="btn btn-light btn-lg px-5">Get Started Free</a>
        </div>
    </div>
</section>

<?php
// Schema: Breadcrumb
echo schema_breadcrumb([
    ['name' => 'Home', 'url' => 'https://cleaners-247.com/'],
    ['name' => 'Pricing', 'url' => 'https://cleaners-247.com/pricing']
]);

// Schema: FAQ
echo schema_faq([
    ['question' => 'Can I switch plans later?', 'answer' => 'Yes. You can upgrade or downgrade your plan at any time. When you upgrade, you\'ll be charged the prorated difference for the remainder of your billing cycle. When you downgrade, your new rate takes effect at the next billing period.'],
    ['question' => 'Is there a contract or commitment?', 'answer' => 'No long-term contracts. All paid plans are billed monthly and you can cancel anytime. Your profile will remain active through the end of your billing period.'],
    ['question' => 'What counts as a lead?', 'answer' => 'A lead is counted each time a homeowner views your contact information, sends you a message through the platform, or requests a quote from your profile. Profile views do not count as leads.'],
    ['question' => 'What is the Verified Badge?', 'answer' => 'The Verified Badge appears on your profile indicating that your insurance, bonding, and business credentials have been verified by our team. It builds trust with homeowners and can significantly increase your lead conversion rate.'],
    ['question' => 'What payment methods do you accept?', 'answer' => 'We accept all major credit cards (Visa, Mastercard, American Express, Discover) through our secure Stripe payment processing. All transactions are encrypted and PCI compliant.'],
]);
?>

<?php include 'includes/inc_footer.php'; ?>
