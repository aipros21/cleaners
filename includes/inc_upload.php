<?php
/**
 * File upload via Cloudflare R2 (S3-compatible API)
 * All images go through R2 for CDN delivery via public bucket URL.
 */

/**
 * Generate AWS Signature V4 for R2 (S3-compatible) requests
 */
function r2_sign_request($method, $path, $headers, $payload_hash, $region = 'auto') {
    $access_key = getenv('R2_ACCESS_KEY_ID');
    $secret_key = getenv('R2_SECRET_ACCESS_KEY');

    // Use the date from headers to ensure consistency between canonical request and signature
    $date = $headers['x-amz-date'] ?? $headers['X-Amz-Date'] ?? gmdate('Ymd\THis\Z');
    $date_short = substr($date, 0, 8);
    $service = 's3';

    $canonical_headers = '';
    $signed_header_names = [];
    ksort($headers);
    foreach ($headers as $k => $v) {
        $canonical_headers .= strtolower($k) . ':' . trim($v) . "\n";
        $signed_header_names[] = strtolower($k);
    }
    $signed_headers = implode(';', $signed_header_names);

    $canonical_request = implode("\n", [
        $method,
        $path,
        '',  // query string
        $canonical_headers,
        $signed_headers,
        $payload_hash
    ]);

    $scope = "{$date_short}/{$region}/{$service}/aws4_request";
    $string_to_sign = implode("\n", [
        'AWS4-HMAC-SHA256',
        $date,
        $scope,
        hash('sha256', $canonical_request)
    ]);

    $signing_key = hash_hmac('sha256', 'aws4_request',
        hash_hmac('sha256', $service,
            hash_hmac('sha256', $region,
                hash_hmac('sha256', $date_short, 'AWS4' . $secret_key, true),
            true),
        true),
    true);

    $signature = hash_hmac('sha256', $string_to_sign, $signing_key);

    return [
        'authorization' => "AWS4-HMAC-SHA256 Credential={$access_key}/{$scope}, SignedHeaders={$signed_headers}, Signature={$signature}",
        'x-amz-date' => $date,
    ];
}

/**
 * Determine R2 object key from metadata
 */
function r2_object_key($filename, $metadata = []) {
    $type = $metadata['type'] ?? 'uploads';
    $cleaner_id = $metadata['cleaner_id'] ?? null;

    switch ($type) {
        case 'portfolio':
            return "cleaners/{$cleaner_id}/portfolio/{$filename}";
        case 'logo':
        case 'cleaner_logo':
            return "cleaners/" . ($cleaner_id ?: 'unknown') . "/logo/{$filename}";
        case 'cover':
        case 'cleaner_cover':
            return "cleaners/" . ($cleaner_id ?: 'unknown') . "/cover/{$filename}";
        case 'blog_image':
            return "blog/{$filename}";
        case 'banner':
            return "banners/{$filename}";
        case 'category':
            return "categories/{$filename}";
        case 'page_image':
            return "pages/{$filename}";
        default:
            return "uploads/{$filename}";
    }
}

/**
 * Upload file to Cloudflare R2
 * Returns: ['success' => bool, 'url' => public URL, 'key' => R2 object key, 'error' => string]
 */
function upload_to_r2($file_path, $metadata = []) {
    $account_id = getenv('R2_ACCOUNT_ID');
    $access_key = getenv('R2_ACCESS_KEY_ID');
    $secret_key = getenv('R2_SECRET_ACCESS_KEY');
    $bucket     = getenv('R2_BUCKET_NAME');
    $public_url = rtrim(getenv('R2_PUBLIC_URL') ?: '', '/');

    if (!$account_id || !$access_key || !$secret_key || !$bucket) {
        return ['success' => false, 'error' => 'R2 not configured. Check .env credentials.'];
    }

    if (!file_exists($file_path)) {
        return ['success' => false, 'error' => 'File not found'];
    }

    $body = file_get_contents($file_path);
    $content_type = mime_content_type($file_path) ?: 'application/octet-stream';

    // Generate unique filename
    $ext = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
    if (!$ext) {
        $ext_map = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp'];
        $ext = $ext_map[$content_type] ?? 'jpg';
    }
    $filename = bin2hex(random_bytes(12)) . '.' . $ext;
    $object_key = r2_object_key($filename, $metadata);

    $endpoint = "https://{$account_id}.r2.cloudflarestorage.com";
    $host = "{$account_id}.r2.cloudflarestorage.com";
    $path = "/{$bucket}/{$object_key}";
    $payload_hash = hash('sha256', $body);

    $headers = [
        'Host' => $host,
        'Content-Type' => $content_type,
        'Content-Length' => (string)strlen($body),
        'x-amz-content-sha256' => $payload_hash,
        'x-amz-date' => gmdate('Ymd\THis\Z'),
    ];

    $signed = r2_sign_request('PUT', $path, $headers, $payload_hash);
    $headers['Authorization'] = $signed['authorization'];

    $curl_headers = [];
    foreach ($headers as $k => $v) {
        $curl_headers[] = "{$k}: {$v}";
    }

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $endpoint . $path,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => $body,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 120,
        CURLOPT_HTTPHEADER => $curl_headers,
    ]);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        return ['success' => false, 'error' => "cURL error: $error"];
    }

    if ($http_code >= 200 && $http_code < 300) {
        $url = $public_url ? "{$public_url}/{$object_key}" : "{$endpoint}/{$bucket}/{$object_key}";
        return [
            'success' => true,
            'url' => $url,
            'key' => $object_key,
            'image_id' => $object_key, // backwards compat
            'variants' => [$url],      // backwards compat
        ];
    }

    return ['success' => false, 'error' => "R2 upload failed (HTTP {$http_code}): " . substr($response, 0, 500)];
}

