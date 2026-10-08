<?php

declare(strict_types=1);

namespace PhpSeries\Fundamentals\Tests;

use function PhpSeries\Fundamentals\{
    accessLabel,
    addIntegers,
    allowedSetting,
    balanceLabel,
    binaryFlag,
    comparisonExamples,
    constantExamples,
    fallbackExamples,
    greetingHtml,
    localLabel,
    loopExamples,
    makeCounter,
    matchDay,
    optionalGreeting,
    outputConstructs,
    pageSize,
    readGlobalLabel,
    staticCallCount,
    stringExamples,
    sumIntegers,
    switchDay,
    variableExamples,
    variableVariableExample
};

if (PHP_VERSION_ID < 80100) {
    fwrite(STDERR, "PHP 8.1 or newer is required.\n");
    exit(1);
}

error_reporting(E_ALL);
set_error_handler(static function (int $severity, string $message, string $file, int $line): bool {
    if ((error_reporting() & $severity) === 0) {
        return false;
    }
    throw new \ErrorException($message, 0, $severity, $file, $line);
});

/** Assertions are always enabled, independent of zend.assertions / assert.active. */
function same(mixed $expected, mixed $actual): void
{
    if ($expected !== $actual) {
        throw new \RuntimeException(
            'Expected ' . var_export($expected, true) . '; got ' . var_export($actual, true)
        );
    }
}

function throws(callable $operation, string $expectedClass): void
{
    try {
        $operation();
    } catch (\Throwable $error) {
        if ($error instanceof $expectedClass) {
            return;
        }
        throw new \RuntimeException(
            'Expected ' . $expectedClass . '; got ' . get_class($error),
            0,
            $error
        );
    }
    throw new \RuntimeException('Expected ' . $expectedClass . '; nothing was thrown.');
}

$lessons = glob(dirname(__DIR__) . '/*.php');
if ($lessons === false || count($lessons) !== 12) {
    throw new \RuntimeException('Expected the 12 original numbered lesson files.');
}
sort($lessons);
ob_start();
foreach ($lessons as $lesson) {
    require_once $lesson;
}
$includeOutput = ob_get_clean();
require_once __DIR__ . '/fixtures/weak_caller.php';

