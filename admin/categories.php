<?php
/**
 * Admin - Manage Categories
 */
$page_title = 'Manage Categories | Admin';
$admin_page = 'categories';
require_once __DIR__ . '/inc_admin_head.php';

$db = get_db();

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $action = $_POST['action'] ?? '';
    $category_id = (int)($_POST['category_id'] ?? 0);

    if ($category_id > 0) {
        if ($action === 'toggle') {
            $db->prepare("UPDATE categories SET is_active = NOT is_active WHERE id = ?")->execute([$category_id]);
            log_activity('toggle_category', 'category', $category_id);
            $_SESSION['flash'] = 'Category status updated.';
        } elseif ($action === 'reorder') {
            $new_order = (int)($_POST['sort_order'] ?? 0);
            $db->prepare("UPDATE categories SET sort_order = ? WHERE id = ?")->execute([$new_order, $category_id]);
            $_SESSION['flash'] = 'Category order updated.';
        } elseif ($action === 'delete') {
            // Check for cleaners in this category
            $count = $db->prepare("SELECT COUNT(*) FROM cleaner_categories WHERE category_id = ?");
            $count->execute([$category_id]);
            if ($count->fetchColumn() > 0) {
                $_SESSION['flash_error'] = 'Cannot delete category with assigned cleaners.';
            }
            // Check for open leads in this category
            $lead_count = $db->prepare("SELECT COUNT(*) FROM leads WHERE category_id = ? AND status IN ('new','contacted','assigned')");
            $lead_count->execute([$category_id]);
            if ($lead_count->fetchColumn() > 0) {
                $_SESSION['flash_error'] = 'Cannot delete category with open leads.';
            }
            if (empty($_SESSION['flash_error'])) {
                $db->prepare("DELETE FROM categories WHERE id = ?")->execute([$category_id]);
                log_activity('delete_category', 'category', $category_id);
                $_SESSION['flash'] = 'Category deleted.';
            }
        }
    }
    header('Location: /admin/categories');
    exit;
}

// Fetch categories with cleaner counts
$categories = $db->query("SELECT cat.*,
    (SELECT COUNT(*) FROM cleaner_categories cc WHERE cc.category_id = cat.id) AS cleaner_count
    FROM categories cat
    ORDER BY cat.sort_order ASC, cat.name ASC")->fetchAll();
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Categories <small class="text-muted">(<?php echo count($categories); ?>)</small></h4>
        <a href="/admin/category-edit" class="btn btn-primary"><i class="ti-plus mr-1"></i> Add Category</a>
    </div>

    <?php if (!empty($_SESSION['flash'])): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo e($_SESSION['flash']); unset($_SESSION['flash']); ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['flash_error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show"><?php echo e($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th style="width:60px;">Order</th>
                            <th>Icon</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Cleaners</th>
                            <th>Lead Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($categories)): ?>
                        <tr><td colspan="8" class="text-center py-4 text-muted">No categories yet.</td></tr>
                        <?php else: ?>
                        <?php foreach ($categories as $cat): ?>
                        <tr>
                            <td>
                                <form method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="category_id" value="<?php echo $cat['id']; ?>">
                                    <input type="hidden" name="action" value="reorder">
                                    <input type="number" name="sort_order" value="<?php echo $cat['sort_order']; ?>" class="form-control form-control-sm" style="width:60px;" onchange="this.form.submit()">
                                </form>
                            </td>
                            <td>
                                <?php if ($cat['icon']): ?>
                                <i class="<?php echo e($cat['icon']); ?>" style="font-size:20px;"></i>
                                <?php else: ?>
                                <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td><strong><?php echo e($cat['name']); ?></strong></td>
                            <td><small class="text-muted"><?php echo e($cat['slug']); ?></small></td>
                            <td><span class="badge badge-info"><?php echo $cat['cleaner_count']; ?></span></td>
                            <td><?php echo $cat['lead_price'] ? format_money($cat['lead_price']) : '-'; ?></td>
                            <td>
                                <span class="badge badge-<?php echo $cat['is_active'] ? 'success' : 'secondary'; ?>"><?php echo $cat['is_active'] ? 'Active' : 'Inactive'; ?></span>
                            </td>
                            <td>
                                <a href="/admin/category-edit?id=<?php echo $cat['id']; ?>" class="btn btn-sm btn-outline-primary mr-1"><i class="ti-pencil"></i></a>
                                <form method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="category_id" value="<?php echo $cat['id']; ?>">
                                    <button type="submit" name="action" value="toggle" class="btn btn-sm btn-outline-<?php echo $cat['is_active'] ? 'warning' : 'success'; ?>">
                                        <i class="ti-<?php echo $cat['is_active'] ? 'close' : 'eye'; ?>"></i>
                                    </button>
                                    <button type="submit" name="action" value="delete" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this category?')"><i class="ti-trash"></i></button>
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
