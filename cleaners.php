<?php
/**
 * Cleaner Directory Listing
 * Handles: /cleaners/, /cleaners/{category}/, /cleaners/{category}/{state}/, /cleaners/{category}/{city}-{state}/
 */
require_once 'includes/inc_db.php';
require_once 'includes/inc_helpers.php';
require_once 'includes/inc_schema.php';
require_once 'includes/inc_banners.php';

$db = get_db();

// Parse URL parameters
$category_slug = $_GET['category'] ?? '';
$state_slug = $_GET['state'] ?? '';
$city_slug = $_GET['city'] ?? '';
$state_code = strtoupper($_GET['state_code'] ?? '');
$search_q = trim($_GET['q'] ?? '');
$sort = $_GET['sort'] ?? 'rating';
$page = max(1, intval($_GET['page'] ?? 1));
$per_page = 12;

// Resolve category
$category = null;
if ($category_slug) {
    $stmt = $db->prepare("SELECT * FROM categories WHERE slug = ? AND is_active = 1");
    $stmt->execute([$category_slug]);
    $category = $stmt->fetch();
}

// Resolve state
$state = null;
if ($state_slug) {
    $stmt = $db->prepare("SELECT * FROM states WHERE slug = ?");
    $stmt->execute([$state_slug]);
    $state = $stmt->fetch();
} elseif ($state_code) {
    $stmt = $db->prepare("SELECT * FROM states WHERE code = ?");
    $stmt->execute([$state_code]);
    $state = $stmt->fetch();
}

// Resolve city
$city = null;
if ($city_slug && $state) {
    $stmt = $db->prepare("SELECT * FROM cities WHERE slug = ? AND state_id = ?");
    $stmt->execute([$city_slug, $state['id']]);
    $city = $stmt->fetch();
}

// Build page title and meta
$title_parts = ['Cleaners'];
$breadcrumbs = [['name' => 'Home', 'url' => '/'], ['name' => 'Cleaners', 'url' => '/cleaners']];

if ($category) {
    $title_parts = [$category['name'] . ' Cleaners'];
    $breadcrumbs[] = ['name' => $category['name'], 'url' => '/cleaners/' . $category['slug']];
}
if ($state) {
    $title_parts[] = 'in ' . $state['name'];
    $breadcrumbs[] = ['name' => $state['name'], 'url' => '/cleaners/' . ($category ? $category['slug'] . '/' : '') . $state['slug']];
}
if ($city) {
    $title_parts = [$title_parts[0], 'in ' . $city['name'] . ', ' . $state['code']];
    $breadcrumbs[] = ['name' => $city['name'], 'url' => ''];
}

$page_title = implode(' ', $title_parts) . ' | FindMyCleaner';
$page_description = $category ? ($category['meta_description'] ?? "Find top-rated {$category['name']} cleaners near you.") : 'Browse our directory of trusted local cleaners across all categories.';
$page_canonical = '/cleaners' . ($category ? '/' . $category['slug'] : '') . ($state ? '/' . $state['slug'] : '') . ($city && $state ? '/' . $city['slug'] . '-' . strtolower($state['code']) : '');
$active_page = 'cleaners';

// Build query
$where = ["c.status = 'active'"];
$params = [];

if ($category) {
    $where[] = "cc.category_id = ?";
    $params[] = $category['id'];
}
if ($state) {
    $where[] = "c.state_id = ?";
    $params[] = $state['id'];
}
if ($city) {
    $where[] = "c.city_id = ?";
    $params[] = $city['id'];
}
if ($search_q) {
    $where[] = "MATCH(c.business_name, c.description, c.tagline) AGAINST(? IN BOOLEAN MODE)";
    $params[] = $search_q;
}

$where_sql = implode(' AND ', $where);

// Count total
$count_sql = "SELECT COUNT(DISTINCT c.id) FROM cleaners c LEFT JOIN cleaner_categories cc ON c.id = cc.cleaner_id WHERE {$where_sql}";
$stmt = $db->prepare($count_sql);
$stmt->execute($params);
$total = $stmt->fetchColumn();

$pagination = paginate($total, $per_page, $page);

// Pagination rel prev/next
$_base_canonical = $page_canonical;
if ($pagination['has_prev']) {
    $page_prev = $_base_canonical . ($pagination['current_page'] - 1 > 1 ? '?page=' . ($pagination['current_page'] - 1) : '');
}
if ($pagination['has_next']) {
    $page_next = $_base_canonical . '?page=' . ($pagination['current_page'] + 1);
}
if ($page > 1) {
    $page_canonical = $_base_canonical . '?page=' . $page;
}

// Sort
$order_by = 'c.is_featured DESC, ';
switch ($sort) {
    case 'newest': $order_by .= 'c.created_at DESC'; break;
    case 'name': $order_by .= 'c.business_name ASC'; break;
    case 'reviews': $order_by .= 'c.review_count DESC'; break;
    default: $order_by .= 'c.avg_rating DESC, c.review_count DESC';
}

