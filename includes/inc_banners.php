<?php
/**
 * Banner ad rendering with impression tracking
 */

function render_banner($position = 'sidebar', $page = null, $category_id = null) {
    try {
        $db = get_db();

        $sql = "SELECT id, name, image, url FROM banners WHERE is_active = 1 AND position = ? AND (start_date IS NULL OR start_date <= CURDATE()) AND (end_date IS NULL OR end_date >= CURDATE())";
        $params = [$position];

        if ($category_id) {
            $sql .= " AND (category_id IS NULL OR category_id = ?)";
            $params[] = $category_id;
        }

        $sql .= " ORDER BY RAND() LIMIT 1";

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $banner = $stmt->fetch();

        if (!$banner) return '';

        // Track impression
        $db->prepare("UPDATE banners SET impressions = impressions + 1 WHERE id = ?")->execute([$banner['id']]);

        $html = '<div class="banner-ad banner-' . e($position) . '" data-banner-id="' . $banner['id'] . '">';
        if ($banner['url']) {
            $html .= '<a href="/api/banner_click.php?id=' . $banner['id'] . '&url=' . urlencode($banner['url']) . '" target="_blank" rel="noopener">';
        }
        $html .= '<img src="' . e($banner['image']) . '" alt="' . e($banner['name']) . '" class="img-fluid banner-img" loading="lazy">';
        if ($banner['url']) {
            $html .= '</a>';
        }
        $html .= '</div>';

        return $html;
    } catch (Exception $e) {
        return '';
    }
}
