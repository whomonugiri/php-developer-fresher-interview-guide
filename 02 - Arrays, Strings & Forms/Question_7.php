<?php
declare(strict_types=1);
/**
 * Question 7: sort(), asort() aur ksort() mein kya difference hai?
 *
 * INTERVIEW ANSWER: sort() sorts values and resets keys; asort() sorts values preserving keys;
 * ksort() sorts keys.
 * EXPLANATION (Hinglish): Ye functions input ko mutate karte hain; result sorted array nahi hai.
 * rsort/arsort/krsort descending versions hain. Marks ranking mein arsort() names preserve karta
 * hai. Numeric scores ke liye SORT_NUMERIC explicit rakho.
 * FOLLOW-UP: How do you rank scores without losing names? arsort($scores, SORT_NUMERIC).
 *
 * Run: php "Question_7.php". JSON labels explain each result.
 * Expected values and edge cases: tests/run.php and README.md.
 * PHP 8.1+; no Composer dependencies. CODEGULLY / Monu Kumar Giri.
 */
require_once __DIR__ . '/lib/lesson.php';
require_once __DIR__ . '/lib/validation.php';

$marks = ['Rohit' => 75, 'Aman' => 90, 'Priya' => 60];
$values = $byScore = $byName = $leaderboard = $marks;
sort($values, SORT_NUMERIC);
asort($byScore, SORT_NUMERIC);
ksort($byName, SORT_STRING);
arsort($leaderboard, SORT_NUMERIC);
return example(['values' => $values, 'by_score' => $byScore, 'by_name' => $byName,
    'leaderboard' => $leaderboard, 'original' => $marks]);