// Fetch cleaners
$sql = "SELECT DISTINCT c.*, s.name AS state_name, s.code AS state_code, ci.name AS city_name,
    GROUP_CONCAT(DISTINCT cat.name SEPARATOR ', ') AS category_names
    FROM cleaners c
    LEFT JOIN cleaner_categories cc ON c.id = cc.cleaner_id
    LEFT JOIN categories cat ON cc.category_id = cat.id
    LEFT JOIN states s ON c.state_id = s.id
    LEFT JOIN cities ci ON c.city_id = ci.id
    WHERE {$where_sql}
    GROUP BY c.id
    ORDER BY {$order_by}
    LIMIT {$per_page} OFFSET {$pagination['offset']}";

$stmt = $db->prepare($sql);
$stmt->execute($params);
$cleaners = $stmt->fetchAll();

// Sponsored cleaners for top
$sponsored = [];
if ($category) {
    $sp_sql = "SELECT c.*, s.name AS state_name, s.code AS state_code, ci.name AS city_name
        FROM sponsored_listings sl
        JOIN cleaners c ON sl.cleaner_id = c.id
        LEFT JOIN states s ON c.state_id = s.id
        LEFT JOIN cities ci ON c.city_id = ci.id
        WHERE sl.is_active = 1 AND sl.category_id = ? AND sl.start_date <= CURDATE() AND sl.end_date >= CURDATE() AND c.status = 'active'
        ORDER BY RAND() LIMIT 2";
    $stmt = $db->prepare($sp_sql);
    $stmt->execute([$category['id']]);
    $sponsored = $stmt->fetchAll();
}

// Get all categories for sidebar
$all_categories = $db->query("SELECT id, name, slug, (SELECT COUNT(*) FROM cleaner_categories WHERE category_id = categories.id) AS cnt FROM categories WHERE is_active = 1 ORDER BY sort_order")->fetchAll();

// Get states with cleaners for sidebar
$states_list = $db->query("SELECT s.id, s.name, s.slug, s.code, COUNT(c.id) AS cnt FROM states s JOIN cleaners c ON c.state_id = s.id WHERE c.status = 'active' GROUP BY s.id ORDER BY cnt DESC LIMIT 15")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/inc_head.php'; ?>
    <?php echo schema_breadcrumb($breadcrumbs); ?>
    <?php if (!empty($cleaners)):
        $list_items = array_map(function($c) { return ['name' => $c['business_name'], 'url' => (getenv('SITE_URL') ?: '') . '/cleaner/' . $c['slug']]; }, $cleaners);
        echo schema_item_list($list_items, implode(' ', $title_parts));
    endif; ?>
</head>
<body>
<?php include 'includes/inc_header.php'; ?>

