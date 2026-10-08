<?php
declare(strict_types=1);
/**
 * Question 3: isset(), empty() aur array_key_exists() mein kya difference hai?
 *
 * INTERVIEW ANSWER: isset() excludes null; array_key_exists() includes null; empty() accepts
 * false-like values.
 * EXPLANATION (Hinglish): Missing field aur explicit null alag business meanings rakh sakte
 * hain. empty("0") true hai, isliye valid zero ko missing mat bolo. ?? null/missing ke liye
 * default deta hai, zero ke liye nahi.
 * FOLLOW-UP: Which check distinguishes a missing key from a key containing null? array_key_exists().
 *
 * Run: php "Question_3.php". JSON labels explain each result.
 * Expected values and edge cases: tests/run.php and README.md.
 * PHP 8.1+; no Composer dependencies. CODEGULLY / Monu Kumar Giri.
 */
require_once __DIR__ . '/lib/lesson.php';
require_once __DIR__ . '/lib/validation.php';

$student = ['middle_name' => null, 'experience' => 0];
return example(['isset_null' => isset($student['middle_name']),
    'key_exists_null' => array_key_exists('middle_name', $student),
    'empty_zero' => empty($student['experience']), 'isset_zero' => isset($student['experience']),
    'missing' => array_key_exists('missing', $student), 'zero_is_blank_string' => ('0' === '')]);
