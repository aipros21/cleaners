<?php
/**
 * Admin - Manage Admin Users
 */
$page_title = 'Manage Admins | Admin';
$admin_page = 'admins';
require_once __DIR__ . '/inc_admin_head.php';

$db = get_db();

$errors = [];
$success = '';

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $action = $_POST['action'] ?? '';
    $user_id = (int)($_POST['user_id'] ?? 0);

    // Create new admin
    if ($action === 'create') {
        $first_name = trim($_POST['first_name'] ?? '');
        $last_name = trim($_POST['last_name'] ?? '');
        $email = strtolower(trim($_POST['email'] ?? ''));
        $password = $_POST['password'] ?? '';

        if (!$first_name) $errors[] = 'First name is required.';
        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
        if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';

        if (empty($errors)) {
            $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $errors[] = 'An account with this email already exists.';
            }
        }

        if (empty($errors)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO users (email, password, role, first_name, last_name, status, created_at) VALUES (?, ?, 'admin', ?, ?, 'active', NOW())");
            $stmt->execute([$email, $hash, $first_name, $last_name]);
            log_activity('create_admin', 'user', $db->lastInsertId());
            $_SESSION['flash'] = 'Admin user created successfully.';
            header('Location: /admin/admins');
            exit;
        }
    }

    // Update admin
    if ($action === 'update' && $user_id > 0) {
        $first_name = trim($_POST['first_name'] ?? '');
        $last_name = trim($_POST['last_name'] ?? '');
        $email = strtolower(trim($_POST['email'] ?? ''));

        if (!$first_name) $errors[] = 'First name is required.';
        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';

        if (empty($errors)) {
            $stmt = $db->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
            $stmt->execute([$email, $user_id]);
            if ($stmt->fetch()) {
                $errors[] = 'This email is already in use by another account.';
            }
        }

        $password = $_POST['password'] ?? '';
        if ($password && strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters.';
        }

        if (empty($errors)) {
            $stmt = $db->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ? WHERE id = ? AND role = 'admin'");
            $stmt->execute([$first_name, $last_name, $email, $user_id]);
            if ($password) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $db->prepare("UPDATE users SET password = ? WHERE id = ? AND role = 'admin'")->execute([$hash, $user_id]);
            }
            log_activity('update_admin', 'user', $user_id);
            $_SESSION['flash'] = 'Admin user updated.';
            header('Location: /admin/admins');
            exit;
        }
    }

    // Reset password
    if ($action === 'reset_password' && $user_id > 0) {
        $password = $_POST['password'] ?? '';
        if (strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $db->prepare("UPDATE users SET password = ? WHERE id = ? AND role = 'admin'")->execute([$hash, $user_id]);
            log_activity('reset_admin_password', 'user', $user_id);
            $_SESSION['flash'] = 'Password reset successfully.';
            header('Location: /admin/admins');
            exit;
        }
    }

    // Toggle status
    if (in_array($action, ['activate', 'suspend']) && $user_id > 0) {
        if ($user_id == $_user['id']) {
            $errors[] = 'You cannot change your own status.';
        } else {
            $new_status = $action === 'activate' ? 'active' : 'suspended';
            $db->prepare("UPDATE users SET status = ? WHERE id = ? AND role = 'admin'")->execute([$new_status, $user_id]);
            log_activity($action . '_admin', 'user', $user_id);
            $_SESSION['flash'] = 'Admin status updated.';
            header('Location: /admin/admins');
            exit;
        }
    }

    // Delete admin
    if ($action === 'delete' && $user_id > 0) {
        if ($user_id == $_user['id']) {
            $errors[] = 'You cannot delete your own account.';
        } else {
            $db->prepare("DELETE FROM users WHERE id = ? AND role = 'admin'")->execute([$user_id]);
            log_activity('delete_admin', 'user', $user_id);
            $_SESSION['flash'] = 'Admin user deleted.';
            header('Location: /admin/admins');
            exit;
        }
    }
}

