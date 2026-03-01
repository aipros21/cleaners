<?php
/**
 * AJAX Search autocomplete handler
 * Returns JSON array of matching cleaners, categories, and blog posts
 */
require_once dirname(__DIR__) . '/includes/inc_db.php';
require_once dirname(__DIR__) . '/includes/inc_helpers.php';

header('Content-Type: application/json');

$q = trim($_GET['q'] ?? '');

if (strlen($q) < 2) {
    json_response(['results' => []]);
}

$db = get_db();
$results = [];
$search = "%{$q}%";

// Search categories
$stmt = $db->prepare("SELECT name, slug FROM categories WHERE is_active = 1 AND name LIKE ? ORDER BY sort_order LIMIT 5");
$stmt->execute([$search]);
foreach ($stmt->fetchAll() as $row) {
    $results[] = ['name' => $row['name'], 'url' => '/cleaners/' . $row['slug'], 'type' => 'category'];
}

// Search cleaners
$stmt = $db->prepare("SELECT business_name, slug FROM cleaners WHERE status = 'active' AND (business_name LIKE ? OR tagline LIKE ?) ORDER BY avg_rating DESC LIMIT 5");
$stmt->execute([$search, $search]);
foreach ($stmt->fetchAll() as $row) {
    $results[] = ['name' => $row['business_name'], 'url' => '/cleaner/' . $row['slug'], 'type' => 'cleaner'];
}

// Search blog posts
$stmt = $db->prepare("SELECT title, slug FROM pages WHERE type = 'blog' AND status = 'published' AND title LIKE ? ORDER BY published_at DESC LIMIT 3");
$stmt->execute([$search]);
foreach ($stmt->fetchAll() as $row) {
    $results[] = ['name' => $row['title'], 'url' => '/blog/' . $row['slug'], 'type' => 'blog'];
}

json_response(['results' => $results]);
