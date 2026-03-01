<?php
/**
 * Admin - Create/Edit Blog Post
 */
$page_title = 'Blog Editor | Admin';
$admin_page = 'blog';
require_once __DIR__ . '/inc_admin_head.php';

$db = get_db();
$id = (int)($_GET['id'] ?? 0);
$is_new = !$id;

$post = [
    'title' => '', 'slug' => '', 'content' => '', 'excerpt' => '',
    'image' => '', 'meta_title' => '', 'meta_description' => '',
    'status' => 'draft', 'published_at' => '', 'type' => 'blog'
];

if ($id) {
    $stmt = $db->prepare("SELECT * FROM pages WHERE id = ? AND type = 'blog'");
    $stmt->execute([$id]);
    $post = $stmt->fetch();
    if (!$post) {
        header('Location: /admin/blog-posts');
        exit;
    }
}

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $title = trim($_POST['title'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $content = $_POST['content'] ?? '';
    $excerpt = trim($_POST['excerpt'] ?? '');
    $meta_title = trim($_POST['meta_title'] ?? '');
    $meta_description = trim($_POST['meta_description'] ?? '');
    $status = $_POST['status'] ?? 'draft';
    $published_at = $_POST['published_at'] ?? '';

    if (!$title) $errors[] = 'Title is required.';
    if (!$slug) $slug = slugify($title);

    // Check slug uniqueness (within blog posts only)
    $check = $db->prepare("SELECT id FROM pages WHERE slug = ? AND type = 'blog' AND id != ?");
    $check->execute([$slug, $id]);
    if ($check->fetch()) {
        $errors[] = 'This slug is already in use.';
    }

    // Handle image upload
    $image = $post['image'] ?? '';
    if (!empty($_FILES['image']['name'])) {
        $upload = handle_upload('image', ['type' => 'blog_image']);
        if ($upload['success']) {
            $image = $upload['url'];
        } else {
            $errors[] = 'Image upload: ' . $upload['error'];
        }
    }

    // Auto-set published_at if publishing
    if ($status === 'published' && !$published_at) {
        $published_at = date('Y-m-d H:i:s');
    }

    if (empty($errors)) {
        if ($is_new) {
            $stmt = $db->prepare("INSERT INTO pages (title, slug, content, excerpt, image, meta_title, meta_description, status, published_at, type, author_id, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'blog', ?, NOW())");
            $stmt->execute([$title, $slug, $content, $excerpt, $image, $meta_title, $meta_description, $status, $published_at ?: null, $_user['id']]);
            $id = $db->lastInsertId();
            log_activity('create_blog_post', 'page', $id, "Created: $title");
            $_SESSION['flash'] = 'Blog post created successfully.';
            header('Location: /admin/blog-edit?id=' . $id);
            exit;
        } else {
            $stmt = $db->prepare("UPDATE pages SET title = ?, slug = ?, content = ?, excerpt = ?, image = ?, meta_title = ?, meta_description = ?, status = ?, published_at = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([$title, $slug, $content, $excerpt, $image, $meta_title, $meta_description, $status, $published_at ?: null, $id]);
            log_activity('edit_blog_post', 'page', $id, "Edited: $title");
            $success = 'Blog post updated successfully.';

            // Refresh
            $stmt = $db->prepare("SELECT * FROM pages WHERE id = ?");
            $stmt->execute([$id]);
            $post = $stmt->fetch();
        }
    }
}
?>

<div class="container-fluid py-4">
    <?php echo render_breadcrumbs([['name' => 'Blog Posts', 'url' => '/admin/blog-posts'], ['name' => $is_new ? 'New Post' : 'Edit: ' . $post['title']]]); ?>

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
                    <div class="card-header"><h6 class="mb-0"><?php echo $is_new ? 'Create' : 'Edit'; ?> Blog Post</h6></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Title *</label>
                            <input type="text" name="title" class="form-control" value="<?php echo e($post['title']); ?>" required id="postTitle">
                        </div>
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" name="slug" class="form-control" value="<?php echo e($post['slug']); ?>" id="postSlug">
                            <small class="form-text text-muted">Auto-generated from title if empty</small>
                        </div>
                        <div class="form-group">
                            <label>Content</label>
                            <textarea name="content" class="form-control" rows="20" style="font-family:monospace;font-size:14px;"><?php echo e($post['content']); ?></textarea>
                            <small class="form-text text-muted">HTML is supported</small>
                        </div>
                        <div class="form-group">
                            <label>Excerpt</label>
                            <textarea name="excerpt" class="form-control" rows="3" maxlength="500"><?php echo e($post['excerpt']); ?></textarea>
                            <small class="form-text text-muted">Short description for listings and meta. Max 500 characters.</small>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header"><h6 class="mb-0">SEO</h6></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" value="<?php echo e($post['meta_title']); ?>" maxlength="70">
                            <small class="form-text text-muted">Leave blank to use post title</small>
                        </div>
                        <div class="form-group">
                            <label>Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="2" maxlength="160"><?php echo e($post['meta_description']); ?></textarea>
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
                                <option value="draft" <?php echo $post['status'] === 'draft' ? 'selected' : ''; ?>>Draft</option>
                                <option value="published" <?php echo $post['status'] === 'published' ? 'selected' : ''; ?>>Published</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Publish Date</label>
                            <input type="datetime-local" name="published_at" class="form-control" value="<?php echo $post['published_at'] ? date('Y-m-d\TH:i', strtotime($post['published_at'])) : ''; ?>">
                            <small class="form-text text-muted">Leave blank to publish immediately</small>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block"><i class="ti-save mr-1"></i> <?php echo $is_new ? 'Create Post' : 'Save Changes'; ?></button>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header"><h6 class="mb-0">Featured Image</h6></div>
                    <div class="card-body">
                        <?php if (!empty($post['image'])): ?>
                        <div class="mb-2"><img src="<?php echo e($post['image']); ?>" alt="" class="img-thumbnail img-fluid"></div>
                        <?php endif; ?>
                        <input type="file" name="image" class="form-control-file" accept="image/*">
                    </div>
                </div>

                <?php if (!$is_new): ?>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td class="text-muted">ID</td><td>#<?php echo $post['id']; ?></td></tr>
                            <tr><td class="text-muted">Views</td><td><?php echo number_format($post['views']); ?></td></tr>
                            <tr><td class="text-muted">Created</td><td><?php echo date('M j, Y', strtotime($post['created_at'])); ?></td></tr>
                            <?php if ($post['updated_at']): ?>
                            <tr><td class="text-muted">Updated</td><td><?php echo date('M j, Y', strtotime($post['updated_at'])); ?></td></tr>
                            <?php endif; ?>
                        </table>
                        <hr>
                        <?php if ($post['status'] === 'published'): ?>
                        <a href="/blog/<?php echo e($post['slug']); ?>" target="_blank" class="btn btn-outline-primary btn-block btn-sm"><i class="ti-eye mr-1"></i> View Post</a>
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
document.getElementById('postTitle').addEventListener('input', function() {
    var slugField = document.getElementById('postSlug');
    if (!slugField.dataset.manual) {
        slugField.value = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
    }
});
document.getElementById('postSlug').addEventListener('input', function() {
    this.dataset.manual = '1';
});
</script>
<script src="/js/admin.js"></script>
</body>
</html>
