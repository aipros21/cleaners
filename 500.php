<?php
/**
 * 500 Internal Server Error - FindMyCleaner
 */
http_response_code(500);

$page_title = 'Server Error | FindMyCleaner';
$page_description = 'Something went wrong on our end. Please try again later.';
$page_canonical = '/500';
$active_page = '';
$page_noindex = true;

// Try to load includes, but don't fail if DB is down
try {
    require_once 'includes/inc_db.php';
    require_once 'includes/inc_helpers.php';
    $includes_loaded = true;
} catch (Exception $e) {
    $includes_loaded = false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php if ($includes_loaded): ?>
    <?php include 'includes/inc_head.php'; ?>
    <?php else: ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <?php endif; ?>
</head>
<body>
<?php if ($includes_loaded): ?>
<?php include 'includes/inc_header.php'; ?>
<?php endif; ?>

<section class="section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="py-5">
                    <h1 class="display-1 font-weight-bold text-danger mb-0">500</h1>
                    <h2 class="h4 mb-3">Something Went Wrong</h2>
                    <p class="text-muted mb-4">We're experiencing a temporary issue on our end. Our team has been notified and is working on it. Please try again in a few minutes.</p>

                    <div class="mt-4">
                        <a href="/" class="btn btn-primary btn-lg mr-2 mb-2">Go Home</a>
                        <a href="/contact" class="btn btn-outline-primary btn-lg mb-2">Contact Us</a>
                    </div>

                    <p class="text-muted small mt-4">If this problem persists, please email <a href="mailto:info@cleaners-247.com">info@cleaners-247.com</a></p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if ($includes_loaded): ?>
<?php include 'includes/inc_footer.php'; ?>
<?php endif; ?>
</body>
</html>
