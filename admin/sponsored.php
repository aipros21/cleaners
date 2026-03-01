<?php
/**
 * Admin - Manage Sponsored Listings
 */
$page_title = 'Sponsored Listings | Admin';
$admin_page = 'sponsored';
require_once __DIR__ . '/inc_admin_head.php';

$db = get_db();

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $action = $_POST['action'] ?? '';
    $sponsored_id = (int)($_POST['sponsored_id'] ?? 0);

    if ($sponsored_id > 0 && $action === 'toggle') {
        $db->prepare("UPDATE sponsored_listings SET is_active = NOT is_active WHERE id = ?")->execute([$sponsored_id]);
        log_activity('toggle_sponsored', 'sponsored_listing', $sponsored_id);
        $_SESSION['flash'] = 'Sponsored listing status updated.';
    } elseif ($action === 'delete' && $sponsored_id > 0) {
        $db->prepare("DELETE FROM sponsored_listings WHERE id = ?")->execute([$sponsored_id]);
        log_activity('delete_sponsored', 'sponsored_listing', $sponsored_id);
        $_SESSION['flash'] = 'Sponsored listing removed.';
    } elseif ($action === 'create') {
        $cleaner_id = (int)($_POST['cleaner_id'] ?? 0);
        $category_id = (int)($_POST['category_id'] ?? 0) ?: null;
        $start_date = $_POST['start_date'] ?? date('Y-m-d');
        $end_date = $_POST['end_date'] ?? '';
        $amount_paid = (float)($_POST['amount_paid'] ?? 0);

        if ($cleaner_id) {
            $stmt = $db->prepare("INSERT INTO sponsored_listings (cleaner_id, category_id, start_date, end_date, amount_paid, is_active, created_at) VALUES (?, ?, ?, ?, ?, 1, NOW())");
            $stmt->execute([$cleaner_id, $category_id, $start_date, $end_date ?: null, $amount_paid]);
            log_activity('create_sponsored', 'sponsored_listing', $db->lastInsertId());
            $_SESSION['flash'] = 'Sponsored listing created.';
        }
    }
    header('Location: /admin/sponsored');
    exit;
}

$page_num = max(1, (int)($_GET['page'] ?? 1));

// Count
$total = $db->query("SELECT COUNT(*) FROM sponsored_listings")->fetchColumn();
$pagination = paginate($total, 20, $page_num);

// Fetch
$sponsored = $db->query("SELECT sl.*, c.business_name, c.slug, cat.name AS category_name
    FROM sponsored_listings sl
    JOIN cleaners c ON sl.cleaner_id = c.id
    LEFT JOIN categories cat ON sl.category_id = cat.id
    ORDER BY sl.created_at DESC
    LIMIT {$pagination['per_page']} OFFSET {$pagination['offset']}")->fetchAll();

// Available cleaners for new sponsored listing
$cleaners_list = $db->query("SELECT id, business_name FROM cleaners WHERE status = 'active' ORDER BY business_name")->fetchAll();
$categories = $db->query("SELECT id, name FROM categories WHERE is_active = 1 ORDER BY name")->fetchAll();
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Sponsored Listings <small class="text-muted">(<?php echo number_format($total); ?>)</small></h4>
        <button class="btn btn-primary" data-toggle="modal" data-target="#addSponsoredModal"><i class="ti-plus mr-1"></i> Add New</button>
    </div>

    <?php if (!empty($_SESSION['flash'])): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo e($_SESSION['flash']); unset($_SESSION['flash']); ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Cleaner</th>
                            <th>Category</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Paid</th>
                            <th>Impressions</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($sponsored)): ?>
                        <tr><td colspan="8" class="text-center py-4 text-muted">No sponsored listings yet.</td></tr>
                        <?php else: ?>
                        <?php foreach ($sponsored as $sp): ?>
                        <tr>
                            <td>
                                <a href="/admin/cleaner-edit?id=<?php echo $sp['cleaner_id']; ?>">
                                    <strong><?php echo e($sp['business_name']); ?></strong>
                                </a>
                            </td>
                            <td><span class="badge badge-light"><?php echo e($sp['category_name'] ?: 'All'); ?></span></td>
                            <td><small><?php echo $sp['start_date'] ? date('M j, Y', strtotime($sp['start_date'])) : '-'; ?></small></td>
                            <td><small><?php echo $sp['end_date'] ? date('M j, Y', strtotime($sp['end_date'])) : 'Ongoing'; ?></small></td>
                            <td><?php echo format_money($sp['amount_paid']); ?></td>
                            <td><?php echo number_format($sp['impressions'] ?? 0); ?></td>
                            <td>
                                <span class="badge badge-<?php echo $sp['is_active'] ? 'success' : 'secondary'; ?>"><?php echo $sp['is_active'] ? 'Active' : 'Inactive'; ?></span>
                            </td>
                            <td>
                                <form method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="sponsored_id" value="<?php echo $sp['id']; ?>">
                                    <button type="submit" name="action" value="toggle" class="btn btn-sm btn-outline-<?php echo $sp['is_active'] ? 'warning' : 'success'; ?>">
                                        <i class="ti-<?php echo $sp['is_active'] ? 'control-pause' : 'control-play'; ?>"></i>
                                    </button>
                                    <button type="submit" name="action" value="delete" class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove this sponsored listing?')"><i class="ti-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <?php echo render_pagination($pagination, '/admin/sponsored'); ?>
    </div>
</div>

<!-- Add Sponsored Modal -->
<div class="modal fade" id="addSponsoredModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="action" value="create">
                <div class="modal-header">
                    <h5 class="modal-title">Add Sponsored Listing</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Cleaner *</label>
                        <select name="cleaner_id" class="form-control" required>
                            <option value="">-- Select --</option>
                            <?php foreach ($cleaners_list as $cl): ?>
                            <option value="<?php echo $cl['id']; ?>"><?php echo e($cl['business_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select name="category_id" class="form-control">
                            <option value="">All Categories</option>
                            <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>"><?php echo e($cat['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Start Date</label>
                            <input type="date" name="start_date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>End Date</label>
                            <input type="date" name="end_date" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Amount Paid ($)</label>
                        <input type="number" name="amount_paid" class="form-control" step="0.01" min="0" value="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Listing</button>
                </div>
            </form>
        </div>
    </div>
</div>

    </div><!-- /.dashboard-content -->
</div><!-- /.dashboard-wrapper -->

<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/js/admin.js"></script>
</body>
</html>
