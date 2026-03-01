<?php
/**
 * Cleaner Dashboard - Home/Overview
 */
$page_title = 'Dashboard | FindMyCleaner';
$dash_page = 'home';
require_once __DIR__ . '/inc_dashboard_head.php';

$db = get_db();
$cid = $_cleaner['id'];

// Stats
$total_views = $_cleaner['profile_views'];
$total_leads = $_cleaner['leads_received'];
$avg_rating = $_cleaner['avg_rating'];
$total_reviews = $_cleaner['review_count'];

// Recent leads
$stmt = $db->prepare("SELECT la.*, l.customer_name, l.project_description, l.budget_range, l.urgency, l.created_at AS lead_date, cat.name AS category_name
    FROM lead_assignments la
    JOIN leads l ON la.lead_id = l.id
    LEFT JOIN categories cat ON l.category_id = cat.id
    WHERE la.cleaner_id = ?
    ORDER BY la.assigned_at DESC LIMIT 5");
$stmt->execute([$cid]);
$recent_leads = $stmt->fetchAll();

// Recent reviews
$stmt = $db->prepare("SELECT * FROM reviews WHERE cleaner_id = ? AND status = 'approved' ORDER BY created_at DESC LIMIT 3");
$stmt->execute([$cid]);
$recent_reviews = $stmt->fetchAll();

// Profile completeness
$completeness = 20; // base for having account
if ($_cleaner['description']) $completeness += 15;
if ($_cleaner['logo']) $completeness += 15;
if ($_cleaner['cover_image']) $completeness += 10;
if ($_cleaner['phone']) $completeness += 10;
if ($_cleaner['license_number']) $completeness += 10;
if ($_cleaner['is_insured']) $completeness += 10;
$photo_count = $db->prepare("SELECT COUNT(*) FROM cleaner_photos WHERE cleaner_id = ?");
$photo_count->execute([$cid]);
if ($photo_count->fetchColumn() > 0) $completeness += 10;
$completeness = min(100, $completeness);
?>

<div class="container-fluid py-4">
    <!-- Welcome -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Welcome back, <?php echo e($_cleaner['business_name']); ?>!</h4>
            <small class="text-muted">Here's your business overview</small>
        </div>
        <a href="/cleaner/<?php echo e($_cleaner['slug']); ?>" target="_blank" class="btn btn-outline-primary btn-sm">
            <i class="ti-eye mr-1"></i> View Public Profile
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stat-card bg-primary text-white">
                <div class="stat-icon"><i class="ti-eye"></i></div>
                <div class="stat-number"><?php echo number_format($total_views); ?></div>
                <div class="stat-label">Profile Views</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card bg-success text-white">
                <div class="stat-icon"><i class="ti-email"></i></div>
                <div class="stat-number"><?php echo number_format($total_leads); ?></div>
                <div class="stat-label">Total Leads</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card bg-warning text-dark">
                <div class="stat-icon"><i class="ti-star"></i></div>
                <div class="stat-number"><?php echo number_format($avg_rating, 1); ?></div>
                <div class="stat-label">Avg Rating</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card bg-info text-white">
                <div class="stat-icon"><i class="ti-comments"></i></div>
                <div class="stat-number"><?php echo number_format($total_reviews); ?></div>
                <div class="stat-label">Reviews</div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Leads -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Recent Leads</h6>
                    <a href="/dashboard/leads" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($recent_leads)): ?>
                    <div class="text-center py-4 text-muted">
                        <i class="ti-email display-4"></i>
                        <p class="mt-2">No leads yet. Complete your profile to start receiving leads!</p>
                    </div>
                    <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr><th>Customer</th><th>Category</th><th>Budget</th><th>Status</th><th>Date</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_leads as $lead): ?>
                                <tr>
                                    <td><?php echo e($lead['customer_name']); ?></td>
                                    <td><span class="badge badge-light"><?php echo e($lead['category_name']); ?></span></td>
                                    <td><?php echo e($lead['budget_range']); ?></td>
                                    <td>
                                        <?php
                                        $status_colors = ['sent' => 'primary', 'viewed' => 'info', 'accepted' => 'success', 'contacted' => 'warning', 'completed' => 'success', 'declined' => 'danger'];
                                        $color = $status_colors[$lead['status']] ?? 'secondary';
                                        ?>
                                        <span class="badge badge-<?php echo $color; ?>"><?php echo ucfirst($lead['status']); ?></span>
                                    </td>
                                    <td><small><?php echo time_ago($lead['lead_date']); ?></small></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Profile Completeness -->
            <div class="card mb-4">
                <div class="card-body">
                    <h6>Profile Completeness</h6>
                    <div class="progress mb-2" style="height:20px;">
                        <div class="progress-bar bg-<?php echo $completeness >= 80 ? 'success' : ($completeness >= 50 ? 'warning' : 'danger'); ?>" style="width:<?php echo $completeness; ?>%">
                            <?php echo $completeness; ?>%
                        </div>
                    </div>
                    <?php if ($completeness < 100): ?>
                    <small class="text-muted">Complete your profile to get more leads!</small>
                    <a href="/dashboard/profile" class="btn btn-sm btn-outline-primary btn-block mt-2">Complete Profile</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Plan Info -->
            <div class="card mb-4">
                <div class="card-body">
                    <h6>Your Plan: <span class="text-primary"><?php echo ucfirst($_cleaner['plan']); ?></span></h6>
                    <?php $limits = plan_limits($_cleaner['plan']); ?>
                    <ul class="list-unstyled small">
                        <li><i class="ti-check text-success mr-1"></i> <?php echo $limits['photos']; ?> photos</li>
                        <li><i class="ti-check text-success mr-1"></i> <?php echo $limits['leads'] > 999 ? 'Unlimited' : $limits['leads']; ?> leads/month</li>
                    </ul>
                    <?php if ($_cleaner['plan'] !== 'premium'): ?>
                    <a href="/dashboard/subscription" class="btn btn-sm btn-primary btn-block">Upgrade Plan</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Recent Reviews -->
            <div class="card">
                <div class="card-header"><h6 class="mb-0">Recent Reviews</h6></div>
                <div class="card-body">
                    <?php if (empty($recent_reviews)): ?>
                    <p class="text-muted small text-center">No reviews yet.</p>
                    <?php else: ?>
                    <?php foreach ($recent_reviews as $rev): ?>
                    <div class="mb-3 pb-3 border-bottom">
                        <div><?php echo format_rating($rev['rating'], false); ?></div>
                        <p class="small mb-1"><?php echo e(truncate($rev['content'], 100)); ?></p>
                        <small class="text-muted">- <?php echo e($rev['author_name']); ?>, <?php echo time_ago($rev['created_at']); ?></small>
                    </div>
                    <?php endforeach; ?>
                    <a href="/dashboard/reviews" class="btn btn-sm btn-outline-primary btn-block">View All Reviews</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

    </div><!-- /.dashboard-content -->
</div><!-- /.dashboard-wrapper -->

<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/plugins/chartjs/chart.min.js"></script>
<script src="/js/dashboard.js"></script>
</body>
</html>