/**
 * Delete file from R2
 */
function delete_from_r2($object_key) {
    $account_id = getenv('R2_ACCOUNT_ID');
    $access_key = getenv('R2_ACCESS_KEY_ID');
    $secret_key = getenv('R2_SECRET_ACCESS_KEY');
    $bucket     = getenv('R2_BUCKET_NAME');

    if (!$account_id || !$access_key || !$secret_key || !$bucket) return false;

    $endpoint = "https://{$account_id}.r2.cloudflarestorage.com";
    $host = "{$account_id}.r2.cloudflarestorage.com";
    $path = "/{$bucket}/{$object_key}";
    $payload_hash = hash('sha256', '');

    $headers = [
        'Host' => $host,
        'x-amz-content-sha256' => $payload_hash,
        'x-amz-date' => gmdate('Ymd\THis\Z'),
    ];

    $signed = r2_sign_request('DELETE', $path, $headers, $payload_hash);
    $headers['Authorization'] = $signed['authorization'];

    $curl_headers = [];
    foreach ($headers as $k => $v) {
        $curl_headers[] = "{$k}: {$v}";
    }

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $endpoint . $path,
        CURLOPT_CUSTOMREQUEST => 'DELETE',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_HTTPHEADER => $curl_headers,
    ]);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return $http_code >= 200 && $http_code < 300;
}

// Backwards-compatible aliases
function upload_to_cloudflare_images($file_path, $metadata = []) {
    return upload_to_r2($file_path, $metadata);
}

function delete_cloudflare_image($image_id) {
    return delete_from_r2($image_id);
}

/**
 * Get public URL for an R2 object
 */
function r2_url($object_key) {
    $public_url = rtrim(getenv('R2_PUBLIC_URL') ?: '', '/');
    if (!$public_url || !$object_key) return '/images/default-logo.png';
    return "{$public_url}/{$object_key}";
}

// Backwards-compatible alias
function cf_image_url($image_id, $variant = 'public') {
    return r2_url($image_id);
}

/**
 * Handle file upload from HTML form
 * Validates, uploads to R2, returns URL
 */
function handle_upload($file_input, $metadata = [], $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp']) {
    if (!isset($_FILES[$file_input]) || $_FILES[$file_input]['error'] !== UPLOAD_ERR_OK) {
        $errors = [
            UPLOAD_ERR_INI_SIZE => 'File exceeds server limit.',
            UPLOAD_ERR_FORM_SIZE => 'File exceeds form limit.',
            UPLOAD_ERR_PARTIAL => 'File only partially uploaded.',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
        ];
        $code = $_FILES[$file_input]['error'] ?? UPLOAD_ERR_NO_FILE;
        return ['success' => false, 'error' => $errors[$code] ?? 'Upload error.'];
    }

    $file = $_FILES[$file_input];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        return ['success' => false, 'error' => 'File type not allowed. Allowed: ' . implode(', ', $allowed)];
    }

    // Max 10MB
    if ($file['size'] > 10 * 1024 * 1024) {
        return ['success' => false, 'error' => 'File too large. Maximum 10MB.'];
    }

    // Verify it's actually an image
    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
        $img_info = getimagesize($file['tmp_name']);
        if ($img_info === false) {
            return ['success' => false, 'error' => 'Invalid image file.'];
        }
    }

    return upload_to_r2($file['tmp_name'], $metadata);
}

/**
 * Upload from URL to R2
 */
function upload_url_to_r2($image_url, $metadata = []) {
    // Download to temp file first
    $tmp = tempnam(sys_get_temp_dir(), 'r2_');
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $image_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 60,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS => 5,
    ]);
    $data = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code !== 200 || !$data) {
        @unlink($tmp);
        return ['success' => false, 'error' => 'Failed to download image from URL'];
    }

    file_put_contents($tmp, $data);

    // Detect extension from URL or content
    $ext = strtolower(pathinfo(parse_url($image_url, PHP_URL_PATH), PATHINFO_EXTENSION));
    if ($ext && in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
        $tmp_ext = $tmp . '.' . $ext;
        rename($tmp, $tmp_ext);
        $tmp = $tmp_ext;
    }

    $result = upload_to_r2($tmp, $metadata);
    @unlink($tmp);

    return $result;
}

// Backwards-compatible alias
function upload_url_to_cloudflare_images($image_url, $metadata = []) {
    return upload_url_to_r2($image_url, $metadata);
}