// Fetch all admins
$admins = $db->query("SELECT id, first_name, last_name, email, phone, status, created_at, last_login FROM users WHERE role = 'admin' ORDER BY created_at ASC")->fetchAll();
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Admin Users <small class="text-muted">(<?php echo count($admins); ?>)</small></h4>
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createModal"><i class="ti-plus mr-1"></i> New Admin</button>
    </div>

    <?php if (!empty($_SESSION['flash'])): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo e($_SESSION['flash']); unset($_SESSION['flash']); ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?php foreach ($errors as $err): ?><div><?php echo e($err); ?></div><?php endforeach; ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php endif; ?>

    <!-- Admin Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Created</th>
                            <th>Last Login</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($admins)): ?>
                        <tr><td colspan="6" class="text-center py-4 text-muted">No admin users found.</td></tr>
                        <?php else: ?>
                        <?php foreach ($admins as $admin): ?>
                        <tr>
                            <td>
                                <strong><?php echo e($admin['first_name'] . ' ' . $admin['last_name']); ?></strong>
                                <?php if ($admin['id'] == $_user['id']): ?><span class="badge badge-info ml-1">You</span><?php endif; ?>
                            </td>
                            <td><small><?php echo e($admin['email']); ?></small></td>
                            <td><small><?php echo date('M j, Y', strtotime($admin['created_at'])); ?></small></td>
                            <td><small><?php echo $admin['last_login'] ? time_ago($admin['last_login']) : 'Never'; ?></small></td>
                            <td>
                                <span class="badge badge-<?php echo $admin['status'] === 'active' ? 'success' : 'danger'; ?>"><?php echo ucfirst($admin['status']); ?></span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#editModal-<?php echo $admin['id']; ?>" title="Edit"><i class="ti-pencil"></i></button>
                                <button class="btn btn-sm btn-outline-warning" data-toggle="modal" data-target="#passwordModal-<?php echo $admin['id']; ?>" title="Reset Password"><i class="ti-key"></i></button>
                                <?php if ($admin['id'] != $_user['id']): ?>
                                <form method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="user_id" value="<?php echo $admin['id']; ?>">
                                    <?php if ($admin['status'] === 'active'): ?>
                                    <button type="submit" name="action" value="suspend" class="btn btn-sm btn-outline-danger" onclick="return confirm('Suspend this admin?')" title="Suspend"><i class="ti-lock"></i></button>
                                    <?php else: ?>
                                    <button type="submit" name="action" value="activate" class="btn btn-sm btn-outline-success" title="Activate"><i class="ti-unlock"></i></button>
                                    <?php endif; ?>
                                </form>
                                <form method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="user_id" value="<?php echo $admin['id']; ?>">
                                    <button type="submit" name="action" value="delete" class="btn btn-sm btn-outline-danger" onclick="return confirm('Permanently delete this admin? This cannot be undone.')" title="Delete"><i class="ti-trash"></i></button>
                                </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create Admin Modal -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="action" value="create">
                <div class="modal-header">
                    <h5 class="modal-title">Create Admin User</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>First Name <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="last_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" minlength="6" required>
                        <small class="text-muted">Minimum 6 characters.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Admin</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit & Password Reset Modals (per admin) -->
<?php foreach ($admins as $admin): ?>
<div class="modal fade" id="editModal-<?php echo $admin['id']; ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="user_id" value="<?php echo $admin['id']; ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Admin</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>First Name <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" class="form-control" value="<?php echo e($admin['first_name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="<?php echo e($admin['last_name']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="<?php echo e($admin['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="password" class="form-control" minlength="6">
                        <small class="text-muted">Leave blank to keep current password. Min 6 characters.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="passwordModal-<?php echo $admin['id']; ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="action" value="reset_password">
                <input type="hidden" name="user_id" value="<?php echo $admin['id']; ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Reset Password — <?php echo e($admin['first_name']); ?></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>New Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" minlength="6" required>
                        <small class="text-muted">Minimum 6 characters.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>

    </div><!-- /.dashboard-content -->
</div><!-- /.dashboard-wrapper -->

<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/js/admin.js"></script>
</body>
</html>
