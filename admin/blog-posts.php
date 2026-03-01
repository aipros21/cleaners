<?php
/**
 * Admin - Blog Posts Management
 */
$page_title = 'Blog Posts | Admin';
$admin_page = 'blog';
require_once __DIR__ . '/inc_admin_head.php';

$db = get_db();

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $delete_id = (int)($_POST['delete_id'] ?? 0);
    if ($delete_id > 0) {
        $db->prepare("DELETE FROM pages WHERE id = ? AND type = 'blog'")->execute([$delete_id]);
        log_activity('delete_blog_post', 'page', $delete_id);
        $_SESSION['flash'] = 'Blog post deleted.';
        header('Location: /admin/blog-posts');
        exit;
    }
}

$page_num = max(1, (int)($_GET['page'] ?? 1));
$per_page = 20;
$total = $db->query("SELECT COUNT(*) FROM pages WHERE type = 'blog'")->fetchColumn();
$pagination = paginate($total, $per_page, $page_num);

$stmt = $db->prepare("SELECT p.*, u.first_name AS author
    FROM pages p
    LEFT JOIN users u ON p.author_id = u.id
    WHERE p.type = 'blog'
    ORDER BY p.created_at DESC
    LIMIT ? OFFSET ?");
$stmt->bindValue(1, $per_page, PDO::PARAM_INT);
$stmt->bindValue(2, $pagination['offset'], PDO::PARAM_INT);
$stmt->execute();
$posts = $stmt->fetchAll();
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Blog Posts <small class="text-muted">(<?php echo number_format($total); ?>)</small></h4>
        <a href="/admin/blog-edit" class="btn btn-primary"><i class="ti-plus mr-1"></i> New Post</a>
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
                            <th>Title</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Views</th>
                            <th>Published</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($posts)): ?>
                        <tr><td colspan="6" class="text-center py-4 text-muted">No blog posts yet.</td></tr>
                        <?php else: ?>
                        <?php foreach ($posts as $p): ?>
                        <tr>
                            <td>
                                <a href="/admin/blog-edit?id=<?php echo $p['id']; ?>">
                                    <strong><?php echo e(truncate($p['title'], 60)); ?></strong>
                                </a>
                            </td>
                            <td><small><?php echo e($p['author'] ?? 'Admin'); ?></small></td>
                            <td>
                                <span class="badge badge-<?php echo $p['status'] === 'published' ? 'success' : 'secondary'; ?>">
                                    <?php echo ucfirst(e($p['status'])); ?>
                                </span>
                            </td>
                            <td><?php echo number_format($p['views'] ?? 0); ?></td>
                            <td><small><?php echo $p['published_at'] ? date('M j, Y', strtotime($p['published_at'])) : '-'; ?></small></td>
                            <td>
                                <a href="/admin/blog-edit?id=<?php echo $p['id']; ?>" class="btn btn-sm btn-outline-primary mr-1" title="Edit"><i class="ti-pencil"></i></a>
                                <form method="POST" class="d-inline" onsubmit="return confirm('Delete this post?')">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="delete_id" value="<?php echo $p['id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="ti-trash"></i></button>
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
        <?php echo render_pagination($pagination, '/admin/blog-posts'); ?>
    </div>
</div>

    </div><!-- /.dashboard-content -->
</div><!-- /.dashboard-wrapper -->

<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/js/admin.js"></script>
</body>
</html>
