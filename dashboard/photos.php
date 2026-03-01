<?php
/**
 * Cleaner Dashboard - Photos Management
 */
$dash_page = 'photos';
$page_title = 'Photos | FindMyCleaner';
require_once __DIR__ . '/inc_dashboard_head.php';

$db = get_db();
$cid = $_cleaner['id'];

$success = '';
$error = '';
$limits = plan_limits($_cleaner['plan']);
$photo_limit = $limits['photos'];

// AJAX upload handler
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_FILES)) {
    // Verify CSRF
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        json_response(['success' => false, 'error' => 'Invalid CSRF token.'], 403);
    }

    // Check photo count
    $stmt = $db->prepare("SELECT COUNT(*) FROM cleaner_photos WHERE cleaner_id = ?");
    $stmt->execute([$cid]);
    $current_count = $stmt->fetchColumn();

    if ($current_count >= $photo_limit) {
        json_response(['success' => false, 'error' => "Photo limit reached ({$photo_limit}). Upgrade your plan for more photos."], 400);
    }

    $upload = handle_upload('file', ['cleaner_id' => $cid, 'type' => 'portfolio']);

    if ($upload['success']) {
        $stmt = $db->prepare("INSERT INTO cleaner_photos (cleaner_id, url, thumbnail, caption, sort_order, created_at) VALUES (?, ?, ?, '', ?, NOW())");
        $stmt->execute([$cid, $upload['url'], $upload['url'], $current_count + 1]);
        $photo_id = $db->lastInsertId();

        log_activity('photo_upload', 'cleaner_photo', $photo_id);

        json_response([
            'success' => true,
            'photo' => [
                'id' => $photo_id,
                'url' => $upload['url'],
                'caption' => ''
            ]
        ]);
    } else {
        json_response(['success' => false, 'error' => $upload['error']], 400);
    }
}

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_photo') {
    if (verify_csrf($_POST['csrf_token'] ?? '')) {
        $photo_id = intval($_POST['photo_id'] ?? 0);
        $stmt = $db->prepare("DELETE FROM cleaner_photos WHERE id = ? AND cleaner_id = ?");
        $stmt->execute([$photo_id, $cid]);
        if ($stmt->rowCount()) {
            $success = 'Photo deleted.';
            log_activity('photo_delete', 'cleaner_photo', $photo_id);
        }
    }
}

// Handle caption update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_caption') {
    if (verify_csrf($_POST['csrf_token'] ?? '')) {
        $photo_id = intval($_POST['photo_id'] ?? 0);
        $caption = trim($_POST['caption'] ?? '');
        $stmt = $db->prepare("UPDATE cleaner_photos SET caption = ? WHERE id = ? AND cleaner_id = ?");
        $stmt->execute([$caption, $photo_id, $cid]);
        if ($stmt->rowCount()) {
            $success = 'Caption updated.';
        }
    }
}

// Get current photos
$stmt = $db->prepare("SELECT * FROM cleaner_photos WHERE cleaner_id = ? ORDER BY sort_order, created_at DESC");
$stmt->execute([$cid]);
$photos = $stmt->fetchAll();
$photo_count = count($photos);
$can_upload = $photo_count < $photo_limit;
?>

<link rel="stylesheet" href="/plugins/dropzone/dropzone.min.css">

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Photos</h4>
            <small class="text-muted"><?php echo $photo_count; ?> / <?php echo $photo_limit; ?> photos used (<?php echo ucfirst($_cleaner['plan']); ?> plan)</small>
        </div>
        <?php if (!$can_upload && $_cleaner['plan'] !== 'premium'): ?>
        <a href="/dashboard/subscription" class="btn btn-sm btn-primary"><i class="ti-crown mr-1"></i> Upgrade for More</a>
        <?php endif; ?>
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

    <!-- Upload Area -->
    <?php if ($can_upload): ?>
    <div class="card mb-4">
        <div class="card-body">
            <form action="/dashboard/photos" class="dropzone" id="photoDropzone" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="dz-message">
                    <i class="ti-cloud-up display-4 text-primary"></i>
                    <h5 class="mt-2">Drop photos here or click to upload</h5>
                    <p class="text-muted">JPG, PNG, GIF, or WebP. Max 10MB each. <?php echo ($photo_limit - $photo_count); ?> remaining.</p>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <!-- Photo Grid -->
    <div class="row" id="photoGrid">
        <?php if (empty($photos)): ?>
        <div class="col-12 text-center py-5 text-muted" id="emptyState">
            <i class="ti-image display-3"></i>
            <h5 class="mt-3">No photos yet</h5>
            <p>Upload photos of your work to attract more customers.</p>
        </div>
        <?php else: ?>
        <?php foreach ($photos as $photo): ?>
        <div class="col-md-4 col-lg-3 mb-4 photo-card" data-id="<?php echo $photo['id']; ?>">
            <div class="card h-100">
                <img src="<?php echo e($photo['url']); ?>" class="card-img-top" alt="<?php echo e($photo['caption']); ?>" style="height:200px;object-fit:cover;">
                <div class="card-body p-2">
                    <form method="POST" class="mb-0">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="action" value="update_caption">
                        <input type="hidden" name="photo_id" value="<?php echo $photo['id']; ?>">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" name="caption" value="<?php echo e($photo['caption']); ?>" placeholder="Add caption...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-outline-secondary" title="Save caption"><i class="ti-check"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer p-2 text-center">
                    <form method="POST" class="d-inline" onsubmit="return confirm('Delete this photo?');">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="action" value="delete_photo">
                        <input type="hidden" name="photo_id" value="<?php echo $photo['id']; ?>">
                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="ti-trash mr-1"></i> Delete</button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

    </div><!-- /.dashboard-content -->
</div><!-- /.dashboard-wrapper -->

<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/plugins/dropzone/dropzone.min.js"></script>
<script src="/js/dashboard.js"></script>
<script>
Dropzone.autoDiscover = false;
<?php if ($can_upload): ?>
var myDropzone = new Dropzone("#photoDropzone", {
    url: "/dashboard/photos",
    paramName: "file",
    maxFilesize: 10,
    acceptedFiles: "image/jpeg,image/png,image/gif,image/webp",
    maxFiles: <?php echo $photo_limit - $photo_count; ?>,
    addRemoveLinks: true,
    headers: {},
    init: function() {
        this.on("success", function(file, response) {
            if (response.success) {
                var photo = response.photo;
                var html = '<div class="col-md-4 col-lg-3 mb-4 photo-card" data-id="' + photo.id + '">' +
                    '<div class="card h-100">' +
                    '<img src="' + photo.url + '" class="card-img-top" style="height:200px;object-fit:cover;">' +
                    '<div class="card-body p-2"><small class="text-muted">Caption saved on reload</small></div>' +
                    '</div></div>';
                $('#emptyState').remove();
                $('#photoGrid').append(html);
            }
        });
        this.on("error", function(file, message) {
            if (typeof message === 'object') message = message.error || 'Upload failed';
            alert(message);
        });
    }
});
<?php endif; ?>
</script>
</body>
</html>
