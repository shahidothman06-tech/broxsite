<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/mailer.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['error' => 'Method not allowed'], 405);
}

rate_limit('contact', 10, 600); // 10 submissions per 10 minutes per IP

$body = json_body();
csrf_verify((string)($body['csrf_token'] ?? ''));

// Honeypot — if filled, silently pretend success.
if (!empty($body['website'])) {
    json_response(['success' => true, 'message' => "Thank you for your inquiry. We'll get back to you within 24 hours."], 201);
}

$name = trim((string)($body['name'] ?? ''));
$email = trim((string)($body['email'] ?? ''));
$company = trim((string)($body['company'] ?? ''));
$message = trim((string)($body['message'] ?? ''));
$service = is_array($body['service'] ?? null) ? array_values(array_filter(array_map('strval', $body['service']))) : [];

$errors = [];
if (mb_strlen($name) < 2) $errors[] = 'Name must be at least 2 characters';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Please enter a valid email address';
if (count($service) < 1) $errors[] = 'Please select at least one service';

if ($errors) {
    json_response(['error' => 'Validation failed', 'details' => implode('; ', $errors)], 400);
}

$adminEmail = env('ADMIN_EMAIL');
$sent = false;
if ($adminEmail) {
    $html = '<h2>New Contact Inquiry</h2>'
        . '<p><strong>Name:</strong> ' . h($name) . '</p>'
        . '<p><strong>Email:</strong> ' . h($email) . '</p>'
        . '<p><strong>Company:</strong> ' . h($company ?: 'N/A') . '</p>'
        . '<p><strong>Services:</strong> ' . h(implode(', ', $service)) . '</p>'
        . '<p><strong>Message:</strong> ' . nl2br(h($message ?: 'N/A')) . '</p>';
    $sent = send_mail($adminEmail, "New Inquiry: $name", $html);
}

// Always tell the visitor it worked — email delivery failures are logged
// server-side (see storage/logs/php-error.log) rather than surfaced to them,
// since there's nowhere else the submission is stored to recover from.
if ($adminEmail && !$sent) {
    error_log("[contact] Email send failed for inquiry from $email — check SMTP settings in .env");
}

json_response([
    'success' => true,
    'message' => "Thank you for your inquiry. We'll get back to you within 24 hours.",
], 201);
