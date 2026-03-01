<?php
/**
 * Google reCAPTCHA v3 verification
 */

function verify_recaptcha($token, $expected_action = '', $min_score = 0.5) {
    if (empty($token)) {
        return ['success' => false, 'error' => 'Security verification failed. Please try again.'];
    }

    $secret = getenv('RECAPTCHA_SECRET_KEY');
    if (!$secret || $secret === 'placeholder') {
        // Skip verification in development
        return ['success' => true];
    }

    $post_data = [
        'secret' => $secret,
        'response' => $token,
        'remoteip' => $_SERVER['REMOTE_ADDR'] ?? ''
    ];

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($post_data),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10
    ]);

    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        return ['success' => false, 'error' => 'Security verification failed. Please try again.'];
    }

    $data = json_decode($response, true);

    if (empty($data['success'])) {
        return ['success' => false, 'error' => 'Security verification failed. Please try again.'];
    }

    // Check action matches if specified
    if ($expected_action && isset($data['action']) && $data['action'] !== $expected_action) {
        return ['success' => false, 'error' => 'Security verification failed. Please try again.'];
    }

    // Check score (0.0 = bot, 1.0 = human)
    $score = $data['score'] ?? 0;
    if ($score < $min_score) {
        return ['success' => false, 'error' => 'Security verification failed. Please try again.'];
    }

    return ['success' => true, 'score' => $score];
}

function recaptcha_site_key() {
    return getenv('RECAPTCHA_SITE_KEY') ?: '';
}
