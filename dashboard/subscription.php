<?php
/**
 * Cleaner Dashboard - Subscription & Plans
 */
$dash_page = 'subscription';
$page_title = 'Subscription | FindMyCleaner';
require_once __DIR__ . '/inc_dashboard_head.php';
require_once dirname(__DIR__) . '/includes/inc_stripe.php';

$db = get_db();
$cid = $_cleaner['id'];

$success = '';
$error = '';

// Check for Stripe success/cancel URL params
if (isset($_GET['success'])) {
    $success = 'Payment successful! Your plan has been upgraded. It may take a moment to reflect.';
}
if (isset($_GET['cancelled'])) {
    $error = 'Payment was cancelled. Your plan has not changed.';
}

// Current plan info
$current_plan = $_cleaner['plan'];
$plan_expires = $_cleaner['plan_expires'];
$stripe_configured = is_stripe_configured();

// Plan definitions
$plans = [
    'free' => [
        'name' => 'Free',
        'price' => 0,
        'photos' => 3,
        'leads' => 3,
        'features' => [
            'Basic profile listing',
            '3 portfolio photos',
            '3 leads per month',
            'Standard search placement',
        ],
        'color' => 'secondary'
    ],
    'basic' => [
        'name' => 'Basic',
        'price' => 29,
        'photos' => 10,
        'leads' => 10,
        'features' => [
            'Enhanced profile listing',
            '10 portfolio photos',
            '10 leads per month',
            'Priority search placement',
            'Business badge',
        ],
        'color' => 'primary'
    ],
    'pro' => [
        'name' => 'Pro',
        'price' => 79,
        'photos' => 30,
        'leads' => 30,
        'features' => [
            'Premium profile listing',
            '30 portfolio photos',
            '30 leads per month',
            'Featured in search results',
            'Verified badge',
            'Discount promotions',
            'Analytics dashboard',
        ],
        'color' => 'success'
    ],
    'premium' => [
        'name' => 'Premium',
        'price' => 149,
        'photos' => 50,
        'leads' => 999999,
        'features' => [
            'Top-tier profile listing',
            '50 portfolio photos',
            'Unlimited leads',
            'Top of search results',
            'Verified + Featured badges',
            'Discount promotions',
            'Full analytics dashboard',
            'Priority customer support',
            'Sponsored listing credits',
        ],
        'color' => 'warning'
    ]
];
?>

<div class="container-fluid py-4">
    <h4 class="mb-4">Subscription</h4>

    <?php if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="ti-check mr-1"></i> <?php echo e($success); ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
    <?php endif; ?>

    <?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="ti-alert mr-1"></i> <?php echo e($error); ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
    <?php endif; ?>

    <!-- Current Plan -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-1">
                        Current Plan: <span class="text-<?php echo $plans[$current_plan]['color']; ?>"><?php echo $plans[$current_plan]['name']; ?></span>
                    </h5>
                    <?php if ($plan_expires): ?>
                    <p class="text-muted mb-0">
                        <?php if (strtotime($plan_expires) > time()): ?>
                        Renews on <?php echo date('F j, Y', strtotime($plan_expires)); ?>
                        <?php else: ?>
                        <span class="text-danger">Expired on <?php echo date('F j, Y', strtotime($plan_expires)); ?></span>
                        <?php endif; ?>
                    </p>
                    <?php elseif ($current_plan === 'free'): ?>
                    <p class="text-muted mb-0">You are on the free plan. Upgrade to get more leads and features.</p>
                    <?php endif; ?>
                </div>
                <div class="col-md-4 text-md-right mt-3 mt-md-0">
                    <?php $current_limits = plan_limits($current_plan); ?>
                    <span class="badge badge-light p-2 mr-1"><i class="ti-image mr-1"></i> <?php echo $current_limits['photos']; ?> photos</span>
                    <span class="badge badge-light p-2">
                        <i class="ti-email mr-1"></i>
                        <?php echo $current_limits['leads'] > 999 ? 'Unlimited' : $current_limits['leads']; ?> leads/mo
                    </span>
                </div>
            </div>
        </div>
    </div>

    <?php if (!$stripe_configured): ?>
    <div class="alert alert-info">
        <i class="ti-info-alt mr-1"></i> <strong>Coming soon:</strong> Online payments are being configured. Plan upgrades will be available shortly.
    </div>
    <?php endif; ?>

    <!-- Plan Comparison -->
    <div class="row">
        <?php foreach ($plans as $plan_key => $plan): ?>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card h-100 <?php echo $plan_key === $current_plan ? 'border-' . $plan['color'] : ''; ?>" style="<?php echo $plan_key === $current_plan ? 'border-width:2px;' : ''; ?>">
                <?php if ($plan_key === $current_plan): ?>
                <div class="card-header bg-<?php echo $plan['color']; ?> text-<?php echo $plan_key === 'premium' ? 'dark' : 'white'; ?> text-center py-1">
                    <small class="font-weight-bold">CURRENT PLAN</small>
                </div>
                <?php endif; ?>
                <div class="card-body text-center">
                    <h5 class="text-<?php echo $plan['color']; ?>"><?php echo $plan['name']; ?></h5>
                    <div class="my-3">
                        <?php if ($plan['price'] == 0): ?>
                        <span class="display-4 font-weight-bold">Free</span>
                        <?php else: ?>
                        <span class="display-4 font-weight-bold">$<?php echo $plan['price']; ?></span>
                        <span class="text-muted">/mo</span>
                        <?php endif; ?>
                    </div>
                    <ul class="list-unstyled text-left small">
                        <?php foreach ($plan['features'] as $feature): ?>
                        <li class="mb-2">
                            <i class="ti-check text-success mr-1"></i> <?php echo e($feature); ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="card-footer bg-white text-center">
                    <?php if ($plan_key === $current_plan): ?>
                    <button class="btn btn-outline-<?php echo $plan['color']; ?> btn-block" disabled>Current Plan</button>
                    <?php elseif ($plan_key === 'free'): ?>
                    <span class="text-muted small">Default plan</span>
                    <?php elseif ($stripe_configured): ?>
                    <a href="/api/stripe_checkout.php?plan=<?php echo $plan_key; ?>" class="btn btn-<?php echo $plan['color']; ?> btn-block">
                        <?php echo ($plans[$current_plan]['price'] < $plan['price']) ? 'Upgrade' : 'Switch'; ?> to <?php echo $plan['name']; ?>
                    </a>
                    <?php else: ?>
                    <button class="btn btn-outline-secondary btn-block" disabled>Coming Soon</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- FAQ -->
    <div class="card mt-2">
        <div class="card-header"><h6 class="mb-0">Frequently Asked Questions</h6></div>
        <div class="card-body">
            <div class="mb-3">
                <strong>Can I cancel at any time?</strong>
                <p class="text-muted small mb-0">Yes. You can downgrade or cancel your subscription at any time. Your current plan features will remain active until the end of your billing period.</p>
            </div>
            <div class="mb-3">
                <strong>What happens when I upgrade?</strong>
                <p class="text-muted small mb-0">Your new plan features are available immediately. You'll be charged the prorated difference for the remainder of the current billing period.</p>
            </div>
            <div>
                <strong>What payment methods do you accept?</strong>
                <p class="text-muted small mb-0">We accept all major credit cards (Visa, Mastercard, American Express) through our secure payment processor, Stripe.</p>
            </div>
        </div>
    </div>
</div>

    </div><!-- /.dashboard-content -->
</div><!-- /.dashboard-wrapper -->

<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/js/dashboard.js"></script>
</body>
</html>
