<?php
/**
 * Admin - Reports & Analytics
 */
$page_title = 'Reports | Admin';
$admin_page = 'reports';
require_once __DIR__ . '/inc_admin_head.php';

$db = get_db();

// Revenue totals
$total_revenue = $db->query("SELECT COALESCE(SUM(amount), 0) FROM payments WHERE status = 'completed'")->fetchColumn();
$month_revenue = $db->query("SELECT COALESCE(SUM(amount), 0) FROM payments WHERE status = 'completed' AND MONTH(created_at) = MONTH(NOW()) AND YEAR(created_at) = YEAR(NOW())")->fetchColumn();

// Revenue by type
$rev_by_type = $db->query("SELECT type, SUM(amount) AS total FROM payments WHERE status = 'completed' GROUP BY type")->fetchAll(PDO::FETCH_KEY_PAIR);

// Revenue by month (last 12 months)
$rev_months = $db->query("
    SELECT DATE_FORMAT(created_at, '%Y-%m') AS month, SUM(amount) AS total
    FROM payments
    WHERE status = 'completed' AND created_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
    GROUP BY month ORDER BY month
")->fetchAll();
$rev_chart = ['labels' => [], 'values' => []];
foreach ($rev_months as $rm) {
    $rev_chart['labels'][] = date('M Y', strtotime($rm['month'] . '-01'));
    $rev_chart['values'][] = round((float)$rm['total'], 2);
}

// Leads by category (top 10)
$leads_cat = $db->query("
    SELECT c.name, COUNT(l.id) AS cnt
    FROM leads l
    JOIN categories c ON l.category_id = c.id
    GROUP BY c.id
    ORDER BY cnt DESC
    LIMIT 10
")->fetchAll();
$leads_chart = ['labels' => [], 'values' => []];
foreach ($leads_cat as $lc) {
    $leads_chart['labels'][] = $lc['name'];
    $leads_chart['values'][] = (int)$lc['cnt'];
}

// Cleaner signups by month (last 12 months)
$signups = $db->query("
    SELECT DATE_FORMAT(created_at, '%Y-%m') AS month, COUNT(*) AS cnt
    FROM cleaners
    WHERE created_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
    GROUP BY month ORDER BY month
")->fetchAll();
$growth_chart = ['labels' => [], 'values' => []];
foreach ($signups as $s) {
    $growth_chart['labels'][] = date('M Y', strtotime($s['month'] . '-01'));
    $growth_chart['values'][] = (int)$s['cnt'];
}
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Reports & Analytics</h4>
        <span class="text-muted"><?php echo date('F j, Y'); ?></span>
    </div>

    <!-- Revenue Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-white-50">Total Revenue</small>
                            <h4 class="mb-0"><?php echo format_money($total_revenue); ?></h4>
                        </div>
                        <i class="ti-money" style="font-size:2rem;opacity:0.5;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-white-50">This Month</small>
                            <h4 class="mb-0"><?php echo format_money($month_revenue); ?></h4>
                        </div>
                        <i class="ti-calendar" style="font-size:2rem;opacity:0.5;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-white-50">Subscription Revenue</small>
                            <h4 class="mb-0"><?php echo format_money($rev_by_type['subscription'] ?? 0); ?></h4>
                        </div>
                        <i class="ti-receipt" style="font-size:2rem;opacity:0.5;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-dark">Lead / Sponsored</small>
                            <h4 class="mb-0"><?php echo format_money(($rev_by_type['lead'] ?? 0) + ($rev_by_type['sponsored'] ?? 0)); ?></h4>
                        </div>
                        <i class="ti-rocket" style="font-size:2rem;opacity:0.5;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Breakdown by Type -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <small class="text-muted">Subscription</small>
                    <h5 class="mb-0"><?php echo format_money($rev_by_type['subscription'] ?? 0); ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <small class="text-muted">Lead Purchases</small>
                    <h5 class="mb-0"><?php echo format_money($rev_by_type['lead'] ?? 0); ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <small class="text-muted">Sponsored Listings</small>
                    <h5 class="mb-0"><?php echo format_money($rev_by_type['sponsored'] ?? 0); ?></h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Revenue by Month (Last 12 Months)</h6>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" data-chart-data='<?php echo e(json_encode($rev_chart)); ?>' height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Leads by Category (Top 10)</h6>
                </div>
                <div class="card-body">
                    <canvas id="leadsCategoryChart" data-chart-data='<?php echo e(json_encode($leads_chart)); ?>' height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Cleaner Signups by Month</h6>
                </div>
                <div class="card-body">
                    <canvas id="growthChart" data-chart-data='<?php echo e(json_encode($growth_chart)); ?>' height="300"></canvas>
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
// Revenue by Month - Line Chart
(function() {
    var el = document.getElementById('revenueChart');
    if (!el) return;
    var data = JSON.parse(el.getAttribute('data-chart-data'));
    new Chart(el.getContext('2d'), {
        type: 'line',
        data: {
            labels: data.labels,
            datasets: [{
                label: 'Revenue ($)',
                data: data.values,
                borderColor: '#00b894',
                backgroundColor: 'rgba(26,115,232,0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3,
                pointRadius: 4,
                pointBackgroundColor: '#00b894'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, ticks: { callback: function(v) { return '$' + v.toLocaleString(); } } }
            },
            plugins: { tooltip: { callbacks: { label: function(ctx) { return '$' + parseFloat(ctx.parsed.y).toLocaleString(undefined, {minimumFractionDigits:2}); } } } }
        }
    });
})();

// Leads by Category - Horizontal Bar Chart
(function() {
    var el = document.getElementById('leadsCategoryChart');
    if (!el) return;
    var data = JSON.parse(el.getAttribute('data-chart-data'));
    var colors = ['#00b894','#34a853','#fbbc04','#ea4335','#4285f4','#0d652d','#e37400','#a142f4','#24c1e0','#f538a0'];
    new Chart(el.getContext('2d'), {
        type: 'bar',
        data: {
            labels: data.labels,
            datasets: [{
                label: 'Leads',
                data: data.values,
                backgroundColor: colors.slice(0, data.values.length),
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            plugins: { legend: { display: false } },
            scales: {
                x: { beginAtZero: true, ticks: { precision: 0 } }
            }
        }
    });
})();

// Cleaner Signups - Bar Chart
(function() {
    var el = document.getElementById('growthChart');
    if (!el) return;
    var data = JSON.parse(el.getAttribute('data-chart-data'));
    new Chart(el.getContext('2d'), {
        type: 'bar',
        data: {
            labels: data.labels,
            datasets: [{
                label: 'New Cleaners',
                data: data.values,
                backgroundColor: 'rgba(52,168,83,0.7)',
                borderColor: '#34a853',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 } }
            }
        }
    });
})();
</script>
<script src="/js/admin.js"></script>
</body>
</html>
