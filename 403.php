<?php
/**
 * 403 Forbidden - FindMyCleaner
 */
http_response_code(403);

require_once 'includes/inc_db.php';
require_once 'includes/inc_helpers.php';

$page_title = 'Access Denied | FindMyCleaner';
$page_description = 'You do not have permission to access this page.';
$page_canonical = '/403';
$active_page = '';
$page_noindex = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/inc_head.php'; ?>
</head>
<body>
<?php include 'includes/inc_header.php'; ?>

<section class="section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="py-5">
                    <h1 class="display-1 font-weight-bold text-primary mb-0">403</h1>
                    <h2 class="h4 mb-3">Access Denied</h2>
                    <p class="text-muted mb-4">You don't have permission to access this page. If you believe this is an error, please contact us.</p>

                    <div class="mt-4">
                        <a href="/" class="btn btn-primary btn-lg mr-2 mb-2">Go Home</a>
                        <a href="/contact" class="btn btn-outline-primary btn-lg mb-2">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/inc_footer.php'; ?>
