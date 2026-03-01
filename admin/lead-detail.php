<?php
/**
 * Admin - Lead Detail
 */
$page_title = 'Lead Detail | Admin';
$admin_page = 'leads';
require_once __DIR__ . '/inc_admin_head.php';

$db = get_db();
$id = (int)($_GET['id'] ?? 0);

if (!$id) {
    header('Location: /admin/leads');
    exit;
}

// Fetch lead
$stmt = $db->prepare("SELECT l.*, cat.name AS category_name FROM leads l LEFT JOIN categories cat ON l.category_id = cat.id WHERE l.id = ?");
$stmt->execute([$id]);
$lead = $stmt->fetch();

if (!$lead) {
    header('Location: /admin/leads');
    exit;
}

// Handle manual assignment
$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $action = $_POST['action'] ?? '';

    if ($action === 'assign') {
        $cleaner_id = (int)($_POST['cleaner_id'] ?? 0);
        $price = (float)($_POST['price'] ?? 0);

        if (!$cleaner_id) {
            $errors[] = 'Please select a cleaner.';
        } else {
            // Check if already assigned
            $check = $db->prepare("SELECT id FROM lead_assignments WHERE lead_id = ? AND cleaner_id = ?");
            $check->execute([$id, $cleaner_id]);
            if ($check->fetch()) {
                $errors[] = 'This cleaner is already assigned to this lead.';
            } else {
                $stmt = $db->prepare("INSERT INTO lead_assignments (lead_id, cleaner_id, price, status, assigned_at) VALUES (?, ?, ?, 'sent', NOW())");
                $stmt->execute([$id, $cleaner_id, $price]);

                // Update lead status
                $db->prepare("UPDATE leads SET status = 'assigned' WHERE id = ? AND status = 'new'")->execute([$id]);

                // Update cleaner lead count
                $db->prepare("UPDATE cleaners SET leads_received = leads_received + 1 WHERE id = ?")->execute([$cleaner_id]);

                log_activity('assign_lead', 'lead', $id, "Assigned to cleaner #$cleaner_id");
                $success = 'Lead assigned successfully.';
            }
        }
    } elseif ($action === 'update_status') {
        $new_status = $_POST['lead_status'] ?? '';
        if (in_array($new_status, ['new', 'assigned', 'in_progress', 'completed', 'cancelled'])) {
            $db->prepare("UPDATE leads SET status = ? WHERE id = ?")->execute([$new_status, $id]);
            log_activity('update_lead_status', 'lead', $id, "Status changed to $new_status");
            $success = 'Lead status updated.';
            $lead['status'] = $new_status;
        }
    }
}

