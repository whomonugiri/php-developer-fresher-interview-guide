<?php
declare(strict_types=1);
/**
 * Question 17: strcmp() aur strcasecmp() mein kya difference hai?
 *
 * INTERVIEW ANSWER: strcmp is case-sensitive; strcasecmp compares case-insensitively for ASCII text.
 * EXPLANATION (Hinglish): Equal strings par 0 return hota hai. Ordering ke liye result ka sign
 * check karo, exact non-zero magnitude nahi; magnitude PHP versions mein change ho sakti hai.
 * These are not natural-language collation tools.
 * FOLLOW-UP: Why is strcmp($a, $b) === 1 unreliable? Only positive/zero/negative is a stable
 * comparison contract.
 *
 * Run: php "Question_17.php". JSON labels explain each result.
 * Expected values and edge cases: tests/run.php and README.md.
 * PHP 8.1+; no Composer dependencies. CODEGULLY / Monu Kumar Giri.
 */
require_once __DIR__ . '/lib/lesson.php';
require_once __DIR__ . '/lib/validation.php';

return example(['same' => strcmp('PHP', 'PHP') === 0,
    'different_case' => strcmp('PHP', 'php') === 0,
    'ignore_case' => strcasecmp('PHP', 'pHp') === 0,
    'before' => strcmp('alpha', 'beta') < 0, 'after' => strcmp('beta', 'alpha') > 0]);
