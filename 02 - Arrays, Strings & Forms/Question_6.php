<?php
declare(strict_types=1);
/**
 * Question 6: array_merge() aur array union operator + mein kya difference hai?
 *
 * INTERVIEW ANSWER: array_merge() overwrites matching string keys and reindexes integer keys; +
 * keeps left-hand keys.
 * EXPLANATION (Hinglish): Union duplicate values remove nahi karta: decision keys par hota hai.
 * Numeric-string keys PHP array mein integer keys ho sakti hain. Defaults merge karte waqt
 * precedence clearly decide karo.
 * FOLLOW-UP: For user options plus defaults, what does $user + $defaults do? User keys win,
 * missing defaults are added.
 *
 * Run: php "Question_6.php". JSON labels explain each result.
 * Expected values and edge cases: tests/run.php and README.md.
 * PHP 8.1+; no Composer dependencies. CODEGULLY / Monu Kumar Giri.
 */
require_once __DIR__ . '/lib/lesson.php';
require_once __DIR__ . '/lib/validation.php';

$left = ['city' => 'Delhi', 0 => 'PHP'];
$right = ['city' => 'Pune', 0 => 'MySQL', 1 => 'React'];
return example(['merge' => array_merge($left, $right), 'union' => $left + $right]);
