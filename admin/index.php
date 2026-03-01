<?php
/**
 * Admin Dashboard - Overview with KPIs
 */
$page_title = 'Admin Dashboard | FindMyCleaner';
$admin_page = 'dashboard';
require_once __DIR__ . '/inc_admin_head.php';

$db = get_db();

// KPI: Total Revenue
$total_revenue = $db->query("SELECT COALESCE(SUM(amount), 0) FROM payments WHERE status = 'completed'")->fetchColumn();

// KPI: Total Leads
$total_leads = $db->query("SELECT COUNT(*) FROM leads")->fetchColumn();

// KPI: Active Cleaners
$active_cleaners = $db->query("SELECT COUNT(*) FROM cleaners WHERE status = 'active'")->fetchColumn();

// KPI: Pending Reviews
$pending_reviews = $db->query("SELECT COUNT(*) FROM reviews WHERE status = 'pending'")->fetchColumn();

// Revenue this month
$month_revenue = $db->query("SELECT COALESCE(SUM(amount), 0) FROM payments WHERE status = 'completed' AND MONTH(created_at) = MONTH(NOW()) AND YEAR(created_at) = YEAR(NOW())")->fetchColumn();

// New leads this month
$month_leads = $db->query("SELECT COUNT(*) FROM leads WHERE MONTH(created_at) = MONTH(NOW()) AND YEAR(created_at) = YEAR(NOW())")->fetchColumn();

// Recent activity
$recent_activity = $db->query("SELECT al.*, u.first_name, u.last_name, u.email FROM activity_log al LEFT JOIN users u ON al.user_id = u.id ORDER BY al.created_at DESC LIMIT 10")->fetchAll();

// Monthly revenue for chart (last 6 months)
$revenue_chart = $db->query("SELECT DATE_FORMAT(created_at, '%Y-%m') AS month, SUM(amount) AS total FROM payments WHERE status = 'completed' AND created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH) GROUP BY DATE_FORMAT(created_at, '%Y-%m') ORDER BY month ASC")->fetchAll();
$chart_labels = array_column($revenue_chart, 'month');
$chart_values = array_column($revenue_chart, 'total');
?>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Admin Dashboard</h4>
            <small class="text-muted">Overview of your platform</small>
        </div>
        <div>
            <span class="text-muted"><?php echo date('l, F j, Y'); ?></span>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stat-card bg-primary text-white">
                <div class="stat-icon"><i class="ti-money"></i></div>
                <div class="stat-number"><?php echo format_money($total_revenue); ?></div>
                <div class="stat-label">Total Revenue</div>
                <small>This month: <?php echo format_money($month_revenue); ?></small>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card bg-success text-white">
                <div class="stat-icon"><i class="ti-email"></i></div>
                <div class="stat-number"><?php echo number_format($total_leads); ?></div>
                <div class="stat-label">Total Leads</div>
                <small>This month: <?php echo number_format($month_leads); ?></small>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card bg-info text-white">
                <div class="stat-icon"><i class="ti-briefcase"></i></div>
                <div class="stat-number"><?php echo number_format($active_cleaners); ?></div>
                <div class="stat-label">Active Cleaners</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card bg-warning text-dark">
                <div class="stat-icon"><i class="ti-comments"></i></div>
                <div class="stat-number"><?php echo number_format($pending_reviews); ?></div>
                <div class="stat-label">Pending Reviews</div>
                <?php if ($pending_reviews > 0): ?>
                <a href="/admin/reviews" class="text-dark"><small>Review now &rarr;</small></a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Revenue Chart -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Revenue (Last 6 Months)</h6>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Recent Activity</h6>
                    <a href="/admin/activity-log" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($recent_activity)): ?>
                    <div class="text-center py-4 text-muted">
                        <p>No activity recorded yet.</p>
                    </div>
                    <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($recent_activity as $activity): ?>
                        <div class="list-group-item px-3 py-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <strong class="small"><?php echo e($activity['first_name'] ? $activity['first_name'] . ' ' . $activity['last_name'] : 'System'); ?></strong>
                                    <p class="mb-0 small text-muted"><?php echo e($activity['action']); ?>
                                        <?php if ($activity['entity_type']): ?>
                                        <span class="badge badge-light"><?php echo e($activity['entity_type']); ?></span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <small class="text-muted text-nowrap"><?php echo time_ago($activity['created_at']); ?></small>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
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
<script>
// Revenue Chart
var ctx = document.getElementById('revenueChart');
if (ctx) {
    new Chart(ctx.getContext('2d'), {
        type: 'line',
        data: {
            labels: <?php echo json_encode($chart_labels); ?>,
            datasets: [{
                label: 'Revenue ($)',
                data: <?php echo json_encode(array_map('floatval', $chart_values)); ?>,
                borderColor: '#00b894',
                backgroundColor: 'rgba(26,115,232,0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, ticks: { callback: function(v) { return '$' + v.toLocaleString(); } } }
            },
            plugins: { tooltip: { callbacks: { label: function(ctx) { return '$' + parseFloat(ctx.parsed.y).toLocaleString(); } } } }
        }
    });
}
</script>
<script src="/js/admin.js"></script>
</body>
</html>
