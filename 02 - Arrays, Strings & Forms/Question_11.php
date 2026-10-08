<?php
declare(strict_types=1);
/**
 * Question 11: PHP mein strings concatenate kaise karte hain?
 *
 * INTERVIEW ANSWER: Use . to concatenate strings and .= to append.
 * EXPLANATION (Hinglish): + arithmetic ke liye hai. Arithmetic and concatenation ek expression
 * mein mix karte waqt parentheses lagao. Interpolation convenient hai, lekin braces variable
 * boundary clear karte hain.
 * FOLLOW-UP: How do you append a calculated total clearly? $message .= " Total: " . ($price *
 * $quantity);
 *
 * Run: php "Question_11.php". JSON labels explain each result.
 * Expected values and edge cases: tests/run.php and README.md.
 * PHP 8.1+; no Composer dependencies. CODEGULLY / Monu Kumar Giri.
 */
require_once __DIR__ . '/lib/lesson.php';
require_once __DIR__ . '/lib/validation.php';

$fullName = 'Monu' . ' ' . 'Giri';
$message = 'Namaste ' . $fullName;
$message .= ', welcome!';
return example(['name' => $fullName, 'message' => $message, 'total' => 'Total: ' . (250 * 2)]);
