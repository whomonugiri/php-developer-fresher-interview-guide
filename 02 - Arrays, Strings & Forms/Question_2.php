<?php
declare(strict_types=1);
/**
 * Question 2: Array mein elements add, update, remove aur count kaise karte hain?
 *
 * INTERVIEW ANSWER: Use [] to append, a key to update, unset() to remove, and count() to count.
 * EXPLANATION (Hinglish): unset() baaki keys reset nahi karta. count() element count hai,
 * highest key nahi. array_values() fresh list deta hai; returned value assign karna padta hai.
 * FOLLOW-UP: Why can a three-element array have keys 1, 2, 3? Removal preserves the surviving keys.
 *
 * Run: php "Question_2.php". JSON labels explain each result.
 * Expected values and edge cases: tests/run.php and README.md.
 * PHP 8.1+; no Composer dependencies. CODEGULLY / Monu Kumar Giri.
 */
require_once __DIR__ . '/lib/lesson.php';
require_once __DIR__ . '/lib/validation.php';

$students = ['Aman', 'Priya', 'Neha'];
$students[] = 'Rohit';
$students[1] = 'Pooja';
unset($students[0]);
return example(['count' => count($students), 'preserved_keys' => array_keys($students),
    'list' => array_values($students)]);
