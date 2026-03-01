<?php
/**
 * Dynamic HTML <head> section
 * Set these variables before including:
 * $page_title, $page_description, $page_keywords, $page_canonical, $page_og_image, $page_og_type
 */
$site_name = getenv('SITE_NAME') ?: 'FindMyCleaner';
$site_url = getenv('SITE_URL') ?: 'https://cleaners-247.com';
$r2_url = getenv('R2_PUBLIC_URL') ?: '';
$ga_id = getenv('GOOGLE_ANALYTICS_ID') ?: 'G-796SX09N7Q';

$_title = isset($page_title) ? htmlspecialchars($page_title) : "$site_name - Find Trusted Local Cleaners";
$_desc = isset($page_description) ? htmlspecialchars($page_description) : 'Find top-rated local cleaners for roofing, plumbing, HVAC, remodeling, and more. Get free quotes from verified professionals near you.';
$_keywords = isset($page_keywords) ? htmlspecialchars($page_keywords) : 'cleaners near me, find cleaners, home improvement, get quotes';
$_canonical = isset($page_canonical) ? $site_url . $page_canonical : $site_url . $_SERVER['REQUEST_URI'];
$_og_image = isset($page_og_image) ? $page_og_image : $site_url . '/images/og-default.jpg';
$_og_type = isset($page_og_type) ? $page_og_type : 'website';
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="google-site-verification" content="vwWK2X18yiCgC-upQXG1z2aVT1_Jkb8E_s6itgPN38U">

<title><?php echo $_title; ?></title>
<meta name="description" content="<?php echo $_desc; ?>">
<meta name="keywords" content="<?php echo $_keywords; ?>">
<link rel="canonical" href="<?php echo htmlspecialchars($_canonical); ?>">
<?php if (!empty($page_noindex)): ?>
<meta name="robots" content="noindex, nofollow">
<?php endif; ?>
<?php if (!empty($page_prev)): ?>
<link rel="prev" href="<?php echo htmlspecialchars($site_url . $page_prev); ?>">
<?php endif; ?>
<?php if (!empty($page_next)): ?>
<link rel="next" href="<?php echo htmlspecialchars($site_url . $page_next); ?>">
<?php endif; ?>

<!-- Open Graph -->
<meta property="og:title" content="<?php echo $_title; ?>">
<meta property="og:description" content="<?php echo $_desc; ?>">
<meta property="og:image" content="<?php echo htmlspecialchars($_og_image); ?>">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:type" content="image/jpeg">
<meta property="og:url" content="<?php echo htmlspecialchars($_canonical); ?>">
<meta property="og:type" content="<?php echo $_og_type; ?>">
<meta property="og:site_name" content="<?php echo $site_name; ?>">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo $_title; ?>">
<meta name="twitter:description" content="<?php echo $_desc; ?>">
<meta name="twitter:image" content="<?php echo htmlspecialchars($_og_image); ?>">

<!-- Favicon -->
<link rel="icon" type="image/png" sizes="32x32" href="/images/favicon.png">
<link rel="apple-touch-icon" sizes="180x180" href="/images/favicon.png">
<meta name="theme-color" content="#1B2838">
<link rel="manifest" href="/manifest.json">

<!-- Preload LCP image on homepage -->
<?php if (isset($active_page) && $active_page === 'home'): ?>
<link rel="preload" as="image" href="/images/hero-bg.webp" type="image/webp">
<?php endif; ?>

<!-- DNS Prefetch -->
<link rel="dns-prefetch" href="//fonts.googleapis.com">
<link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
<?php if ($r2_url): ?><link rel="dns-prefetch" href="//<?php echo parse_url($r2_url, PHP_URL_HOST); ?>"><?php endif; ?>

<!-- Preconnect -->
<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<!-- Google Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Montserrat:wght@500;600;700;800;900&display=swap">

<!-- Themify Icons -->
<link rel="stylesheet" href="/plugins/themify-icons/themify-icons.css">

<!-- Bootstrap 4 CSS -->
<link rel="stylesheet" href="/plugins/bootstrap/css/bootstrap.min.css">

<!-- Plugin CSS (AOS loaded globally, others conditionally) -->
<link rel="stylesheet" href="/plugins/aos/aos.css">
<?php if (!empty($load_slick)): ?>
<link rel="stylesheet" href="/plugins/slick/slick.css">
<link rel="stylesheet" href="/plugins/slick/slick-theme.css">
<?php endif; ?>
<?php if (!empty($load_magnific)): ?>
<link rel="stylesheet" href="/plugins/magnific-popup/magnific-popup.css">
<?php endif; ?>
<?php if (!empty($load_select2)): ?>
<link rel="stylesheet" href="/plugins/select2/select2.min.css">
<?php endif; ?>

<!-- Main Stylesheet -->
<link rel="stylesheet" href="/css/style.min.css?v=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'] . '/css/style.min.css') ?: '2'; ?>">

<?php if (isset($extra_css)): ?>
<?php foreach ((array)$extra_css as $css): ?>
<link rel="stylesheet" href="<?php echo $css; ?>">
<?php endforeach; ?>
<?php endif; ?>

<?php if ($ga_id): ?>
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $ga_id; ?>"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?php echo $ga_id; ?>');</script>
<?php endif; ?>
