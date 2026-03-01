<?php
/**
 * Stripe Checkout Session creator
 * Used for subscription upgrades and sponsored listing purchases
 */
require_once dirname(__DIR__) . '/includes/inc_db.php';
require_once dirname(__DIR__) . '/includes/inc_auth.php';
require_once dirname(__DIR__) . '/includes/inc_helpers.php';
require_once dirname(__DIR__) . '/includes/inc_stripe.php';

require_auth();

$user = current_user();
$cleaner = current_cleaner();

$type = $_GET['type'] ?? $_POST['type'] ?? 'subscription';
$plan = $_GET['plan'] ?? $_POST['plan'] ?? '';

header('Content-Type: application/json');

$site_url = getenv('SITE_URL') ?: 'https://cleaners-247.com';

// ========== SUBSCRIPTION ==========
if ($type === 'subscription' && $cleaner) {
    $plan_prices = [
        'basic' => 2900,   // $29.00
        'pro' => 7900,     // $79.00
        'premium' => 14900  // $149.00
    ];

    if (!isset($plan_prices[$plan])) {
        json_response(['success' => false, 'error' => 'Invalid plan.'], 400);
    }

    $session = create_checkout_session([
        'mode' => 'subscription',
        'customer_email' => $user['email'],
        'amount' => $plan_prices[$plan] / 100,
        'product_name' => 'FindMyCleaner ' . ucfirst($plan) . ' Plan',
        'success_url' => $site_url . '/dashboard/subscription?success=1&plan=' . $plan,
        'cancel_url' => $site_url . '/dashboard/subscription?cancelled=1',
        'metadata' => [
            'type' => 'subscription',
            'plan' => $plan,
            'cleaner_id' => $cleaner['id'],
            'user_id' => $user['id']
        ]
    ]);

    if (isset($session['error'])) {
        json_response(['success' => false, 'error' => $session['error']]);
    }

    if (!empty($session['url'])) {
        json_response(['success' => true, 'url' => $session['url']]);
    }

    json_response(['success' => false, 'error' => 'Could not create checkout session.']);
}

// ========== SPONSORED LISTING ==========
if ($type === 'sponsored' && $cleaner) {
    $category_id = intval($_GET['category_id'] ?? $_POST['category_id'] ?? 0);
    $duration = $_GET['duration'] ?? $_POST['duration'] ?? 'monthly';

    $prices = ['weekly' => 4900, 'monthly' => 14900]; // cents
    if (!isset($prices[$duration])) {
        json_response(['success' => false, 'error' => 'Invalid duration.'], 400);
    }

    $session = create_checkout_session([
        'mode' => 'payment',
        'customer_email' => $user['email'],
        'amount' => $prices[$duration] / 100,
        'product_name' => 'Sponsored Listing - ' . ucfirst($duration),
        'success_url' => $site_url . '/dashboard/sponsored?success=1',
        'cancel_url' => $site_url . '/dashboard/sponsored?cancelled=1',
        'metadata' => [
            'type' => 'sponsored',
            'duration' => $duration,
            'category_id' => $category_id,
            'cleaner_id' => $cleaner['id'],
            'user_id' => $user['id']
        ]
    ]);

    if (!empty($session['url'])) {
        json_response(['success' => true, 'url' => $session['url']]);
    }

    json_response(['success' => false, 'error' => $session['error'] ?? 'Could not create checkout session.']);
}

json_response(['success' => false, 'error' => 'Invalid request.'], 400);
