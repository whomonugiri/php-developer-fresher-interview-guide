<?php
declare(strict_types=1);
require_once __DIR__ . '/validation.php';

/** These exercises deliberately refuse public/remote serving and a wrong web root. */
function enforceLocalServer(): void
{
    $expectedRoot = realpath(__DIR__ . '/../public');
    $actualRoot = realpath($_SERVER['DOCUMENT_ROOT'] ?? '');
    $remote = $_SERVER['REMOTE_ADDR'] ?? '';
    $host = $_SERVER['HTTP_HOST'] ?? '';
    if ($actualRoot !== $expectedRoot || !in_array($remote, ['127.0.0.1', '::1'], true)
        || preg_match('/\A(?:localhost|127\.0\.0\.1|\[::1\])(?::[0-9]+)?\z/i', $host) !== 1) {
        http_response_code(403);
        header('Content-Type: text/plain; charset=UTF-8');
        exit("Local teaching server only. Follow the README and use public/ as the document root.\n");
    }
}

function webStart(array $allowedMethods = ['GET', 'POST']): string
{
    if (PHP_SAPI === 'cli') {
        exit("This is a browser exercise. Start the localhost server using README.md.\n");
    }
    enforceLocalServer();
    header('Content-Type: text/html; charset=UTF-8');
    header('X-Content-Type-Options: nosniff');
    header("Content-Security-Policy: default-src 'none'; style-src 'unsafe-inline'; form-action 'self'; frame-ancestors 'none'; base-uri 'none'");
    header('Referrer-Policy: no-referrer');
    header('Cache-Control: no-store');
    $method = $_SERVER['REQUEST_METHOD'] ?? '';
    if (!in_array($method, $allowedMethods, true)) {
        header('Allow: ' . implode(', ', $allowedMethods));
        http_response_code(405);
        exit('This request method is not allowed.');
    }
    if ((int) ($_SERVER['CONTENT_LENGTH'] ?? 0) > 3 * 1024 * 1024) {
        http_response_code(413);
        exit('Request body exceeds the 3 MiB teaching limit.');
    }
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_name('part2_demo');
        $started = session_start(['use_strict_mode' => 1, 'use_only_cookies' => 1,
            'cookie_httponly' => true, 'cookie_samesite' => 'Strict',
            // false is needed for the documented HTTP localhost demo. Use HTTPS in production.
            'cookie_secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off']);
        if (!$started) {
            http_response_code(503);
            exit('Session storage is unavailable. Configure a writable session save path.');
        }
    }
    if (!isset($_SESSION['csrf']) || !is_string($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    if ($method === 'POST' && !validCsrf($_POST['csrf'] ?? null, $_SESSION['csrf'])) {
        http_response_code(403);
        exit('Invalid or missing CSRF token. Reload the form and try again.');
    }
    return $method;
}

function csrfField(): void
{
    echo '<input type="hidden" name="csrf" value="' . escapeHtml($_SESSION['csrf']) . '">';
}

function pageStart(string $title, string $description): void
{
    echo '<!doctype html><html lang="en"><head><meta charset="utf-8">'
        . '<meta name="viewport" content="width=device-width,initial-scale=1"><title>'
        . escapeHtml($title) . '</title><style>body{max-width:800px;margin:2rem auto;padding:0 1rem;font:18px/1.6 system-ui}input,select,button{font:inherit}label{display:block;margin:1rem 0}input,select{max-width:100%}.error{color:#9b1c1c}</style>'
        . '</head><body><nav><a href="/">All questions</a></nav><h1>' . escapeHtml($title) . '</h1><p>'
        . escapeHtml($description) . '</p>';
}

function pageEnd(): void
{
    echo '<p><small>Local teaching example. Use fictional data. No messages are sent.</small></p></body></html>';
}

function showErrors(array $errors): void
{
    if ($errors !== []) {
        echo '<ul class="error">';
        foreach ($errors as $error) {
            echo '<li>' . escapeHtml($error) . '</li>';
        }
        echo '</ul>';
    }
}

function nameForm(string $action, string $name = ''): void
{
    echo '<form method="post" action="' . escapeHtml($action) . '">';
    csrfField();
    echo '<label for="student-name">Student name</label><input id="student-name" name="student_name" value="'
        . escapeHtml($name) . '" required><button>Submit</button></form>';
}
