<?php
/**
 * Cleaner Dashboard - Leads Management
 */
$dash_page = 'leads';
$page_title = 'Leads | FindMyCleaner';
require_once __DIR__ . '/inc_dashboard_head.php';

$db = get_db();
$cid = $_cleaner['id'];

$success = '';
$error = '';

// Process status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $action = $_POST['action'] ?? '';

    if ($action === 'update_status') {
        $assignment_id = intval($_POST['assignment_id'] ?? 0);
        $new_status = $_POST['status'] ?? '';
        $notes = trim($_POST['notes'] ?? '');
        $valid_statuses = ['accepted', 'contacted', 'completed', 'declined'];

        if (in_array($new_status, $valid_statuses)) {
            $stmt = $db->prepare("UPDATE lead_assignments SET status = ?, notes = ?, updated_at = NOW() WHERE id = ? AND cleaner_id = ?");
            $stmt->execute([$new_status, $notes, $assignment_id, $cid]);
            if ($stmt->rowCount()) {
                $success = 'Lead status updated to ' . ucfirst($new_status) . '.';
                log_activity('lead_status_update', 'lead_assignment', $assignment_id, $new_status);
            }
        } else {
            $error = 'Invalid status.';
        }
    }
}

// Pagination
$page = max(1, intval($_GET['page'] ?? 1));
$per_page = 15;

// Count total
$count_stmt = $db->prepare("SELECT COUNT(*) FROM lead_assignments WHERE cleaner_id = ?");
$count_stmt->execute([$cid]);
$total = $count_stmt->fetchColumn();
$pagination = paginate($total, $per_page, $page);

