<?php
/**
 * Admin - Manage Banners
 */
$page_title = 'Manage Banners | Admin';
$admin_page = 'banners';
require_once __DIR__ . '/inc_admin_head.php';

$db = get_db();

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $action = $_POST['action'] ?? '';
    $banner_id = (int)($_POST['banner_id'] ?? 0);

    if ($banner_id > 0) {
        if ($action === 'toggle') {
            $db->prepare("UPDATE banners SET is_active = NOT is_active WHERE id = ?")->execute([$banner_id]);
            log_activity('toggle_banner', 'banner', $banner_id);
            $_SESSION['flash'] = 'Banner status updated.';
        } elseif ($action === 'delete') {
            $db->prepare("DELETE FROM banners WHERE id = ?")->execute([$banner_id]);
            log_activity('delete_banner', 'banner', $banner_id);
            $_SESSION['flash'] = 'Banner deleted.';
        }
    }
    header('Location: /admin/banners');
    exit;
}

// Fetch all banners
$banners = $db->query("SELECT b.*, cat.name AS category_name FROM banners b LEFT JOIN categories cat ON b.category_id = cat.id ORDER BY b.created_at DESC")->fetchAll();
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Banners <small class="text-muted">(<?php echo count($banners); ?>)</small></h4>
        <a href="/admin/banner-edit" class="btn btn-primary"><i class="ti-plus mr-1"></i> Add New Banner</a>
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
                            <th>Preview</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Category</th>
                            <th>Impressions</th>
                            <th>Clicks</th>
                            <th>CTR</th>
                            <th>Dates</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($banners)): ?>
                        <tr><td colspan="10" class="text-center py-4 text-muted">No banners yet. Create your first one!</td></tr>
                        <?php else: ?>
                        <?php foreach ($banners as $b): ?>
                        <?php $ctr = $b['impressions'] > 0 ? round(($b['clicks'] / $b['impressions']) * 100, 2) : 0; ?>
                        <tr>
                            <td><img src="<?php echo e($b['image']); ?>" alt="" style="max-width:100px;max-height:40px;" class="img-thumbnail"></td>
                            <td><strong><?php echo e($b['name']); ?></strong></td>
                            <td><span class="badge badge-light"><?php echo e($b['position']); ?></span></td>
                            <td><small><?php echo e($b['category_name'] ?: 'All'); ?></small></td>
                            <td><?php echo number_format($b['impressions']); ?></td>
                            <td><?php echo number_format($b['clicks']); ?></td>
                            <td><?php echo $ctr; ?>%</td>
                            <td>
                                <small>
                                    <?php echo $b['start_date'] ? date('M j', strtotime($b['start_date'])) : 'Any'; ?>
                                    - <?php echo $b['end_date'] ? date('M j', strtotime($b['end_date'])) : 'Any'; ?>
                                </small>
                            </td>
                            <td>
                                <span class="badge badge-<?php echo $b['is_active'] ? 'success' : 'secondary'; ?>"><?php echo $b['is_active'] ? 'Active' : 'Inactive'; ?></span>
                            </td>
                            <td>
                                <a href="/admin/banner-edit?id=<?php echo $b['id']; ?>" class="btn btn-sm btn-outline-primary mr-1"><i class="ti-pencil"></i></a>
                                <form method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="banner_id" value="<?php echo $b['id']; ?>">
                                    <button type="submit" name="action" value="toggle" class="btn btn-sm btn-outline-<?php echo $b['is_active'] ? 'warning' : 'success'; ?>" title="<?php echo $b['is_active'] ? 'Deactivate' : 'Activate'; ?>"><i class="ti-<?php echo $b['is_active'] ? 'close' : 'eye'; ?>"></i></button>
                                    <button type="submit" name="action" value="delete" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this banner?')"><i class="ti-trash"></i></button>
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
</div>

    </div><!-- /.dashboard-content -->
</div><!-- /.dashboard-wrapper -->

<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/js/admin.js"></script>
</body>
</html>
