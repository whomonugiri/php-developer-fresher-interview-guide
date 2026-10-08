<?php

declare(strict_types=1);

namespace PhpSeries\Fundamentals;

/**
 * Q: Which strings interpolate variables and interpret escape sequences?
 * A: Double quotes support interpolation and escapes such as \n and \t.
 *    Single quotes only specially escape a quote and backslash: \' and \\.
 *    Quoting is not HTML escaping, SQL parameterization, or validation.
 */
function stringExamples(string $name): array
{
    return [
        'single' => 'Hello, $name\n',
        'double' => "Hello, {$name}\n",
        'apostrophe' => 'It\'s PHP',
        'backslash' => 'C:\\lessons',
        'literal_dollar' => "Price: \$5",
        'concatenation' => 'Hello, ' . $name,
    ];
}

if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    // JSON visibly distinguishes a literal backslash-n from a newline.
    echo json_encode(stringExamples('Ada'), JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR), PHP_EOL;
}
