<?php
/**
 * Search Results - FindMyCleaner
 */
require_once 'includes/inc_db.php';
require_once 'includes/inc_helpers.php';

$db = get_db();
$q = trim($_GET['q'] ?? '');
$tab = $_GET['tab'] ?? 'cleaners';
$page = max(1, intval($_GET['page'] ?? 1));
$per_page = 12;

$page_title = ($q ? 'Search: ' . e($q) : 'Search') . ' | FindMyCleaner';
$page_description = $q ? 'Search results for "' . e($q) . '" on FindMyCleaner.' : 'Search for cleaning services and blog posts on FindMyCleaner.';
$page_canonical = '/search' . ($q ? '?q=' . urlencode($q) : '');
$active_page = '';
$page_noindex = true;

$cleaners = [];
$cleaner_count = 0;
$blog_posts = [];
$blog_count = 0;

if ($q !== '') {
    // Search cleaners (FULLTEXT)
    $stmt = $db->prepare("
        SELECT COUNT(DISTINCT c.id)
        FROM cleaners c
        LEFT JOIN cleaner_categories cc ON c.id = cc.cleaner_id
        LEFT JOIN categories cat ON cc.category_id = cat.id
        WHERE c.status = 'active'
        AND MATCH(c.business_name, c.description, c.tagline) AGAINST(? IN BOOLEAN MODE)
    ");
    $stmt->execute([$q]);
    $cleaner_count = (int) $stmt->fetchColumn();

    // Search blog posts
    $stmt = $db->prepare("
        SELECT COUNT(*)
        FROM pages
        WHERE type = 'blog' AND status = 'published'
        AND (title LIKE ? OR content LIKE ? OR excerpt LIKE ?)
    ");
    $like = '%' . $q . '%';
    $stmt->execute([$like, $like, $like]);
    $blog_count = (int) $stmt->fetchColumn();

    // Fetch results for current tab
    if ($tab === 'cleaners') {
        $pagination = paginate($cleaner_count, $per_page, $page);

        $stmt = $db->prepare("
            SELECT DISTINCT c.*, s.name AS state_name, s.code AS state_code, ci.name AS city_name,
            GROUP_CONCAT(DISTINCT cat.name SEPARATOR ', ') AS category_names
            FROM cleaners c
            LEFT JOIN cleaner_categories cc ON c.id = cc.cleaner_id
            LEFT JOIN categories cat ON cc.category_id = cat.id
            LEFT JOIN states s ON c.state_id = s.id
            LEFT JOIN cities ci ON c.city_id = ci.id
            WHERE c.status = 'active'
            AND MATCH(c.business_name, c.description, c.tagline) AGAINST(? IN BOOLEAN MODE)
            GROUP BY c.id
            ORDER BY c.is_featured DESC, c.avg_rating DESC
            LIMIT {$per_page} OFFSET {$pagination['offset']}
        ");
        $stmt->execute([$q]);
        $cleaners = $stmt->fetchAll();
    } else {
        $pagination = paginate($blog_count, $per_page, $page);

        $stmt = $db->prepare("
            SELECT id, title, slug, excerpt, image, published_at, created_at
            FROM pages
            WHERE type = 'blog' AND status = 'published'
            AND (title LIKE ? OR content LIKE ? OR excerpt LIKE ?)
            ORDER BY published_at DESC
            LIMIT {$per_page} OFFSET {$pagination['offset']}
        ");
        $stmt->execute([$like, $like, $like]);
        $blog_posts = $stmt->fetchAll();
    }
} else {
    $pagination = paginate(0, $per_page, 1);
}

$total_results = $cleaner_count + $blog_count;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/inc_head.php'; ?>
</head>
<body>
<?php include 'includes/inc_header.php'; ?>

<!-- Page Header -->
<section class="page-header py-4">
    <div class="container">
        <h1 class="h3 mb-2">Search Results</h1>

        <!-- Search Form -->
        <form action="/search" method="GET">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search cleaning services or blog posts..." value="<?php echo e($q); ?>">
                        <div class="input-group-append">
                            <button class="btn btn-light" type="submit"><i class="ti-search"></i> Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <?php if ($q): ?>
        <p class="mb-0 small opacity-75 mt-2"><?php echo number_format($total_results); ?> result<?php echo $total_results !== 1 ? 's' : ''; ?> for "<?php echo e($q); ?>"</p>
        <?php endif; ?>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        <?php if (empty($q)): ?>
        <div class="text-center py-5">
            <i class="ti-search display-4 text-muted"></i>
            <h4 class="mt-3">Enter a search term</h4>
            <p class="text-muted">Search for cleaning services by name, category, or browse our blog articles.</p>
        </div>
        <?php elseif ($total_results === 0): ?>
        <div class="text-center py-5">
            <i class="ti-face-sad display-4 text-muted"></i>
            <h4 class="mt-3">No results found</h4>
            <p class="text-muted">We couldn't find anything matching "<?php echo e($q); ?>". Try different keywords or <a href="/cleaners">browse all cleaning services</a>.</p>
        </div>
        <?php else: ?>

        <!-- Tabs -->
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link <?php echo $tab === 'cleaners' ? 'active' : ''; ?>" href="/search?q=<?php echo urlencode($q); ?>&tab=cleaners">
                    <i class="ti-user mr-1"></i> Cleaners <span class="badge badge-primary ml-1"><?php echo number_format($cleaner_count); ?></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $tab === 'blog' ? 'active' : ''; ?>" href="/search?q=<?php echo urlencode($q); ?>&tab=blog">
                    <i class="ti-pencil-alt mr-1"></i> Blog <span class="badge badge-primary ml-1"><?php echo number_format($blog_count); ?></span>
                </a>
            </li>
        </ul>

        <!-- Cleaners Tab -->
        <?php if ($tab === 'cleaners'): ?>
            <?php if (empty($cleaners)): ?>
            <div class="text-center py-5">
                <p class="text-muted">No cleaners found for this search. Try the <a href="/search?q=<?php echo urlencode($q); ?>&tab=blog">Blog</a> tab.</p>
            </div>
            <?php else: ?>
                <?php foreach ($cleaners as $c): ?>
                <div class="cleaner-list-card mb-3">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-2 text-center p-3">
                            <a href="/cleaner/<?php echo e($c['slug']); ?>">
                                <img src="<?php echo e($c['logo'] ?: '/images/default-logo.png'); ?>" alt="<?php echo e($c['business_name']); ?>" class="img-fluid rounded" style="max-height:80px;">
                            </a>
                        </div>
                        <div class="col-md-7 p-3">
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
                            <p class="small text-muted mt-1 mb-0"><?php echo e(truncate($c['category_names'] ?? '', 100)); ?></p>
                        </div>
                        <div class="col-md-3 text-center p-3">
                            <a href="/cleaner/<?php echo e($c['slug']); ?>" class="btn btn-primary btn-sm btn-block">View Profile</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

                <?php echo render_pagination($pagination, '/search?q=' . urlencode($q) . '&tab=cleaners'); ?>
            <?php endif; ?>

        <!-- Blog Tab -->
        <?php else: ?>
            <?php if (empty($blog_posts)): ?>
            <div class="text-center py-5">
                <p class="text-muted">No blog posts found for this search. Try the <a href="/search?q=<?php echo urlencode($q); ?>&tab=cleaners">Cleaners</a> tab.</p>
            </div>
            <?php else: ?>
            <div class="row">
                <?php foreach ($blog_posts as $post): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <?php if ($post['image']): ?>
                        <a href="/blog/<?php echo e($post['slug']); ?>">
                            <img src="<?php echo e($post['image']); ?>" class="card-img-top" alt="<?php echo e($post['title']); ?>" style="height:180px;object-fit:cover;" loading="lazy">
                        </a>
                        <?php endif; ?>
                        <div class="card-body">
                            <small class="text-muted"><?php echo date('M j, Y', strtotime($post['published_at'] ?? $post['created_at'])); ?></small>
                            <h6 class="card-title mt-1">
                                <a href="/blog/<?php echo e($post['slug']); ?>"><?php echo e($post['title']); ?></a>
                            </h6>
                            <p class="card-text small text-muted"><?php echo e(truncate($post['excerpt'] ?? '', 120)); ?></p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="/blog/<?php echo e($post['slug']); ?>" class="btn btn-sm btn-outline-primary">Read More</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <?php echo render_pagination($pagination, '/search?q=' . urlencode($q) . '&tab=blog'); ?>
            <?php endif; ?>
        <?php endif; ?>

        <?php endif; ?>
    </div>
</section>

<?php include 'includes/inc_footer.php'; ?>
