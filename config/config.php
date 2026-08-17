<?php
/**
 * Simple BROX Tech site — no database. The contact form emails you directly
 * instead of storing leads anywhere. Every page requires this file first.
 */

declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/../storage/logs/php-error.log');

define('ROOT_PATH', dirname(__DIR__));

if (!is_dir(ROOT_PATH . '/storage/logs')) {
    mkdir(ROOT_PATH . '/storage/logs', 0700, true);
}

// ── Load .env ────────────────────────────────────────────────────────────────
function load_env(string $path): void
{
    if (!is_file($path)) return;
    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) continue;
        [$key, $value] = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        if (strlen($value) >= 2 && (
            ($value[0] === '"' && $value[-1] === '"') ||
            ($value[0] === "'" && $value[-1] === "'")
        )) {
            $value = substr($value, 1, -1);
        }
        if ($key !== '' && getenv($key) === false) {
            putenv("$key=$value");
            $_ENV[$key] = $value;
        }
    }
}

load_env(ROOT_PATH . '/.env');

function env(string $key, ?string $default = null): ?string
{
    $value = getenv($key);
    return $value === false || $value === '' ? $default : $value;
}

define('APP_ENV', env('APP_ENV', 'production'));
define('IS_PROD', APP_ENV === 'production');

// ── Sessions (used only for the CSRF token — no accounts, no database) ──────
$sessionPath = ROOT_PATH . '/storage/sessions';
if (!is_dir($sessionPath)) mkdir($sessionPath, 0700, true);
session_save_path($sessionPath);
session_name('brox_sess');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => IS_PROD,
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_start();

require_once ROOT_PATH . '/includes/functions.php';
