<?php
/**
 * Sitemap XML Generator
 * Serves dynamic sitemap at /sitemap.xml (via .htaccess rewrite)
 * Also callable via CLI: php sitemap-generator.php
 * All entries include lastmod for better crawl efficiency
 */
require_once __DIR__ . '/includes/inc_db.php';

$site_url = getenv('SITE_URL') ?: 'https://cleaners-247.com';
$db = get_db();
$today = date('Y-m-d');

$urls = [];

// Static pages — use today's date (content rarely changes, but keeps sitemap fresh)
$static = [
    ['path' => '/',             'priority' => '1.0', 'changefreq' => 'daily'],
    ['path' => '/cleaners',  'priority' => '0.9', 'changefreq' => 'daily'],
    ['path' => '/get-quotes',   'priority' => '0.8', 'changefreq' => 'weekly'],
    ['path' => '/about',        'priority' => '0.5', 'changefreq' => 'monthly'],
    ['path' => '/contact',      'priority' => '0.5', 'changefreq' => 'monthly'],
    ['path' => '/pricing',      'priority' => '0.7', 'changefreq' => 'weekly'],
    ['path' => '/blog',         'priority' => '0.8', 'changefreq' => 'daily'],
    ['path' => '/faq',          'priority' => '0.7', 'changefreq' => 'monthly'],
    ['path' => '/join',         'priority' => '0.7', 'changefreq' => 'monthly'],
    ['path' => '/register',     'priority' => '0.6', 'changefreq' => 'monthly'],
];
foreach ($static as $page) {
    $urls[] = ['loc' => $site_url . $page['path'], 'priority' => $page['priority'], 'changefreq' => $page['changefreq'], 'lastmod' => $today];
}

// Categories — lastmod from most recent cleaner update in that category
$categories = $db->query("
    SELECT cat.slug, COALESCE(MAX(c.updated_at), cat.created_at) AS last_updated
    FROM categories cat
    LEFT JOIN cleaner_categories cc ON cat.id = cc.category_id
    LEFT JOIN cleaners c ON cc.cleaner_id = c.id AND c.status = 'active'
    WHERE cat.is_active = 1
    GROUP BY cat.id
    ORDER BY cat.sort_order
")->fetchAll();
foreach ($categories as $cat) {
    $urls[] = ['loc' => $site_url . '/cleaners/' . $cat['slug'], 'priority' => '0.9', 'changefreq' => 'daily', 'lastmod' => date('Y-m-d', strtotime($cat['last_updated']))];
}

// Category + State combos — lastmod from most recent cleaner in that combo
$combos = $db->query("
    SELECT cat.slug AS cat_slug, s.slug AS state_slug, MAX(c.updated_at) AS last_updated
    FROM cleaners c
    JOIN cleaner_categories cc ON c.id = cc.cleaner_id
    JOIN categories cat ON cc.category_id = cat.id
    JOIN states s ON c.state_id = s.id
    WHERE c.status = 'active'
    GROUP BY cat.slug, s.slug
")->fetchAll();
foreach ($combos as $combo) {
    $urls[] = ['loc' => $site_url . '/cleaners/' . $combo['cat_slug'] . '/' . $combo['state_slug'], 'priority' => '0.8', 'changefreq' => 'daily', 'lastmod' => date('Y-m-d', strtotime($combo['last_updated']))];
}

// State landing pages — lastmod from most recent cleaner in that state
$states = $db->query("
    SELECT s.slug, COALESCE(MAX(c.updated_at), NOW()) AS last_updated
    FROM states s
    LEFT JOIN cleaners c ON c.state_id = s.id AND c.status = 'active'
    GROUP BY s.id
")->fetchAll();
foreach ($states as $state) {
    $urls[] = ['loc' => $site_url . '/' . $state['slug'] . '/cleaners', 'priority' => '0.7', 'changefreq' => 'weekly', 'lastmod' => date('Y-m-d', strtotime($state['last_updated']))];
}

// Cleaner profiles
$cleaners = $db->query("SELECT slug, updated_at FROM cleaners WHERE status = 'active'")->fetchAll();
foreach ($cleaners as $c) {
    $urls[] = ['loc' => $site_url . '/cleaner/' . $c['slug'], 'priority' => '0.7', 'changefreq' => 'weekly', 'lastmod' => date('Y-m-d', strtotime($c['updated_at']))];
}

// Blog posts
$posts = $db->query("SELECT slug, updated_at FROM pages WHERE type = 'blog' AND status = 'published' ORDER BY published_at DESC")->fetchAll();
foreach ($posts as $p) {
    $urls[] = ['loc' => $site_url . '/blog/' . $p['slug'], 'priority' => '0.6', 'changefreq' => 'monthly', 'lastmod' => date('Y-m-d', strtotime($p['updated_at']))];
}

// Generate XML
$xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

foreach ($urls as $u) {
    $xml .= "  <url>\n";
    $xml .= "    <loc>" . htmlspecialchars($u['loc']) . "</loc>\n";
    $xml .= "    <lastmod>{$u['lastmod']}</lastmod>\n";
    $xml .= "    <changefreq>{$u['changefreq']}</changefreq>\n";
    $xml .= "    <priority>{$u['priority']}</priority>\n";
    $xml .= "  </url>\n";
}

$xml .= '</urlset>';

if (php_sapi_name() === 'cli') {
    file_put_contents(__DIR__ . '/sitemap.xml', $xml);
    echo "Sitemap generated: " . count($urls) . " URLs\n";
} else {
    header('Content-Type: application/xml; charset=UTF-8');
    header('X-Robots-Tag: noindex');
    echo $xml;
}
