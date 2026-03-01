<?php
/**
 * Admin - Manage Leads
 */
$page_title = 'Manage Leads | Admin';
$admin_page = 'leads';
require_once __DIR__ . '/inc_admin_head.php';

$db = get_db();

// Filters
$search = trim($_GET['search'] ?? '');
$status_filter = $_GET['status'] ?? '';
$category_filter = (int)($_GET['category'] ?? 0);
$date_from = $_GET['date_from'] ?? '';
$date_to = $_GET['date_to'] ?? '';
$page_num = max(1, (int)($_GET['page'] ?? 1));

$where = [];
$params = [];

if ($search) {
    $where[] = "(l.customer_name LIKE ? OR l.customer_email LIKE ? OR l.project_description LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}
if ($status_filter) {
    $where[] = "l.status = ?";
    $params[] = $status_filter;
}
if ($category_filter) {
    $where[] = "l.category_id = ?";
    $params[] = $category_filter;
}
if ($date_from) {
    $where[] = "l.created_at >= ?";
    $params[] = $date_from . ' 00:00:00';
}
if ($date_to) {
    $where[] = "l.created_at <= ?";
    $params[] = $date_to . ' 23:59:59';
}

$where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// Count
$stmt = $db->prepare("SELECT COUNT(*) FROM leads l $where_sql");
$stmt->execute($params);
$total = $stmt->fetchColumn();

$pagination = paginate($total, 20, $page_num);

// Fetch leads with category and assignment count
$sql = "SELECT l.*, cat.name AS category_name,
    (SELECT COUNT(*) FROM lead_assignments la WHERE la.lead_id = l.id) AS assignment_count
    FROM leads l
    LEFT JOIN categories cat ON l.category_id = cat.id
    $where_sql
    ORDER BY l.created_at DESC
    LIMIT {$pagination['per_page']} OFFSET {$pagination['offset']}";
$stmt = $db->prepare($sql);
$stmt->execute($params);
$leads = $stmt->fetchAll();

// Categories for filter
$categories = $db->query("SELECT id, name FROM categories WHERE is_active = 1 ORDER BY name")->fetchAll();

$filter_params = array_filter(['search' => $search, 'status' => $status_filter, 'category' => $category_filter ?: '', 'date_from' => $date_from, 'date_to' => $date_to]);
$base_url = build_url('/admin/leads', $filter_params);
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Leads <small class="text-muted">(<?php echo number_format($total); ?>)</small></h4>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body py-3">
            <form method="GET" class="form-inline flex-wrap">
                <input type="text" name="search" class="form-control form-control-sm mr-2 mb-2" placeholder="Search name, email, description..." value="<?php echo e($search); ?>" style="min-width:200px;">
                <select name="status" class="form-control form-control-sm mr-2 mb-2">
                    <option value="">All Statuses</option>
                    <option value="new" <?php echo $status_filter === 'new' ? 'selected' : ''; ?>>New</option>
                    <option value="assigned" <?php echo $status_filter === 'assigned' ? 'selected' : ''; ?>>Assigned</option>
                    <option value="in_progress" <?php echo $status_filter === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                    <option value="completed" <?php echo $status_filter === 'completed' ? 'selected' : ''; ?>>Completed</option>
                    <option value="cancelled" <?php echo $status_filter === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                </select>
                <select name="category" class="form-control form-control-sm mr-2 mb-2">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>" <?php echo $category_filter == $cat['id'] ? 'selected' : ''; ?>><?php echo e($cat['name']); ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="date" name="date_from" class="form-control form-control-sm mr-2 mb-2" value="<?php echo e($date_from); ?>" placeholder="From">
                <input type="date" name="date_to" class="form-control form-control-sm mr-2 mb-2" value="<?php echo e($date_to); ?>" placeholder="To">
                <button type="submit" class="btn btn-sm btn-primary mb-2 mr-2">Filter</button>
                <a href="/admin/leads" class="btn btn-sm btn-outline-secondary mb-2">Reset</a>
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
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Category</th>
                            <th>Budget</th>
                            <th>Status</th>
                            <th>Assignments</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($leads)): ?>
                        <tr><td colspan="8" class="text-center py-4 text-muted">No leads found.</td></tr>
                        <?php else: ?>
                        <?php foreach ($leads as $lead): ?>
                        <tr class="clickable-row" data-toggle="collapse" data-target="#lead-detail-<?php echo $lead['id']; ?>" style="cursor:pointer;">
                            <td><strong>#<?php echo $lead['id']; ?></strong></td>
                            <td>
                                <div><?php echo e($lead['customer_name']); ?></div>
                                <small class="text-muted"><?php echo e($lead['customer_email']); ?></small>
                            </td>
                            <td><span class="badge badge-light"><?php echo e($lead['category_name']); ?></span></td>
                            <td><?php echo e($lead['budget_range']); ?></td>
                            <td>
                                <?php
                                $status_colors = ['new' => 'primary', 'assigned' => 'info', 'in_progress' => 'warning', 'completed' => 'success', 'cancelled' => 'danger'];
                                $color = $status_colors[$lead['status']] ?? 'secondary';
                                ?>
                                <span class="badge badge-<?php echo $color; ?>"><?php echo ucfirst(str_replace('_', ' ', $lead['status'])); ?></span>
                            </td>
                            <td><span class="badge badge-secondary"><?php echo $lead['assignment_count']; ?></span></td>
                            <td><small><?php echo time_ago($lead['created_at']); ?></small></td>
                            <td><a href="/admin/lead-detail?id=<?php echo $lead['id']; ?>" class="btn btn-sm btn-outline-primary"><i class="ti-eye"></i></a></td>
                        </tr>
                        <tr class="collapse" id="lead-detail-<?php echo $lead['id']; ?>">
                            <td colspan="8" class="bg-light">
                                <div class="p-3">
                                    <strong>Project Description:</strong>
                                    <p class="mb-1"><?php echo e($lead['project_description']); ?></p>
                                    <div class="row small text-muted">
                                        <div class="col-md-3"><strong>Phone:</strong> <?php echo $lead['customer_phone'] ? format_phone($lead['customer_phone']) : 'N/A'; ?></div>
                                        <div class="col-md-3"><strong>Urgency:</strong> <?php echo e($lead['urgency'] ?? 'N/A'); ?></div>
                                        <div class="col-md-3"><strong>ZIP:</strong> <?php echo e($lead['zip_code'] ?? 'N/A'); ?></div>
                                        <div class="col-md-3"><a href="/admin/lead-detail?id=<?php echo $lead['id']; ?>" class="btn btn-sm btn-primary">Full Details</a></div>
                                    </div>
                                </div>
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
