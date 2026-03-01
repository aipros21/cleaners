<?php
/**
 * Stripe Webhook handler
 * Processes subscription and payment events
 */
require_once dirname(__DIR__) . '/includes/inc_db.php';
require_once dirname(__DIR__) . '/includes/inc_helpers.php';
require_once dirname(__DIR__) . '/includes/inc_stripe.php';
require_once dirname(__DIR__) . '/includes/inc_mailgun.php';

// Read raw payload
$payload = file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';

if (!verify_webhook_signature($payload, $sig_header)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid signature']);
    exit;
}

$event = json_decode($payload, true);
$type = $event['type'] ?? '';
$data = $event['data']['object'] ?? [];

$db = get_db();

switch ($type) {
    // ========== Checkout completed ==========
    case 'checkout.session.completed':
        $metadata = $data['metadata'] ?? [];
        $cleaner_id = $metadata['cleaner_id'] ?? null;
        $user_id = $metadata['user_id'] ?? null;

        if ($metadata['type'] === 'subscription' && $cleaner_id) {
            $plan = $metadata['plan'] ?? 'basic';
            $subscription_id = $data['subscription'] ?? null;
            $customer_id = $data['customer'] ?? null;

            // Update cleaner plan
            $stmt = $db->prepare("UPDATE cleaners SET plan = ?, stripe_customer_id = ?, stripe_subscription_id = ?, plan_expires = DATE_ADD(NOW(), INTERVAL 1 MONTH) WHERE id = ?");
            $stmt->execute([$plan, $customer_id, $subscription_id, $cleaner_id]);

            // Record payment
            $amount = ($data['amount_total'] ?? 0) / 100;
            $stmt = $db->prepare("INSERT INTO payments (user_id, cleaner_id, type, amount, stripe_payment_id, description, status, created_at) VALUES (?, ?, 'subscription', ?, ?, ?, 'completed', NOW())");
            $stmt->execute([$user_id, $cleaner_id, $amount, $data['payment_intent'] ?? '', ucfirst($plan) . ' Plan Subscription']);

            log_activity('subscription_created', 'cleaner', $cleaner_id, "Plan: {$plan}");
        }

        if ($metadata['type'] === 'sponsored' && $cleaner_id) {
            $duration = $metadata['duration'] ?? 'monthly';
            $category_id = $metadata['category_id'] ?? null;
            $days = $duration === 'weekly' ? 7 : 30;

            $stmt = $db->prepare("INSERT INTO sponsored_listings (cleaner_id, category_id, start_date, end_date, price_paid, is_active, created_at) VALUES (?, ?, CURDATE(), DATE_ADD(CURDATE(), INTERVAL ? DAY), ?, 1, NOW())");
            $amount = ($data['amount_total'] ?? 0) / 100;
            $stmt->execute([$cleaner_id, $category_id ?: null, $days, $amount]);

            // Record payment
            $stmt = $db->prepare("INSERT INTO payments (user_id, cleaner_id, type, amount, stripe_payment_id, description, status, created_at) VALUES (?, ?, 'sponsored', ?, ?, ?, 'completed', NOW())");
            $stmt->execute([$user_id, $cleaner_id, $amount, $data['payment_intent'] ?? '', "Sponsored Listing - {$duration}"]);

            log_activity('sponsored_created', 'cleaner', $cleaner_id, "Duration: {$duration}");
        }
        break;

    // ========== Subscription renewed ==========
    case 'invoice.payment_succeeded':
        $subscription_id = $data['subscription'] ?? '';
        if ($subscription_id) {
            $stmt = $db->prepare("UPDATE cleaners SET plan_expires = DATE_ADD(NOW(), INTERVAL 1 MONTH) WHERE stripe_subscription_id = ?");
            $stmt->execute([$subscription_id]);

            $amount = ($data['amount_paid'] ?? 0) / 100;
            $stmt = $db->prepare("SELECT id, user_id FROM cleaners WHERE stripe_subscription_id = ?");
            $stmt->execute([$subscription_id]);
            $c = $stmt->fetch();
            if ($c) {
                $db->prepare("INSERT INTO payments (user_id, cleaner_id, type, amount, stripe_invoice_id, description, status, created_at) VALUES (?, ?, 'subscription', ?, ?, 'Subscription Renewal', 'completed', NOW())")
                    ->execute([$c['user_id'], $c['id'], $amount, $data['id'] ?? '']);
            }
        }
        break;

    // ========== Subscription cancelled ==========
    case 'customer.subscription.deleted':
        $subscription_id = $data['id'] ?? '';
        if ($subscription_id) {
            $stmt = $db->prepare("UPDATE cleaners SET plan = 'free', stripe_subscription_id = NULL, plan_expires = NULL WHERE stripe_subscription_id = ?");
            $stmt->execute([$subscription_id]);

            log_activity('subscription_cancelled', 'cleaner', null, "Subscription: {$subscription_id}");
        }
        break;

    // ========== Payment failed ==========
    case 'invoice.payment_failed':
        $subscription_id = $data['subscription'] ?? '';
        if ($subscription_id) {
            $stmt = $db->prepare("SELECT c.id, u.email FROM cleaners c JOIN users u ON c.user_id = u.id WHERE c.stripe_subscription_id = ?");
            $stmt->execute([$subscription_id]);
            $c = $stmt->fetch();
            if ($c) {
                send_email($c['email'], 'Payment Failed - FindMyCleaner', 'Payment Issue',
                    '<p>Your subscription payment has failed. Please update your payment method to avoid service interruption.</p>
                    <p style="text-align:center;"><a href="' . (getenv('SITE_URL') ?: '') . '/dashboard/subscription" style="background-color:#00b894;color:#fff;padding:12px 30px;text-decoration:none;border-radius:5px;display:inline-block;">Update Payment</a></p>');
            }
        }
        break;
}

http_response_code(200);
echo json_encode(['received' => true]);
