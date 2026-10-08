<?php
declare(strict_types=1);
require dirname(__DIR__) . '/queries.php';
require dirname(__DIR__) . '/config.php';
function same(mixed $actual, mixed $expected, string $label): void {
    if ($actual !== $expected) { throw new RuntimeException($label); }
}
same(pagination(1, 10), ['limit' => 10, 'offset' => 0], 'First page');
same(pagination(3, 10), ['limit' => 10, 'offset' => 20], 'Third page');
same(studentOrder('name'), 'name ASC, id ASC', 'Stable name order');
same(studentOrder('newest'), 'created_at DESC, id DESC', 'Stable newest order');
foreach ([[0,10], [1,0], [1,101], [1000001,10]] as [$page,$size]) {
    try { pagination($page,$size); } catch (InvalidArgumentException) { continue; }
    throw new RuntimeException('Invalid pagination accepted');
}
same(literalLike('20%_!'), '%20!%!_!!%', 'Escape LIKE metacharacters');
same(literalLike(''), '%%', 'Empty search matches all');
$oldPassword = getenv('DB_PASSWORD');
$oldName = getenv('DB_NAME');
try {
    putenv('DB_NAME=php_interview_lab');
    putenv('DB_PASSWORD=0');
    same(databaseConfig()['password'], '0', 'Literal zero password is preserved');
    putenv('DB_PASSWORD');
    same(databaseConfig()['password'], '', 'Unset demo password');
} finally {
    putenv($oldPassword === false ? 'DB_PASSWORD' : 'DB_PASSWORD=' . $oldPassword);
    putenv($oldName === false ? 'DB_NAME' : 'DB_NAME=' . $oldName);
}
try { studentOrder('name; DROP TABLE students'); }
catch (InvalidArgumentException) { echo "Part 3 pure-function tests passed (13 checks).\n"; exit(0); }
throw new RuntimeException('Unsafe sort accepted');
