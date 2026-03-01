<?php
/**
 * Cleaner Dashboard - Reviews
 */
$dash_page = 'reviews';
$page_title = 'Reviews | FindMyCleaner';
require_once __DIR__ . '/inc_dashboard_head.php';

$db = get_db();
$cid = $_cleaner['id'];

$success = '';
$error = '';

// Process response submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $action = $_POST['action'] ?? '';

    if ($action === 'respond') {
        $review_id = intval($_POST['review_id'] ?? 0);
        $response_text = trim($_POST['response'] ?? '');

        if (empty($response_text)) {
            $error = 'Response text is required.';
        } else {
            // Verify this review belongs to this cleaner and is approved
            $stmt = $db->prepare("SELECT id FROM reviews WHERE id = ? AND cleaner_id = ? AND status = 'approved'");
            $stmt->execute([$review_id, $cid]);
            if ($stmt->fetch()) {
                $stmt = $db->prepare("UPDATE reviews SET response = ?, response_date = NOW() WHERE id = ?");
                $stmt->execute([$response_text, $review_id]);
                $success = 'Response submitted successfully!';
                log_activity('review_response', 'review', $review_id);
            } else {
                $error = 'Review not found or not eligible for response.';
            }
        }
    }
}

// Pagination
$page = max(1, intval($_GET['page'] ?? 1));
$per_page = 10;

$count_stmt = $db->prepare("SELECT COUNT(*) FROM reviews WHERE cleaner_id = ?");
$count_stmt->execute([$cid]);
$total = $count_stmt->fetchColumn();
$pagination = paginate($total, $per_page, $page);

// Get reviews
$stmt = $db->prepare("SELECT * FROM reviews WHERE cleaner_id = ? ORDER BY created_at DESC LIMIT ? OFFSET ?");
$stmt->execute([$cid, $per_page, $pagination['offset']]);
$reviews = $stmt->fetchAll();

$status_badges = [
    'pending' => 'warning',
    'approved' => 'success',
    'rejected' => 'danger'
];
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Reviews</h4>
            <small class="text-muted">
                <?php echo number_format($total); ?> total reviews
                &middot; Average rating: <?php echo format_rating($_cleaner['avg_rating']); ?>
            </small>
        </div>
    </div>

    <?php if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="ti-check mr-1"></i> <?php echo e($success); ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
    <?php endif; ?>

    <?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="ti-alert mr-1"></i> <?php echo e($error); ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
    <?php endif; ?>

    <?php if (empty($reviews)): ?>
    <div class="card">
        <div class="card-body text-center py-5 text-muted">
            <i class="ti-comments display-3"></i>
            <h5 class="mt-3">No reviews yet</h5>
            <p>When customers leave reviews about your work, they will appear here.</p>
        </div>
    </div>
    <?php else: ?>
    <?php foreach ($reviews as $review): ?>
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <div class="mb-1"><?php echo format_rating($review['rating']); ?></div>
                    <?php if ($review['title']): ?>
                    <h6 class="mb-0"><?php echo e($review['title']); ?></h6>
                    <?php endif; ?>
                </div>
                <div>
                    <span class="badge badge-<?php echo $status_badges[$review['status']] ?? 'secondary'; ?>">
                        <?php echo ucfirst($review['status']); ?>
                    </span>
                    <?php if ($review['is_verified']): ?>
                    <span class="badge badge-info ml-1"><i class="ti-check mr-1"></i>Verified</span>
                    <?php endif; ?>
                </div>
            </div>

            <p class="mb-2"><?php echo nl2br(e($review['content'])); ?></p>

            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    <i class="ti-user mr-1"></i> <?php echo e($review['author_name']); ?>
                    &middot; <?php echo date('M j, Y', strtotime($review['created_at'])); ?>
                </small>
            </div>

            <?php if ($review['response']): ?>
            <!-- Existing response -->
            <div class="mt-3 p-3 bg-light rounded">
                <strong class="d-block mb-1"><i class="ti-comment-alt mr-1"></i> Your Response:</strong>
                <p class="mb-1"><?php echo nl2br(e($review['response'])); ?></p>
                <small class="text-muted"><?php echo date('M j, Y', strtotime($review['response_date'])); ?></small>
            </div>
            <?php elseif ($review['status'] === 'approved'): ?>
            <!-- Response form -->
            <div class="mt-3 p-3 border rounded">
                <form method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="action" value="respond">
                    <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                    <div class="form-group mb-2">
                        <label class="small font-weight-bold"><i class="ti-comment-alt mr-1"></i> Write a Response</label>
                        <textarea name="response" class="form-control form-control-sm" rows="3" required placeholder="Thank the reviewer and address their feedback..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti-check mr-1"></i> Submit Response
                    </button>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>

    <div class="mt-4">
        <?php echo render_pagination($pagination, '/dashboard/reviews?'); ?>
    </div>
    <?php endif; ?>
</div>

    </div><!-- /.dashboard-content -->
</div><!-- /.dashboard-wrapper -->

<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/js/dashboard.js"></script>
</body>
</html>
