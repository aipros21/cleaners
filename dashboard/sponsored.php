<?php
/**
 * Cleaner Dashboard - Sponsored Listings
 */
$dash_page = 'sponsored';
$page_title = 'Sponsored Placement | FindMyCleaner';
require_once __DIR__ . '/inc_dashboard_head.php';
require_once dirname(__DIR__) . '/includes/inc_stripe.php';

$db = get_db();
$cid = $_cleaner['id'];

$success = '';
$error = '';

$stripe_configured = is_stripe_configured();

// Check for success param
if (isset($_GET['success'])) {
    $success = 'Sponsored listing purchased successfully! It will be active shortly.';
}
if (isset($_GET['cancelled'])) {
    $error = 'Payment was cancelled. No sponsored listing was created.';
}

// Get categories for dropdown
$categories = $db->query("SELECT id, name FROM categories WHERE is_active = 1 ORDER BY name")->fetchAll();

// Get current active sponsored listings
$stmt = $db->prepare("SELECT sl.*, cat.name AS category_name
    FROM sponsored_listings sl
    LEFT JOIN categories cat ON sl.category_id = cat.id
    WHERE sl.cleaner_id = ?
    ORDER BY sl.end_date DESC");
$stmt->execute([$cid]);
$sponsored = $stmt->fetchAll();

// Separate active vs expired
$active_listings = [];
$expired_listings = [];
$today = date('Y-m-d');
foreach ($sponsored as $s) {
    if ($s['is_active'] && $s['end_date'] >= $today) {
        $active_listings[] = $s;
    } else {
        $expired_listings[] = $s;
    }
}

// Duration options
$durations = [
    '1_week'  => ['label' => '1 Week', 'days' => 7, 'price' => 49],
    '1_month' => ['label' => '1 Month', 'days' => 30, 'price' => 149],
];
?>

<div class="container-fluid py-4">
    <h4 class="mb-4">Sponsored Placement</h4>

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

    <div class="row">
        <!-- Purchase Form -->
        <div class="col-lg-5 mb-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="ti-rocket mr-1"></i> Purchase Sponsored Placement</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">
                        Get your business featured at the top of search results in your chosen category. Sponsored cleaners get significantly more profile views and leads.
                    </p>

                    <?php if (!$stripe_configured): ?>
                    <div class="alert alert-info">
                        <i class="ti-info-alt mr-1"></i> <strong>Coming soon:</strong> Sponsored placements will be available once payment processing is configured.
                    </div>
                    <?php else: ?>
                    <form action="/api/stripe_checkout.php" method="GET">
                        <input type="hidden" name="type" value="sponsored">

                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option value="">-- Select Category --</option>
                                <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>"><?php echo e($cat['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Duration</label>
                            <?php foreach ($durations as $key => $dur): ?>
                            <div class="custom-control custom-radio mb-2">
                                <input type="radio" class="custom-control-input" id="dur_<?php echo $key; ?>" name="duration" value="<?php echo $key; ?>" <?php echo $key === '1_week' ? 'checked' : ''; ?>>
                                <label class="custom-control-label" for="dur_<?php echo $key; ?>">
                                    <?php echo $dur['label']; ?> &mdash; <strong>$<?php echo $dur['price']; ?></strong>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="ti-credit-card mr-1"></i> Proceed to Checkout
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>

            <!-- How it works -->
            <div class="card mt-4">
                <div class="card-header"><h6 class="mb-0">How It Works</h6></div>
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <div class="mr-3"><span class="badge badge-primary badge-pill px-3 py-2">1</span></div>
                        <div>
                            <strong>Choose a category</strong>
                            <p class="text-muted small mb-0">Select the service category where you want to appear.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="mr-3"><span class="badge badge-primary badge-pill px-3 py-2">2</span></div>
                        <div>
                            <strong>Select duration</strong>
                            <p class="text-muted small mb-0">Pick 1 week or 1 month of featured placement.</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="mr-3"><span class="badge badge-primary badge-pill px-3 py-2">3</span></div>
                        <div>
                            <strong>Get featured</strong>
                            <p class="text-muted small mb-0">Your profile appears at the top of search results with a "Sponsored" badge.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Listings -->
        <div class="col-lg-7">
            <!-- Active Listings -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Active Sponsored Listings <span class="badge badge-success ml-1"><?php echo count($active_listings); ?></span></h6>
                </div>
                <div class="card-body">
                    <?php if (empty($active_listings)): ?>
                    <div class="text-center py-4 text-muted">
                        <i class="ti-rocket display-4"></i>
                        <p class="mt-2">No active sponsored listings.</p>
                    </div>
                    <?php else: ?>
                    <?php foreach ($active_listings as $listing): ?>
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <div>
                            <strong><?php echo e($listing['category_name'] ?? 'All Categories'); ?></strong>
                            <br>
                            <small class="text-muted">
                                <?php echo date('M j, Y', strtotime($listing['start_date'])); ?> &mdash; <?php echo date('M j, Y', strtotime($listing['end_date'])); ?>
                            </small>
                        </div>
                        <div class="text-right">
                            <span class="badge badge-success mb-1">Active</span><br>
                            <small class="text-muted">
                                <?php echo number_format($listing['impressions']); ?> views
                                &middot; <?php echo number_format($listing['clicks']); ?> clicks
                            </small>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Past Listings -->
            <?php if (!empty($expired_listings)): ?>
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Past Listings</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead class="thead-light">
                                <tr><th>Category</th><th>Dates</th><th>Views</th><th>Clicks</th><th>Paid</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach ($expired_listings as $listing): ?>
                                <tr>
                                    <td><?php echo e($listing['category_name'] ?? 'All'); ?></td>
                                    <td><small><?php echo date('M j', strtotime($listing['start_date'])); ?> - <?php echo date('M j, Y', strtotime($listing['end_date'])); ?></small></td>
                                    <td><?php echo number_format($listing['impressions']); ?></td>
                                    <td><?php echo number_format($listing['clicks']); ?></td>
                                    <td><?php echo format_money($listing['price_paid']); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
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
