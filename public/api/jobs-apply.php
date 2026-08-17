<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/jobs.php';
require_once __DIR__ . '/../../includes/mailer.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['error' => 'Method not allowed'], 405);
}

// Tighter than the contact form — applications carry file attachments.
rate_limit('jobs_apply', 5, 900); // 5 applications per 15 minutes per IP

$body = json_body();
csrf_verify((string)($body['csrf_token'] ?? ''));

// Honeypot — if filled, silently pretend success.
if (!empty($body['website'])) {
    json_response(['success' => true, 'message' => 'Application received.'], 201);
}

$jobId     = trim((string)($body['job'] ?? ''));
$name      = trim((string)($body['name'] ?? ''));
$email     = trim((string)($body['email'] ?? ''));
$portfolio = trim((string)($body['portfolio'] ?? ''));
$message   = trim((string)($body['message'] ?? ''));

$jobTitle = job_title($jobId);

$errors = [];
if ($jobTitle === null)                                 $errors[] = 'Please choose one of the open roles';
if (mb_strlen($name) < 2)                               $errors[] = 'Name must be at least 2 characters';
if (!filter_var($email, FILTER_VALIDATE_EMAIL))         $errors[] = 'Please enter a valid email address';
if (mb_strlen($message) < 20)                           $errors[] = 'Please tell us a bit more — at least 20 characters';
if ($portfolio !== '' && !filter_var($portfolio, FILTER_VALIDATE_URL)) {
    $errors[] = 'Portfolio must be a valid URL (including https://)';
}

// Reject absurd input outright rather than emailing it on.
if (mb_strlen($name) > 190)      $errors[] = 'Name is too long';
if (mb_strlen($email) > 190)     $errors[] = 'Email is too long';
if (mb_strlen($portfolio) > 500) $errors[] = 'Portfolio URL is too long';
if (mb_strlen($message) > 5000)  $errors[] = 'Message is too long (5000 characters max)';

if ($errors) {
    json_response(['error' => 'Validation failed', 'details' => implode('; ', $errors)], 400);
}

// ── CV attachment (optional) ────────────────────────────────────────────────
const CV_MAX_BYTES = 4 * 1024 * 1024;
const CV_ALLOWED_EXT = ['pdf', 'doc', 'docx'];

$attachments = [];
$cv = $body['cv'] ?? null;

if (is_array($cv) && !empty($cv['data_base64'])) {
    $rawName = (string)($cv['name'] ?? 'cv');
    $b64     = (string)$cv['data_base64'];

    // strict:true so malformed base64 is rejected rather than silently repaired
    $decoded = base64_decode($b64, true);
    if ($decoded === false) {
        json_response(['error' => 'That CV file could not be read. Please try attaching it again.'], 400);
    }
    if (strlen($decoded) > CV_MAX_BYTES) {
        json_response(['error' => 'CV is larger than 4 MB. Please attach a smaller file.'], 400);
    }

    $ext = strtolower(pathinfo($rawName, PATHINFO_EXTENSION));
    if (!in_array($ext, CV_ALLOWED_EXT, true)) {
        json_response(['error' => 'CV must be a PDF, DOC or DOCX file.'], 400);
    }

    // mailer.php drops this straight into `filename="..."` and Content-Type
    // headers without escaping, so anything that could break out of the
    // header — quotes, CR/LF, path separators — has to go here.
    $base = pathinfo($rawName, PATHINFO_FILENAME);
    $base = preg_replace('/[^A-Za-z0-9 ._-]/', '_', $base) ?? 'cv';
    $base = trim(substr($base, 0, 80));
    if ($base === '') $base = 'cv';

    $attachments[] = [
        'name' => $base . '.' . $ext,
        'type' => $ext === 'pdf' ? 'application/pdf' : 'application/octet-stream',
        'data_base64' => base64_encode($decoded),
    ];
}

// ── Notify ──────────────────────────────────────────────────────────────────
$adminEmail = env('ADMIN_EMAIL');
$sent = false;

if ($adminEmail) {
    $html = '<h2>New Job Application — ' . h($jobTitle) . '</h2>'
        . '<table style="border-collapse:collapse;font-family:sans-serif">'
        . '<tr><td style="padding:6px 12px 6px 0"><strong>Role</strong></td><td>' . h($jobTitle) . '</td></tr>'
        . '<tr><td style="padding:6px 12px 6px 0"><strong>Name</strong></td><td>' . h($name) . '</td></tr>'
        . '<tr><td style="padding:6px 12px 6px 0"><strong>Email</strong></td><td>' . h($email) . '</td></tr>'
        . '<tr><td style="padding:6px 12px 6px 0"><strong>Portfolio</strong></td><td>' . h($portfolio ?: 'N/A') . '</td></tr>'
        . '<tr><td style="padding:6px 12px 6px 0"><strong>CV</strong></td><td>' . ($attachments ? h($attachments[0]['name']) . ' (attached)' : 'Not attached') . '</td></tr>'
        . '</table>'
        . '<p style="font-family:sans-serif"><strong>Why them:</strong></p>'
        . '<p style="font-family:sans-serif">' . nl2br(h($message)) . '</p>';

    $sent = send_mail($adminEmail, "Application: $jobTitle — $name", $html, $attachments);
}

// There's no database in this version, so a failed send means the application
// is gone. Log loudly rather than telling the applicant to retry into a void.
if ($adminEmail && !$sent) {
    error_log("[jobs] Application email FAILED for $email ($jobTitle) — check SMTP settings in .env");
}

json_response([
    'success' => true,
    'message' => 'Application received.',
], 201);