// Fetch assignments
$assignments = $db->prepare("SELECT la.*, c.business_name, c.slug, c.phone AS cleaner_phone
    FROM lead_assignments la
    JOIN cleaners c ON la.cleaner_id = c.id
    WHERE la.lead_id = ?
    ORDER BY la.assigned_at DESC");
$assignments->execute([$id]);
$assignments = $assignments->fetchAll();

// Fetch available cleaners for assignment (in same category)
$available = $db->prepare("SELECT c.id, c.business_name, c.city, c.state, c.plan, c.avg_rating
    FROM cleaners c
    JOIN cleaner_categories cc ON c.id = cc.cleaner_id
    WHERE cc.category_id = ? AND c.status = 'active'
    ORDER BY c.plan DESC, c.avg_rating DESC");
$available->execute([$lead['category_id']]);
$available_cleaners = $available->fetchAll();
?>

<div class="container-fluid py-4">
    <?php echo render_breadcrumbs([['name' => 'Leads', 'url' => '/admin/leads'], ['name' => 'Lead #' . $id]]); ?>

    <?php if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo e($success); ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>
    <?php endif; ?>
    <?php if (!empty($errors)): ?>
    <div class="alert alert-danger alert-dismissible fade show"><ul class="mb-0"><?php foreach ($errors as $err): ?><li><?php echo e($err); ?></li><?php endforeach; ?></ul><button type="button" class="close" data-dismiss="alert">&times;</button></div>
    <?php endif; ?>

    <div class="row">
        <!-- Lead Details -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Lead #<?php echo $id; ?> Details</h6>
                    <?php
                    $status_colors = ['new' => 'primary', 'assigned' => 'info', 'in_progress' => 'warning', 'completed' => 'success', 'cancelled' => 'danger'];
                    $color = $status_colors[$lead['status']] ?? 'secondary';
                    ?>
                    <span class="badge badge-<?php echo $color; ?> badge-lg"><?php echo ucfirst(str_replace('_', ' ', $lead['status'])); ?></span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Customer</h6>
                            <p class="mb-0"><strong><?php echo e($lead['customer_name']); ?></strong></p>
                            <p class="mb-0"><small><?php echo e($lead['customer_email']); ?></small></p>
                            <p class="mb-0"><small><?php echo $lead['customer_phone'] ? format_phone($lead['customer_phone']) : 'N/A'; ?></small></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Project Info</h6>
                            <p class="mb-0"><strong>Category:</strong> <?php echo e($lead['category_name']); ?></p>
                            <p class="mb-0"><strong>Budget:</strong> <?php echo e($lead['budget_range']); ?></p>
                            <p class="mb-0"><strong>Urgency:</strong> <?php echo e($lead['urgency'] ?? 'N/A'); ?></p>
                            <p class="mb-0"><strong>ZIP:</strong> <?php echo e($lead['zip_code'] ?? 'N/A'); ?></p>
                        </div>
                    </div>

                    <h6 class="text-muted mb-1">Project Description</h6>
                    <div class="bg-light p-3 rounded mb-3">
                        <?php echo nl2br(e($lead['project_description'])); ?>
                    </div>

                    <small class="text-muted">Submitted: <?php echo date('M j, Y g:i A', strtotime($lead['created_at'])); ?></small>
                </div>
            </div>

            <!-- Assignment History -->
            <div class="card mb-4">
                <div class="card-header"><h6 class="mb-0">Assignment History</h6></div>
                <div class="card-body p-0">
                    <?php if (empty($assignments)): ?>
                    <div class="text-center py-4 text-muted">No assignments yet.</div>
                    <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr><th>Cleaner</th><th>Price</th><th>Status</th><th>Assigned</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach ($assignments as $a): ?>
                                <tr>
                                    <td>
                                        <a href="/admin/cleaner-edit?id=<?php echo $a['cleaner_id']; ?>"><?php echo e($a['business_name']); ?></a>
                                        <br><small class="text-muted"><?php echo $a['cleaner_phone'] ? format_phone($a['cleaner_phone']) : ''; ?></small>
                                    </td>
                                    <td><?php echo $a['price'] ? format_money($a['price']) : '-'; ?></td>
                                    <td>
                                        <?php
                                        $a_colors = ['sent' => 'primary', 'viewed' => 'info', 'accepted' => 'success', 'contacted' => 'warning', 'completed' => 'success', 'declined' => 'danger'];
                                        ?>
                                        <span class="badge badge-<?php echo $a_colors[$a['status']] ?? 'secondary'; ?>"><?php echo ucfirst($a['status']); ?></span>
                                    </td>
                                    <td><small><?php echo time_ago($a['assigned_at']); ?></small></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Manual Assignment -->
            <div class="card mb-4">
                <div class="card-header"><h6 class="mb-0">Assign to Cleaner</h6></div>
                <div class="card-body">
                    <form method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="action" value="assign">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Select Cleaner</label>
                                <select name="cleaner_id" class="form-control" required>
                                    <option value="">-- Choose --</option>
                                    <?php foreach ($available_cleaners as $ac): ?>
                                    <option value="<?php echo $ac['id']; ?>"><?php echo e($ac['business_name']); ?> (<?php echo e($ac['city'] . ', ' . $ac['state']); ?>) - <?php echo ucfirst($ac['plan']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Lead Price ($)</label>
                                <input type="number" name="price" class="form-control" step="0.01" min="0" placeholder="0.00">
                            </div>
                            <div class="col-md-3 form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">Assign Lead</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Update Status -->
            <div class="card mb-4">
                <div class="card-header"><h6 class="mb-0">Update Status</h6></div>
                <div class="card-body">
                    <form method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="action" value="update_status">
                        <div class="form-group">
                            <select name="lead_status" class="form-control">
                                <option value="new" <?php echo $lead['status'] === 'new' ? 'selected' : ''; ?>>New</option>
                                <option value="assigned" <?php echo $lead['status'] === 'assigned' ? 'selected' : ''; ?>>Assigned</option>
                                <option value="in_progress" <?php echo $lead['status'] === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                                <option value="completed" <?php echo $lead['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                <option value="cancelled" <?php echo $lead['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Update Status</button>
                    </form>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card">
                <div class="card-header"><h6 class="mb-0">Quick Info</h6></div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr><td class="text-muted">Lead ID</td><td>#<?php echo $id; ?></td></tr>
                        <tr><td class="text-muted">Assignments</td><td><?php echo count($assignments); ?></td></tr>
                        <tr><td class="text-muted">Category</td><td><?php echo e($lead['category_name']); ?></td></tr>
                        <tr><td class="text-muted">Created</td><td><?php echo date('M j, Y', strtotime($lead['created_at'])); ?></td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

    </div><!-- /.dashboard-content -->
</div><!-- /.dashboard-wrapper -->

<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/js/admin.js"></script>
</body>
</html>
