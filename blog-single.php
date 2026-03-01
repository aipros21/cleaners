<?php
/**
 * Single Blog Post - FindMyCleaner
 */
require_once 'includes/inc_db.php';
require_once 'includes/inc_helpers.php';
require_once 'includes/inc_schema.php';

$db = get_db();

$slug = $_GET['slug'] ?? '';

if (empty($slug)) {
    redirect('/blog');
}

// Fetch post
$stmt = $db->prepare("SELECT * FROM pages WHERE slug = ? AND type = 'blog' AND status = 'published'");
$stmt->execute([$slug]);
$post = $stmt->fetch();

if (!$post) {
    http_response_code(404);
    include '404.php';
    exit;
}

// Increment views counter
try {
    $db->prepare("UPDATE pages SET views = COALESCE(views, 0) + 1 WHERE id = ?")->execute([$post['id']]);
} catch (Exception $e) {
    // views column may not exist; fail silently
}

// SEO
$page_title = $post['title'] . ' | FindMyCleaner Blog';
$page_description = $post['excerpt'] ?? truncate(strip_tags($post['content'] ?? ''), 160);
$page_canonical = '/blog/' . $post['slug'];
$page_og_type = 'article';
$page_og_image = $post['image'] ?? null;
$active_page = 'blog';

$breadcrumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Blog', 'url' => '/blog'],
    ['name' => $post['title'], 'url' => '']
];

