<?php
/**
 * Admin - Manage Cleaners
 */
$page_title = 'Manage Cleaners | Admin';
$admin_page = 'cleaners';
require_once __DIR__ . '/inc_admin_head.php';

$db = get_db();

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $action = $_POST['action'] ?? '';
    $cleaner_id = (int)($_POST['cleaner_id'] ?? 0);

    if ($cleaner_id > 0) {
        switch ($action) {
            case 'verify':
                $db->prepare("UPDATE cleaners SET is_verified = NOT is_verified WHERE id = ?")->execute([$cleaner_id]);
                log_activity('toggle_verification', 'cleaner', $cleaner_id);
                $_SESSION['flash'] = 'Cleaner verification status updated.';
                break;
            case 'feature':
                $db->prepare("UPDATE cleaners SET is_featured = NOT is_featured WHERE id = ?")->execute([$cleaner_id]);
                log_activity('toggle_featured', 'cleaner', $cleaner_id);
                $_SESSION['flash'] = 'Cleaner featured status updated.';
                break;
            case 'suspend':
                $db->prepare("UPDATE cleaners SET status = IF(status='suspended','active','suspended') WHERE id = ?")->execute([$cleaner_id]);
                log_activity('toggle_suspend', 'cleaner', $cleaner_id);
                $_SESSION['flash'] = 'Cleaner status updated.';
                break;
        }
    }
    header('Location: /admin/cleaners?' . $_SERVER['QUERY_STRING']);
    exit;
}

// Filters
$search = trim($_GET['search'] ?? '');
$status_filter = $_GET['status'] ?? '';
$plan_filter = $_GET['plan'] ?? '';
$page_num = max(1, (int)($_GET['page'] ?? 1));

// Build query
$where = [];
$params = [];

