<?php

declare(strict_types=1);

namespace PhpSeries\Fundamentals;

/**
 * Q: What is a parameter, an argument, and a return value?
 * A: A parameter is a declared input; an argument is the value passed in;
 *    return sends a result to the caller without necessarily printing it.
 *    Optional parameters should follow required ones.
 *
 * For scalar arguments, strict_types is selected by the CALLING file.
 * It rejects coercion such as '2' to int for these direct calls. An int may
 * still satisfy a float declaration. It is not input validation.
 */
function addIntegers(int $left, int $right = 0): int
{
    return $left + $right;
}

function optionalGreeting(?string $name = null): string
{
    // Nullable and optional are different: = null makes omission legal here.
    return 'Hello, ' . ($name ?? 'guest');
}

function sumIntegers(int ...$values): int
{
    return array_sum($values);
}

if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    echo 'default: ', addIntegers(5), PHP_EOL;
    echo 'named: ', addIntegers(right: 3, left: 2), PHP_EOL;
    echo 'variadic: ', sumIntegers(1, 2, 3), PHP_EOL;
    echo optionalGreeting(), PHP_EOL;

    try {
        addIntegers('2', 3);
    } catch (\TypeError $error) {
        // Show the failure without making this example crash.
        echo 'Caught TypeError for a string argument', PHP_EOL;
    }
    // Expected lines: default: 5; named: 5; variadic: 6; Hello, guest;
    // Caught TypeError for a string argument.
}
