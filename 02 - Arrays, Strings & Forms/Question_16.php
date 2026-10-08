<?php
declare(strict_types=1);
/**
 * Question 16: substr() aur str_replace() kya karte hain?
 *
 * INTERVIEW ANSWER: substr extracts a byte range; str_replace replaces all matching occurrences.
 * EXPLANATION (Hinglish): Negative offset end se count karta hai. Original variable unchanged
 * rahega unless result assign karo. Unicode character slicing ke liye mb_substr use karo;
 * arbitrary byte cut UTF-8 tod sakta hai.
 * FOLLOW-UP: How do you learn replacement count? Pass the optional fourth argument to str_replace().
 *
 * Run: php "Question_16.php". JSON labels explain each result.
 * Expected values and edge cases: tests/run.php and README.md.
 * PHP 8.1+; no Composer dependencies. CODEGULLY / Monu Kumar Giri.
 */
require_once __DIR__ . '/lib/lesson.php';
require_once __DIR__ . '/lib/validation.php';

$id = 'ORD-2026-1045';
$message = 'PHP classes in Delhi; workshops in Delhi';
$count = 0;
$updated = str_replace('Delhi', 'Pune', $message, $count);
return example(['prefix' => substr($id, 0, 3), 'suffix' => substr($id, -4),
    'updated' => $updated, 'replacements' => $count, 'original' => $message]);
