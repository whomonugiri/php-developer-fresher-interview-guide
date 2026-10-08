<?php

declare(strict_types=1);

namespace PhpSeries\Fundamentals;

/**
 * Q: What is a variable variable? Why usually use an array instead?
 * A: $key holds a name; $$key accesses the variable bearing that name.
 *    It obscures dependencies and can overwrite local bindings when names
 *    come from untrusted input. An array gives the data an explicit container.
 *    No eval() is needed or appropriate for this feature.
 */
function variableVariableExample(): array
{
    $key = 'planet';
    $$key = 'Earth'; // Equivalent to $planet = 'Earth' for this fixed key.

    $values = [];
    $values[$key] = 'Earth';

    return [
        'dynamic_variable' => $planet,
        'explicit_array' => $values['planet'],
    ];
}

function allowedSetting(array $settings, string $key): string
{
    if (!in_array($key, ['theme', 'language'], true)) {
        throw new \InvalidArgumentException('Unsupported setting key.');
    }
    $value = $settings[$key] ?? 'default';
    if (!is_string($value)) {
        throw new \InvalidArgumentException('Setting values must be strings.');
    }

    return $value;
}

if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    echo json_encode(variableVariableExample(), JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR), PHP_EOL;
    echo allowedSetting(['theme' => 'dark'], 'theme'), PHP_EOL;
    // Expected: both planet values are Earth; the setting is dark.
}
