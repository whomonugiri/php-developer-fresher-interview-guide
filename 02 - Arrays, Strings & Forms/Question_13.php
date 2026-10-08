<?php
declare(strict_types=1);
/**
 * Question 13: trim(), strtolower(), strtoupper() aur ucwords() kya karte hain?
 *
 * INTERVIEW ANSWER: trim removes selected edge characters; strtolower/strtoupper/ucwords change case.
 * EXPLANATION (Hinglish): trim internal spaces collapse nahi karta aur all Unicode whitespace
 * remove nahi karta. Results assign/use karo. ASCII examples portable hain; Unicode case
 * conversions ke liye mbstring functions use karo. PHP 8.1 case behavior can depend on locale;
 * PHP 8.2+ these byte functions are ASCII-only.
 * FOLLOW-UP: Does trim($name) change $name? No: assign its returned string.
 *
 * Run: php "Question_13.php". JSON labels explain each result.
 * Expected values and edge cases: tests/run.php and README.md.
 * PHP 8.1+; no Composer dependencies. CODEGULLY / Monu Kumar Giri.
 */
require_once __DIR__ . '/lib/lesson.php';
require_once __DIR__ . '/lib/validation.php';

$name = '   aman sharma   ';
$cleanName = trim($name);
return example(['trimmed' => $cleanName, 'upper' => strtoupper($cleanName),
    'words' => ucwords($cleanName), 'lower' => strtolower('PHP DEVELOPER'),
    'inner_spaces' => trim('  Aman   Sharma  '), 'original_unchanged' => $name]);