// Recent posts for sidebar
$stmt = $db->prepare("
    SELECT id, title, slug, image, published_at, created_at
    FROM pages
    WHERE type = 'blog' AND status = 'published' AND id != ?
    ORDER BY published_at DESC
    LIMIT 5
");
$stmt->execute([$post['id']]);
$recent_posts = $stmt->fetchAll();

// Related posts (by shared tags, fallback to recent)
$related_posts = [];
if (!empty($post['tags'])) {
    $tags = array_map('trim', explode(',', $post['tags']));
    $tag_conditions = [];
    $tag_params = [$post['id']];
    foreach ($tags as $tag) {
        $tag_conditions[] = "p.tags LIKE ?";
        $tag_params[] = '%' . $tag . '%';
    }
    $tag_sql = "SELECT p.id, p.title, p.slug, p.image, p.excerpt, p.published_at, p.created_at
        FROM pages p
        WHERE p.type = 'blog' AND p.status = 'published' AND p.id != ?
        AND (" . implode(' OR ', $tag_conditions) . ")
        ORDER BY p.published_at DESC LIMIT 3";
    $stmt = $db->prepare($tag_sql);
    $stmt->execute($tag_params);
    $related_posts = $stmt->fetchAll();
}
// Fallback: if fewer than 3 related, fill with recent
if (count($related_posts) < 3) {
    $exclude_ids = array_merge([$post['id']], array_column($related_posts, 'id'));
    $placeholders = implode(',', array_fill(0, count($exclude_ids), '?'));
    $stmt = $db->prepare("SELECT id, title, slug, image, excerpt, published_at, created_at
        FROM pages WHERE type = 'blog' AND status = 'published' AND id NOT IN ($placeholders)
        ORDER BY published_at DESC LIMIT ?");
    $stmt->execute(array_merge($exclude_ids, [3 - count($related_posts)]));
    $related_posts = array_merge($related_posts, $stmt->fetchAll());
}

// Previous and next posts
$stmt = $db->prepare("
    SELECT id, title, slug FROM pages
    WHERE type = 'blog' AND status = 'published' AND published_at < ?
    ORDER BY published_at DESC LIMIT 1
");
$stmt->execute([$post['published_at'] ?? $post['created_at']]);
$prev_post = $stmt->fetch();

$stmt = $db->prepare("
    SELECT id, title, slug FROM pages
    WHERE type = 'blog' AND status = 'published' AND published_at > ?
    ORDER BY published_at ASC LIMIT 1
");
$stmt->execute([$post['published_at'] ?? $post['created_at']]);
$next_post = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/inc_head.php'; ?>
    <?php echo schema_breadcrumb($breadcrumbs); ?>
    <?php echo schema_article($post); ?>
</head>
<body>
<?php include 'includes/inc_header.php'; ?>

<!-- Page Header -->
<section class="page-header py-4">
    <div class="container">
        <?php echo render_breadcrumbs($breadcrumbs); ?>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <article>
                    <!-- Title & Meta -->
                    <header class="mb-4">
                        <h1 class="h2 mb-3"><?php echo e($post['title']); ?></h1>
                        <?php $word_count = str_word_count(strip_tags($post['content'] ?? '')); $read_time = max(1, ceil($word_count / 230)); ?>
                        <div class="d-flex flex-wrap align-items-center text-muted small mb-3">
                            <span class="mr-3"><i class="ti-calendar mr-1"></i> <?php echo date('F j, Y', strtotime($post['published_at'] ?? $post['created_at'])); ?></span>
                            <?php if (!empty($post['author'])): ?>
                            <span class="mr-3"><i class="ti-user mr-1"></i> <?php echo e($post['author']); ?></span>
                            <?php endif; ?>
                            <span class="mr-3"><i class="ti-timer mr-1"></i> <?php echo $read_time; ?> min read</span>
                            <?php if (!empty($post['views'])): ?>
                            <span><i class="ti-eye mr-1"></i> <?php echo number_format($post['views']); ?> views</span>
                            <?php endif; ?>
                        </div>
                    </header>

                    <!-- Featured Image -->
                    <div class="mb-4">
                        <img src="<?php echo e($post['image'] ?: '/images/blog-default.webp'); ?>" alt="<?php echo e($post['title']); ?>" class="img-fluid rounded shadow-sm w-100" style="max-height:450px;object-fit:cover;">
                    </div>

                    <!-- Content -->
                    <div class="blog-content">
                        <?php echo $post['content']; ?>
                    </div>

                    <!-- Tags -->
                    <?php if (!empty($post['tags'])): ?>
                    <div class="mt-4 pt-3 border-top">
                        <i class="ti-tag mr-2 text-muted"></i>
                        <?php foreach (explode(',', $post['tags']) as $tag): ?>
                        <a href="/search?q=<?php echo urlencode(trim($tag)); ?>&tab=blog" class="badge badge-light mr-1 mb-1"><?php echo e(trim($tag)); ?></a>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Share -->
                    <div class="mt-4 pt-3 border-top">
                        <h6 class="small text-muted text-uppercase mb-3">Share this article</h6>
                        <?php $share_url = urlencode((getenv('SITE_URL') ?: 'https://cleaners-247.com') . '/blog/' . $post['slug']); ?>
                        <?php $share_title = urlencode($post['title']); ?>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary mr-2"><i class="ti-facebook mr-1"></i> Facebook</a>
                        <a href="https://twitter.com/intent/tweet?url=<?php echo $share_url; ?>&text=<?php echo $share_title; ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-info mr-2"><i class="ti-twitter-alt mr-1"></i> Twitter</a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $share_url; ?>&title=<?php echo $share_title; ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary"><i class="ti-linkedin mr-1"></i> LinkedIn</a>
                    </div>

                    <!-- Post Navigation -->
                    <div class="mt-4 pt-3 border-top">
                        <div class="row">
                            <div class="col-6">
                                <?php if ($prev_post): ?>
                                <small class="text-muted text-uppercase">Previous</small>
                                <p class="mb-0"><a href="/blog/<?php echo e($prev_post['slug']); ?>">&laquo; <?php echo e(truncate($prev_post['title'], 50)); ?></a></p>
                                <?php endif; ?>
                            </div>
                            <div class="col-6 text-right">
                                <?php if ($next_post): ?>
                                <small class="text-muted text-uppercase">Next</small>
                                <p class="mb-0"><a href="/blog/<?php echo e($next_post['slug']); ?>"><?php echo e(truncate($next_post['title'], 50)); ?> &raquo;</a></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <!-- Related Articles -->
                    <?php if (!empty($related_posts)): ?>
                    <div class="mt-5 pt-4 border-top">
                        <h5 class="mb-4">Related Articles</h5>
                        <div class="row">
                            <?php foreach ($related_posts as $rp): ?>
                            <div class="col-md-4 mb-3">
                                <a href="/blog/<?php echo e($rp['slug']); ?>" class="d-block">
                                    <img src="<?php echo e($rp['image'] ?: '/images/blog-default.webp'); ?>" alt="<?php echo e($rp['title']); ?>" class="img-fluid rounded mb-2" style="height:140px;width:100%;object-fit:cover;" loading="lazy">
                                </a>
                                <h6 class="mb-1"><a href="/blog/<?php echo e($rp['slug']); ?>"><?php echo e(truncate($rp['title'], 65)); ?></a></h6>
                                <small class="text-muted"><?php echo date('M j, Y', strtotime($rp['published_at'] ?? $rp['created_at'])); ?></small>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </article>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="sidebar">
                    <!-- CTA -->
                    <div class="sidebar-cta mb-4">
                        <h5>Need a Cleaner?</h5>
                        <p class="small">Get free quotes from top-rated local cleaners for your project.</p>
                        <a href="/get-quotes" class="btn btn-primary btn-block">Get Free Quotes</a>
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

                    <!-- Cleaner CTA -->
                    <div class="sidebar-widget mb-4 p-4 bg-light rounded">
                        <h6>Are You a Cleaner?</h6>
                        <p class="text-muted small">Create your free profile and start getting leads from homeowners today.</p>
                        <a href="/join" class="btn btn-outline-primary btn-block btn-sm">List Your Business</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/inc_footer.php'; ?>
