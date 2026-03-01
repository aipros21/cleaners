<?php
/**
 * Admin - Create/Edit Static Page
 */
$page_title = 'Page Editor | Admin';
$admin_page = 'pages';
require_once __DIR__ . '/inc_admin_head.php';

$db = get_db();
$id = (int)($_GET['id'] ?? 0);
$is_new = !$id;

$pg = [
    'title' => '', 'slug' => '', 'content' => '',
    'meta_title' => '', 'meta_description' => '',
    'status' => 'draft', 'image' => '', 'type' => 'page'
];

if ($id) {
    $stmt = $db->prepare("SELECT * FROM pages WHERE id = ? AND type = 'page'");
    $stmt->execute([$id]);
    $pg = $stmt->fetch();
    if (!$pg) {
        header('Location: /admin/pages');
        exit;
    }
}

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $title = trim($_POST['title'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $content = $_POST['content'] ?? '';
    $meta_title = trim($_POST['meta_title'] ?? '');
    $meta_description = trim($_POST['meta_description'] ?? '');
    $status = $_POST['status'] ?? 'draft';

    if (!$title) $errors[] = 'Title is required.';
    if (!$slug) $slug = slugify($title);

    // Check slug uniqueness (within static pages only)
    $check = $db->prepare("SELECT id FROM pages WHERE slug = ? AND type = 'page' AND id != ?");
    $check->execute([$slug, $id]);
    if ($check->fetch()) {
        $errors[] = 'This slug is already in use.';
    }

    // Handle image upload
    $image = $pg['image'] ?? '';
    if (!empty($_FILES['image']['name'])) {
        $upload = handle_upload('image', ['type' => 'page_image']);
        if ($upload['success']) {
            $image = $upload['url'];
        } else {
            $errors[] = 'Image upload: ' . $upload['error'];
        }
    }

    if (empty($errors)) {
        if ($is_new) {
            $stmt = $db->prepare("INSERT INTO pages (title, slug, content, image, meta_title, meta_description, status, type, author_id, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, 'page', ?, NOW())");
            $stmt->execute([$title, $slug, $content, $image, $meta_title, $meta_description, $status, $_user['id']]);
            $id = $db->lastInsertId();
            log_activity('create_page', 'page', $id, "Created: $title");
            $_SESSION['flash'] = 'Page created successfully.';
            header('Location: /admin/page-edit?id=' . $id);
            exit;
        } else {
            $stmt = $db->prepare("UPDATE pages SET title = ?, slug = ?, content = ?, image = ?, meta_title = ?, meta_description = ?, status = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([$title, $slug, $content, $image, $meta_title, $meta_description, $status, $id]);
            log_activity('edit_page', 'page', $id, "Edited: $title");
            $success = 'Page updated successfully.';

            // Refresh
            $stmt = $db->prepare("SELECT * FROM pages WHERE id = ?");
            $stmt->execute([$id]);
            $pg = $stmt->fetch();
        }
    }
}
?>

<div class="container-fluid py-4">
    <?php echo render_breadcrumbs([['name' => 'Pages', 'url' => '/admin/pages'], ['name' => $is_new ? 'New Page' : 'Edit: ' . $pg['title']]]); ?>

    <?php if (!empty($_SESSION['flash'])): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo e($_SESSION['flash']); unset($_SESSION['flash']); ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>
    <?php endif; ?>
    <?php if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo e($success); ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>
    <?php endif; ?>
    <?php if (!empty($errors)): ?>
    <div class="alert alert-danger alert-dismissible fade show"><ul class="mb-0"><?php foreach ($errors as $err): ?><li><?php echo e($err); ?></li><?php endforeach; ?></ul><button type="button" class="close" data-dismiss="alert">&times;</button></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header"><h6 class="mb-0"><?php echo $is_new ? 'Create' : 'Edit'; ?> Page</h6></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Title *</label>
                            <input type="text" name="title" class="form-control" value="<?php echo e($pg['title']); ?>" required id="pageTitle">
                        </div>
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" name="slug" class="form-control" value="<?php echo e($pg['slug']); ?>" id="pageSlug">
                            <small class="form-text text-muted">Auto-generated from title if empty</small>
                        </div>
                        <div class="form-group">
                            <label>Content</label>
                            <textarea name="content" class="form-control" rows="20" style="font-family:monospace;font-size:14px;"><?php echo e($pg['content']); ?></textarea>
                            <small class="form-text text-muted">HTML is supported</small>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header"><h6 class="mb-0">SEO</h6></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" value="<?php echo e($pg['meta_title']); ?>" maxlength="70">
                            <small class="form-text text-muted">Leave blank to use page title</small>
                        </div>
                        <div class="form-group">
                            <label>Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="2" maxlength="160"><?php echo e($pg['meta_description']); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header"><h6 class="mb-0">Publish</h6></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="draft" <?php echo $pg['status'] === 'draft' ? 'selected' : ''; ?>>Draft</option>
                                <option value="published" <?php echo $pg['status'] === 'published' ? 'selected' : ''; ?>>Published</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block"><i class="ti-save mr-1"></i> <?php echo $is_new ? 'Create Page' : 'Save Changes'; ?></button>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header"><h6 class="mb-0">Featured Image</h6></div>
                    <div class="card-body">
                        <?php if (!empty($pg['image'])): ?>
                        <div class="mb-2"><img src="<?php echo e($pg['image']); ?>" alt="" class="img-thumbnail img-fluid"></div>
                        <?php endif; ?>
                        <input type="file" name="image" class="form-control-file" accept="image/*">
                    </div>
                </div>

                <?php if (!$is_new): ?>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td class="text-muted">ID</td><td>#<?php echo $pg['id']; ?></td></tr>
                            <tr><td class="text-muted">Views</td><td><?php echo number_format($pg['views'] ?? 0); ?></td></tr>
                            <tr><td class="text-muted">Created</td><td><?php echo date('M j, Y', strtotime($pg['created_at'])); ?></td></tr>
                            <?php if ($pg['updated_at']): ?>
                            <tr><td class="text-muted">Updated</td><td><?php echo date('M j, Y', strtotime($pg['updated_at'])); ?></td></tr>
                            <?php endif; ?>
                        </table>
                        <hr>
                        <?php if ($pg['status'] === 'published'): ?>
                        <a href="/<?php echo e($pg['slug']); ?>" target="_blank" class="btn btn-outline-primary btn-block btn-sm"><i class="ti-eye mr-1"></i> View Page</a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </form>
</div>

    </div><!-- /.dashboard-content -->
</div><!-- /.dashboard-wrapper -->

<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
// Auto-generate slug from title
document.getElementById('pageTitle').addEventListener('input', function() {
    var slugField = document.getElementById('pageSlug');
    if (!slugField.dataset.manual) {
        slugField.value = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
    }
});
document.getElementById('pageSlug').addEventListener('input', function() {
    this.dataset.manual = '1';
});
</script>
<script src="/js/admin.js"></script>
</body>
</html>