$tests = [
    '01: including lessons does not print demonstrations' => static fn () => same('', $includeOutput),
    '01: HTML text escapes an ampersand' => static fn () => same('<h1>Hello, Ada &amp; Lin</h1>', greetingHtml('Ada & Lin')),
    '01: HTML text escapes a tag and quotes' => static fn () => same('<h1>Hello, &lt;script&gt;&quot;x&quot;&lt;/script&gt;</h1>', greetingHtml('<script>"x"</script>')),
    '01: empty text is handled' => static fn () => same('<h1>Hello, </h1>', greetingHtml('')),
    '02: echo emits multiple expressions and print emits one' => static fn () => same("Hello, PHP\nPrinted\n", outputConstructs()['output']),
    '02: print returns integer one' => static fn () => same(1, outputConstructs()['print_return']),
    '03: a variable can change runtime types' => static fn () => same(['string', 'int'], variableExamples()['reassignment']),
    '03: variable names are case-sensitive' => static fn () => same(['Ada', 'Lin'], variableExamples()['case_sensitive_names']),
    '03: seven common value types are identified' => static fn () => same(['int', 'float', 'bool', 'string', 'array', 'stdClass', 'null'], variableExamples()['types']),
    '03: an open stream is a resource' => static fn () => same('resource', variableExamples()['stream_type']),
    '04: loose comparison accepts a numeric string' => static fn () => same(true, comparisonExamples()['10 == "10"']),
    '04: strict comparison rejects a numeric string' => static fn () => same(false, comparisonExamples()['10 === "10"']),
    '04: PHP 8 does not equate zero and arbitrary text' => static fn () => same(false, comparisonExamples()['0 == "text"']),
    '04: zero is loosely equal to numeric zero text' => static fn () => same(true, comparisonExamples()['0 == "0"']),
    '04: loose and strict boolean comparisons differ' => static function (): void {
        same(true, comparisonExamples()['0 == false']);
        same(false, comparisonExamples()['0 === false']);
    },
    '04: zero offset is distinct from false' => static function (): void {
        same(true, comparisonExamples()['found_at_zero']);
        same(false, comparisonExamples()['missing']);
    },
    '05: namespace and runtime constants are available' => static fn () => same(['language' => 'PHP', 'formats' => ['html', 'json'], 'runtime' => 'runtime-demo'], constantExamples()),
    '05: runtime definition is safe on repeated calls' => static fn () => same(constantExamples(), constantExamples()),
    '05: namespaced constant names are case-sensitive' => static fn () => same(false, defined('PhpSeries\\Fundamentals\\course_language')),
    '06: all if branches are reachable' => static function (): void {
        same('overdrawn', balanceLabel(-1));
        same('empty', balanceLabel(0));
        same('available', balanceLabel(1));
    },
    '06: switch uses loose case comparison' => static fn () => same('Monday', switchDay('1')),
    '06: match uses strict identity' => static function (): void {
        same('Other', matchDay('1'));
        same('Monday', matchDay(1));
    },
    '06: grouped match arms and fallback work' => static function (): void {
        same('Weekend', matchDay(6));
        same('Weekend', matchDay(7));
        same('Other', matchDay(8));
        same('Other', switchDay(8));
    },
    '06: missing match arm throws' => static fn () => throws(static fn () => binaryFlag(2), \UnhandledMatchError::class),
    '06: exhaustive binary flag accepts expected inputs' => static function (): void {
        same('off', binaryFlag(0));
        same('on', binaryFlag(1));
    },
    '07: default and named arguments work' => static function (): void {
        same(5, addIntegers(5));
        same(5, addIntegers(right: 3, left: 2));
        same(0, addIntegers(-2, 2));
    },
    '07: strict calling file rejects numeric text' => static fn () => throws(static fn () => addIntegers('2', 3), \TypeError::class),
    '07: weak calling file permits scalar coercion' => static fn () => same(5, callAddCoercively()),
    '07: nullable optional parameter accepts omission and null' => static function (): void {
        same('Hello, guest', optionalGreeting());
        same('Hello, guest', optionalGreeting(null));
        same('Hello, Ada', optionalGreeting('Ada'));
        same('Hello, ', optionalGreeting(''));
    },
    '07: variadic input handles zero or multiple arguments' => static function (): void {
        same(0, sumIntegers());
        same(6, sumIntegers(1, 2, 3));
    },
    '08: local input is explicit' => static fn () => same('local:Ada', localLabel('Ada')),
    '08: global keyword imports the global binding' => static function (): void {
        $existed = array_key_exists('fundamentalsLabel', $GLOBALS);
        $previous = $GLOBALS['fundamentalsLabel'] ?? null;
        try {
            unset($GLOBALS['fundamentalsLabel']);
            same('unset', readGlobalLabel());
            $GLOBALS['fundamentalsLabel'] = 'test-label';
            same('test-label', readGlobalLabel());
        } finally {
            if ($existed) {
                $GLOBALS['fundamentalsLabel'] = $previous;
            } else {
                unset($GLOBALS['fundamentalsLabel']);
            }
        }
    },
    '08: static local retains state across calls' => static function (): void {
        $first = staticCallCount();
        same($first + 1, staticCallCount());
    },
    '08: newly created closures have independent counters' => static function (): void {
        $first = makeCounter();
        $second = makeCounter();
        same(1, $first());
        same(2, $first());
        same(1, $second());
    },
    '09: single quotes preserve dollar-name and slash-n' => static fn () => same('Hello, $name\n', stringExamples('Ada')['single']),
    '09: double quotes interpolate and expand a newline' => static fn () => same("Hello, Ada\n", stringExamples('Ada')['double']),
    '09: single quote escapes and a literal dollar work' => static function (): void {
        same("It's PHP", stringExamples('Ada')['apostrophe']);
        same('C:\\lessons', stringExamples('Ada')['backslash']);
        same('Price: $5', stringExamples('Ada')['literal_dollar']);
        same('Hello, Ada', stringExamples('Ada')['concatenation']);
    },
    '10: variable variables and array lookup return the same value' => static fn () => same(['dynamic_variable' => 'Earth', 'explicit_array' => 'Earth'], variableVariableExample()),
    '10: explicit settings allow known keys and defaults' => static function (): void {
        same('dark', allowedSetting(['theme' => 'dark'], 'theme'));
        same('default', allowedSetting([], 'language'));
    },
    '10: unexpected setting key is rejected' => static fn () => throws(static fn () => allowedSetting(['admin' => 'yes'], 'admin'), \InvalidArgumentException::class),
    '10: unexpected setting type is rejected' => static fn () => throws(static fn () => allowedSetting(['theme' => 42], 'theme'), \InvalidArgumentException::class),
    '11: for visits each intended bound' => static fn () => same([0, 1, 2], loopExamples()['for']),
    '11: while terminates at zero' => static fn () => same([2, 1], loopExamples()['while']),
    '11: do-while executes once with an initially false condition' => static fn () => same(1, loopExamples()['attempts']),
    '11: foreach exposes keys and values' => static fn () => same(['php:8', 'sql:1'], loopExamples()['labels']),
    '11: unset prevents reference alias corruption' => static fn () => same([2, 4, 6], loopExamples()['doubled']),
    '11: continue skips and break terminates' => static fn () => same([1, 3], loopExamples()['selected']),
    '12: full ternary selects one result' => static function (): void {
        same('allowed', accessLabel(true));
        same('denied', accessLabel(false));
    },
    '12: short ternary loses each falsy non-null value' => static function (): void {
        foreach ([0, false, '', '0', []] as $value) {
            same('fallback', fallbackExamples($value)['short_ternary']);
            same($value, fallbackExamples($value)['null_coalescing']);
        }
    },
    '12: null triggers both fallbacks' => static fn () => same(['short_ternary' => 'fallback', 'null_coalescing' => 'fallback'], fallbackExamples(null)),
    '12: truthy value survives both defaults' => static fn () => same(['short_ternary' => 'PHP', 'null_coalescing' => 'PHP'], fallbackExamples('PHP')),
    '12: missing or null size uses the default' => static function (): void {
        same(20, pageSize([]));
        same(20, pageSize(['size' => null]));
    },
    '12: page size includes both valid boundaries' => static function (): void {
        same(1, pageSize(['size' => 1]));
        same(100, pageSize(['size' => 100]));
    },
    '12: defaulting does not replace validation' => static function (): void {
        foreach ([0, 101, -1, '20', true, []] as $invalid) {
            throws(static fn () => pageSize(['size' => $invalid]), \InvalidArgumentException::class);
        }
    },
];

$failed = 0;
foreach ($tests as $name => $test) {
    try {
        $test();
        echo 'PASS ', $name, PHP_EOL;
    } catch (\Throwable $error) {
        ++$failed;
        fwrite(STDERR, 'FAIL ' . $name . ': ' . $error->getMessage() . PHP_EOL);
    }
}
restore_error_handler();
printf("\n%d tests, %d failed.\n", count($tests), $failed);
exit($failed === 0 ? 0 : 1);
