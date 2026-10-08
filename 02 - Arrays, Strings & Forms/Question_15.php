<?php
declare(strict_types=1);
/**
 * Question 15: String mein kisi word ko search kaise karte hain? strpos() mein common mistake kya hai?
 *
 * INTERVIEW ANSWER: strpos returns the first byte offset or false; use !== false for presence.
 * EXPLANATION (Hinglish): Position 0 true match hai. strpos case-sensitive hai; stripos
 * case-insensitive search ke liye hai. PHP 8 str_contains boolean check deta hai. Empty needle
 * str_contains mein true hoti hai; query rules separately validate karo.
 * FOLLOW-UP: Why is if (strpos($title, "PHP")) wrong? It treats a match at offset zero as false.
 *
 * Run: php "Question_15.php". JSON labels explain each result.
 * Expected values and edge cases: tests/run.php and README.md.
 * PHP 8.1+; no Composer dependencies. CODEGULLY / Monu Kumar Giri.
 */
require_once __DIR__ . '/lib/lesson.php';
require_once __DIR__ . '/lib/validation.php';

$title = 'PHP Developer in Delhi';
$position = strpos($title, 'PHP');
return example(['position' => $position, 'found' => $position !== false,
    'case_sensitive_miss' => strpos($title, 'php'), 'contains' => str_contains($title, 'Developer'),
    'case_insensitive' => stripos($title, 'php'), 'empty_needle' => str_contains($title, '')]);
