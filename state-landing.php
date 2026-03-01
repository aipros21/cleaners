<?php
/**
 * State Landing Page - FindMyCleaner
 * URL: /{state-slug}/cleaners/ (e.g., /florida/cleaners/)
 */
require_once 'includes/inc_db.php';
require_once 'includes/inc_helpers.php';
require_once 'includes/inc_schema.php';

$db = get_db();

// Resolve state from slug
$state_slug = $_GET['state_slug'] ?? '';
$state = null;

if ($state_slug) {
    $stmt = $db->prepare("SELECT * FROM states WHERE slug = ?");
    $stmt->execute([$state_slug]);
    $state = $stmt->fetch();
}

// 404 if state not found
if (!$state) {
    http_response_code(404);
    include '404.php';
    exit;
}

// Fetch categories with cleaner counts for this state
$categories = $db->prepare("
    SELECT cat.id, cat.name, cat.slug, cat.icon, COUNT(DISTINCT c.id) AS cnt
    FROM categories cat
    JOIN cleaner_categories cc ON cat.id = cc.category_id
    JOIN cleaners c ON cc.cleaner_id = c.id
    WHERE cat.is_active = 1 AND c.status = 'active' AND c.state_id = ?
    GROUP BY cat.id
    ORDER BY cnt DESC
");
$categories->execute([$state['id']]);
$categories = $categories->fetchAll();

// Fetch top cities in this state
$cities = $db->prepare("
    SELECT ci.id, ci.name, ci.slug, COUNT(c.id) AS cnt
    FROM cities ci
    JOIN cleaners c ON c.city_id = ci.id
    WHERE ci.state_id = ? AND c.status = 'active'
    GROUP BY ci.id
    ORDER BY cnt DESC
    LIMIT 12
");
$cities->execute([$state['id']]);
$cities = $cities->fetchAll();

// Fetch featured cleaners in this state
$featured = $db->prepare("
    SELECT c.*, ci.name AS city_name,
    GROUP_CONCAT(DISTINCT cat.name SEPARATOR ', ') AS category_names
    FROM cleaners c
    LEFT JOIN cities ci ON c.city_id = ci.id
    LEFT JOIN cleaner_categories cc ON c.id = cc.cleaner_id
    LEFT JOIN categories cat ON cc.category_id = cat.id
    WHERE c.status = 'active' AND c.state_id = ?
    GROUP BY c.id
    ORDER BY c.is_featured DESC, c.avg_rating DESC, c.review_count DESC
    LIMIT 8
");
$featured->execute([$state['id']]);
$featured = $featured->fetchAll();

// Total cleaner count
$stmt = $db->prepare("SELECT COUNT(*) FROM cleaners WHERE status = 'active' AND state_id = ?");
$stmt->execute([$state['id']]);
$total_cleaners = (int) $stmt->fetchColumn();

// SEO
$state_name = e($state['name']);
$page_title = "Cleaners in {$state_name} | FindMyCleaner";
$page_description = "Find top-rated cleaning services in {$state_name}. Browse {$total_cleaners}+ verified cleaning professionals across " . count($categories) . " categories. Get free quotes today.";
$page_canonical = '/' . $state['slug'] . '/cleaners';
$active_page = 'cleaners';

$breadcrumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Cleaners', 'url' => '/cleaners'],
    ['name' => $state['name'], 'url' => '']
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/inc_head.php'; ?>
    <?php echo schema_breadcrumb($breadcrumbs); ?>
    <?php if (!empty($featured)):
        $site_url = getenv('SITE_URL') ?: 'https://cleaners-247.com';
        $list_items = array_map(function($c) use ($site_url) { return ['name' => $c['business_name'], 'url' => $site_url . '/cleaner/' . $c['slug']]; }, $featured);
        echo schema_item_list($list_items, "Top Cleaners in {$state['name']}");
    endif; ?>
</head>
<body>
<?php include 'includes/inc_header.php'; ?>

<!-- Page Header -->
<section class="page-header py-5">
    <div class="container">
        <?php echo render_breadcrumbs($breadcrumbs); ?>
        <h1 class="mb-2" data-aos="fade-up">Cleaners in <?php echo $state_name; ?></h1>
        <p class="mb-0 opacity-75" data-aos="fade-up" data-aos-delay="100"><?php echo number_format($total_cleaners); ?> verified cleaners across <?php echo $state['code']; ?></p>
    </div>
</section>

<!-- SEO Intro Content -->
<section class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <p class="text-muted mb-0">Looking for trusted cleaning professionals in <?php echo $state_name; ?>? FindMyCleaner connects you with <?php echo number_format($total_cleaners); ?>+ verified cleaning services across <?php echo count($categories); ?> service categories<?php echo !empty($cities) ? ', serving ' . e($cities[0]['name']) . (count($cities) > 1 ? ', ' . e($cities[1]['name']) : '') . ' and other cities' : ''; ?>. Compare ratings, read real reviews, and get free quotes from <?php echo $state_name; ?> cleaning companies for house cleaning, office cleaning, deep cleaning, move-in/move-out cleaning, and more.</p>
            </div>
        </div>
    </div>
</section>

<!-- Categories in this State -->
<?php if (!empty($categories)): ?>
<section class="section-padding bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-4" data-aos="fade-up">Browse by Category in <?php echo $state_name; ?></h2>
        <div class="row">
            <?php foreach ($categories as $i => $cat): ?>
            <div class="col-lg-3 col-md-4 col-6 mb-4" data-aos="fade-up" data-aos-delay="<?php echo ($i % 4) * 50; ?>">
                <a href="/cleaners/<?php echo e($cat['slug']); ?>/<?php echo e($state['slug']); ?>" class="category-card text-center d-block p-4">
                    <div class="category-icon mb-3">
                        <i class="<?php echo e($cat['icon']); ?>"></i>
                    </div>
                    <h6 class="mb-1"><?php echo e($cat['name']); ?></h6>
                    <small class="text-muted"><?php echo number_format($cat['cnt']); ?> cleaner<?php echo $cat['cnt'] != 1 ? 's' : ''; ?></small>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Featured Cleaners -->
<?php if (!empty($featured)): ?>
<section class="section-padding">
    <div class="container">
        <h2 class="section-title text-center mb-4" data-aos="fade-up">Top Cleaners in <?php echo $state_name; ?></h2>
        <div class="row">
            <?php foreach ($featured as $i => $c): ?>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="<?php echo ($i % 4) * 50; ?>">
                <div class="cleaner-card h-100 d-flex flex-column">
                    <div class="card-image">
                        <img src="<?php echo e($c['logo'] ?: '/images/default-logo.png'); ?>" alt="<?php echo e($c['business_name']); ?>" loading="lazy">
                        <div class="card-badges" style="position:absolute;top:12px;left:12px;right:12px;display:flex;gap:6px;flex-wrap:wrap;">
                            <?php if ($c['is_verified']): ?><span class="badge-verified"><i class="ti-check"></i> Verified</span><?php endif; ?>
                            <?php if ($c['is_featured']): ?><span class="badge-featured"><i class="ti-star"></i> Featured</span><?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column flex-grow-1">
                        <h6 class="card-title mb-1"><a href="/cleaner/<?php echo e($c['slug']); ?>"><?php echo e($c['business_name']); ?></a></h6>
                        <div class="card-location mb-2">
                            <?php if ($c['city_name']): ?>
                            <i class="ti-location-pin"></i> <?php echo e($c['city_name'] . ', ' . $state['code']); ?>
                            <?php endif; ?>
                        </div>
                        <div class="card-rating mb-2">
                            <?php echo format_rating($c['avg_rating']); ?>
                            <span class="rating-count">(<?php echo $c['review_count']; ?>)</span>
                        </div>
                        <p class="card-category mt-auto mb-0"><?php echo e(truncate($c['category_names'] ?? '', 60)); ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-3">
            <a href="/cleaners?state=<?php echo e($state['slug']); ?>" class="btn btn-outline-primary">View All <?php echo $state_name; ?> Cleaners</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Cities in this State -->
<?php if (!empty($cities)): ?>
<section class="section-padding bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-4" data-aos="fade-up">Popular Cities in <?php echo $state_name; ?></h2>
        <div class="row">
            <?php foreach ($cities as $i => $city): ?>
            <div class="col-lg-3 col-md-4 col-6 mb-3" data-aos="fade-up" data-aos-delay="<?php echo ($i % 4) * 50; ?>">
                <a href="/cleaners?state=<?php echo e($state['slug']); ?>&city=<?php echo e($city['slug']); ?>" class="d-block p-3 bg-white rounded shadow-sm text-center">
                    <i class="ti-location-pin text-primary mr-1"></i>
                    <strong><?php echo e($city['name']); ?></strong>
                    <small class="text-muted d-block"><?php echo number_format($city['cnt']); ?> cleaner<?php echo $city['cnt'] != 1 ? 's' : ''; ?></small>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CTA -->
<section class="section-padding bg-slate" style="background:linear-gradient(135deg, rgba(27,40,56,0.88), rgba(44,62,80,0.82)), url('/images/cta-cleaner.webp') center/cover no-repeat !important;">
    <div class="container text-center">
        <h2 data-aos="fade-up">Need a Cleaner in <?php echo $state_name; ?>?</h2>
        <p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">Get free quotes from top-rated professionals near you</p>
        <div data-aos="fade-up" data-aos-delay="200">
            <a href="/get-quotes" class="btn btn-light btn-lg mr-3">Get Free Quotes</a>
            <a href="/join" class="btn btn-outline-light btn-lg">List Your Business</a>
        </div>
    </div>
</section>

<?php include 'includes/inc_footer.php'; ?>
