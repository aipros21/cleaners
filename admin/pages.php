<?php
/**
 * Admin - Static Pages Management
 */
$page_title = 'Static Pages | Admin';
$admin_page = 'pages';
require_once __DIR__ . '/inc_admin_head.php';

$db = get_db();

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $delete_id = (int)($_POST['delete_id'] ?? 0);
    if ($delete_id > 0) {
        $db->prepare("DELETE FROM pages WHERE id = ? AND type = 'page'")->execute([$delete_id]);
        log_activity('delete_page', 'page', $delete_id);
        $_SESSION['flash'] = 'Page deleted.';
        header('Location: /admin/pages');
        exit;
    }
}

$page_num = max(1, (int)($_GET['page'] ?? 1));
$per_page = 20;
$total = $db->query("SELECT COUNT(*) FROM pages WHERE type = 'page'")->fetchColumn();
$pagination = paginate($total, $per_page, $page_num);

$stmt = $db->prepare("SELECT p.*, u.first_name AS author
    FROM pages p
    LEFT JOIN users u ON p.author_id = u.id
    WHERE p.type = 'page'
    ORDER BY p.title ASC
    LIMIT ? OFFSET ?");
$stmt->bindValue(1, $per_page, PDO::PARAM_INT);
$stmt->bindValue(2, $pagination['offset'], PDO::PARAM_INT);
$stmt->execute();
$pages_list = $stmt->fetchAll();
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Static Pages <small class="text-muted">(<?php echo number_format($total); ?>)</small></h4>
        <a href="/admin/page-edit" class="btn btn-primary"><i class="ti-plus mr-1"></i> New Page</a>
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
                            <th>Slug</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Views</th>
                            <th>Updated</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pages_list)): ?>
                        <tr><td colspan="7" class="text-center py-4 text-muted">No static pages yet. Create your first one!</td></tr>
                        <?php else: ?>
                        <?php foreach ($pages_list as $p): ?>
                        <tr>
                            <td>
                                <a href="/admin/page-edit?id=<?php echo $p['id']; ?>"><strong><?php echo e($p['title']); ?></strong></a>
                            </td>
                            <td><small class="text-muted">/<?php echo e($p['slug']); ?></small></td>
                            <td><small><?php echo e($p['author'] ?? 'Admin'); ?></small></td>
                            <td><span class="badge badge-<?php echo $p['status'] === 'published' ? 'success' : 'secondary'; ?>"><?php echo ucfirst(e($p['status'])); ?></span></td>
                            <td><?php echo number_format($p['views'] ?? 0); ?></td>
                            <td><small><?php echo $p['updated_at'] ? date('M j, Y', strtotime($p['updated_at'])) : '-'; ?></small></td>
                            <td>
                                <a href="/admin/page-edit?id=<?php echo $p['id']; ?>" class="btn btn-sm btn-outline-primary mr-1" title="Edit"><i class="ti-pencil"></i></a>
                                <?php if ($p['status'] === 'published'): ?>
                                <a href="/<?php echo e($p['slug']); ?>" target="_blank" class="btn btn-sm btn-outline-info mr-1" title="View"><i class="ti-eye"></i></a>
                                <?php endif; ?>
                                <form method="POST" class="d-inline" onsubmit="return confirm('Delete this page?')">
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
        <?php echo render_pagination($pagination, '/admin/pages'); ?>
    </div>
</div>

    </div><!-- /.dashboard-content -->
</div><!-- /.dashboard-wrapper -->

<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/js/admin.js"></script>
</body>
</html>
