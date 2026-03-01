<?php
/**
 * Dashboard sidebar navigation
 */

// Get unread leads count
$_lead_count = 0;
$_review_count = 0;
try {
    $db = get_db();
    $_lead_count = $db->prepare("SELECT COUNT(*) FROM lead_assignments WHERE cleaner_id = ? AND status = 'sent'");
    $_lead_count->execute([$_cleaner['id']]);
    $_lead_count = $_lead_count->fetchColumn();

    $_review_count = $db->prepare("SELECT COUNT(*) FROM reviews WHERE cleaner_id = ? AND status = 'pending'");
    $_review_count->execute([$_cleaner['id']]);
    $_review_count = $_review_count->fetchColumn();
} catch (Exception $e) {}
?>
<aside class="dashboard-sidebar">
    <div class="sidebar-profile text-center py-4">
        <img src="<?php echo e($_cleaner['logo'] ?: '/images/default-logo.png'); ?>" alt="Logo" class="rounded-circle mb-2" width="60" height="60">
        <h6 class="mb-0 text-white"><?php echo e($_cleaner['business_name']); ?></h6>
        <small class="text-muted"><?php echo ucfirst($_cleaner['plan']); ?> Plan</small>
    </div>

    <nav class="sidebar-nav">
        <a href="/dashboard" class="sidebar-link <?php echo $dash_page === 'home' ? 'active' : ''; ?>">
            <i class="ti-dashboard"></i> <span>Dashboard</span>
        </a>
        <a href="/dashboard/profile" class="sidebar-link <?php echo $dash_page === 'profile' ? 'active' : ''; ?>">
            <i class="ti-user"></i> <span>Profile</span>
        </a>
        <a href="/dashboard/photos" class="sidebar-link <?php echo $dash_page === 'photos' ? 'active' : ''; ?>">
            <i class="ti-image"></i> <span>Photos</span>
        </a>
        <a href="/dashboard/specialties" class="sidebar-link <?php echo $dash_page === 'specialties' ? 'active' : ''; ?>">
            <i class="ti-star"></i> <span>Specialties</span>
        </a>
        <a href="/dashboard/discounts" class="sidebar-link <?php echo $dash_page === 'discounts' ? 'active' : ''; ?>">
            <i class="ti-gift"></i> <span>Discounts</span>
        </a>
        <a href="/dashboard/leads" class="sidebar-link <?php echo $dash_page === 'leads' ? 'active' : ''; ?>">
            <i class="ti-email"></i> <span>Leads</span>
            <?php if ($_lead_count > 0): ?><span class="badge badge-danger ml-auto"><?php echo $_lead_count; ?></span><?php endif; ?>
        </a>
        <a href="/dashboard/reviews" class="sidebar-link <?php echo $dash_page === 'reviews' ? 'active' : ''; ?>">
            <i class="ti-comments"></i> <span>Reviews</span>
            <?php if ($_review_count > 0): ?><span class="badge badge-warning ml-auto"><?php echo $_review_count; ?></span><?php endif; ?>
        </a>
        <a href="/dashboard/subscription" class="sidebar-link <?php echo $dash_page === 'subscription' ? 'active' : ''; ?>">
            <i class="ti-credit-card"></i> <span>Subscription</span>
        </a>
        <a href="/dashboard/sponsored" class="sidebar-link <?php echo $dash_page === 'sponsored' ? 'active' : ''; ?>">
            <i class="ti-rocket"></i> <span>Sponsored</span>
        </a>
        <a href="/dashboard/settings" class="sidebar-link <?php echo $dash_page === 'settings' ? 'active' : ''; ?>">
            <i class="ti-settings"></i> <span>Settings</span>
        </a>
    </nav>
</aside>
