<?php
/**
 * Helper functions
 */

/**
 * Generate URL-friendly slug
 */
function slugify($text) {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9-]/', '-', $text);
    $text = preg_replace('/-+/', '-', $text);
    return trim($text, '-');
}

/**
 * Pagination helper - returns array of page info
 */
function paginate($total, $per_page = 12, $current_page = 1) {
    $total_pages = max(1, ceil($total / $per_page));
    $current_page = max(1, min($current_page, $total_pages));
    $offset = ($current_page - 1) * $per_page;

    return [
        'total' => $total,
        'per_page' => $per_page,
        'current_page' => $current_page,
        'total_pages' => $total_pages,
        'offset' => $offset,
        'has_prev' => $current_page > 1,
        'has_next' => $current_page < $total_pages
    ];
}

/**
 * Render pagination HTML
 */
function render_pagination($pagination, $base_url = '?') {
    if ($pagination['total_pages'] <= 1) return '';

    $sep = strpos($base_url, '?') !== false ? '&' : '?';
    $html = '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">';

    // Previous
    if ($pagination['has_prev']) {
        $html .= '<li class="page-item"><a class="page-link" href="' . $base_url . $sep . 'page=' . ($pagination['current_page'] - 1) . '">&laquo;</a></li>';
    } else {
        $html .= '<li class="page-item disabled"><span class="page-link">&laquo;</span></li>';
    }

    // Page numbers
    $start = max(1, $pagination['current_page'] - 2);
    $end = min($pagination['total_pages'], $pagination['current_page'] + 2);

    if ($start > 1) {
        $html .= '<li class="page-item"><a class="page-link" href="' . $base_url . $sep . 'page=1">1</a></li>';
        if ($start > 2) $html .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
    }

    for ($i = $start; $i <= $end; $i++) {
        if ($i == $pagination['current_page']) {
            $html .= '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
        } else {
            $html .= '<li class="page-item"><a class="page-link" href="' . $base_url . $sep . 'page=' . $i . '">' . $i . '</a></li>';
        }
    }

    if ($end < $pagination['total_pages']) {
        if ($end < $pagination['total_pages'] - 1) $html .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
        $html .= '<li class="page-item"><a class="page-link" href="' . $base_url . $sep . 'page=' . $pagination['total_pages'] . '">' . $pagination['total_pages'] . '</a></li>';
    }

    // Next
    if ($pagination['has_next']) {
        $html .= '<li class="page-item"><a class="page-link" href="' . $base_url . $sep . 'page=' . ($pagination['current_page'] + 1) . '">&raquo;</a></li>';
    } else {
        $html .= '<li class="page-item disabled"><span class="page-link">&raquo;</span></li>';
    }

    $html .= '</ul></nav>';
    return $html;
}

/**
 * Time ago helper
 */
function time_ago($datetime) {
    $time = is_numeric($datetime) ? $datetime : strtotime($datetime);
    $diff = time() - $time;

    if ($diff < 60) return 'just now';
    if ($diff < 3600) return floor($diff / 60) . ' min ago';
    if ($diff < 86400) return floor($diff / 3600) . ' hours ago';
    if ($diff < 604800) return floor($diff / 86400) . ' days ago';
    if ($diff < 2592000) return floor($diff / 604800) . ' weeks ago';
    return date('M j, Y', $time);
}

/**
 * Format phone number
 */
function format_phone($phone) {
    $phone = preg_replace('/[^0-9]/', '', $phone);
    if (strlen($phone) === 10) {
        return '(' . substr($phone, 0, 3) . ') ' . substr($phone, 3, 3) . '-' . substr($phone, 6);
    }
    if (strlen($phone) === 11 && $phone[0] === '1') {
        return '(' . substr($phone, 1, 3) . ') ' . substr($phone, 4, 3) . '-' . substr($phone, 7);
    }
    return $phone;
}

/**
 * Format star rating HTML
 */
