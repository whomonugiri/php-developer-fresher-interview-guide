<?php
declare(strict_types=1);
/**
 * Question 14: explode() aur implode() mein kya difference hai?
 *
 * INTERVIEW ANSWER: explode splits a string; implode joins array values using a separator.
 * EXPLANATION (Hinglish): explode comma ke baad spaces preserve karta hai, array_map("trim",
 * ...) se normalize karo. Empty separator PHP 8 mein ValueError deta hai. Quoted CSV ke liye
 * str_getcsv/fgetcsv use karo, simple explode nahi.
 * FOLLOW-UP: What does explode(",", "a,,b") produce? Three values, with an empty string in the middle.
 *
 * Run: php "Question_14.php". JSON labels explain each result.
 * Expected values and edge cases: tests/run.php and README.md.
 * PHP 8.1+; no Composer dependencies. CODEGULLY / Monu Kumar Giri.
 */
require_once __DIR__ . '/lib/lesson.php';
require_once __DIR__ . '/lib/validation.php';

$skills = array_map('trim', explode(',', 'PHP, MySQL, JavaScript'));
return example(['skills' => $skills, 'joined' => implode(' | ', $skills),
    'empty_part' => explode(',', 'a,,b')]);
