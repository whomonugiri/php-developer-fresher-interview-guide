<?php
declare(strict_types=1);

// Shared setup for this LOCAL teaching demo. Do not use the sample account in production.
const DEMO_IDLE_SECONDS = 900;
const DEMO_MAX_SECONDS = 28800;

function demo_https(): bool
{
    // If deployed behind a proxy, configure HTTPS detection at the trusted proxy/server.
    return ($_SERVER['HTTPS'] ?? '') === 'on' || ($_SERVER['SERVER_PORT'] ?? '') === '443';
}

function demo_cookie_path(): string
{
    $path = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/demo/index.php'));
    // SCRIPT_NAME is decoded, but browsers match the URL-encoded request path.
    return implode('/', array_map('rawurlencode', explode('/', $path)));
}

function demo_escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function demo_csrf_token(): string
{
    if (!isset($_SESSION['csrf']) || !is_string($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function demo_require_post_and_csrf(): void
{
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        http_response_code(405);
        header('Allow: POST');
        exit('POST required.');
    }

    $submitted = $_POST['csrf'] ?? null;
    $expected = $_SESSION['csrf'] ?? null;
    if (!is_string($submitted) || !is_string($expected) || !hash_equals($expected, $submitted)) {
        http_response_code(403);
        exit('Invalid CSRF token.');
    }
}

function demo_require_auth(): void
{
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] !== 1) {
        header('Location: login.php', true, 302);
        exit;
    }
}

function demo_expire_session_cookie(): void
{
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', [
            'expires' => time() - 3600,
            'path' => $params['path'],
            'domain' => $params['domain'],
            'secure' => $params['secure'],
            'httponly' => $params['httponly'],
            'samesite' => $params['samesite'] ?? 'Lax',
        ]);
    }
}

// Header values match the plain, script-free HTML in these pages.
header('Content-Type: text/html; charset=UTF-8');
header('Cache-Control: no-store');
header("Content-Security-Policy: default-src 'none'; form-action 'self'; base-uri 'none'; frame-ancestors 'none'");
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Referrer-Policy: no-referrer');
if (demo_https()) {
    header('Strict-Transport-Security: max-age=31536000');
}

ini_set('session.use_strict_mode', '1');
ini_set('session.use_only_cookies', '1');
session_name('dev_ninja_demo');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => demo_cookie_path(),
    'secure' => demo_https(),
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_start();

$now = time();
$created = $_SESSION['created_at'] ?? null;
$lastSeen = $_SESSION['last_seen_at'] ?? null;
if ((is_int($created) && $now - $created > DEMO_MAX_SECONDS)
    || (is_int($lastSeen) && $now - $lastSeen > DEMO_IDLE_SECONDS)) {
    $_SESSION = [];
    if (!session_regenerate_id(true)) {
        throw new RuntimeException('Could not renew expired session.');
    }
}
$_SESSION['created_at'] ??= $now;
$_SESSION['last_seen_at'] = $now;
