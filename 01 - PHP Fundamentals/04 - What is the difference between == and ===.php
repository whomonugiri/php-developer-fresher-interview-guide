<?php

declare(strict_types=1);

namespace PhpSeries\Fundamentals;

/**
 * Q: Why prefer === for application decisions?
 * A: It compares type and value without loose-comparison conversions.
 *    Numeric strings still compare numerically with == in PHP 8.
 *    PHP 8 changed number/non-numeric-string comparisons: 0 == 'text' is false.
 *    strict_types does NOT change ==, truthiness, or the type of input data.
 */
function comparisonExamples(): array
{
    return [
        '10 == "10"' => 10 == '10',
        '10 === "10"' => 10 === '10',
        '0 == "text"' => 0 == 'text',
        '0 == "0"' => 0 == '0',
        '0 == false' => 0 == false,
        '0 === false' => 0 === false,
        // A match at offset 0 must not be confused with the false sentinel.
        'found_at_zero' => strpos('php', 'p') !== false,
        'missing' => strpos('php', 'z') !== false,
    ];
}

if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    // Expected booleans: true, false, false, true, true, false, true, false.
    echo json_encode(comparisonExamples(), JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR), PHP_EOL;
}
