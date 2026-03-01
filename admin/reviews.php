<?php
/**
 * Admin - Review Moderation
 */
$page_title = 'Review Moderation | Admin';
$admin_page = 'reviews';
require_once __DIR__ . '/inc_admin_head.php';

$db = get_db();

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $action = $_POST['action'] ?? '';
    $review_id = (int)($_POST['review_id'] ?? 0);

    if ($review_id > 0) {
        switch ($action) {
            case 'approve':
                $db->prepare("UPDATE reviews SET status = 'approved' WHERE id = ?")->execute([$review_id]);
                // Recalculate cleaner avg rating
                $r = $db->prepare("SELECT cleaner_id FROM reviews WHERE id = ?");
                $r->execute([$review_id]);
                $cid = $r->fetchColumn();
                if ($cid) {
                    $db->prepare("UPDATE cleaners SET avg_rating = (SELECT COALESCE(AVG(rating),0) FROM reviews WHERE cleaner_id = ? AND status = 'approved'), review_count = (SELECT COUNT(*) FROM reviews WHERE cleaner_id = ? AND status = 'approved') WHERE id = ?")->execute([$cid, $cid, $cid]);
                }
                log_activity('approve_review', 'review', $review_id);
                $_SESSION['flash'] = 'Review approved.';
                break;
            case 'reject':
                $db->prepare("UPDATE reviews SET status = 'rejected' WHERE id = ?")->execute([$review_id]);
                log_activity('reject_review', 'review', $review_id);
                $_SESSION['flash'] = 'Review rejected.';
                break;
            case 'respond':
                $response = trim($_POST['admin_response'] ?? '');
                if ($response) {
                    $db->prepare("UPDATE reviews SET admin_response = ?, admin_response_at = NOW() WHERE id = ?")->execute([$response, $review_id]);
                    log_activity('respond_review', 'review', $review_id);
                    $_SESSION['flash'] = 'Response added.';
                }
                break;
        }
    }
    header('Location: /admin/reviews?' . $_SERVER['QUERY_STRING']);
    exit;
}

// Filters
$status_filter = $_GET['status'] ?? 'pending';
$page_num = max(1, (int)($_GET['page'] ?? 1));

$where = [];
$params = [];

if ($status_filter) {
    $where[] = "r.status = ?";
    $params[] = $status_filter;
}

$where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// Count
$stmt = $db->prepare("SELECT COUNT(*) FROM reviews r $where_sql");
$stmt->execute($params);
$total = $stmt->fetchColumn();

$pagination = paginate($total, 20, $page_num);

// Fetch
$sql = "SELECT r.*, c.business_name, c.slug AS cleaner_slug
    FROM reviews r
    JOIN cleaners c ON r.cleaner_id = c.id
    $where_sql
    ORDER BY r.created_at DESC
    LIMIT {$pagination['per_page']} OFFSET {$pagination['offset']}";
$stmt = $db->prepare($sql);
$stmt->execute($params);
$reviews = $stmt->fetchAll();

$base_url = build_url('/admin/reviews', array_filter(['status' => $status_filter]));

// Counts per status
$counts = [];
foreach (['pending', 'approved', 'rejected'] as $s) {
    $c = $db->prepare("SELECT COUNT(*) FROM reviews WHERE status = ?");
    $c->execute([$s]);
    $counts[$s] = $c->fetchColumn();
}
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Review Moderation</h4>
    </div>

    <?php if (!empty($_SESSION['flash'])): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo e($_SESSION['flash']); unset($_SESSION['flash']); ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>
    <?php endif; ?>

    <!-- Status Tabs -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link <?php echo $status_filter === 'pending' ? 'active' : ''; ?>" href="/admin/reviews?status=pending">
                Pending <span class="badge badge-warning"><?php echo $counts['pending']; ?></span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $status_filter === 'approved' ? 'active' : ''; ?>" href="/admin/reviews?status=approved">
                Approved <span class="badge badge-success"><?php echo $counts['approved']; ?></span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $status_filter === 'rejected' ? 'active' : ''; ?>" href="/admin/reviews?status=rejected">
                Rejected <span class="badge badge-danger"><?php echo $counts['rejected']; ?></span>
            </a>
        </li>
    </ul>

    <!-- Reviews -->
    <?php if (empty($reviews)): ?>
    <div class="card">
        <div class="card-body text-center py-5 text-muted">
            <i class="ti-comments display-4 d-block mb-3"></i>
            <p>No <?php echo e($status_filter); ?> reviews.</p>
        </div>
    </div>
    <?php else: ?>
    <?php foreach ($reviews as $review): ?>
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <strong><?php echo e($review['author_name']); ?></strong>
                            <small class="text-muted ml-2"><?php echo e($review['author_email'] ?? ''); ?></small>
                        </div>
                        <div><?php echo format_rating($review['rating']); ?></div>
                    </div>
                    <p class="mb-2"><?php echo e($review['content']); ?></p>
                    <div class="small text-muted">
                        <strong>Cleaner:</strong>
                        <a href="/admin/cleaner-edit?id=<?php echo $review['cleaner_id']; ?>"><?php echo e($review['business_name']); ?></a>
                        &middot; <?php echo time_ago($review['created_at']); ?>
                    </div>

                    <?php if ($review['admin_response']): ?>
                    <div class="mt-2 p-2 bg-light rounded">
                        <small class="text-muted"><strong>Admin Response:</strong></small>
                        <p class="mb-0 small"><?php echo e($review['admin_response']); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-4 text-right">
                    <?php if ($review['status'] === 'pending'): ?>
                    <form method="POST" class="d-inline">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                        <button type="submit" name="action" value="approve" class="btn btn-sm btn-success mb-1"><i class="ti-check mr-1"></i>Approve</button>
                        <button type="submit" name="action" value="reject" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Reject this review?')"><i class="ti-close mr-1"></i>Reject</button>
                    </form>
                    <?php else: ?>
                    <span class="badge badge-<?php echo $review['status'] === 'approved' ? 'success' : 'danger'; ?>"><?php echo ucfirst($review['status']); ?></span>
                    <?php endif; ?>

                    <hr class="my-2">

                    <!-- Admin Response Form -->
                    <form method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                        <input type="hidden" name="action" value="respond">
                        <div class="form-group mb-2">
                            <textarea name="admin_response" class="form-control form-control-sm" rows="2" placeholder="Admin response..."><?php echo e($review['admin_response']); ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-sm btn-outline-primary btn-block">Save Response</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>

    <div class="mt-4">
        <?php echo render_pagination($pagination, $base_url); ?>
    </div>
</div>

    </div><!-- /.dashboard-content -->
</div><!-- /.dashboard-wrapper -->

<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/js/admin.js"></script>
</body>
</html>
