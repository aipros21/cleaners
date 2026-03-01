<?php
/**
 * Admin - Site Settings
 */
$page_title = 'Settings | Admin';
$admin_page = 'settings';
require_once __DIR__ . '/inc_admin_head.php';

$db = get_db();
$success = '';

// Save settings
if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $settings = $_POST['settings'] ?? [];
    $stmt = $db->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = ?");
    foreach ($settings as $key => $value) {
        $stmt->execute([trim($value), $key]);
    }
    $success = 'Settings saved successfully.';
    log_activity('update_settings', 'settings', null, 'Updated ' . count($settings) . ' settings');
}

// Fetch all settings grouped
$rows = $db->query("SELECT * FROM settings ORDER BY setting_group, setting_key")->fetchAll();
$groups = [];
foreach ($rows as $row) {
    $group = $row['setting_group'] ?: 'general';
    $groups[$group][] = $row;
}
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Site Settings</h4>
    </div>

    <?php if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo e($success); ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>
    <?php endif; ?>

    <form method="POST">
        <?php echo csrf_field(); ?>

        <?php foreach ($groups as $group => $settings_list): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="ti-settings mr-1"></i> <?php echo e(ucwords(str_replace('_', ' ', $group))); ?></h6>
            </div>
            <div class="card-body">
                <?php foreach ($settings_list as $s): ?>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">
                        <strong><?php echo e(ucwords(str_replace('_', ' ', $s['setting_key']))); ?></strong>
                    </label>
                    <div class="col-md-9">
                        <?php if (strlen($s['setting_value'] ?? '') > 100): ?>
                        <textarea name="settings[<?php echo e($s['setting_key']); ?>]" class="form-control" rows="3"><?php echo e($s['setting_value']); ?></textarea>
                        <?php else: ?>
                        <input type="text" name="settings[<?php echo e($s['setting_key']); ?>]" class="form-control" value="<?php echo e($s['setting_value']); ?>">
                        <?php endif; ?>
                        <?php if (!empty($s['description'])): ?>
                        <small class="form-text text-muted"><?php echo e($s['description']); ?></small>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>

        <?php if (empty($groups)): ?>
        <div class="card">
            <div class="card-body text-center py-5 text-muted">
                <i class="ti-settings display-4 d-block mb-3"></i>
                <p>No settings found in the database.</p>
            </div>
        </div>
        <?php else: ?>
        <button type="submit" class="btn btn-primary btn-lg mb-4"><i class="ti-save mr-1"></i> Save All Settings</button>
        <?php endif; ?>
    </form>
</div>

    </div><!-- /.dashboard-content -->
</div><!-- /.dashboard-wrapper -->

<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/js/admin.js"></script>
</body>
</html>
