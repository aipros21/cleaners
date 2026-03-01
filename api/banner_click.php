<?php
/**
 * Banner click tracker + redirect
 */
require_once dirname(__DIR__) . '/includes/inc_db.php';

$id = intval($_GET['id'] ?? 0);
$url = $_GET['url'] ?? '/';

if ($id > 0) {
    try {
        $db = get_db();
        $db->prepare("UPDATE banners SET clicks = clicks + 1 WHERE id = ?")->execute([$id]);
    } catch (Exception $e) {
        // Silently fail
    }
}

// Only allow same-origin URLs (starting with /) or the site's own domain
$site_url = getenv('SITE_URL') ?: 'https://cleaners-247.com';
$site_host = parse_url($site_url, PHP_URL_HOST);

if (str_starts_with($url, '/') && !str_starts_with($url, '//')) {
    // Relative URL - safe
} elseif (filter_var($url, FILTER_VALIDATE_URL) && parse_url($url, PHP_URL_HOST) === $site_host) {
    // Same-domain absolute URL - safe
} else {
    $url = '/';
}

header("Location: $url");
exit;
