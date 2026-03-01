<?php
/**
 * Dashboard layout wrapper - requires cleaner role
 */
require_once dirname(__DIR__) . '/includes/inc_db.php';
require_once dirname(__DIR__) . '/includes/inc_helpers.php';
require_once dirname(__DIR__) . '/includes/inc_auth.php';
require_once dirname(__DIR__) . '/includes/inc_upload.php';

require_role('cleaner');

$_user = current_user();
$_cleaner = current_cleaner();

if (!$_cleaner) {
    header('Location: /');
    exit;
}

$page_title = $page_title ?? 'Dashboard | FindMyCleaner';
$page_description = 'Manage your cleaner profile, leads, and reviews.';
$dash_page = $dash_page ?? 'home';

$extra_css = ['/css/dashboard.css'];
$extra_js = ['/js/dashboard.js'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include dirname(__DIR__) . '/includes/inc_head.php'; ?>
</head>
<body class="dashboard-body">

<!-- Dashboard Top Nav -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top dashboard-navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <strong style="color:#00b894;">Find<span style="color:#55efc4;">My</span>Cleaner</strong>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#dashNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="dashNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/cleaner/<?php echo e($_cleaner['slug']); ?>" target="_blank"><i class="ti-eye mr-1"></i> View Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/"><i class="ti-home mr-1"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/api/handle_login.php?logout=1"><i class="ti-power-off mr-1"></i> Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="dashboard-wrapper">
    <?php include __DIR__ . '/inc_dashboard_sidebar.php'; ?>
    <div class="dashboard-content">
