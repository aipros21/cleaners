<?php
/**
 * Admin - Manage Customers
 */
$page_title = 'Manage Customers | Admin';
$admin_page = 'customers';
require_once __DIR__ . '/inc_admin_head.php';

$db = get_db();

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $action = $_POST['action'] ?? '';
    $user_id = (int)($_POST['user_id'] ?? 0);

    if ($user_id > 0 && in_array($action, ['activate', 'suspend'])) {
        $new_status = $action === 'activate' ? 'active' : 'suspended';
        $db->prepare("UPDATE users SET status = ? WHERE id = ? AND role = 'customer'")->execute([$new_status, $user_id]);
        log_activity($action . '_customer', 'user', $user_id);
        $_SESSION['flash'] = 'Customer status updated.';
    }
    header('Location: /admin/customers?' . $_SERVER['QUERY_STRING']);
    exit;
}

// Filters
$search = trim($_GET['search'] ?? '');
$page_num = max(1, (int)($_GET['page'] ?? 1));

$where = ["u.role = 'customer'"];
$params = [];

if ($search) {
    $where[] = "(u.first_name LIKE ? OR u.last_name LIKE ? OR u.email LIKE ? OR u.phone LIKE ?)";
    $params = array_merge($params, ["%$search%", "%$search%", "%$search%", "%$search%"]);
}

$where_sql = 'WHERE ' . implode(' AND ', $where);

// Count
$stmt = $db->prepare("SELECT COUNT(*) FROM users u $where_sql");
$stmt->execute($params);
$total = $stmt->fetchColumn();

$pagination = paginate($total, 20, $page_num);

// Fetch
$sql = "SELECT u.id, u.first_name, u.last_name, u.email, u.phone, u.status, u.created_at, u.last_login
    FROM users u
    $where_sql
    ORDER BY u.created_at DESC
    LIMIT {$pagination['per_page']} OFFSET {$pagination['offset']}";
$stmt = $db->prepare($sql);
$stmt->execute($params);
$customers = $stmt->fetchAll();

$base_url = build_url('/admin/customers', array_filter(['search' => $search]));
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Customers <small class="text-muted">(<?php echo number_format($total); ?>)</small></h4>
    </div>

    <?php if (!empty($_SESSION['flash'])): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo e($_SESSION['flash']); unset($_SESSION['flash']); ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>
    <?php endif; ?>

    <!-- Search -->
    <div class="card mb-4">
        <div class="card-body py-3">
            <form method="GET" class="form-inline">
                <input type="text" name="search" class="form-control form-control-sm mr-2" placeholder="Search name, email, phone..." value="<?php echo e($search); ?>" style="min-width:250px;">
                <button type="submit" class="btn btn-sm btn-primary mr-2">Search</button>
                <a href="/admin/customers" class="btn btn-sm btn-outline-secondary">Reset</a>
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Registered</th>
                            <th>Last Login</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($customers)): ?>
                        <tr><td colspan="7" class="text-center py-4 text-muted">No customers found.</td></tr>
                        <?php else: ?>
                        <?php foreach ($customers as $cust): ?>
                        <tr>
                            <td><strong><?php echo e($cust['first_name'] . ' ' . $cust['last_name']); ?></strong></td>
                            <td><small><?php echo e($cust['email']); ?></small></td>
                            <td><small><?php echo $cust['phone'] ? format_phone($cust['phone']) : '-'; ?></small></td>
                            <td><small><?php echo date('M j, Y', strtotime($cust['created_at'])); ?></small></td>
                            <td><small><?php echo $cust['last_login'] ? time_ago($cust['last_login']) : 'Never'; ?></small></td>
                            <td>
                                <span class="badge badge-<?php echo $cust['status'] === 'active' ? 'success' : 'danger'; ?>"><?php echo ucfirst($cust['status']); ?></span>
                            </td>
                            <td>
                                <form method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="user_id" value="<?php echo $cust['id']; ?>">
                                    <?php if ($cust['status'] === 'active'): ?>
                                    <button type="submit" name="action" value="suspend" class="btn btn-sm btn-outline-danger" onclick="return confirm('Suspend this customer?')"><i class="ti-lock mr-1"></i>Suspend</button>
                                    <?php else: ?>
                                    <button type="submit" name="action" value="activate" class="btn btn-sm btn-outline-success"><i class="ti-unlock mr-1"></i>Activate</button>
                                    <?php endif; ?>
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