if ($search) {
    $where[] = "(c.business_name LIKE ? OR u.email LIKE ? OR c.city LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}
if ($status_filter) {
    $where[] = "c.status = ?";
    $params[] = $status_filter;
}
if ($plan_filter) {
    $where[] = "c.plan = ?";
    $params[] = $plan_filter;
}

$where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// Count
$count_sql = "SELECT COUNT(*) FROM cleaners c JOIN users u ON c.user_id = u.id $where_sql";
$stmt = $db->prepare($count_sql);
$stmt->execute($params);
$total = $stmt->fetchColumn();

$pagination = paginate($total, 20, $page_num);

// Fetch
$sql = "SELECT c.*, u.email, u.status AS user_status
    FROM cleaners c
    JOIN users u ON c.user_id = u.id
    $where_sql
    ORDER BY c.created_at DESC
    LIMIT {$pagination['per_page']} OFFSET {$pagination['offset']}";
$stmt = $db->prepare($sql);
$stmt->execute($params);
$cleaners = $stmt->fetchAll();

$base_url = build_url('/admin/cleaners', array_filter(['search' => $search, 'status' => $status_filter, 'plan' => $plan_filter]));
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Cleaners <small class="text-muted">(<?php echo number_format($total); ?>)</small></h4>
    </div>

    <?php if (!empty($_SESSION['flash'])): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo e($_SESSION['flash']); unset($_SESSION['flash']); ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>
    <?php endif; ?>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body py-3">
            <form method="GET" class="form-inline flex-wrap">
                <input type="text" name="search" class="form-control form-control-sm mr-2 mb-2" placeholder="Search business, email, city..." value="<?php echo e($search); ?>" style="min-width:200px;">
                <select name="status" class="form-control form-control-sm mr-2 mb-2">
                    <option value="">All Statuses</option>
                    <option value="active" <?php echo $status_filter === 'active' ? 'selected' : ''; ?>>Active</option>
                    <option value="pending" <?php echo $status_filter === 'pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="suspended" <?php echo $status_filter === 'suspended' ? 'selected' : ''; ?>>Suspended</option>
                </select>
                <select name="plan" class="form-control form-control-sm mr-2 mb-2">
                    <option value="">All Plans</option>
                    <option value="free" <?php echo $plan_filter === 'free' ? 'selected' : ''; ?>>Free</option>
                    <option value="basic" <?php echo $plan_filter === 'basic' ? 'selected' : ''; ?>>Basic</option>
                    <option value="pro" <?php echo $plan_filter === 'pro' ? 'selected' : ''; ?>>Pro</option>
                    <option value="premium" <?php echo $plan_filter === 'premium' ? 'selected' : ''; ?>>Premium</option>
                </select>
                <button type="submit" class="btn btn-sm btn-primary mb-2 mr-2">Filter</button>
                <a href="/admin/cleaners" class="btn btn-sm btn-outline-secondary mb-2">Reset</a>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Business Name</th>
                            <th>Email</th>
                            <th>Location</th>
                            <th>Plan</th>
                            <th>Rating</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($cleaners)): ?>
                        <tr><td colspan="7" class="text-center py-4 text-muted">No cleaners found.</td></tr>
                        <?php else: ?>
                        <?php foreach ($cleaners as $c): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="<?php echo e($c['logo'] ?: '/images/default-logo.png'); ?>" class="rounded-circle mr-2" width="32" height="32" alt="">
                                    <div>
                                        <strong><?php echo e($c['business_name']); ?></strong>
                                        <?php if ($c['is_verified']): ?><i class="ti-check text-primary ml-1" title="Verified"></i><?php endif; ?>
                                        <?php if ($c['is_featured']): ?><i class="ti-star text-warning ml-1" title="Featured"></i><?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td><small><?php echo e($c['email']); ?></small></td>
                            <td><small><?php echo e($c['city'] . ', ' . $c['state']); ?></small></td>
                            <td><span class="badge badge-<?php echo $c['plan'] === 'premium' ? 'primary' : ($c['plan'] === 'pro' ? 'info' : ($c['plan'] === 'basic' ? 'secondary' : 'light')); ?>"><?php echo ucfirst($c['plan']); ?></span></td>
                            <td><?php echo format_rating($c['avg_rating']); ?> <small class="text-muted">(<?php echo $c['review_count']; ?>)</small></td>
                            <td>
                                <?php
                                $status_colors = ['active' => 'success', 'pending' => 'warning', 'suspended' => 'danger'];
                                ?>
                                <span class="badge badge-<?php echo $status_colors[$c['status']] ?? 'secondary'; ?>"><?php echo ucfirst($c['status']); ?></span>
                            </td>
                            <td>
                                <a href="/admin/cleaner-edit?id=<?php echo $c['id']; ?>" class="btn btn-sm btn-outline-primary mr-1" title="Edit"><i class="ti-pencil"></i></a>
                                <form method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="cleaner_id" value="<?php echo $c['id']; ?>">
                                    <button type="submit" name="action" value="verify" class="btn btn-sm btn-outline-<?php echo $c['is_verified'] ? 'success' : 'secondary'; ?>" title="<?php echo $c['is_verified'] ? 'Remove Verification' : 'Verify'; ?>"><i class="ti-check"></i></button>
                                    <button type="submit" name="action" value="feature" class="btn btn-sm btn-outline-<?php echo $c['is_featured'] ? 'warning' : 'secondary'; ?>" title="<?php echo $c['is_featured'] ? 'Unfeature' : 'Feature'; ?>"><i class="ti-star"></i></button>
                                    <button type="submit" name="action" value="suspend" class="btn btn-sm btn-outline-danger" title="<?php echo $c['status'] === 'suspended' ? 'Activate' : 'Suspend'; ?>"><i class="ti-lock"></i></button>
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

    <!-- Pagination -->
    <div class="mt-4">
        <?php echo render_pagination($pagination, $base_url); ?>
    </div>
</div>

    </div><!-- /.dashboard-content -->
</div><!-- /.dashboard-wrapper -->

<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/js/admin.js"></script>
</body>
</html>
