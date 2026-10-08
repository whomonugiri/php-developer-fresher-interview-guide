<?php

// Intentional contrast with the strict calling file in ../run.php.
declare(strict_types=0);

namespace PhpSeries\Fundamentals\Tests;

function callAddCoercively(): int
{
    return \PhpSeries\Fundamentals\addIntegers('2', 3);
}
