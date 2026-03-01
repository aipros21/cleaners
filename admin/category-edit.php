<?php
/**
 * Admin - Create/Edit Category
 */
$page_title = 'Category Editor | Admin';
$admin_page = 'categories';
require_once __DIR__ . '/inc_admin_head.php';

$db = get_db();
$id = (int)($_GET['id'] ?? 0);
$is_new = !$id;

$category = [
    'name' => '', 'slug' => '', 'description' => '', 'icon' => '',
    'image' => '', 'meta_title' => '', 'meta_description' => '',
    'lead_price' => '', 'sort_order' => 0, 'is_active' => 1
];

if ($id) {
    $stmt = $db->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    $category = $stmt->fetch();
    if (!$category) {
        header('Location: /admin/categories');
        exit;
    }
}

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $name = trim($_POST['name'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $icon = trim($_POST['icon'] ?? '');
    $meta_title = trim($_POST['meta_title'] ?? '');
    $meta_description = trim($_POST['meta_description'] ?? '');
    $lead_price = (float)($_POST['lead_price'] ?? 0);
    $sort_order = (int)($_POST['sort_order'] ?? 0);
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    if (!$name) $errors[] = 'Category name is required.';
    if (!$slug) $slug = slugify($name);

    // Check slug uniqueness
    $check = $db->prepare("SELECT id FROM categories WHERE slug = ? AND id != ?");
    $check->execute([$slug, $id]);
    if ($check->fetch()) {
        $errors[] = 'This slug is already in use.';
    }

    // Handle image upload
    $image = $category['image'] ?? '';
    if (!empty($_FILES['image']['name'])) {
        $upload = handle_upload('image', ['type' => 'category']);
        if ($upload['success']) {
            $image = $upload['url'];
        } else {
            $errors[] = 'Image upload: ' . $upload['error'];
        }
    }

    if (empty($errors)) {
        if ($is_new) {
            $stmt = $db->prepare("INSERT INTO categories (name, slug, description, icon, image, meta_title, meta_description, lead_price, sort_order, is_active, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$name, $slug, $description, $icon, $image, $meta_title, $meta_description, $lead_price ?: null, $sort_order, $is_active]);
            $id = $db->lastInsertId();
            log_activity('create_category', 'category', $id, "Created: $name");
            $_SESSION['flash'] = 'Category created successfully.';
            header('Location: /admin/categories');
            exit;
        } else {
            $stmt = $db->prepare("UPDATE categories SET name = ?, slug = ?, description = ?, icon = ?, image = ?, meta_title = ?, meta_description = ?, lead_price = ?, sort_order = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$name, $slug, $description, $icon, $image, $meta_title, $meta_description, $lead_price ?: null, $sort_order, $is_active, $id]);
            log_activity('edit_category', 'category', $id, "Edited: $name");
            $success = 'Category updated successfully.';

            // Refresh
            $stmt = $db->prepare("SELECT * FROM categories WHERE id = ?");
            $stmt->execute([$id]);
            $category = $stmt->fetch();
        }
    }
}
?>

<div class="container-fluid py-4">
    <?php echo render_breadcrumbs([['name' => 'Categories', 'url' => '/admin/categories'], ['name' => $is_new ? 'New Category' : 'Edit: ' . $category['name']]]); ?>

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
                    <div class="card-header"><h6 class="mb-0"><?php echo $is_new ? 'Create' : 'Edit'; ?> Category</h6></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 form-group">
                                <label>Category Name *</label>
                                <input type="text" name="name" class="form-control" value="<?php echo e($category['name']); ?>" required id="catName">
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Slug</label>
                                <input type="text" name="slug" class="form-control" value="<?php echo e($category['slug']); ?>" id="catSlug">
                                <small class="form-text text-muted">Auto-generated if empty</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3"><?php echo e($category['description']); ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Icon Class</label>
                                <input type="text" name="icon" class="form-control" value="<?php echo e($category['icon']); ?>" placeholder="e.g., ti-home">
                                <small class="form-text text-muted">Themify icon class name</small>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Category Image</label>
                                <?php if (!empty($category['image'])): ?>
                                <div class="mb-2"><img src="<?php echo e($category['image']); ?>" alt="" class="img-thumbnail" style="max-height:60px;"></div>
                                <?php endif; ?>
                                <input type="file" name="image" class="form-control-file" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header"><h6 class="mb-0">SEO</h6></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" value="<?php echo e($category['meta_title']); ?>" maxlength="70">
                        </div>
                        <div class="form-group">
                            <label>Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="2" maxlength="160"><?php echo e($category['meta_description']); ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header"><h6 class="mb-0">Settings</h6></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label>Lead Price ($)</label>
                                <input type="number" name="lead_price" class="form-control" step="0.01" min="0" value="<?php echo e($category['lead_price']); ?>">
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Sort Order</label>
                                <input type="number" name="sort_order" class="form-control" value="<?php echo e($category['sort_order']); ?>">
                            </div>
                            <div class="col-md-4 form-group">
                                <label>&nbsp;</label>
                                <div class="custom-control custom-switch mt-2">
                                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" <?php echo $category['is_active'] ? 'checked' : ''; ?>>
                                    <label class="custom-control-label" for="is_active">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg mb-4"><i class="ti-save mr-1"></i> <?php echo $is_new ? 'Create Category' : 'Save Changes'; ?></button>
                <a href="/admin/categories" class="btn btn-outline-secondary btn-lg mb-4">Cancel</a>
            </form>
        </div>
    </div>
</div>

    </div><!-- /.dashboard-content -->
</div><!-- /.dashboard-wrapper -->

<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
// Auto-generate slug from name
document.getElementById('catName').addEventListener('input', function() {
    var slug = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
    document.getElementById('catSlug').value = slug;
});
</script>
<script src="/js/admin.js"></script>
</body>
</html>
