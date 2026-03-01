<?php
/**
 * Individual Cleaner Profile Page
 * URL: /cleaner/{slug}/ -> cleaner-profile.php?slug=$1
 */
require_once 'includes/inc_db.php';
require_once 'includes/inc_helpers.php';
require_once 'includes/inc_schema.php';
require_once 'includes/inc_banners.php';
require_once 'includes/inc_recaptcha.php';
$load_magnific = true;
$load_recaptcha = true;

$db = get_db();
$site_url = getenv('SITE_URL') ?: 'https://cleaners-247.com';

// ------------------------------------
// Fetch cleaner by slug
// ------------------------------------
$slug = trim($_GET['slug'] ?? '');
if (!$slug) {
    http_response_code(404);
    include '404.php';
    exit;
}

$stmt = $db->prepare("
    SELECT c.*, s.name AS state_name, s.code AS state_code, s.slug AS state_slug,
           ci.name AS city_name, ci.slug AS city_slug
    FROM cleaners c
    LEFT JOIN states s ON c.state_id = s.id
    LEFT JOIN cities ci ON c.city_id = ci.id
    WHERE c.slug = ? AND c.status = 'active'
    LIMIT 1
");
$stmt->execute([$slug]);
$cleaner = $stmt->fetch();

if (!$cleaner) {
    http_response_code(404);
    include '404.php';
    exit;
}

$cid = $cleaner['id'];

// ------------------------------------
// Increment profile views
// ------------------------------------
$db->prepare("UPDATE cleaners SET profile_views = profile_views + 1 WHERE id = ?")->execute([$cid]);

// ------------------------------------
// Fetch categories
// ------------------------------------
$stmt = $db->prepare("
    SELECT cat.id, cat.name, cat.slug, cat.icon
    FROM cleaner_categories cc
    JOIN categories cat ON cc.category_id = cat.id
    WHERE cc.cleaner_id = ? AND cat.is_active = 1
    ORDER BY cat.sort_order
");
$stmt->execute([$cid]);
$categories = $stmt->fetchAll();
$primary_category = $categories[0] ?? null;

// ------------------------------------
// Fetch photos
// ------------------------------------
$stmt = $db->prepare("SELECT * FROM cleaner_photos WHERE cleaner_id = ? ORDER BY sort_order ASC, created_at DESC");
$stmt->execute([$cid]);
$photos = $stmt->fetchAll();

// ------------------------------------
// Fetch specialties
// ------------------------------------
$stmt = $db->prepare("SELECT * FROM cleaner_specialties WHERE cleaner_id = ? ORDER BY name ASC");
$stmt->execute([$cid]);
$specialties = $stmt->fetchAll();

// ------------------------------------
// Fetch active discounts
// ------------------------------------
$stmt = $db->prepare("
    SELECT * FROM cleaner_discounts
    WHERE cleaner_id = ? AND is_active = 1
      AND (valid_from IS NULL OR valid_from <= CURDATE())
      AND (valid_until IS NULL OR valid_until >= CURDATE())
    ORDER BY created_at DESC
");
$stmt->execute([$cid]);
$discounts = $stmt->fetchAll();

// ------------------------------------
// Fetch approved reviews
// ------------------------------------
$stmt = $db->prepare("
    SELECT * FROM reviews
    WHERE cleaner_id = ? AND status = 'approved'
    ORDER BY created_at DESC
");
$stmt->execute([$cid]);
$reviews = $stmt->fetchAll();

// Compute star breakdown
$star_counts = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
foreach ($reviews as $r) {
    $rating_key = min(5, max(1, (int)$r['rating']));
    $star_counts[$rating_key]++;
}
$total_reviews = count($reviews);

// ------------------------------------
// Fetch service areas
// ------------------------------------
$stmt = $db->prepare("
    SELECT sa.*, ci.name AS area_city, st.name AS area_state, st.code AS area_state_code, sa.radius_miles
    FROM cleaner_service_areas sa
    LEFT JOIN cities ci ON sa.city_id = ci.id
    LEFT JOIN states st ON sa.state_id = st.id
    WHERE sa.cleaner_id = ?
");
$stmt->execute([$cid]);
$service_areas = $stmt->fetchAll();

// ------------------------------------
// Fetch similar cleaners (same primary category)
// ------------------------------------
$similar = [];
if ($primary_category) {
    $stmt = $db->prepare("
        SELECT c.id, c.business_name, c.slug, c.logo, c.avg_rating, c.review_count,
               ci.name AS city_name, s.code AS state_code
        FROM cleaners c
        JOIN cleaner_categories cc ON c.id = cc.cleaner_id
        LEFT JOIN states s ON c.state_id = s.id
        LEFT JOIN cities ci ON c.city_id = ci.id
        WHERE cc.category_id = ? AND c.id != ? AND c.status = 'active'
        ORDER BY c.avg_rating DESC, c.review_count DESC
        LIMIT 4
    ");
    $stmt->execute([$primary_category['id'], $cid]);
    $similar = $stmt->fetchAll();
}

// ------------------------------------
// SEO variables
// ------------------------------------
$category_name = $primary_category ? $primary_category['name'] : 'Cleaner';
$location_parts = [];
if (!empty($cleaner['city_name'])) $location_parts[] = $cleaner['city_name'];
if (!empty($cleaner['state_name'])) $location_parts[] = $cleaner['state_name'];
$location_str = implode(', ', $location_parts);

$page_title = e($cleaner['business_name']) . ' - ' . e($category_name) . ($location_str ? ' in ' . e($location_str) : '') . ' | FindMyCleaner';
$page_description = truncate(strip_tags($cleaner['description'] ?? $cleaner['tagline'] ?? "Find {$cleaner['business_name']} on FindMyCleaner."), 160);
$page_canonical = '/cleaner/' . $cleaner['slug'];
$page_og_image = $cleaner['cover_image'] ?: ($cleaner['logo'] ?: $site_url . '/images/og-default.jpg');
$page_og_type = 'business.business';
$active_page = 'cleaners';

// Breadcrumbs
$breadcrumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Cleaners', 'url' => '/cleaners']
];
if ($primary_category) {
    $breadcrumbs[] = ['name' => $primary_category['name'], 'url' => '/cleaners/' . $primary_category['slug']];
}
if (!empty($cleaner['state_slug'])) {
    $breadcrumbs[] = ['name' => $cleaner['state_name'], 'url' => '/cleaners/' . ($primary_category ? $primary_category['slug'] . '/' : '') . $cleaner['state_slug']];
}
$breadcrumbs[] = ['name' => $cleaner['business_name'], 'url' => ''];

// Schema breadcrumb items with full URLs
$schema_breadcrumb_items = array_map(function($item) use ($site_url) {
    return ['name' => $item['name'], 'url' => $item['url'] ? $site_url . $item['url'] : ''];
}, $breadcrumbs);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/inc_head.php'; ?>
    <?php echo schema_local_business($cleaner); ?>
    <?php echo schema_breadcrumb($schema_breadcrumb_items); ?>
    <?php foreach (array_slice($reviews, 0, 10) as $rev): ?>
    <?php echo schema_review($rev, $cleaner); ?>
    <?php endforeach; ?>
    <style>
        .cover-area {
            position: relative;
            height: 380px;
            background: #1a1a2e;
            overflow: hidden;
        }
        .cover-area .cover-bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            opacity: 0.5;
        }
        .cover-area .cover-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.7) 100%);
        }
        .cover-area .cover-content {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding-bottom: 40px;
        }
        .profile-logo-wrap {
            margin-top: -60px;
            position: relative;
            z-index: 3;
        }
        .profile-logo {
            width: 120px;
            height: 120px;
            border-radius: 12px;
            border: 4px solid #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            object-fit: cover;
            background: #fff;
        }
        .badge-profile {
            font-size: 0.75rem;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 600;
        }
        .quick-info-bar {
            border-bottom: 1px solid #e9ecef;
        }
        .quick-info-item {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            color: #495057;
        }
        .quick-info-item i { color: #00b894; }
        .specialty-badge {
            display: inline-block;
            background: #e8f0fe;
            color: #00b894;
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            margin: 0 6px 8px 0;
        }
        .photo-gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 12px;
        }
        .photo-gallery-grid a {
            display: block;
            border-radius: 8px;
            overflow: hidden;
            aspect-ratio: 4/3;
        }
        .photo-gallery-grid img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }
        .photo-gallery-grid a:hover img { transform: scale(1.05); }
        .discount-card {
            border-left: 4px solid #28a745;
            background: #f0fdf4;
            padding: 1rem 1.25rem;
            border-radius: 6px;
            margin-bottom: 1rem;
        }
        .discount-card .discount-percent {
            font-size: 1.5rem;
            font-weight: 700;
            color: #28a745;
        }
        .review-card {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 1.25rem;
            margin-bottom: 1rem;
        }
        .review-card .review-response {
            background: #f8f9fa;
            border-left: 3px solid #00b894;
            padding: 0.75rem 1rem;
            margin-top: 0.75rem;
            border-radius: 4px;
            font-size: 0.9rem;
        }
        .star-breakdown .bar-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 4px;
            font-size: 0.85rem;
        }
        .star-breakdown .bar-track {
            flex: 1;
            height: 8px;
            background: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
        }
        .star-breakdown .bar-fill {
            height: 100%;
            background: #ffc107;
            border-radius: 4px;
        }
        .star-select label {
            cursor: pointer;
            font-size: 1.5rem;
            color: #dee2e6;
            transition: color 0.15s;
        }
        .star-select input { display: none; }
        .star-select label:hover,
        .star-select label:hover ~ label,
        .star-select input:checked ~ label { color: #ffc107; }
        .star-select { direction: rtl; display: inline-flex; }
        .star-select label { direction: ltr; }
        .sidebar-cta {
            background: linear-gradient(135deg, #00b894, #009975);
            border-radius: 12px;
            padding: 1.75rem;
            color: #fff;
        }
        .sidebar-cta .btn { font-weight: 600; }
        .hours-table td { padding: 3px 0; font-size: 0.9rem; }
        .hours-table td:first-child { font-weight: 600; width: 90px; }
        .map-placeholder {
            background: #e9ecef;
            border-radius: 8px;
            height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
        }
    </style>
</head>
<body>
<?php include 'includes/inc_header.php'; ?>

<!-- Breadcrumbs -->
<div class="bg-light py-2 border-bottom">
    <div class="container">
        <?php echo render_breadcrumbs($breadcrumbs); ?>
    </div>
</div>

<!-- Cover Image Header -->
<section class="cover-area">
    <?php if (!empty($cleaner['cover_image'])): ?>
    <div class="cover-bg" style="background-image:url('<?php echo e($cleaner['cover_image']); ?>');"></div>
    <?php endif; ?>
    <div class="cover-overlay"></div>
    <div class="container cover-content">
        <h1 class="text-white mb-2 h2"><?php echo e($cleaner['business_name']); ?></h1>
        <?php if (!empty($cleaner['tagline'])): ?>
        <p class="text-white-50 mb-2"><?php echo e($cleaner['tagline']); ?></p>
        <?php endif; ?>
        <div class="d-flex flex-wrap align-items-center mb-2">
            <?php if ($location_str): ?>
            <span class="text-white mr-3"><i class="ti-location-pin mr-1"></i> <?php echo e($location_str); ?></span>
            <?php endif; ?>
            <?php if ($cleaner['avg_rating'] > 0): ?>
            <span class="text-white mr-3"><?php echo format_rating($cleaner['avg_rating']); ?> <small class="text-white-50">(<?php echo $cleaner['review_count']; ?> review<?php echo $cleaner['review_count'] !== 1 ? 's' : ''; ?>)</small></span>
            <?php endif; ?>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <?php if ($cleaner['is_verified']): ?>
            <span class="badge badge-success badge-profile mr-2"><i class="ti-check mr-1"></i> Verified</span>
            <?php endif; ?>
            <?php if ($cleaner['license_verified']): ?>
            <span class="badge badge-info badge-profile mr-2"><i class="ti-id-badge mr-1"></i> Licensed</span>
            <?php endif; ?>
            <?php if ($cleaner['is_insured']): ?>
            <span class="badge badge-warning badge-profile mr-2"><i class="ti-shield mr-1"></i> Insured</span>
            <?php endif; ?>
            <?php if ($cleaner['is_featured']): ?>
            <span class="badge badge-primary badge-profile mr-2"><i class="ti-crown mr-1"></i> Featured</span>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Logo + Quick Info Bar -->
<section class="bg-white">
    <div class="container">
        <div class="d-flex align-items-end flex-wrap">
            <div class="profile-logo-wrap mr-3">
                <img src="<?php echo e($cleaner['logo'] ?: '/images/default-logo.png'); ?>" alt="<?php echo e($cleaner['business_name']); ?> logo" class="profile-logo">
            </div>
            <div class="quick-info-bar py-3 d-flex flex-wrap">
                <?php if (!empty($cleaner['phone'])): ?>
                <a href="tel:<?php echo e(preg_replace('/[^0-9+]/', '', $cleaner['phone'])); ?>" class="quick-info-item text-decoration-none">
                    <i class="ti-mobile"></i> <?php echo format_phone($cleaner['phone']); ?>
                </a>
                <?php endif; ?>
                <?php if (!empty($cleaner['email'])): ?>
                <a href="mailto:<?php echo e($cleaner['email']); ?>" class="quick-info-item text-decoration-none">
                    <i class="ti-email"></i> <?php echo e($cleaner['email']); ?>
                </a>
                <?php endif; ?>
                <?php if (!empty($cleaner['website'])): ?>
                <a href="<?php echo e($cleaner['website']); ?>" target="_blank" rel="noopener" class="quick-info-item text-decoration-none">
                    <i class="ti-world"></i> Website
                </a>
                <?php endif; ?>
                <?php if (!empty($cleaner['years_experience'])): ?>
                <span class="quick-info-item"><i class="ti-briefcase"></i> <?php echo (int)$cleaner['years_experience']; ?> yrs experience</span>
                <?php endif; ?>
                <?php if (!empty($cleaner['employees_count'])): ?>
                <span class="quick-info-item"><i class="ti-user"></i> <?php echo e($cleaner['employees_count']); ?> employees</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8">

                <!-- About Section -->
                <?php if (!empty($cleaner['description'])): ?>
                <div class="mb-5" id="about">
                    <h3 class="mb-3">About <?php echo e($cleaner['business_name']); ?></h3>
                    <div class="text-muted" style="line-height:1.8;">
                        <?php echo nl2br(e($cleaner['description'])); ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Categories -->
                <?php if (!empty($categories)): ?>
                <div class="mb-4">
                    <h5 class="mb-3">Services</h5>
                    <?php foreach ($categories as $cat): ?>
                    <a href="/cleaners/<?php echo e($cat['slug']); ?>" class="specialty-badge">
                        <?php if (!empty($cat['icon'])): ?><i class="<?php echo e($cat['icon']); ?> mr-1"></i><?php endif; ?>
                        <?php echo e($cat['name']); ?>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Specialties -->
                <?php if (!empty($specialties)): ?>
                <div class="mb-5" id="specialties">
                    <h5 class="mb-3">Specialties</h5>
                    <?php foreach ($specialties as $sp): ?>
                    <span class="specialty-badge"><i class="ti-check-box mr-1"></i> <?php echo e($sp['name']); ?></span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Photo Gallery -->
                <?php if (!empty($photos)): ?>
                <div class="mb-5" id="gallery">
                    <h3 class="mb-3">Photo Gallery</h3>
                    <div class="photo-gallery photo-gallery-grid">
                        <?php foreach ($photos as $photo): ?>
                        <a href="<?php echo e($photo['url']); ?>" title="<?php echo e($photo['caption'] ?? ''); ?>">
                            <img src="<?php echo e($photo['thumbnail'] ?: $photo['url']); ?>" alt="<?php echo e($photo['caption'] ?? $cleaner['business_name'] . ' photo'); ?>" loading="lazy">
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <script>document.addEventListener('DOMContentLoaded', function(){ if(typeof initGallery === 'function') initGallery(); });</script>
                <?php endif; ?>

                <!-- Discounts / Promotions -->
                <?php if (!empty($discounts)): ?>
                <div class="mb-5" id="promotions">
                    <h3 class="mb-3"><i class="ti-gift text-success mr-2"></i>Current Promotions</h3>
                    <?php foreach ($discounts as $disc): ?>
                    <div class="discount-card">
                        <div class="d-flex align-items-start">
                            <?php if (!empty($disc['discount_percent'])): ?>
                            <div class="discount-percent mr-3"><?php echo (int)$disc['discount_percent']; ?>%<small class="d-block text-muted" style="font-size:0.7rem;font-weight:400;">OFF</small></div>
                            <?php endif; ?>
                            <div>
                                <h6 class="mb-1"><?php echo e($disc['title']); ?></h6>
                                <?php if (!empty($disc['description'])): ?>
                                <p class="text-muted small mb-1"><?php echo e($disc['description']); ?></p>
                                <?php endif; ?>
                                <?php if (!empty($disc['valid_until'])): ?>
                                <small class="text-muted"><i class="ti-timer mr-1"></i>Valid until <?php echo date('M j, Y', strtotime($disc['valid_until'])); ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Reviews Section -->
                <div class="mb-5" id="reviews">
                    <h3 class="mb-4">Reviews</h3>

                    <?php if ($total_reviews > 0): ?>
                    <!-- Star Breakdown -->
                    <div class="row mb-4">
                        <div class="col-md-4 text-center mb-3 mb-md-0">
                            <div style="font-size:3rem;font-weight:700;line-height:1;"><?php echo number_format($cleaner['avg_rating'], 1); ?></div>
                            <div class="my-2"><?php echo format_rating($cleaner['avg_rating'], false); ?></div>
                            <small class="text-muted"><?php echo $total_reviews; ?> review<?php echo $total_reviews !== 1 ? 's' : ''; ?></small>
                        </div>
                        <div class="col-md-8">
                            <div class="star-breakdown">
                                <?php for ($s = 5; $s >= 1; $s--): ?>
                                <?php $pct = $total_reviews > 0 ? round(($star_counts[$s] / $total_reviews) * 100) : 0; ?>
                                <div class="bar-row">
                                    <span><?php echo $s; ?> <i class="ti-star text-warning" style="font-size:0.75rem;"></i></span>
                                    <div class="bar-track"><div class="bar-fill" style="width:<?php echo $pct; ?>%;"></div></div>
                                    <span class="text-muted"><?php echo $star_counts[$s]; ?></span>
                                </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Individual Reviews -->
                    <?php foreach ($reviews as $rev): ?>
                    <div class="review-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <strong><?php echo e($rev['author_name']); ?></strong>
                                <?php if ($rev['is_verified']): ?>
                                <span class="badge badge-success badge-sm ml-1"><i class="ti-check"></i> Verified</span>
                                <?php endif; ?>
                            </div>
                            <small class="text-muted"><?php echo time_ago($rev['created_at']); ?></small>
                        </div>
                        <div class="mb-2"><?php echo format_rating($rev['rating'], false); ?></div>
                        <?php if (!empty($rev['title'])): ?>
                        <h6 class="mb-1"><?php echo e($rev['title']); ?></h6>
                        <?php endif; ?>
                        <?php if (!empty($rev['content'])): ?>
                        <p class="text-muted mb-0"><?php echo nl2br(e($rev['content'])); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($rev['response'])): ?>
                        <div class="review-response">
                            <strong class="d-block mb-1"><i class="ti-comments mr-1"></i> Response from <?php echo e($cleaner['business_name']); ?></strong>
                            <span class="text-muted"><?php echo nl2br(e($rev['response'])); ?></span>
                            <?php if (!empty($rev['response_date'])): ?>
                            <small class="d-block text-muted mt-1"><?php echo time_ago($rev['response_date']); ?></small>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <p class="text-muted">No reviews yet. Be the first to leave a review!</p>
                    <?php endif; ?>
                </div>

                <!-- Leave a Review Form -->
                <div class="mb-5" id="leave-review">
                    <h3 class="mb-3">Leave a Review</h3>
                    <div class="card">
                        <div class="card-body">
                            <form data-ajax method="POST" action="/api/handle_review.php" data-reset="true" data-recaptcha-action="review">
                                <input type="hidden" name="cleaner_id" value="<?php echo $cid; ?>">

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="reviewName">Your Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="reviewName" name="author_name" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="reviewEmail">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="reviewEmail" name="author_email" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Rating <span class="text-danger">*</span></label>
                                    <div class="star-select">
                                        <?php for ($s = 5; $s >= 1; $s--): ?>
                                        <input type="radio" name="rating" id="star<?php echo $s; ?>" value="<?php echo $s; ?>" <?php echo $s === 5 ? 'required' : ''; ?>>
                                        <label for="star<?php echo $s; ?>" title="<?php echo $s; ?> star<?php echo $s > 1 ? 's' : ''; ?>"><i class="ti-star"></i></label>
                                        <?php endfor; ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="reviewTitle">Review Title</label>
                                    <input type="text" class="form-control" id="reviewTitle" name="title" maxlength="200" placeholder="Summary of your experience">
                                </div>

                                <div class="form-group">
                                    <label for="reviewContent">Your Review <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="reviewContent" name="content" rows="5" required placeholder="Tell others about your experience with this cleaner..."></textarea>
                                </div>

                                <input type="hidden" name="g-recaptcha-response" id="recaptchaReview">

                                <button type="submit" class="btn btn-primary"><i class="ti-check mr-1"></i> Submit Review</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">

                <!-- Request Quote CTA -->
                <div class="sidebar-cta mb-4">
                    <h5 class="text-white mb-2">Request a Free Quote</h5>
                    <p class="small mb-3 opacity-75">Get a personalized quote from <?php echo e($cleaner['business_name']); ?> for your project.</p>
                    <a href="/get-quotes<?php echo $primary_category ? '/' . e($primary_category['slug']) : ''; ?>" class="btn btn-light btn-block"><i class="ti-write mr-1"></i> Request Quote</a>
                    <?php if (!empty($cleaner['phone'])): ?>
                    <a href="tel:<?php echo e(preg_replace('/[^0-9+]/', '', $cleaner['phone'])); ?>" class="btn btn-outline-light btn-block mt-2"><i class="ti-mobile mr-1"></i> <?php echo format_phone($cleaner['phone']); ?></a>
                    <?php endif; ?>
                </div>

                <!-- Business Hours -->
                <?php
                // Business hours stored as JSON in settings or cleaner meta
                // Attempt to decode from a 'business_hours' field if present
                $hours = null;
                if (!empty($cleaner['business_hours'])) {
                    $hours = json_decode($cleaner['business_hours'], true);
                }
                if ($hours && is_array($hours)):
                ?>
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="mb-3"><i class="ti-time mr-2"></i>Business Hours</h6>
                        <table class="hours-table w-100">
                            <?php
                            $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
                            foreach ($days as $day):
                                $key = strtolower($day);
                                $val = $hours[$key] ?? 'Closed';
                            ?>
                            <tr>
                                <td><?php echo substr($day, 0, 3); ?></td>
                                <td class="text-muted"><?php echo e($val); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Service Area -->
                <?php if (!empty($service_areas)): ?>
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="mb-3"><i class="ti-map-alt mr-2"></i>Service Area</h6>
                        <ul class="list-unstyled mb-0">
                            <?php foreach ($service_areas as $sa): ?>
                            <li class="mb-1">
                                <i class="ti-location-pin text-primary mr-1"></i>
                                <?php
                                $area_parts = [];
                                if (!empty($sa['area_city'])) $area_parts[] = $sa['area_city'];
                                if (!empty($sa['area_state_code'])) $area_parts[] = $sa['area_state_code'];
                                echo e(implode(', ', $area_parts));
                                if (!empty($sa['radius_miles'])) echo ' <small class="text-muted">(' . (int)$sa['radius_miles'] . ' mi radius)</small>';
                                ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Google Map Placeholder -->
                <?php if (!empty($cleaner['lat']) && !empty($cleaner['lng'])): ?>
                <div class="card mb-4">
                    <div class="card-body p-0">
                        <div id="cleanerMap" class="map-placeholder" data-lat="<?php echo e($cleaner['lat']); ?>" data-lng="<?php echo e($cleaner['lng']); ?>">
                            <span><i class="ti-map-alt mr-2"></i>Map</span>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Banner Ad -->
                <?php echo render_banner('sidebar', 'profile', $primary_category ? $primary_category['id'] : null); ?>

                <!-- Similar Cleaners -->
                <?php if (!empty($similar)): ?>
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="mb-3">Similar Cleaners</h6>
                        <?php foreach ($similar as $sim): ?>
                        <div class="d-flex align-items-center mb-3">
                            <img src="<?php echo e($sim['logo'] ?: '/images/default-logo.png'); ?>" alt="<?php echo e($sim['business_name']); ?>" class="rounded mr-3" style="width:48px;height:48px;object-fit:cover;">
                            <div class="flex-grow-1 overflow-hidden">
                                <a href="/cleaner/<?php echo e($sim['slug']); ?>" class="d-block font-weight-bold text-truncate"><?php echo e($sim['business_name']); ?></a>
                                <small class="text-muted">
                                    <?php if ($sim['city_name'] && $sim['state_code']): ?>
                                    <?php echo e($sim['city_name'] . ', ' . $sim['state_code']); ?> &middot;
                                    <?php endif; ?>
                                    <?php echo format_rating($sim['avg_rating']); ?> <span class="text-muted">(<?php echo $sim['review_count']; ?>)</span>
                                </small>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>

<?php include 'includes/inc_footer.php'; ?>