<!-- Page Header -->
<section class="page-header py-5">
    <div class="container">
        <?php echo render_breadcrumbs($breadcrumbs); ?>
        <h1 class="mb-2"><?php echo e(implode(' ', $title_parts)); ?></h1>
        <p class="mb-0 opacity-75" style="font-size:1.1rem;"><?php echo number_format($total); ?> cleaner<?php echo $total !== 1 ? 's' : ''; ?> found</p>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Sort Bar -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center">
                        <label class="mr-2 mb-0 small text-muted">Sort by:</label>
                        <select class="form-control form-control-sm" style="width:auto;" onchange="window.location.href='?sort='+this.value<?php echo $category ? "+'&category={$category_slug}'" : ''; ?>">
                            <option value="rating" <?php echo $sort === 'rating' ? 'selected' : ''; ?>>Top Rated</option>
                            <option value="reviews" <?php echo $sort === 'reviews' ? 'selected' : ''; ?>>Most Reviews</option>
                            <option value="newest" <?php echo $sort === 'newest' ? 'selected' : ''; ?>>Newest</option>
                            <option value="name" <?php echo $sort === 'name' ? 'selected' : ''; ?>>Name A-Z</option>
                        </select>
                    </div>
                    <small class="text-muted">Page <?php echo $pagination['current_page']; ?> of <?php echo $pagination['total_pages']; ?></small>
                </div>

                <!-- Sponsored Results -->
                <?php foreach ($sponsored as $sp): ?>
                <div class="cleaner-list-card mb-3 sponsored">
                    <span class="badge-sponsored">Sponsored</span>
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-3 text-center p-3">
                            <img src="<?php echo e($sp['logo'] ?: '/images/default-logo.png'); ?>" alt="<?php echo e($sp['business_name']); ?>" class="img-fluid rounded" style="max-height:100px;">
                        </div>
                        <div class="col-md-6 p-3">
                            <h5 class="mb-1"><a href="/cleaner/<?php echo e($sp['slug']); ?>"><?php echo e($sp['business_name']); ?></a></h5>
                            <small class="text-muted"><i class="ti-location-pin"></i> <?php echo e(($sp['city_name'] ?? '') . ', ' . ($sp['state_code'] ?? '')); ?></small>
                            <div class="mt-1"><?php echo format_rating($sp['avg_rating']); ?> <small class="text-muted">(<?php echo $sp['review_count']; ?> reviews)</small></div>
                            <p class="small text-muted mt-1 mb-0"><?php echo e(truncate($sp['tagline'] ?? $sp['description'] ?? '', 120)); ?></p>
                        </div>
                        <div class="col-md-3 text-center p-3">
                            <a href="/cleaner/<?php echo e($sp['slug']); ?>" class="btn btn-primary btn-block mb-2">View Profile</a>
                            <a href="/get-quotes<?php echo $category ? '/' . $category['slug'] : ''; ?>" class="btn btn-outline-primary btn-block">Get Quote</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

                <!-- Results -->
                <?php if (empty($cleaners)): ?>
                <div class="empty-state text-center py-5">
                    <i class="ti-search display-4 text-muted"></i>
                    <h4 class="mt-3">No Cleaners Found</h4>
                    <p class="text-muted">Try broadening your search or <a href="/get-quotes">submit a quote request</a> and we'll find cleaners for you.</p>
                </div>
                <?php else: ?>
                <?php foreach ($cleaners as $c): ?>
                <div class="cleaner-list-card mb-3">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-3 text-center p-3">
                            <a href="/cleaner/<?php echo e($c['slug']); ?>">
                                <img src="<?php echo e($c['logo'] ?: '/images/default-logo.png'); ?>" alt="<?php echo e($c['business_name']); ?>" class="img-fluid rounded" style="max-height:100px;">
                            </a>
                        </div>
                        <div class="col-md-6 p-3">
                            <h5 class="mb-1">
                                <a href="/cleaner/<?php echo e($c['slug']); ?>"><?php echo e($c['business_name']); ?></a>
                                <?php if ($c['is_verified']): ?><span class="badge badge-success badge-sm ml-1"><i class="ti-check"></i> Verified</span><?php endif; ?>
                            </h5>
                            <small class="text-muted">
                                <?php if ($c['city_name'] && $c['state_code']): ?>
                                <i class="ti-location-pin"></i> <?php echo e($c['city_name'] . ', ' . $c['state_code']); ?>
                                <?php endif; ?>
                            </small>
                            <div class="mt-1"><?php echo format_rating($c['avg_rating']); ?> <small class="text-muted">(<?php echo $c['review_count']; ?> reviews)</small></div>
                            <p class="small text-muted mt-1 mb-0"><?php echo e(truncate($c['category_names'] ?? '', 80)); ?></p>
                            <div class="mt-2">
                                <?php if ($c['license_verified']): ?><span class="badge badge-info badge-sm mr-1"><i class="ti-id-badge"></i> Licensed</span><?php endif; ?>
                                <?php if ($c['is_insured']): ?><span class="badge badge-warning badge-sm mr-1"><i class="ti-shield"></i> Insured</span><?php endif; ?>
                                <?php if ($c['plan'] === 'premium'): ?><span class="badge badge-primary badge-sm"><i class="ti-crown"></i> Premium</span><?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-3 text-center p-3">
                            <a href="/cleaner/<?php echo e($c['slug']); ?>" class="btn btn-primary btn-block mb-2">View Profile</a>
                            <a href="/get-quotes<?php echo $category ? '/' . $category['slug'] : ''; ?>" class="btn btn-outline-primary btn-block">Get Quote</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

                <?php echo render_pagination($pagination, $_SERVER['REQUEST_URI']); ?>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="sidebar">
                    <!-- CTA -->
                    <div class="sidebar-cta mb-4">
                        <h5>Get Free Quotes</h5>
                        <p class="small">Tell us about your project and get matched with top cleaners.</p>
                        <a href="/get-quotes" class="btn btn-primary btn-block">Get Started</a>
                    </div>

                    <!-- Categories -->
                    <div class="sidebar-widget mb-4">
                        <h6 class="sidebar-title">Categories</h6>
                        <ul class="sidebar-list">
                            <?php foreach ($all_categories as $ac): ?>
                            <li<?php echo ($category && $category['id'] == $ac['id']) ? ' class="active"' : ''; ?>>
                                <a href="/cleaners/<?php echo e($ac['slug']); ?>"><?php echo e($ac['name']); ?> <span class="badge badge-light"><?php echo $ac['cnt']; ?></span></a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Locations -->
                    <?php if (!empty($states_list)): ?>
                    <div class="sidebar-widget mb-4">
                        <h6 class="sidebar-title">Popular Locations</h6>
                        <ul class="sidebar-list">
                            <?php foreach ($states_list as $st): ?>
                            <li>
                                <a href="/cleaners/<?php echo ($category ? e($category['slug']) . '/' : ''); ?><?php echo e($st['slug']); ?>"><?php echo e($st['name']); ?> <span class="badge badge-light"><?php echo $st['cnt']; ?></span></a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <!-- Banner Ad -->
                    <?php echo render_banner('sidebar', 'cleaners', $category ? $category['id'] : null); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/inc_footer.php'; ?>
