<?php

declare(strict_types=1);

namespace PhpSeries\Fundamentals;

/**
 * Q: How do ?: and ?? differ?
 * A: A full ternary selects a branch by truthiness. A short ternary uses its
 *    fallback for any falsy value. ?? only falls back for null/missing values,
 *    preserving 0, false, '', and '0'. It also avoids an undefined-key warning.
 *    Parenthesize nested full ternaries in PHP 8; prefer if for readability.
 */
function accessLabel(bool $allowed): string
{
    return $allowed ? 'allowed' : 'denied';
}

function fallbackExamples(mixed $value): array
{
    return [
        'short_ternary' => $value ?: 'fallback',
        'null_coalescing' => $value ?? 'fallback',
    ];
}

function pageSize(array $input): int
{
    // Coalescing is a defaulting mechanism, not validation or type conversion.
    $size = $input['size'] ?? 20;
    if (!is_int($size) || $size < 1 || $size > 100) {
        throw new \InvalidArgumentException('size must be an integer from 1 to 100.');
    }

    return $size;
}

if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    echo accessLabel(false), PHP_EOL; // denied
    echo json_encode(fallbackExamples(0), JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR), PHP_EOL;
    // Expected: short_ternary is fallback, null_coalescing is integer 0.
    echo 'default page size: ', pageSize([]), PHP_EOL; // 20
}
