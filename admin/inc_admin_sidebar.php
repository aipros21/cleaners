<?php
/**
 * Admin sidebar navigation
 */

// Get pending counts for badges
$_pending_reviews = 0;
$_pending_leads = 0;
try {
    $db = get_db();
    $_pending_reviews = $db->query("SELECT COUNT(*) FROM reviews WHERE status = 'pending'")->fetchColumn();
    $_pending_leads = $db->query("SELECT COUNT(*) FROM leads WHERE status = 'new'")->fetchColumn();
} catch (Exception $e) {}
?>
<aside class="dashboard-sidebar">
    <div class="sidebar-profile text-center py-4">
        <img src="<?php echo e($_user['avatar'] ?: '/images/default-logo.png'); ?>" alt="Admin" class="rounded-circle mb-2" width="60" height="60">
        <h6 class="mb-0 text-white"><?php echo e($_user['first_name'] . ' ' . $_user['last_name']); ?></h6>
        <small class="text-muted">Administrator</small>
    </div>

    <nav class="sidebar-nav">
        <a href="/admin" class="sidebar-link <?php echo $admin_page === 'dashboard' ? 'active' : ''; ?>">
            <i class="ti-dashboard"></i> <span>Dashboard</span>
        </a>
        <a href="/admin/cleaners" class="sidebar-link <?php echo $admin_page === 'cleaners' ? 'active' : ''; ?>">
            <i class="ti-briefcase"></i> <span>Cleaners</span>
        </a>
        <a href="/admin/customers" class="sidebar-link <?php echo $admin_page === 'customers' ? 'active' : ''; ?>">
            <i class="ti-user"></i> <span>Customers</span>
        </a>
        <a href="/admin/leads" class="sidebar-link <?php echo $admin_page === 'leads' ? 'active' : ''; ?>">
            <i class="ti-email"></i> <span>Leads</span>
            <?php if ($_pending_leads > 0): ?><span class="badge badge-danger ml-auto"><?php echo $_pending_leads; ?></span><?php endif; ?>
        </a>
        <a href="/admin/reviews" class="sidebar-link <?php echo $admin_page === 'reviews' ? 'active' : ''; ?>">
            <i class="ti-comments"></i> <span>Reviews</span>
            <?php if ($_pending_reviews > 0): ?><span class="badge badge-warning ml-auto"><?php echo $_pending_reviews; ?></span><?php endif; ?>
        </a>
        <a href="/admin/banners" class="sidebar-link <?php echo $admin_page === 'banners' ? 'active' : ''; ?>">
            <i class="ti-image"></i> <span>Banners</span>
        </a>
        <a href="/admin/sponsored" class="sidebar-link <?php echo $admin_page === 'sponsored' ? 'active' : ''; ?>">
            <i class="ti-rocket"></i> <span>Sponsored</span>
        </a>
        <a href="/admin/categories" class="sidebar-link <?php echo $admin_page === 'categories' ? 'active' : ''; ?>">
            <i class="ti-list"></i> <span>Categories</span>
        </a>
        <a href="/admin/locations" class="sidebar-link <?php echo $admin_page === 'locations' ? 'active' : ''; ?>">
            <i class="ti-location-pin"></i> <span>Locations</span>
        </a>
        <a href="/admin/blog-posts" class="sidebar-link <?php echo $admin_page === 'blog' ? 'active' : ''; ?>">
            <i class="ti-pencil-alt"></i> <span>Blog</span>
        </a>
        <a href="/admin/pages" class="sidebar-link <?php echo $admin_page === 'pages' ? 'active' : ''; ?>">
            <i class="ti-file"></i> <span>Pages</span>
        </a>
        <a href="/admin/settings" class="sidebar-link <?php echo $admin_page === 'settings' ? 'active' : ''; ?>">
            <i class="ti-settings"></i> <span>Settings</span>
        </a>
        <a href="/admin/activity-log" class="sidebar-link <?php echo $admin_page === 'activity' ? 'active' : ''; ?>">
            <i class="ti-time"></i> <span>Activity Log</span>
        </a>
        <a href="/admin/reports" class="sidebar-link <?php echo $admin_page === 'reports' ? 'active' : ''; ?>">
            <i class="ti-bar-chart"></i> <span>Reports</span>
        </a>

        <div style="border-top:1px solid rgba(255,255,255,0.1); margin:10px 0;"></div>

        <a href="/admin/admins" class="sidebar-link <?php echo $admin_page === 'admins' ? 'active' : ''; ?>">
            <i class="ti-shield"></i> <span>Admins</span>
        </a>
    </nav>
</aside>
