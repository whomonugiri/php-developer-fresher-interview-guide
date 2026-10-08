<?php

declare(strict_types=1);

namespace PhpSeries\Fundamentals;

/**
 * Q: Do local, global, and static variables have the same lifetime?
 * A: An ordinary local binding belongs to a call. global imports a binding
 *    from global scope. A static local retains its value between calls in
 *    the current execution. It is NOT a session or durable shared storage.
 *    Values may outlive a local binding when returned or captured elsewhere.
 *    Long-running workers may retain state longer than a web request.
 */
function localLabel(string $label): string
{
    $local = 'local:' . $label;

    return $local;
}

function readGlobalLabel(): string
{
    global $fundamentalsLabel;

    return $fundamentalsLabel ?? 'unset';
}

function staticCallCount(): int
{
    static $calls = 0;

    return ++$calls;
}

function makeCounter(): \Closure
{
    // Each factory invocation produces a new closure with its own state.
    return static function (): int {
        static $count = 0;

        return ++$count;
    };
}

if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    $fundamentalsLabel = 'global-demo';
    echo localLabel('Ada'), PHP_EOL;
    echo readGlobalLabel(), PHP_EOL;
    echo staticCallCount(), ', ', staticCallCount(), PHP_EOL;
    $first = makeCounter();
    $second = makeCounter();
    echo $first(), ', ', $first(), ', ', $second(), PHP_EOL;
    // Expected lines: local:Ada; global-demo; 1, 2; 1, 2, 1.
    // Prefer passing dependencies as parameters to relying on globals.
}
