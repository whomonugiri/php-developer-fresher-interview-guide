<?php
declare(strict_types=1);
/**
 * Question 10: array_map(), array_filter() aur array_reduce() mein kya difference hai?
 *
 * INTERVIEW ANSWER: map transforms, filter selects, reduce accumulates into one result.
 * EXPLANATION (Hinglish): array_filter keys preserve karta hai, isliye JSON list ke liye
 * array_values useful hai. Callback ke bina filter 0 aur "0" bhi remove karta hai. Reduce ka
 * initial value empty-input result aur accumulator type clear karta hai.
 * FOLLOW-UP: Which function produces a sum, and what happens for an empty list? array_reduce
 * with initial 0 returns 0.
 *
 * Run: php "Question_10.php". JSON labels explain each result.
 * Expected values and edge cases: tests/run.php and README.md.
 * PHP 8.1+; no Composer dependencies. CODEGULLY / Monu Kumar Giri.
 */
require_once __DIR__ . '/lib/lesson.php';
require_once __DIR__ . '/lib/validation.php';

$prices = [500, 1000, 1500];
$discounted = array_map(static fn(int $price): int => $price - 100, $prices);
$selected = array_filter($prices, static fn(int $price): bool => $price >= 1000);
$total = array_reduce($prices, static fn(int $sum, int $price): int => $sum + $price, 0);
return example(['discounted' => $discounted, 'selected_keys' => array_keys($selected),
    'selected' => array_values($selected), 'total' => $total,
    'keep_zero' => array_values(array_filter([0, 5, null], static fn($n): bool => $n !== null)),
    'empty_total' => array_reduce([], static fn(int $sum, int $n): int => $sum + $n, 0)]);
