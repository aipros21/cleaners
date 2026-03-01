<?php
/**
 * Admin layout wrapper - requires admin role
 */
require_once dirname(__DIR__) . '/includes/inc_db.php';
require_once dirname(__DIR__) . '/includes/inc_helpers.php';
require_once dirname(__DIR__) . '/includes/inc_auth.php';
require_once dirname(__DIR__) . '/includes/inc_upload.php';

require_role('admin');

$_user = current_user();

$page_title = $page_title ?? 'Admin | FindMyCleaner';
$page_description = 'FindMyCleaner Administration Panel';
$admin_page = $admin_page ?? 'dashboard';

$extra_css = ['/css/dashboard.css', '/css/admin.css'];
$extra_js = ['/js/admin.js'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include dirname(__DIR__) . '/includes/inc_head.php'; ?>
</head>
<body class="dashboard-body">

<!-- Admin Top Nav -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top dashboard-navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="/admin">
            <strong style="color:#00b894;">Find<span style="color:#55efc4;">My</span>Cleaner</strong>
            <span class="badge badge-danger ml-2" style="font-size:10px;">ADMIN</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#adminNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminNav">
            <ul class="navbar-nav ml-auto">
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
    <?php include __DIR__ . '/inc_admin_sidebar.php'; ?>
    <div class="dashboard-content">
