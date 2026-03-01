<?php
/**
 * Cleaner Dashboard - Account Settings
 */
$dash_page = 'settings';
$page_title = 'Settings | FindMyCleaner';
require_once __DIR__ . '/inc_dashboard_head.php';

$db = get_db();
$cid = $_cleaner['id'];
$uid = $_user['id'];

$success = '';
$error = '';

// Process POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $action = $_POST['action'] ?? '';

    // Change Password
    if ($action === 'change_password') {
        $current_password = $_POST['current_password'] ?? '';
        $new_password     = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        // Get current password hash
        $stmt = $db->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$uid]);
        $user_row = $stmt->fetch();

        if (!password_verify($current_password, $user_row['password'])) {
            $error = 'Current password is incorrect.';
        } elseif (strlen($new_password) < 8) {
            $error = 'New password must be at least 8 characters.';
        } elseif ($new_password !== $confirm_password) {
            $error = 'New passwords do not match.';
        } else {
            $hash = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $db->prepare("UPDATE users SET password = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([$hash, $uid]);
            $success = 'Password changed successfully!';
            log_activity('password_change', 'user', $uid);
        }
    }

    // Update notification preferences
    if ($action === 'update_notifications') {
        $notify_leads     = isset($_POST['notify_leads']) ? 1 : 0;
        $notify_reviews   = isset($_POST['notify_reviews']) ? 1 : 0;
        $notify_marketing = isset($_POST['notify_marketing']) ? 1 : 0;

        // Store as JSON in a simple settings approach using the description field or a dedicated column
        // We'll use a pattern of storing in settings table with cleaner-specific keys
        $prefs = json_encode([
            'leads' => $notify_leads,
            'reviews' => $notify_reviews,
            'marketing' => $notify_marketing
        ]);

        // Upsert notification prefs in settings table
        $key = 'cleaner_notify_' . $cid;
        $stmt = $db->prepare("SELECT id FROM settings WHERE setting_key = ?");
        $stmt->execute([$key]);

        if ($stmt->fetch()) {
            $db->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = ?")->execute([$prefs, $key]);
        } else {
            $db->prepare("INSERT INTO settings (setting_key, setting_value, setting_group) VALUES (?, ?, 'notifications')")->execute([$key, $prefs]);
        }

        $success = 'Notification preferences updated!';
        log_activity('notification_prefs_update', 'cleaner', $cid);
    }

    // Deactivate account
    if ($action === 'deactivate') {
        $confirm_text = trim($_POST['confirm_deactivate'] ?? '');

        if ($confirm_text !== 'DEACTIVATE') {
            $error = 'Please type DEACTIVATE to confirm account deactivation.';
        } else {
            $db->prepare("UPDATE users SET status = 'suspended', updated_at = NOW() WHERE id = ?")->execute([$uid]);
            $db->prepare("UPDATE cleaners SET status = 'suspended', updated_at = NOW() WHERE id = ?")->execute([$cid]);
            log_activity('account_deactivate', 'user', $uid);

            // Logout
            logout_user();
            header('Location: /?deactivated=1');
            exit;
        }
    }
}

// Load current notification prefs
$notify_prefs = ['leads' => 1, 'reviews' => 1, 'marketing' => 0];
$prefs_key = 'cleaner_notify_' . $cid;
$stmt = $db->prepare("SELECT setting_value FROM settings WHERE setting_key = ?");
$stmt->execute([$prefs_key]);
$prefs_row = $stmt->fetch();
if ($prefs_row) {
    $decoded = json_decode($prefs_row['setting_value'], true);
    if ($decoded) $notify_prefs = array_merge($notify_prefs, $decoded);
}
?>

<div class="container-fluid py-4">
    <h4 class="mb-4">Account Settings</h4>

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
        <div class="col-lg-8">
            <!-- Change Password -->
            <div class="card mb-4">
                <div class="card-header"><h6 class="mb-0"><i class="ti-lock mr-1"></i> Change Password</h6></div>
                <div class="card-body">
                    <form method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="action" value="change_password">

                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="new_password">New Password</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password" required minlength="8">
                                    <small class="form-text text-muted">Minimum 8 characters.</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="confirm_password">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required minlength="8">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="ti-save mr-1"></i> Update Password
                        </button>
                    </form>
                </div>
            </div>

            <!-- Email Notifications -->
            <div class="card mb-4">
                <div class="card-header"><h6 class="mb-0"><i class="ti-bell mr-1"></i> Email Notifications</h6></div>
                <div class="card-body">
                    <form method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="action" value="update_notifications">

                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" id="notify_leads" name="notify_leads" value="1" <?php echo $notify_prefs['leads'] ? 'checked' : ''; ?>>
                            <label class="custom-control-label" for="notify_leads">
                                <strong>New Leads</strong>
                                <br><small class="text-muted">Get notified when a new lead is assigned to you.</small>
                            </label>
                        </div>

                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" id="notify_reviews" name="notify_reviews" value="1" <?php echo $notify_prefs['reviews'] ? 'checked' : ''; ?>>
                            <label class="custom-control-label" for="notify_reviews">
                                <strong>New Reviews</strong>
                                <br><small class="text-muted">Get notified when a customer leaves a review.</small>
                            </label>
                        </div>

                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" id="notify_marketing" name="notify_marketing" value="1" <?php echo $notify_prefs['marketing'] ? 'checked' : ''; ?>>
                            <label class="custom-control-label" for="notify_marketing">
                                <strong>Marketing &amp; Tips</strong>
                                <br><small class="text-muted">Receive tips to improve your profile and marketing updates.</small>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="ti-save mr-1"></i> Save Preferences
                        </button>
                    </form>
                </div>
            </div>

            <!-- Deactivate Account -->
            <div class="card border-danger">
                <div class="card-header bg-danger text-white"><h6 class="mb-0"><i class="ti-na mr-1"></i> Deactivate Account</h6></div>
                <div class="card-body">
                    <p class="text-muted">
                        Deactivating your account will hide your profile from search results and stop all lead assignments.
                        This action can be reversed by contacting support.
                    </p>
                    <form method="POST" onsubmit="return confirm('Are you absolutely sure you want to deactivate your account? Your profile will be hidden from all search results.');">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="action" value="deactivate">

                        <div class="form-group">
                            <label for="confirm_deactivate">Type <strong>DEACTIVATE</strong> to confirm</label>
                            <input type="text" class="form-control" id="confirm_deactivate" name="confirm_deactivate" required placeholder="DEACTIVATE" autocomplete="off">
                        </div>

                        <button type="submit" class="btn btn-danger">
                            <i class="ti-na mr-1"></i> Deactivate My Account
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header"><h6 class="mb-0">Account Info</h6></div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted">Email</td>
                            <td><?php echo e($_user['email']); ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Role</td>
                            <td><span class="badge badge-primary"><?php echo ucfirst($_user['role']); ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Status</td>
                            <td><span class="badge badge-success"><?php echo ucfirst($_user['status']); ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Plan</td>
                            <td><?php echo ucfirst($_cleaner['plan']); ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Member since</td>
                            <td><?php echo date('M j, Y', strtotime($_cleaner['created_at'])); ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h6>Need Help?</h6>
                    <p class="text-muted small">
                        Contact our support team if you have questions about your account, billing, or need assistance.
                    </p>
                    <a href="mailto:info@cleaners-247.com" class="btn btn-outline-primary btn-sm btn-block">
                        <i class="ti-email mr-1"></i> Contact Support
                    </a>
                </div>
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
