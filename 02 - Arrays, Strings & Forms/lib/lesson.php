<?php
declare(strict_types=1);

/** Render deterministic examples in CLI or as JSON over localhost HTTP. */
function example(array $data): array
{
    if (!defined('PART2_TESTING')) {
        if (PHP_SAPI !== 'cli') {
            header('Content-Type: application/json; charset=UTF-8');
            header('X-Content-Type-Options: nosniff');
        }
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR) . PHP_EOL;
    }
    return $data;
}
