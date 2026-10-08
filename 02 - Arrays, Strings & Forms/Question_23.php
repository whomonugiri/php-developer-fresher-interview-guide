<?php
declare(strict_types=1);
/**
 * Question 23: Email, fresher experience aur mobile-number input validate kaise karenge?
 *
 * INTERVIEW ANSWER: Validate email syntax, integer experience range, and the
 * application-specific phone format separately.
 * EXPLANATION (Hinglish): 0 years valid hai; filter result === false se compare karo. Phone
 * identifier string hai, numeric quantity nahi. Demo phone rule exactly 10 ASCII digits without
 * country code hai. Format validation ownership/deliverability prove nahi karti.
 * FOLLOW-UP: How do you establish ownership of an email or phone? A separate verified
 * confirmation flow, not this regex.
 *
 * Run: php "Question_23.php". JSON labels explain each result.
 * Expected values and edge cases: tests/run.php and README.md.
 * PHP 8.1+; no Composer dependencies. CODEGULLY / Monu Kumar Giri.
 */
require_once __DIR__ . '/lib/lesson.php';
require_once __DIR__ . '/lib/validation.php';

$valid = validateApplicant(['email' => 'priya@example.com', 'experience' => '0', 'mobile' => '0123456789']);
$invalid = validateApplicant(['email' => 'bad', 'experience' => '51', 'mobile' => '+911234567890']);
return example(['valid' => $valid, 'invalid_errors' => $invalid['errors']]);
