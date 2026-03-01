<?php
/**
 * Site header with navigation
 * Set $active_page before including
 */
require_once __DIR__ . '/inc_db.php';
require_once __DIR__ . '/inc_helpers.php';
require_once __DIR__ . '/inc_auth.php';

$_user = current_user();

// Fetch categories for dropdown
try {
    $_categories = get_db()->query("SELECT id, name, slug, icon FROM categories WHERE is_active = 1 ORDER BY sort_order ASC")->fetchAll();
} catch (Exception $e) {
    $_categories = [];
}

$active_page = $active_page ?? '';
?>

<a href="#main-content" class="sr-only sr-only-focusable">Skip to content</a>

<!-- Top Bar -->
<div class="top-bar d-none d-md-block">
    <div class="container d-flex justify-content-between align-items-center py-2">
        <div>
            <small class="text-white-50"><i class="ti-email mr-1"></i> info@cleaners-247.com <span class="mx-2 text-white-25">|</span> <i class="ti-headphone-alt mr-1"></i> 1-800-FIND-PRO</small>
        </div>
        <div>
            <?php if ($_user): ?>
                <small class="text-white-50">Welcome, <?php echo e($_user['first_name'] ?: $_user['email']); ?>
                <?php if ($_user['role'] === 'cleaner'): ?>
                    &middot; <a href="/dashboard" class="text-white">Dashboard</a>
                <?php elseif ($_user['role'] === 'admin'): ?>
                    &middot; <a href="/admin" class="text-white">Admin</a>
                <?php endif; ?>
                 &middot; <a href="/api/handle_login.php?logout=1" class="text-white">Logout</a></small>
            <?php else: ?>
                <small><a href="/login" class="text-white-50">Login</a> <span class="mx-2 text-white-25">|</span> <a href="/join" class="text-white">List Your Business</a></small>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Main Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <span class="brand-icon d-inline-flex align-items-center justify-content-center mr-2" style="width:40px;height:40px;background:#0D47A1;border-radius:10px;color:#fff;font-weight:800;font-size:15px;">FC</span>
            <span style="font-size:1.35rem;font-weight:800;color:#212121;">Find<span style="color:#1565C0;">My</span>Cleaner</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ml-auto align-items-lg-center">
                <li class="nav-item<?php echo $active_page === 'home' ? ' active' : ''; ?>">
                    <a class="nav-link" href="/">Home</a>
                </li>

                <!-- Services Dropdown -->
                <li class="nav-item dropdown<?php echo $active_page === 'cleaners' ? ' active' : ''; ?>">
                    <a class="nav-link dropdown-toggle" href="/cleaners" id="servicesDropdown" data-toggle="dropdown">
                        Services
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg p-3" style="min-width:540px;">
                        <div class="row no-gutters">
                            <?php foreach ($_categories as $i => $cat): ?>
                            <div class="col-6">
                                <a class="dropdown-item rounded py-2 px-3" href="/cleaners/<?php echo e($cat['slug']); ?>">
                                    <i class="<?php echo e($cat['icon']); ?> mr-2 text-muted" style="width:20px;text-align:center;"></i><?php echo e($cat['name']); ?>
                                </a>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="text-center">
                            <a href="/cleaners" class="btn btn-sm btn-outline-secondary">View All Cleaners <i class="ti-arrow-right ml-1"></i></a>
                        </div>
                    </div>
                </li>

                <li class="nav-item<?php echo $active_page === 'pricing' ? ' active' : ''; ?>">
                    <a class="nav-link" href="/pricing">Pricing</a>
                </li>
                <li class="nav-item<?php echo $active_page === 'blog' ? ' active' : ''; ?>">
                    <a class="nav-link" href="/blog">Blog</a>
                </li>
                <li class="nav-item<?php echo $active_page === 'about' ? ' active' : ''; ?>">
                    <a class="nav-link" href="/about">About</a>
                </li>
                <li class="nav-item<?php echo $active_page === 'contact' ? ' active' : ''; ?>">
                    <a class="nav-link" href="/contact">Contact</a>
                </li>
                <li class="nav-item<?php echo $active_page === 'faq' ? ' active' : ''; ?>">
                    <a class="nav-link" href="/faq">FAQ</a>
                </li>
                <li class="nav-item ml-lg-3">
                    <a class="btn btn-primary px-4 rounded-pill" href="/get-quotes" style="white-space:nowrap;">
                        <i class="ti-write mr-1"></i> Get Free Quotes
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main id="main-content">
