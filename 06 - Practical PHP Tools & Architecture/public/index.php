<?php
declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use DevNinja\Part6\BookController;
use DevNinja\Part6\BookRepository;
use DevNinja\Part6\BookService;
use DevNinja\Part6\Response;

// A dependency-free front controller. The route query avoids web-server rewrite
// configuration, so the same URL works under XAMPP Apache and php -S.
$controller = new BookController(new BookService(new BookRepository()));
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$route = $_GET['route'] ?? '/';
if ($method !== 'GET') {
    header('Allow: GET');
    $response = new Response(405, 'text/plain; charset=UTF-8', 'GET required.');
} elseif (!is_string($route)) {
    $response = new Response(400, 'text/plain; charset=UTF-8', 'Invalid route.');
} elseif ($route === '/') {
    $response = new Response(200, 'text/html; charset=UTF-8',
        '<!doctype html><html lang="en"><meta charset="utf-8"><title>Part 6 API</title>'
        . '<h1>Book API demo</h1><p><a href="?route=/api/books">All books</a> '
        . '<a href="?route=/api/books/2">Book 2</a></p></html>');
    header("Content-Security-Policy: default-src 'none'; base-uri 'none'");
} elseif ($route === '/api/books') {
    $response = $controller->index($_GET['q'] ?? '');
} elseif (preg_match('#^/api/books/([1-9][0-9]*)$#D', $route, $match)) {
    $response = $controller->show((int) $match[1]);
} else {
    $response = new Response(404, 'text/plain; charset=UTF-8', 'Route not found.');
}
$response->send();
