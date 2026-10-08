<?php

declare(strict_types=1);

namespace PhpSeries\Fundamentals;

/**
 * Q: Are echo and print functions? What do they return?
 * A: Both are language constructs. echo can emit comma-separated expressions
 *    and has no return value. print takes one expression and returns int 1.
 *    Neither appends a newline. Choose for readability, not microbenchmarks.
 *
 * $result = echo 'hello'; is a syntax error. Do not uncomment invalid syntax
 * in a runnable lesson; explain it in an interview instead.
 *
 * @return array{output: string, print_return: int}
 */
function outputConstructs(): array
{
    ob_start();
    echo 'Hello', ', ', 'PHP', "\n";
    $result = print "Printed\n";
    $output = ob_get_clean();

    if ($output === false) {
        throw new \RuntimeException('The demonstration output buffer is missing.');
    }

    return ['output' => $output, 'print_return' => $result];
}

if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    // output contains two lines; print_return is the integer 1.
    echo json_encode(outputConstructs(), JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR), PHP_EOL;
}
