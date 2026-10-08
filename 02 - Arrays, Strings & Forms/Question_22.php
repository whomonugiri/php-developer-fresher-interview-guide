<?php
declare(strict_types=1);
/**
 * Question 22: Validation, sanitization aur output escaping mein kya difference hai? Kya HTML
 * validation enough hai?
 *
 * INTERVIEW ANSWER: Normalization transforms input, validation accepts/rejects rules, escaping
 * makes a specific output context safe.
 * EXPLANATION (Hinglish): trim helpful normalization hai, universal sanitization nahi. Invalid
 * data ko silently repair karne ke bajaye business rule report karo. Browser validation UX hai;
 * server authoritative hai. Store meaningful data and escape when rendering.
 * FOLLOW-UP: Can HTML escaping prevent SQL injection? No: SQL needs parameterized queries.
 *
 * Run: php "Question_22.php". JSON labels explain each result.
 * Expected values and edge cases: tests/run.php and README.md.
 * PHP 8.1+; no Composer dependencies. CODEGULLY / Monu Kumar Giri.
 */
require_once __DIR__ . '/lib/lesson.php';
require_once __DIR__ . '/lib/validation.php';

$rawName = '   Priya <script>alert(1)</script>   ';
$name = trim($rawName); // Normalization, not an XSS defense.
$valid = $name !== '' && strlen($name) <= 200;
return example(['normalized' => $name, 'valid_by_demo_name_rules' => $valid,
    'html_text' => escapeHtml($name)]);
