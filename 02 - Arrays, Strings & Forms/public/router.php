<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/lib/web.php';
enforceLocalServer();
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$root = dirname(__DIR__);
if ($path === '/' || $path === '/index.php' || $path === '/index.html') {
    require __DIR__ . '/index.php';
    return;
}
if (is_string($path) && preg_match('~\A/Question_([1-9]|1[0-9]|2[0-8])\.php\z~', $path, $match) === 1) {
    require $root . '/Question_' . $match[1] . '.php';
    return;
}
$routes = [
    '/support/question_19/form.html' => '/support/question_19/form.html',
    '/support/question_19/form.php' => '/support/question_19/form.php',
    '/support/question_19/process.php' => '/support/question_19/process.php',
    '/support/question_27/prg.php' => '/support/question_27/prg.php',
    '/support/question_27/thank-you.php' => '/support/question_27/thank-you.php',
];
if (is_string($path) && isset($routes[$path])) {
    if (str_ends_with($path, '.html')) {
        header('Content-Type: text/html; charset=UTF-8');
        readfile($root . $routes[$path]);
    } else {
        require $root . $routes[$path];
    }
    return;
}
http_response_code(404);
header('Content-Type: text/plain; charset=UTF-8');
echo "Not found. Only the documented lesson routes are available.\n";
// Never return false: the teaching router never serves arbitrary files.
