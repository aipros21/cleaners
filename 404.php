<?php
/**
 * 404 Not Found - FindMyCleaner
 */
http_response_code(404);

require_once 'includes/inc_db.php';
require_once 'includes/inc_helpers.php';

$page_title = 'Page Not Found | FindMyCleaner';
$page_description = 'The page you are looking for could not be found. Browse our cleaning services directory or search for what you need.';
$page_canonical = '/404';
$active_page = '';
$page_noindex = true;

// Fetch popular categories for helpful links
try {
    $categories = get_db()->query("SELECT name, slug, icon FROM categories WHERE is_active = 1 ORDER BY sort_order ASC LIMIT 8")->fetchAll();
} catch (Exception $e) {
    $categories = [];
}
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
                    <h1 class="display-1 font-weight-bold text-primary mb-0">404</h1>
                    <h2 class="h4 mb-3">Oops! Page Not Found</h2>
                    <p class="text-muted mb-4">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>

                    <!-- Search Box -->
                    <div class="row justify-content-center mb-5">
                        <div class="col-md-8">
                            <form action="/search" method="GET">
                                <div class="input-group input-group-lg">
                                    <input type="text" name="q" class="form-control" placeholder="Search cleaning services, categories, or blog posts..." autofocus>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit"><i class="ti-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Popular Categories -->
                    <?php if (!empty($categories)): ?>
                    <h5 class="mb-3">Popular Categories</h5>
                    <div class="row justify-content-center">
                        <?php foreach ($categories as $cat): ?>
                        <div class="col-6 col-md-3 mb-3">
                            <a href="/cleaners/<?php echo e($cat['slug']); ?>" class="category-card text-center d-block p-3">
                                <div class="category-icon mb-2">
                                    <i class="<?php echo e($cat['icon']); ?>"></i>
                                </div>
                                <small><?php echo e($cat['name']); ?></small>
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Helpful Links -->
                    <div class="mt-4">
                        <p class="text-muted mb-2">Or try one of these links:</p>
                        <a href="/" class="btn btn-outline-primary btn-sm mr-2 mb-2">Home</a>
                        <a href="/cleaners" class="btn btn-outline-primary btn-sm mr-2 mb-2">All Cleaning Services</a>
                        <a href="/blog" class="btn btn-outline-primary btn-sm mr-2 mb-2">Blog</a>
                        <a href="/contact" class="btn btn-outline-primary btn-sm mb-2">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
if (typeof gtag === 'function') {
    gtag('event', '404_error', {
        event_category: 'error',
        event_label: window.location.pathname + window.location.search,
        non_interaction: true
    });
}
</script>
<?php include 'includes/inc_footer.php'; ?>
