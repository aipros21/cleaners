<?php
/**
 * Cleaner Dashboard - Discounts & Promotions
 */
$dash_page = 'discounts';
$page_title = 'Discounts | FindMyCleaner';
require_once __DIR__ . '/inc_dashboard_head.php';

$db = get_db();
$cid = $_cleaner['id'];

$success = '';
$error = '';

// Process POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $action = $_POST['action'] ?? '';

    // Add or Edit discount
    if ($action === 'save') {
        $discount_id     = intval($_POST['discount_id'] ?? 0);
        $title           = trim($_POST['title'] ?? '');
        $description     = trim($_POST['description'] ?? '');
        $discount_percent = floatval($_POST['discount_percent'] ?? 0);
        $valid_from      = $_POST['valid_from'] ?? '';
        $valid_until     = $_POST['valid_until'] ?? '';

        if (empty($title)) {
            $error = 'Discount title is required.';
        } elseif ($discount_percent < 0 || $discount_percent > 100) {
            $error = 'Discount percentage must be between 0 and 100.';
        } else {
            if ($discount_id > 0) {
                // Update existing
                $stmt = $db->prepare("UPDATE cleaner_discounts SET title = ?, description = ?, discount_percent = ?, valid_from = ?, valid_until = ? WHERE id = ? AND cleaner_id = ?");
                $stmt->execute([$title, $description, $discount_percent ?: null, $valid_from ?: null, $valid_until ?: null, $discount_id, $cid]);
                $success = 'Discount updated!';
                log_activity('discount_update', 'cleaner_discount', $discount_id);
            } else {
                // Insert new
                $stmt = $db->prepare("INSERT INTO cleaner_discounts (cleaner_id, title, description, discount_percent, valid_from, valid_until, is_active, created_at) VALUES (?, ?, ?, ?, ?, ?, 1, NOW())");
                $stmt->execute([$cid, $title, $description, $discount_percent ?: null, $valid_from ?: null, $valid_until ?: null]);
                $success = 'Discount created!';
                log_activity('discount_create', 'cleaner_discount', $db->lastInsertId());
            }
        }
    }

    // Toggle active/inactive
    if ($action === 'toggle') {
        $discount_id = intval($_POST['discount_id'] ?? 0);
        $stmt = $db->prepare("UPDATE cleaner_discounts SET is_active = NOT is_active WHERE id = ? AND cleaner_id = ?");
        $stmt->execute([$discount_id, $cid]);
        if ($stmt->rowCount()) {
            $success = 'Discount status toggled.';
        }
    }

    // Delete
    if ($action === 'delete') {
        $discount_id = intval($_POST['discount_id'] ?? 0);
        $stmt = $db->prepare("DELETE FROM cleaner_discounts WHERE id = ? AND cleaner_id = ?");
        $stmt->execute([$discount_id, $cid]);
        if ($stmt->rowCount()) {
            $success = 'Discount deleted.';
            log_activity('discount_delete', 'cleaner_discount', $discount_id);
        }
    }
}

// Get current discounts
$stmt = $db->prepare("SELECT * FROM cleaner_discounts WHERE cleaner_id = ? ORDER BY is_active DESC, created_at DESC");
$stmt->execute([$cid]);
$discounts = $stmt->fetchAll();

// Check if we're editing
$editing = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    foreach ($discounts as $d) {
        if ($d['id'] == $edit_id) {
            $editing = $d;
            break;
        }
    }
}
?>

<div class="container-fluid py-4">
    <h4 class="mb-4">Discounts &amp; Promotions</h4>

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
        <!-- Discount Form -->
        <div class="col-lg-5 mb-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><?php echo $editing ? 'Edit Discount' : 'Add New Discount'; ?></h6>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="action" value="save">
                        <input type="hidden" name="discount_id" value="<?php echo $editing ? $editing['id'] : 0; ?>">

                        <div class="form-group">
                            <label for="title">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" required maxlength="200" value="<?php echo e($editing['title'] ?? ''); ?>" placeholder="e.g. Spring Special!">
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Describe the offer..."><?php echo e($editing['description'] ?? ''); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="discount_percent">Discount Percentage (%)</label>
                            <input type="number" class="form-control" id="discount_percent" name="discount_percent" min="0" max="100" step="0.01" value="<?php echo e($editing['discount_percent'] ?? ''); ?>" placeholder="e.g. 15">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="valid_from">Valid From</label>
                                    <input type="date" class="form-control" id="valid_from" name="valid_from" value="<?php echo e($editing['valid_from'] ?? ''); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="valid_until">Valid Until</label>
                                    <input type="date" class="form-control" id="valid_until" name="valid_until" value="<?php echo e($editing['valid_until'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="ti-save mr-1"></i> <?php echo $editing ? 'Update Discount' : 'Create Discount'; ?>
                        </button>

                        <?php if ($editing): ?>
                        <a href="/dashboard/discounts" class="btn btn-light btn-block mt-2">Cancel Editing</a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>

        <!-- Current Discounts -->
        <div class="col-lg-7">
            <?php if (empty($discounts)): ?>
            <div class="card">
                <div class="card-body text-center py-5 text-muted">
                    <i class="ti-gift display-3"></i>
                    <h5 class="mt-3">No discounts yet</h5>
                    <p>Create promotions to attract more customers and stand out from the competition.</p>
                </div>
            </div>
            <?php else: ?>
            <?php foreach ($discounts as $disc): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-1">
                                <?php echo e($disc['title']); ?>
                                <?php if ($disc['discount_percent']): ?>
                                <span class="badge badge-success ml-1"><?php echo number_format($disc['discount_percent'], 0); ?>% OFF</span>
                                <?php endif; ?>
                            </h6>
                            <?php if ($disc['description']): ?>
                            <p class="text-muted small mb-1"><?php echo e($disc['description']); ?></p>
                            <?php endif; ?>
                            <small class="text-muted">
                                <?php if ($disc['valid_from'] || $disc['valid_until']): ?>
                                    <?php echo $disc['valid_from'] ? date('M j, Y', strtotime($disc['valid_from'])) : 'Any time'; ?>
                                    &mdash;
                                    <?php echo $disc['valid_until'] ? date('M j, Y', strtotime($disc['valid_until'])) : 'No end date'; ?>
                                <?php else: ?>
                                    No date restriction
                                <?php endif; ?>
                            </small>
                        </div>
                        <div>
                            <?php if ($disc['is_active']): ?>
                            <span class="badge badge-success">Active</span>
                            <?php else: ?>
                            <span class="badge badge-secondary">Inactive</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <hr class="my-2">
                    <div class="d-flex justify-content-end">
                        <a href="/dashboard/discounts?edit=<?php echo $disc['id']; ?>" class="btn btn-sm btn-outline-primary mr-2">
                            <i class="ti-pencil mr-1"></i> Edit
                        </a>
                        <form method="POST" class="d-inline mr-2">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="action" value="toggle">
                            <input type="hidden" name="discount_id" value="<?php echo $disc['id']; ?>">
                            <button type="submit" class="btn btn-sm btn-outline-<?php echo $disc['is_active'] ? 'warning' : 'success'; ?>">
                                <i class="ti-<?php echo $disc['is_active'] ? 'na' : 'check'; ?> mr-1"></i>
                                <?php echo $disc['is_active'] ? 'Deactivate' : 'Activate'; ?>
                            </button>
                        </form>
                        <form method="POST" class="d-inline" onsubmit="return confirm('Delete this discount?');">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="discount_id" value="<?php echo $disc['id']; ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="ti-trash mr-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
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
