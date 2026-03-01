<?php
/**
 * Admin - Activity Log
 */
$page_title = 'Activity Log | Admin';
$admin_page = 'activity';
require_once __DIR__ . '/inc_admin_head.php';

$db = get_db();

// Filters
$filter_action = $_GET['action_filter'] ?? '';
$page_num = max(1, (int)($_GET['page'] ?? 1));
$per_page = 50;

$where = [];
$params = [];

if ($filter_action) {
    $where[] = "al.action = ?";
    $params[] = $filter_action;
}

$where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// Count
$stmt = $db->prepare("SELECT COUNT(*) FROM activity_log al $where_sql");
$stmt->execute($params);
$total = $stmt->fetchColumn();

$pagination = paginate($total, $per_page, $page_num);

// Fetch logs
$sql = "SELECT al.*, u.email AS user_email, u.first_name, u.last_name
    FROM activity_log al
    LEFT JOIN users u ON al.user_id = u.id
    $where_sql
    ORDER BY al.created_at DESC
    LIMIT $per_page OFFSET {$pagination['offset']}";
$stmt = $db->prepare($sql);
$stmt->execute($params);
$logs = $stmt->fetchAll();

// Get distinct actions for filter dropdown
$actions = $db->query("SELECT DISTINCT action FROM activity_log ORDER BY action")->fetchAll(PDO::FETCH_COLUMN);

$base_url = build_url('/admin/activity-log', array_filter(['action_filter' => $filter_action]));
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Activity Log <small class="text-muted">(<?php echo number_format($total); ?> entries)</small></h4>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body py-3">
            <form method="GET" class="form-inline">
                <select name="action_filter" class="form-control form-control-sm mr-2">
                    <option value="">All Actions</option>
                    <?php foreach ($actions as $a): ?>
                    <option value="<?php echo e($a); ?>" <?php echo $filter_action === $a ? 'selected' : ''; ?>><?php echo e($a); ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-sm btn-primary mr-2">Filter</button>
                <?php if ($filter_action): ?>
                <a href="/admin/activity-log" class="btn btn-sm btn-outline-secondary">Clear</a>
                <?php endif; ?>
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
                            <th>User</th>
                            <th>Action</th>
                            <th>Entity</th>
                            <th>Details</th>
                            <th>IP Address</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($logs)): ?>
                        <tr><td colspan="6" class="text-center py-4 text-muted">No activity logs found.</td></tr>
                        <?php else: ?>
                        <?php foreach ($logs as $log): ?>
                        <tr>
                            <td>
                                <?php if ($log['user_email']): ?>
                                <small><strong><?php echo e($log['first_name'] . ' ' . $log['last_name']); ?></strong></small>
                                <br><small class="text-muted"><?php echo e($log['user_email']); ?></small>
                                <?php else: ?>
                                <small class="text-muted">System</small>
                                <?php endif; ?>
                            </td>
                            <td><span class="badge badge-light"><?php echo e($log['action']); ?></span></td>
                            <td>
                                <?php if ($log['entity_type']): ?>
                                <small><?php echo e($log['entity_type']); ?>
                                    <?php if ($log['entity_id']): ?>
                                    <span class="text-muted">#<?php echo e($log['entity_id']); ?></span>
                                    <?php endif; ?>
                                </small>
                                <?php else: ?>
                                <small class="text-muted">-</small>
                                <?php endif; ?>
                            </td>
                            <td><small class="text-muted"><?php echo e(truncate($log['details'] ?? '', 80)); ?></small></td>
                            <td><small class="text-muted"><?php echo e($log['ip_address'] ?? '-'); ?></small></td>
                            <td>
                                <small title="<?php echo e($log['created_at']); ?>"><?php echo time_ago($log['created_at']); ?></small>
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
