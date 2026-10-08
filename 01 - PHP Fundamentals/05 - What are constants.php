<?php

declare(strict_types=1);

namespace PhpSeries\Fundamentals;

/**
 * Q: How do const and define differ?
 * A: Namespace-level const declarations use constant expressions and cannot
 *    sit inside a function/conditional. define() runs at runtime, so it can.
 *    Names are case-sensitive; neither spelling uses $ to access a constant.
 *    Namespace and class constant rules still matter: not every constant is
 *    an unqualified global name, and class constants may have visibility.
 *
 * These values are public lesson settings. Never put real credentials here.
 */
const COURSE_LANGUAGE = 'PHP';
const OUTPUT_FORMATS = ['html', 'json'];

function constantExamples(): array
{
    $runtimeName = __NAMESPACE__ . '\\RUNTIME_LABEL';
    if (!defined($runtimeName)) {
        define($runtimeName, 'runtime-demo');
    }

    return [
        'language' => COURSE_LANGUAGE,
        'formats' => OUTPUT_FORMATS,
        'runtime' => constant($runtimeName),
    ];
}

if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    // Expected: PHP, [html, json], runtime-demo.
    echo json_encode(constantExamples(), JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR), PHP_EOL;
}
