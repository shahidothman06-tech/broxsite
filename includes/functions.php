<?php
declare(strict_types=1);

function h(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function json_response(array $data, int $status = 200): never
{
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function json_body(): array
{
    $raw = file_get_contents('php://input');
    if ($raw === '' || $raw === false) return [];
    $decoded = json_decode($raw, true);
    return is_array($decoded) ? $decoded : [];
}

// ── CSRF ─────────────────────────────────────────────────────────────────────

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . h(csrf_token()) . '">';
}

function csrf_verify(string $token): void
{
    $expected = $_SESSION['csrf_token'] ?? '';
    if ($expected === '' || !hash_equals($expected, $token)) {
        json_response(['error' => 'Invalid or expired form session. Please refresh and try again.'], 403);
    }
}

// ── Rate limiting — file-based, no database required ────────────────────────
// One small JSON file per (bucket, IP), guarded with flock so concurrent
// requests can't race each other. Good enough for a low-traffic contact form
// on a single server; if you outgrow this, the DB-backed version in the
// full project (rate_limits table) is a drop-in upgrade.

function client_ip(): string
{
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

function rate_limit(string $bucket, int $maxAttempts, int $windowSeconds, ?string $identifier = null): void
{
    $identifier ??= client_ip();
    $dir = ROOT_PATH . '/storage/ratelimits';
    if (!is_dir($dir)) mkdir($dir, 0700, true);

    $safeKey = preg_replace('/[^a-zA-Z0-9_.-]/', '_', $bucket . '_' . $identifier);
    $path = $dir . '/' . $safeKey . '.json';

    $fh = fopen($path, 'c+');
    if (!$fh) return; // fail open rather than break the site over a filesystem hiccup
    flock($fh, LOCK_EX);

    $raw = stream_get_contents($fh);
    $data = $raw ? json_decode($raw, true) : null;
    $now = time();

    if (!is_array($data) || $now - ($data['start'] ?? 0) > $windowSeconds) {
        $data = ['start' => $now, 'count' => 0];
    }

    if ($data['count'] >= $maxAttempts) {
        flock($fh, LOCK_UN);
        fclose($fh);
        json_response(['error' => 'Too many requests. Please try again later.'], 429);
    }

    $data['count']++;
    ftruncate($fh, 0);
    rewind($fh);
    fwrite($fh, json_encode($data));
    flock($fh, LOCK_UN);
    fclose($fh);
}
