<?php
declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use DevNinja\Part6\BookController;
use DevNinja\Part6\BookRepository;
use DevNinja\Part6\BookService;

$controller = new BookController(new BookService(new BookRepository()));

function check(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

$all = $controller->index('');
check($all->status === 200 && count(json_decode($all->body, true, 512, JSON_THROW_ON_ERROR)['books']) === 3, 'List');
$found = $controller->index('secure');
check(count(json_decode($found->body, true, 512, JSON_THROW_ON_ERROR)['books']) === 1, 'Search');
check($controller->index(['unexpected'])->status === 400, 'Array input rejected');
check($controller->index(str_repeat('a', 51))->status === 400, 'Long input rejected');
check($controller->show(2)->status === 200, 'Known book');
check($controller->show(99)->status === 404, 'Missing book');
echo "Part 6 service/controller checks passed.\n";
