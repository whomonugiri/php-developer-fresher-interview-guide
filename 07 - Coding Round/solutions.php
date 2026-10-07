<?php
declare(strict_types=1);

namespace DevNinja\CodingRound;

// These string exercises intentionally use ASCII. For international text,
// choose an explicit Unicode normalization and grapheme-aware approach.
function reverseAscii(string $text): string
{
    return strrev($text);
}

function isPalindrome(string $text): bool
{
    $normalized = preg_replace('/[^a-z0-9]/', '', strtolower($text));
    return $normalized === strrev($normalized);
}

function areAnagrams(string $left, string $right): bool
{
    $normalize = static function (string $value): array {
        $chars = str_split(preg_replace('/[^a-z0-9]/', '', strtolower($value)));
        sort($chars);
        return $chars;
    };
    return $normalize($left) === $normalize($right);
}

function factorial(int $n): int
{
    if ($n < 0 || $n > 20) {
        throw new \InvalidArgumentException('Factorial input must be 0..20 on 64-bit PHP.');
    }
    $result = 1;
    for ($i = 2; $i <= $n; $i++) {
        $result *= $i;
    }
    return $result;
}

function fibonacci(int $n): int
{
    if ($n < 0 || $n > 92) {
        throw new \InvalidArgumentException('Fibonacci index must be 0..92 on 64-bit PHP.');
    }
    [$a, $b] = [0, 1];
    for ($i = 0; $i < $n; $i++) {
        [$a, $b] = [$b, $a + $b];
    }
    return $a;
}

function isPrime(int $n): bool
{
    if ($n < 2) {
        return false;
    }
    for ($divisor = 2; $divisor <= intdiv($n, $divisor); $divisor++) {
        if ($n % $divisor === 0) {
            return false;
        }
    }
    return true;
}

/** @return list<string> */
function fizzBuzz(int $n): array
{
    if ($n < 0 || $n > 10000) {
        throw new \InvalidArgumentException('n must be 0..10000.');
    }
    $result = [];
    for ($i = 1; $i <= $n; $i++) {
        $result[] = $i % 15 === 0 ? 'FizzBuzz' : ($i % 3 === 0 ? 'Fizz' : ($i % 5 === 0 ? 'Buzz' : (string) $i));
    }
    return $result;
}

/** @param list<int> $numbers */
function secondLargest(array $numbers): ?int
{
    $largest = null;
    $second = null;
    foreach ($numbers as $number) {
        if ($largest === null || $number > $largest) {
            $second = $largest;
            $largest = $number;
        } elseif ($number !== $largest && ($second === null || $number > $second)) {
            $second = $number;
        }
    }
    return $second;
}

/** @param list<int> $numbers @return array{int, int}|null */
function twoSum(array $numbers, int $target): ?array
{
    $seen = [];
    foreach ($numbers as $index => $number) {
        $need = $target - $number;
        if (!is_int($need)) {
            // A difference outside the integer range cannot match an int input.
            $seen[$number] = $index;
            continue;
        }
        if (isset($seen[$need])) {
            return [$seen[$need], $index];
        }
        $seen[$number] = $index;
    }
    return null;
}

/** @param list<int> $sorted */
function binarySearch(array $sorted, int $target): ?int
{
    $low = 0;
    $high = count($sorted) - 1;
    while ($low <= $high) {
        $mid = $low + intdiv($high - $low, 2);
        if ($sorted[$mid] === $target) {
            return $mid;
        }
        if ($sorted[$mid] < $target) {
            $low = $mid + 1;
        } else {
            $high = $mid - 1;
        }
    }
    return null;
}

/** @return array<string, int> */
function wordFrequency(string $text): array
{
    preg_match_all('/[a-z0-9]+/i', strtolower($text), $matches);
    $counts = [];
    foreach ($matches[0] as $word) {
        $counts[$word] = ($counts[$word] ?? 0) + 1;
    }
    ksort($counts);
    return $counts;
}

function balancedBrackets(string $text): bool
{
    $opening = ['(', '[', '{'];
    $matching = [')' => '(', ']' => '[', '}' => '{'];
    $stack = [];
    foreach (str_split($text) as $char) {
        if (in_array($char, $opening, true)) {
            $stack[] = $char;
        } elseif (isset($matching[$char]) && array_pop($stack) !== $matching[$char]) {
            return false;
        }
    }
    return $stack === [];
}

/** @param list<int> $numbers @return list<int> */
function uniqueInOrder(array $numbers): array
{
    $seen = [];
    $result = [];
    foreach ($numbers as $number) {
        if (!isset($seen[$number])) {
            $seen[$number] = true;
            $result[] = $number;
        }
    }
    return $result;
}

/** @param array<string, int> $scores @return array<string, int> */
function sortByValue(array $scores): array
{
    // PHP 8 sorting is stable: equal values retain their input order.
    uasort($scores, static fn (int $a, int $b): int => $a <=> $b);
    return $scores;
}

/** @param list<array{name: string, role: string}> $records
 *  @return array<string, list<array{name: string, role: string}>>
 */
function groupByRole(array $records): array
{
    $groups = [];
    foreach ($records as $record) {
        $groups[$record['role']][] = $record;
    }
    return $groups;
}

/** @param list<list<int>> $groups @return list<int> */
function flattenOneLevel(array $groups): array
{
    $result = [];
    foreach ($groups as $group) {
        foreach ($group as $value) {
            $result[] = $value;
        }
    }
    return $result;
}

/** @param list<string> $emails @return list<string> */
function validEmails(array $emails): array
{
    return array_values(array_filter($emails, static fn (string $email): bool => filter_var($email, FILTER_VALIDATE_EMAIL) !== false));
}

/** @param list<array{price_cents: int, quantity: int}> $items */
function cartTotalCents(array $items): int
{
    $total = 0;
    foreach ($items as $item) {
        $price = $item['price_cents'];
        $quantity = $item['quantity'];
        if ($price < 0 || $quantity < 1) {
            throw new \InvalidArgumentException('Invalid cart line.');
        }
        if ($price > intdiv(PHP_INT_MAX, $quantity)) {
            throw new \OverflowException('Cart line overflows an integer.');
        }
        $line = $price * $quantity;
        if ($total > PHP_INT_MAX - $line) {
            throw new \OverflowException('Cart total overflows an integer.');
        }
        $total += $line;
    }
    return $total;
}

/** @return list<int> */
function fibonacciTerms(int $count): array
{
    if ($count < 0 || $count > 92) {
        throw new \InvalidArgumentException('Term count must be 0..92 on 64-bit PHP.');
    }
    [$a, $b] = [0, 1];
    $terms = [];
    for ($i = 0; $i < $count; $i++) {
        $terms[] = $a;
        if ($i + 1 < $count) {
            [$a, $b] = [$b, $a + $b];
        }
    }
    return $terms;
}

/** @param list<int> $left @param list<int> $right @return list<int> */
function mergeSorted(array $left, array $right): array
{
    $result = [];
    $i = 0;
    $j = 0;
    while ($i < count($left) && $j < count($right)) {
        if ($left[$i] <= $right[$j]) {
            $result[] = $left[$i++];
        } else {
            $result[] = $right[$j++];
        }
    }
    while ($i < count($left)) {
        $result[] = $left[$i++];
    }
    while ($j < count($right)) {
        $result[] = $right[$j++];
    }
    return $result;
}
