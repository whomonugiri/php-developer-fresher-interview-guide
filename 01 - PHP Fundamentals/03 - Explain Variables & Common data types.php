<?php

declare(strict_types=1);

namespace PhpSeries\Fundamentals;

/**
 * Q: Is a variable's type fixed by its first assignment?
 * A: No. PHP is dynamically typed; a variable can hold a different type later.
 *    Type declarations add checks at function/property boundaries.
 *    $name and $NAME are distinct. For portable identifiers use letters,
 *    digits and underscores, starting with a letter or underscore after $.
 *
 * Resources are handles such as streams, not ordinary strings or objects.
 * Some APIs now return objects instead of resources; inspect their contracts.
 */
function variableExamples(): array
{
    $value = '42';
    $before = get_debug_type($value);
    $value = 42;
    $after = get_debug_type($value);

    $name = 'Ada';
    $NAME = 'Lin';
    $samples = [42, 3.5, true, 'PHP', [1, 2], new \stdClass(), null];
    $types = array_map(static fn (mixed $sample): string => get_debug_type($sample), $samples);

    $stream = fopen('php://memory', 'r+');
    if ($stream === false) {
        throw new \RuntimeException('Unable to create the in-memory stream.');
    }

    try {
        $resourceType = gettype($stream);
    } finally {
        fclose($stream);
    }

    return [
        'reassignment' => [$before, $after],
        'case_sensitive_names' => [$name, $NAME],
        'types' => $types,
        'stream_type' => $resourceType,
    ];
}

if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    // Reassignment: string -> int. The stream is closed before returning.
    echo json_encode(variableExamples(), JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR), PHP_EOL;
}
