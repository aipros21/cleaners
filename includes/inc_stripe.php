<?php
/**
 * Stripe API integration via cURL (no SDK)
 */

/**
 * Check if Stripe is configured with real keys
 */
function is_stripe_configured() {
    $key = getenv('STRIPE_SECRET_KEY');
    return $key && $key !== 'sk_test_placeholder';
}

function stripe_api($endpoint, $method = 'GET', $data = []) {
    if (!is_stripe_configured()) {
        return ['error' => 'Stripe not configured'];
    }
    $secret_key = getenv('STRIPE_SECRET_KEY');

    $url = "https://api.stripe.com/v1/{$endpoint}";

    $ch = curl_init();
    $opts = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_USERPWD => "{$secret_key}:",
        CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded']
    ];

    if ($method === 'POST') {
        $opts[CURLOPT_POST] = true;
        $opts[CURLOPT_POSTFIELDS] = http_build_query($data);
    } elseif ($method === 'DELETE') {
        $opts[CURLOPT_CUSTOMREQUEST] = 'DELETE';
    }

    curl_setopt_array($ch, $opts);
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) return ['error' => $error];

    return json_decode($response, true);
}

/**
 * Create a Stripe Checkout Session
 */
function create_checkout_session($params) {
    $site_url = getenv('SITE_URL') ?: 'https://cleaners-247.com';

    $data = [
        'mode' => $params['mode'] ?? 'subscription',
        'success_url' => $params['success_url'] ?? $site_url . '/dashboard/subscription?success=1',
        'cancel_url' => $params['cancel_url'] ?? $site_url . '/dashboard/subscription?cancelled=1',
    ];

    if (!empty($params['customer_email'])) {
        $data['customer_email'] = $params['customer_email'];
    }
    if (!empty($params['customer'])) {
        $data['customer'] = $params['customer'];
    }

    // Line items
    if (!empty($params['price_id'])) {
        $data['line_items[0][price]'] = $params['price_id'];
        $data['line_items[0][quantity]'] = 1;
    } elseif (!empty($params['amount'])) {
        $data['line_items[0][price_data][currency]'] = 'usd';
        $data['line_items[0][price_data][product_data][name]'] = $params['product_name'] ?? 'FindMyCleaner';
        $data['line_items[0][price_data][unit_amount]'] = intval($params['amount'] * 100);
        if (($params['mode'] ?? 'subscription') === 'subscription') {
            $data['line_items[0][price_data][recurring][interval]'] = 'month';
        }
        $data['line_items[0][quantity]'] = 1;
    }

    // Metadata
    if (!empty($params['metadata'])) {
        foreach ($params['metadata'] as $k => $v) {
            $data["metadata[$k]"] = $v;
        }
    }

    return stripe_api('checkout/sessions', 'POST', $data);
}

/**
 * Verify Stripe webhook signature
 */
function verify_webhook_signature($payload, $sig_header) {
    $secret = getenv('STRIPE_WEBHOOK_SECRET');
    if (!$secret) return false;

    $elements = [];
    foreach (explode(',', $sig_header) as $part) {
        list($key, $value) = explode('=', trim($part), 2);
        $elements[$key] = $value;
    }

    if (!isset($elements['t']) || !isset($elements['v1'])) return false;

    $signed_payload = $elements['t'] . '.' . $payload;
    $expected = hash_hmac('sha256', $signed_payload, $secret);

    return hash_equals($expected, $elements['v1']);
}

/**
 * Cancel a Stripe subscription
 */
function cancel_subscription($subscription_id) {
    return stripe_api("subscriptions/{$subscription_id}", 'DELETE');
}

/**
 * Get Stripe customer
 */
function get_stripe_customer($customer_id) {
    return stripe_api("customers/{$customer_id}");
}
