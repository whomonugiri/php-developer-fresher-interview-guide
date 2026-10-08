<?php
declare(strict_types=1);
/**
 * Question 8: array_slice() aur array_splice() mein kya difference hai?
 *
 * INTERVIEW ANSWER: slice returns a portion without changing the source; splice mutates and
 * returns removed values.
 * EXPLANATION (Hinglish): Offsets positions hain, keys nahi. slice by default integer keys reset
 * karta hai; fourth argument true se preserve hote hain. splice numeric keys reindexes and can
 * insert replacements.
 * FOLLOW-UP: What does array_splice($a, 1, 0, ["new"]) do? Insert at position 1 without removing items.
 *
 * Run: php "Question_8.php". JSON labels explain each result.
 * Expected values and edge cases: tests/run.php and README.md.
 * PHP 8.1+; no Composer dependencies. CODEGULLY / Monu Kumar Giri.
 */
require_once __DIR__ . '/lib/lesson.php';
require_once __DIR__ . '/lib/validation.php';

$cities = ['Delhi', 'Mumbai', 'Pune'];
$slice = array_slice($cities, 1, 1);
$before = $cities; // slice did not modify it.
$removed = array_splice($cities, 1, 1, ['Jaipur']);
return example(['slice' => $slice, 'before_splice' => $before, 'removed' => $removed,
    'after_splice' => $cities, 'preserved_slice' => array_slice([5 => 'A', 9 => 'B'], 1, 1, true)]);