// Get leads
$stmt = $db->prepare("SELECT la.*, l.customer_name, l.customer_email, l.customer_phone, l.project_description,
    l.budget_range, l.urgency, l.property_type, l.zip_code AS lead_zip, l.created_at AS lead_date,
    cat.name AS category_name
    FROM lead_assignments la
    JOIN leads l ON la.lead_id = l.id
    LEFT JOIN categories cat ON l.category_id = cat.id
    WHERE la.cleaner_id = ?
    ORDER BY la.assigned_at DESC
    LIMIT ? OFFSET ?");
$stmt->execute([$cid, $per_page, $pagination['offset']]);
$leads = $stmt->fetchAll();

// Mark viewed leads as viewed
$view_ids = [];
foreach ($leads as $lead) {
    if ($lead['status'] === 'sent') $view_ids[] = $lead['id'];
}
if (!empty($view_ids)) {
    $placeholders = implode(',', array_fill(0, count($view_ids), '?'));
    $db->prepare("UPDATE lead_assignments SET status = 'viewed' WHERE id IN ($placeholders) AND cleaner_id = ?")->execute(array_merge($view_ids, [$cid]));
}

// Expand a specific lead
$expand_id = intval($_GET['expand'] ?? 0);

$status_colors = [
    'sent' => 'primary', 'viewed' => 'info', 'accepted' => 'success',
    'contacted' => 'warning', 'completed' => 'success', 'declined' => 'danger'
];

$urgency_labels = [
    'asap' => 'ASAP', 'within_week' => 'Within a Week',
    'within_month' => 'Within a Month', 'flexible' => 'Flexible'
];
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Leads</h4>
            <small class="text-muted"><?php echo number_format($total); ?> total leads received</small>
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

    <?php if (empty($leads)): ?>
    <div class="card">
        <div class="card-body text-center py-5 text-muted">
            <i class="ti-email display-3"></i>
            <h5 class="mt-3">No leads yet</h5>
            <p>Complete your profile and add photos to start receiving leads from customers in your area.</p>
            <a href="/dashboard/profile" class="btn btn-primary">Complete Profile</a>
        </div>
    </div>
    <?php else: ?>
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Customer</th>
                            <th>Category</th>
                            <th>Budget</th>
                            <th>Urgency</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($leads as $lead): ?>
                        <tr class="<?php echo ($lead['status'] === 'sent' || $lead['status'] === 'viewed') ? 'table-light' : ''; ?>">
                            <td>
                                <strong><?php echo e($lead['customer_name']); ?></strong>
                                <?php if ($lead['status'] === 'sent'): ?>
                                <span class="badge badge-info badge-pill ml-1">New</span>
                                <?php endif; ?>
                            </td>
                            <td><span class="badge badge-light"><?php echo e($lead['category_name']); ?></span></td>
                            <td><?php echo e($lead['budget_range']); ?></td>
                            <td>
                                <?php
                                $urg_color = $lead['urgency'] === 'asap' ? 'danger' : ($lead['urgency'] === 'within_week' ? 'warning' : 'secondary');
                                ?>
                                <span class="badge badge-<?php echo $urg_color; ?>"><?php echo $urgency_labels[$lead['urgency']] ?? ucfirst($lead['urgency']); ?></span>
                            </td>
                            <td>
                                <span class="badge badge-<?php echo $status_colors[$lead['status']] ?? 'secondary'; ?>">
                                    <?php echo ucfirst($lead['status']); ?>
                                </span>
                            </td>
                            <td><small><?php echo time_ago($lead['lead_date']); ?></small></td>
                            <td>
                                <a href="/dashboard/leads?expand=<?php echo $lead['id']; ?>&page=<?php echo $page; ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="ti-angle-<?php echo ($expand_id === (int)$lead['id']) ? 'up' : 'down'; ?>"></i>
                                </a>
                            </td>
                        </tr>
                        <?php if ($expand_id === (int)$lead['id']): ?>
                        <tr>
                            <td colspan="7" class="bg-light p-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Project Details</h6>
                                        <p class="mb-2"><?php echo nl2br(e($lead['project_description'])); ?></p>
                                        <?php if ($lead['property_type']): ?>
                                        <p class="small text-muted mb-1"><strong>Property type:</strong> <?php echo e($lead['property_type']); ?></p>
                                        <?php endif; ?>
                                        <?php if ($lead['lead_zip']): ?>
                                        <p class="small text-muted mb-1"><strong>ZIP Code:</strong> <?php echo e($lead['lead_zip']); ?></p>
                                        <?php endif; ?>

                                        <?php if (in_array($lead['status'], ['accepted', 'contacted', 'completed'])): ?>
                                        <hr>
                                        <h6>Contact Information</h6>
                                        <p class="mb-1"><i class="ti-email mr-1"></i> <?php echo e($lead['customer_email']); ?></p>
                                        <p class="mb-1"><i class="ti-mobile mr-1"></i> <?php echo e(format_phone($lead['customer_phone'])); ?></p>
                                        <?php else: ?>
                                        <hr>
                                        <p class="small text-muted"><i class="ti-lock mr-1"></i> Accept this lead to view contact information.</p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Update Status</h6>
                                        <form method="POST">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="action" value="update_status">
                                            <input type="hidden" name="assignment_id" value="<?php echo $lead['id']; ?>">
                                            <div class="form-group">
                                                <select name="status" class="form-control form-control-sm">
                                                    <option value="accepted" <?php echo $lead['status'] === 'accepted' ? 'selected' : ''; ?>>Accepted</option>
                                                    <option value="contacted" <?php echo $lead['status'] === 'contacted' ? 'selected' : ''; ?>>Contacted</option>
                                                    <option value="completed" <?php echo $lead['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                                    <option value="declined" <?php echo $lead['status'] === 'declined' ? 'selected' : ''; ?>>Declined</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Notes</label>
                                                <textarea name="notes" class="form-control form-control-sm" rows="3" placeholder="Add private notes about this lead..."><?php echo e($lead['notes']); ?></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="ti-save mr-1"></i> Update
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <?php echo render_pagination($pagination, '/dashboard/leads?'); ?>
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
