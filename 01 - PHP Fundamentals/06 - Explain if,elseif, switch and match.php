<?php

declare(strict_types=1);

namespace PhpSeries\Fundamentals;

/**
 * Q: When should each branch form be used?
 * A: if/elseif handles ranges and arbitrary conditions. switch loosely
 *    compares cases and can fall through without break/return. match (8.0+)
 *    is an expression with strict matching, no fall-through, and must match
 *    an arm or a default; otherwise it throws UnhandledMatchError.
 */
function balanceLabel(int $cents): string
{
    if ($cents < 0) {
        return 'overdrawn';
    } elseif ($cents === 0) {
        return 'empty';
    } else {
        return 'available';
    }
}

function switchDay(int|string $day): string
{
    switch ($day) {
        case 1:
            return 'Monday'; // return ends the function, so break is unnecessary.
        case 2:
            return 'Tuesday';
        default:
            return 'Other';
    }
}

function matchDay(int|string $day): string
{
    return match ($day) {
        1 => 'Monday',
        2 => 'Tuesday',
        6, 7 => 'Weekend',
        default => 'Other',
    };
}

function binaryFlag(int $flag): string
{
    // Deliberately no default: the test suite verifies the failure for 2.
    return match ($flag) {
        0 => 'off',
        1 => 'on',
    };
}

if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    echo json_encode([
        'if' => balanceLabel(0),
        'switch_string' => switchDay('1'),
        'match_string' => matchDay('1'),
        'match_int' => matchDay(1),
        'grouped_arm' => matchDay(7),
    ], JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR), PHP_EOL;
    // Expected: empty, Monday, Other, Monday, Weekend.
}
