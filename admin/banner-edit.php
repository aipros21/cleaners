<?php
/**
 * Admin - Create/Edit Banner
 */
$page_title = 'Banner Editor | Admin';
$admin_page = 'banners';
require_once __DIR__ . '/inc_admin_head.php';

$db = get_db();
$id = (int)($_GET['id'] ?? 0);
$is_new = !$id;

$banner = [
    'name' => '', 'image' => '', 'url' => '', 'position' => 'sidebar',
    'page_target' => '', 'category_id' => null, 'start_date' => '',
    'end_date' => '', 'is_active' => 1
];

if ($id) {
    $stmt = $db->prepare("SELECT * FROM banners WHERE id = ?");
    $stmt->execute([$id]);
    $banner = $stmt->fetch();
    if (!$banner) {
        header('Location: /admin/banners');
        exit;
    }
}

// Categories for dropdown
$categories = $db->query("SELECT id, name FROM categories WHERE is_active = 1 ORDER BY name")->fetchAll();

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $name = trim($_POST['name'] ?? '');
    $url = trim($_POST['url'] ?? '');
    $position = $_POST['position'] ?? 'sidebar';
    $page_target = trim($_POST['page_target'] ?? '');
    $category_id = (int)($_POST['category_id'] ?? 0) ?: null;
    $start_date = $_POST['start_date'] ?? null;
    $end_date = $_POST['end_date'] ?? null;
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    if (!$name) $errors[] = 'Banner name is required.';

    // Handle image upload
    $image = $banner['image'] ?? '';
    if (!empty($_FILES['image']['name'])) {
        $upload = handle_upload('image', ['type' => 'banner']);
        if ($upload['success']) {
            $image = $upload['url'];
        } else {
            $errors[] = 'Image upload: ' . $upload['error'];
        }
    }

    if ($is_new && !$image) {
        $errors[] = 'Banner image is required.';
    }

    if (empty($errors)) {
        if ($is_new) {
            $stmt = $db->prepare("INSERT INTO banners (name, image, url, position, page_target, category_id, start_date, end_date, is_active, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$name, $image, $url, $position, $page_target, $category_id, $start_date ?: null, $end_date ?: null, $is_active]);
            $id = $db->lastInsertId();
            log_activity('create_banner', 'banner', $id, "Created: $name");
            $_SESSION['flash'] = 'Banner created successfully.';
            header('Location: /admin/banners');
            exit;
        } else {
            $stmt = $db->prepare("UPDATE banners SET name = ?, image = ?, url = ?, position = ?, page_target = ?, category_id = ?, start_date = ?, end_date = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$name, $image, $url, $position, $page_target, $category_id, $start_date ?: null, $end_date ?: null, $is_active, $id]);
            log_activity('edit_banner', 'banner', $id, "Edited: $name");
            $success = 'Banner updated successfully.';

            // Refresh
            $stmt = $db->prepare("SELECT * FROM banners WHERE id = ?");
            $stmt->execute([$id]);
            $banner = $stmt->fetch();
        }
    }
}
?>

<div class="container-fluid py-4">
    <?php echo render_breadcrumbs([['name' => 'Banners', 'url' => '/admin/banners'], ['name' => $is_new ? 'New Banner' : 'Edit: ' . $banner['name']]]); ?>

    <?php if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo e($success); ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>
    <?php endif; ?>
    <?php if (!empty($errors)): ?>
    <div class="alert alert-danger alert-dismissible fade show"><ul class="mb-0"><?php foreach ($errors as $err): ?><li><?php echo e($err); ?></li><?php endforeach; ?></ul><button type="button" class="close" data-dismiss="alert">&times;</button></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8">
            <form method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="card mb-4">
                    <div class="card-header"><h6 class="mb-0"><?php echo $is_new ? 'Create' : 'Edit'; ?> Banner</h6></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Banner Name *</label>
                            <input type="text" name="name" class="form-control" value="<?php echo e($banner['name']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Banner Image *</label>
                            <?php if (!empty($banner['image'])): ?>
                            <div class="mb-2"><img src="<?php echo e($banner['image']); ?>" alt="Preview" class="img-thumbnail" style="max-height:120px;"></div>
                            <?php endif; ?>
                            <input type="file" name="image" class="form-control-file" accept="image/*" <?php echo $is_new ? 'required' : ''; ?>>
                            <small class="form-text text-muted">Recommended sizes: Header 1200x150, Sidebar 300x250, Between listings 728x90</small>
                        </div>

                        <div class="form-group">
                            <label>Click URL</label>
                            <input type="url" name="url" class="form-control" value="<?php echo e($banner['url']); ?>" placeholder="https://example.com">
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Position</label>
                                <select name="position" class="form-control">
                                    <option value="header" <?php echo $banner['position'] === 'header' ? 'selected' : ''; ?>>Header</option>
                                    <option value="sidebar" <?php echo $banner['position'] === 'sidebar' ? 'selected' : ''; ?>>Sidebar</option>
                                    <option value="between_listings" <?php echo $banner['position'] === 'between_listings' ? 'selected' : ''; ?>>Between Listings</option>
                                    <option value="footer" <?php echo $banner['position'] === 'footer' ? 'selected' : ''; ?>>Footer</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Page Target</label>
                                <input type="text" name="page_target" class="form-control" value="<?php echo e($banner['page_target']); ?>" placeholder="e.g., home, cleaners, category">
                                <small class="form-text text-muted">Leave blank for all pages</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label>Category</label>
                                <select name="category_id" class="form-control">
                                    <option value="">All Categories</option>
                                    <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>" <?php echo $banner['category_id'] == $cat['id'] ? 'selected' : ''; ?>><?php echo e($cat['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Start Date</label>
                                <input type="date" name="start_date" class="form-control" value="<?php echo e($banner['start_date']); ?>">
                            </div>
                            <div class="col-md-4 form-group">
                                <label>End Date</label>
                                <input type="date" name="end_date" class="form-control" value="<?php echo e($banner['end_date']); ?>">
                            </div>
                        </div>

                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" <?php echo $banner['is_active'] ? 'checked' : ''; ?>>
                            <label class="custom-control-label" for="is_active">Active</label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg mb-4"><i class="ti-save mr-1"></i> <?php echo $is_new ? 'Create Banner' : 'Save Changes'; ?></button>
                <a href="/admin/banners" class="btn btn-outline-secondary btn-lg mb-4">Cancel</a>
            </form>
        </div>

        <?php if (!$is_new): ?>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header"><h6 class="mb-0">Stats</h6></div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr><td class="text-muted">Impressions</td><td><?php echo number_format($banner['impressions']); ?></td></tr>
                        <tr><td class="text-muted">Clicks</td><td><?php echo number_format($banner['clicks']); ?></td></tr>
                        <tr>
                            <td class="text-muted">CTR</td>
                            <td><?php echo $banner['impressions'] > 0 ? round(($banner['clicks'] / $banner['impressions']) * 100, 2) : 0; ?>%</td>
                        </tr>
                        <tr><td class="text-muted">Created</td><td><?php echo date('M j, Y', strtotime($banner['created_at'])); ?></td></tr>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

    </div><!-- /.dashboard-content -->
</div><!-- /.dashboard-wrapper -->

<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/js/admin.js"></script>
</body>
</html>