function format_rating($rating, $show_number = true) {
    $rating = round($rating, 1);
    $full = floor($rating);
    $half = ($rating - $full) >= 0.5 ? 1 : 0;
    $empty = 5 - $full - $half;

    $html = '<span class="star-rating" aria-label="Rating: ' . number_format($rating, 1) . ' out of 5">';
    for ($i = 0; $i < $full; $i++) $html .= '<i class="ti-star text-warning" aria-hidden="true"></i>';
    if ($half) $html .= '<i class="ti-star text-warning half-star" aria-hidden="true"></i>';
    for ($i = 0; $i < $empty; $i++) $html .= '<i class="ti-star text-muted" aria-hidden="true"></i>';
    if ($show_number) $html .= ' <span class="rating-number">' . number_format($rating, 1) . '</span>';
    $html .= '</span>';

    return $html;
}

/**
 * Truncate text
 */
function truncate($text, $length = 150, $suffix = '...') {
    if (mb_strlen($text) <= $length) return $text;
    return mb_substr($text, 0, $length) . $suffix;
}

/**
 * Get setting from database
 */
function get_setting($key, $default = null) {
    static $cache = [];

    if (isset($cache[$key])) return $cache[$key];

    try {
        $db = get_db();
        $stmt = $db->prepare("SELECT setting_value FROM settings WHERE setting_key = ?");
        $stmt->execute([$key]);
        $row = $stmt->fetch();
        $cache[$key] = $row ? $row['setting_value'] : $default;
    } catch (Exception $e) {
        $cache[$key] = $default;
    }

    return $cache[$key];
}

/**
 * Log activity
 */
function log_activity($action, $entity_type = null, $entity_id = null, $details = null) {
    try {
        $db = get_db();
        $user = function_exists('current_user') ? current_user() : null;
        $stmt = $db->prepare("INSERT INTO activity_log (user_id, action, entity_type, entity_id, details, ip_address) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $user ? $user['id'] : null,
            $action,
            $entity_type,
            $entity_id,
            $details,
            $_SERVER['REMOTE_ADDR'] ?? null
        ]);
    } catch (Exception $e) {
        // Silently fail - logging shouldn't break the app
    }
}

/**
 * Escape output
 */
function e($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Build URL with parameters
 */
function build_url($path, $params = []) {
    $url = $path;
    if (!empty($params)) {
        $url .= '?' . http_build_query($params);
    }
    return $url;
}

/**
 * Get plan limits
 */
function plan_limits($plan) {
    $plans = [
        'free'    => ['photos' => 3, 'leads' => 3, 'price' => 0],
        'basic'   => ['photos' => 10, 'leads' => 10, 'price' => 29],
        'pro'     => ['photos' => 30, 'leads' => 30, 'price' => 79],
        'premium' => ['photos' => 50, 'leads' => 999999, 'price' => 149],
    ];
    return $plans[$plan] ?? $plans['free'];
}

/**
 * Breadcrumb builder
 */
function render_breadcrumbs($items) {
    $html = '<nav aria-label="breadcrumb"><ol class="breadcrumb">';
    $last = count($items) - 1;
    foreach ($items as $i => $item) {
        if ($i === $last) {
            $html .= '<li class="breadcrumb-item active" aria-current="page">' . e($item['name']) . '</li>';
        } else {
            $html .= '<li class="breadcrumb-item"><a href="' . e($item['url']) . '">' . e($item['name']) . '</a></li>';
        }
    }
    $html .= '</ol></nav>';
    return $html;
}

/**
 * JSON response helper
 */
function json_response($data, $status = 200) {
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

/**
 * Redirect helper
 */
function redirect($url) {
    header("Location: $url");
    exit;
}

/**
 * Get category photo limits by plan
 */
function get_photo_limit($plan) {
    $limits = plan_limits($plan);
    return $limits['photos'];
}

/**
 * Format currency
 */
function format_money($amount) {
    return '$' . number_format((float)$amount, 2);
}
