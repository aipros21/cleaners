<?php
/**
 * Blog Listing - FindMyCleaner
 */
require_once 'includes/inc_db.php';
require_once 'includes/inc_helpers.php';
require_once 'includes/inc_schema.php';

$db = get_db();

$page = max(1, intval($_GET['page'] ?? 1));
$per_page = 9;

$page_title = 'Blog | FindMyCleaner';
$page_description = 'Read expert tips, guides, and advice on home improvement, hiring cleaners, and getting the most out of your renovation projects.';
$page_canonical = '/blog' . ($page > 1 ? '?page=' . $page : '');
$active_page = 'blog';

// Count total published posts
$total = (int) $db->query("SELECT COUNT(*) FROM pages WHERE type = 'blog' AND status = 'published'")->fetchColumn();
$pagination = paginate($total, $per_page, $page);

// Pagination rel prev/next
if ($pagination['has_prev']) {
    $page_prev = '/blog' . ($pagination['current_page'] - 1 > 1 ? '?page=' . ($pagination['current_page'] - 1) : '');
}
if ($pagination['has_next']) {
    $page_next = '/blog?page=' . ($pagination['current_page'] + 1);
}

// Fetch posts
$stmt = $db->prepare("
    SELECT id, title, slug, excerpt, image, published_at, created_at
    FROM pages
    WHERE type = 'blog' AND status = 'published'
    ORDER BY published_at DESC
    LIMIT :limit OFFSET :offset
");
$stmt->bindValue(':limit', $per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $pagination['offset'], PDO::PARAM_INT);
$stmt->execute();
$posts = $stmt->fetchAll();

// Recent posts for sidebar
$recent_posts = $db->query("
    SELECT id, title, slug, image, published_at, created_at
    FROM pages
    WHERE type = 'blog' AND status = 'published'
    ORDER BY published_at DESC
    LIMIT 5
")->fetchAll();

// Categories with post counts (using tags/categories if available, otherwise generic)
$blog_categories = [];
try {
    $blog_categories = $db->query("
        SELECT DISTINCT category, COUNT(*) AS cnt
        FROM pages
        WHERE type = 'blog' AND status = 'published' AND category IS NOT NULL AND category != ''
        GROUP BY category
        ORDER BY cnt DESC
        LIMIT 10
    ")->fetchAll();
} catch (Exception $e) {
    // category column may not exist
}
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
        <h1 class="h3 mb-1">Blog</h1>
        <p class="mb-0 small opacity-75">Expert tips, guides, and advice for homeowners and cleaners</p>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <?php if (empty($posts)): ?>
                <div class="text-center py-5">
                    <i class="ti-pencil-alt display-4 text-muted"></i>
                    <h4 class="mt-3">No Posts Yet</h4>
                    <p class="text-muted">Stay tuned! We're working on bringing you great content.</p>
                </div>
                <?php else: ?>
                <div class="row">
                    <?php foreach ($posts as $i => $post): ?>
                    <div class="col-md-6 mb-4" data-aos="fade-up" data-aos-delay="<?php echo ($i % 2) * 50; ?>">
                        <div class="card h-100 shadow-sm border-0">
                            <a href="/blog/<?php echo e($post['slug']); ?>">
                                <img src="<?php echo e($post['image'] ?: '/images/blog-default.webp'); ?>" class="card-img-top" alt="<?php echo e($post['title']); ?>" style="height:200px;object-fit:cover;" loading="lazy">
                            </a>
                            <div class="card-body d-flex flex-column">
                                <small class="text-muted mb-2">
                                    <i class="ti-calendar mr-1"></i>
                                    <?php echo date('M j, Y', strtotime($post['published_at'] ?? $post['created_at'])); ?>
                                </small>
                                <h5 class="card-title">
                                    <a href="/blog/<?php echo e($post['slug']); ?>" class="text-dark"><?php echo e($post['title']); ?></a>
                                </h5>
                                <p class="card-text text-muted small flex-grow-1"><?php echo e(truncate($post['excerpt'] ?? '', 150)); ?></p>
                                <a href="/blog/<?php echo e($post['slug']); ?>" class="btn btn-sm btn-outline-primary mt-2">Read More <i class="ti-arrow-right ml-1"></i></a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <?php echo render_pagination($pagination, '/blog'); ?>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="sidebar">
                    <!-- Search -->
                    <div class="sidebar-widget mb-4">
                        <h6 class="sidebar-title">Search Blog</h6>
                        <form action="/search" method="GET">
                            <input type="hidden" name="tab" value="blog">
                            <div class="input-group">
                                <input type="text" name="q" class="form-control" placeholder="Search articles...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="ti-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Recent Posts -->
                    <?php if (!empty($recent_posts)): ?>
                    <div class="sidebar-widget mb-4">
                        <h6 class="sidebar-title">Recent Posts</h6>
                        <?php foreach ($recent_posts as $rp): ?>
                        <div class="d-flex mb-3">
                            <?php if ($rp['image']): ?>
                            <div class="mr-3 flex-shrink-0">
                                <a href="/blog/<?php echo e($rp['slug']); ?>">
                                    <img src="<?php echo e($rp['image']); ?>" alt="<?php echo e($rp['title']); ?>" class="rounded" style="width:60px;height:60px;object-fit:cover;" loading="lazy">
                                </a>
                            </div>
                            <?php endif; ?>
                            <div>
                                <h6 class="mb-1 small"><a href="/blog/<?php echo e($rp['slug']); ?>"><?php echo e(truncate($rp['title'], 60)); ?></a></h6>
                                <small class="text-muted"><?php echo date('M j, Y', strtotime($rp['published_at'] ?? $rp['created_at'])); ?></small>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Categories -->
                    <?php if (!empty($blog_categories)): ?>
                    <div class="sidebar-widget mb-4">
                        <h6 class="sidebar-title">Categories</h6>
                        <ul class="sidebar-list">
                            <?php foreach ($blog_categories as $bc): ?>
                            <li>
                                <a href="/search?q=<?php echo urlencode($bc['category']); ?>&tab=blog">
                                    <?php echo e($bc['category']); ?> <span class="badge badge-light"><?php echo $bc['cnt']; ?></span>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <!-- CTA -->
                    <div class="sidebar-cta">
                        <h5>Are You a Cleaner?</h5>
                        <p class="small">Create your free profile and start getting leads from homeowners.</p>
                        <a href="/join" class="btn btn-primary btn-block">List Your Business</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
echo schema_breadcrumb([
    ['name' => 'Home', 'url' => 'https://cleaners-247.com/'],
    ['name' => 'Blog', 'url' => 'https://cleaners-247.com/blog']
]);

if (!empty($posts)) {
    $site_url = getenv('SITE_URL') ?: 'https://cleaners-247.com';
    $blog_items = array_map(function($p) use ($site_url) {
        return ['name' => $p['title'], 'url' => $site_url . '/blog/' . $p['slug']];
    }, $posts);
    echo schema_item_list($blog_items, 'Blog Posts');
}
?>

<?php include 'includes/inc_footer.php'; ?>
