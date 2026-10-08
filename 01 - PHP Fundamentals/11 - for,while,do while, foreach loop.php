<?php

declare(strict_types=1);

namespace PhpSeries\Fundamentals;

/**
 * Q: Which loop runs at least once? What is a foreach reference trap?
 * A: do...while checks after its body. for/while may run zero times.
 *    foreach walks arrays/Traversable values. A reference loop leaves its
 *    value variable referencing the last element, so unset it afterward.
 */
function loopExamples(): array
{
    $for = [];
    for ($i = 0; $i < 3; ++$i) {
        $for[] = $i;
    }

    $while = [];
    $remaining = 2;
    while ($remaining > 0) {
        $while[] = $remaining;
        --$remaining;
    }

    $attempts = 0;
    do {
        ++$attempts;
    } while (false);

    $labels = [];
    foreach (['php' => 8, 'sql' => 1] as $key => $value) {
        $labels[] = $key . ':' . $value;
    }

    $doubled = [1, 2, 3];
    foreach ($doubled as &$value) {
        $value *= 2;
    }
    unset($value); // Detach the alias before $value is reused.
    $value = 999;

    $selected = [];
    for ($i = 0; $i < 10; ++$i) {
        if ($i === 5) {
            break; // End this loop.
        }
        if ($i % 2 === 0) {
            continue; // Skip this iteration.
        }
        $selected[] = $i;
    }

    return compact('for', 'while', 'attempts', 'labels', 'doubled', 'selected');
}

if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    // Expected: [0,1,2], [2,1], 1, [php:8,sql:1], [2,4,6], [1,3].
    echo json_encode(loopExamples(), JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR), PHP_EOL;
}
