<?php
/**
 * Cleaner Dashboard - Specialties Management
 */
$dash_page = 'specialties';
$page_title = 'Specialties | FindMyCleaner';
require_once __DIR__ . '/inc_dashboard_head.php';

$db = get_db();
$cid = $_cleaner['id'];

$success = '';
$error = '';

// Process POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $name = trim($_POST['specialty_name'] ?? '');
        if (empty($name)) {
            $error = 'Specialty name is required.';
        } elseif (mb_strlen($name) > 200) {
            $error = 'Specialty name must be under 200 characters.';
        } else {
            // Check for duplicate
            $stmt = $db->prepare("SELECT id FROM cleaner_specialties WHERE cleaner_id = ? AND LOWER(name) = LOWER(?)");
            $stmt->execute([$cid, $name]);
            if ($stmt->fetch()) {
                $error = 'You already have this specialty.';
            } else {
                $stmt = $db->prepare("INSERT INTO cleaner_specialties (cleaner_id, name) VALUES (?, ?)");
                $stmt->execute([$cid, $name]);
                $success = 'Specialty added!';
                log_activity('specialty_add', 'cleaner_specialty', $db->lastInsertId(), $name);
            }
        }
    }

    if ($action === 'delete') {
        $spec_id = intval($_POST['specialty_id'] ?? 0);
        $stmt = $db->prepare("DELETE FROM cleaner_specialties WHERE id = ? AND cleaner_id = ?");
        $stmt->execute([$spec_id, $cid]);
        if ($stmt->rowCount()) {
            $success = 'Specialty removed.';
            log_activity('specialty_delete', 'cleaner_specialty', $spec_id);
        }
    }
}

// Get current specialties
$stmt = $db->prepare("SELECT * FROM cleaner_specialties WHERE cleaner_id = ? ORDER BY name");
$stmt->execute([$cid]);
$specialties = $stmt->fetchAll();
?>

<div class="container-fluid py-4">
    <h4 class="mb-4">Specialties</h4>

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

    <div class="row">
        <div class="col-lg-8">
            <!-- Current Specialties -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Your Specialties <span class="badge badge-primary ml-1"><?php echo count($specialties); ?></span></h6>
                </div>
                <div class="card-body">
                    <?php if (empty($specialties)): ?>
                    <div class="text-center py-4 text-muted">
                        <i class="ti-star display-4"></i>
                        <p class="mt-2">No specialties added yet. Add your areas of expertise below.</p>
                    </div>
                    <?php else: ?>
                    <div class="d-flex flex-wrap">
                        <?php foreach ($specialties as $spec): ?>
                        <div class="mr-2 mb-2">
                            <span class="badge badge-light border p-2" style="font-size:0.95rem;">
                                <?php echo e($spec['name']); ?>
                                <form method="POST" class="d-inline ml-1" onsubmit="return confirm('Remove this specialty?');">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="specialty_id" value="<?php echo $spec['id']; ?>">
                                    <button type="submit" class="btn btn-link btn-sm p-0 text-danger" title="Remove">
                                        <i class="ti-close"></i>
                                    </button>
                                </form>
                            </span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Add Specialty -->
            <div class="card">
                <div class="card-header"><h6 class="mb-0">Add Specialty</h6></div>
                <div class="card-body">
                    <form method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="action" value="add">
                        <div class="form-group">
                            <label for="specialty_name">Specialty Name</label>
                            <input type="text" class="form-control" id="specialty_name" name="specialty_name" required maxlength="200" placeholder="e.g. Kitchen Remodeling">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="ti-plus mr-1"></i> Add Specialty
                        </button>
                    </form>
                    <hr>
                    <small class="text-muted">
                        <strong>Tip:</strong> Adding specific specialties helps customers find you when they search for particular services.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

    </div><!-- /.dashboard-content -->
</div><!-- /.dashboard-wrapper -->

<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/js/dashboard.js"></script>
</body>
</html>
