<?php
/**
 * Mailgun email sending
 */

function mailgun_send($to, $subject, $html, $reply_to = null, $from_name = null, $from_email = null) {
    $api_key = getenv('MAILGUN_API_KEY');
    $domain = getenv('MAILGUN_DOMAIN') ?: 'cleaners-247.com';
    $from_name = $from_name ?: (getenv('MAILGUN_FROM_NAME') ?: 'FindMyCleaner');
    $from_email = $from_email ?: (getenv('MAILGUN_FROM_EMAIL') ?: 'noreply@cleaners-247.com');

    if (!$api_key || $api_key === 'placeholder') {
        return ['success' => false, 'error' => 'Mailgun API key not configured'];
    }

    $post_data = [
        'from' => "$from_name <$from_email>",
        'to' => $to,
        'subject' => $subject,
        'html' => $html
    ];

    if ($reply_to) {
        $post_data['h:Reply-To'] = $reply_to;
    }

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => "https://api.mailgun.net/v3/{$domain}/messages",
        CURLOPT_USERPWD => "api:{$api_key}",
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $post_data,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_SSL_VERIFYPEER => true
    ]);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        return ['success' => false, 'error' => "cURL error: $error"];
    }

    $data = json_decode($response, true);

    if ($http_code === 200) {
        return ['success' => true, 'id' => $data['id'] ?? null];
    }

    return ['success' => false, 'error' => $data['message'] ?? "HTTP $http_code"];
}

/**
 * Branded email template
 */
function mailgun_template($title, $body_html) {
    $site_name = getenv('SITE_NAME') ?: 'FindMyCleaner';
    $site_url = getenv('SITE_URL') ?: 'https://cleaners-247.com';

    return '<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"></head>
<body style="margin:0;padding:0;background-color:#f5f5f5;font-family:Arial,Helvetica,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f5f5f5;padding:20px 0;">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.1);">

<!-- Header -->
<tr><td style="background-color:#00b894;padding:30px 40px;text-align:center;">
<h1 style="color:#ffffff;margin:0;font-size:24px;">' . htmlspecialchars($site_name) . '</h1>
<p style="color:#bbdefb;margin:5px 0 0;font-size:14px;">Find Trusted Local Cleaners</p>
</td></tr>

<!-- Title -->
<tr><td style="padding:30px 40px 10px;">
<h2 style="color:#009975;margin:0;font-size:20px;">' . $title . '</h2>
</td></tr>

<!-- Body -->
<tr><td style="padding:10px 40px 30px;color:#333333;font-size:15px;line-height:1.6;">
' . $body_html . '
</td></tr>

<!-- Footer -->
<tr><td style="background-color:#f5f5f5;padding:20px 40px;text-align:center;border-top:1px solid #e0e0e0;">
<p style="color:#757575;font-size:12px;margin:0;">
&copy; ' . date('Y') . ' ' . htmlspecialchars($site_name) . '. All rights reserved.<br>
<a href="' . $site_url . '" style="color:#00b894;text-decoration:none;">' . $site_url . '</a>
</p>
</td></tr>

</table>
</td></tr>
</table>
</body>
</html>';
}

/**
 * Send a templated email
 */
function send_email($to, $subject, $title, $body_html, $reply_to = null) {
    $html = mailgun_template($title, $body_html);
    $result = mailgun_send($to, $subject, $html, $reply_to);

    if (!$result['success']) {
        error_log("[Mailgun] Failed to send email to {$to}: " . ($result['error'] ?? 'unknown error'));
    }

    return $result;
}
