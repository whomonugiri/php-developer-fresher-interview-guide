<?php
declare(strict_types=1);
require dirname(__DIR__) . '/config.php';
require dirname(__DIR__) . '/queries.php';
requireCli();
echo json_encode(studentPage(connectPdo(), 1, 2), JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR) . "\n";
