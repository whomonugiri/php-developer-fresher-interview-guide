<?php
declare(strict_types=1);
/**
 * Question 18: htmlspecialchars() aur strip_tags() mein kya difference hai?
 *
 * INTERVIEW ANSWER: htmlspecialchars escapes HTML output; strip_tags removes tags and is not an
 * XSS defense.
 * EXPLANATION (Hinglish): HTML text/quoted attributes ke liye ENT_QUOTES | ENT_SUBSTITUTE with
 * UTF-8 use karo. JavaScript, URLs, CSS aur SQL ke rules alag hain. Allowed tags with dangerous
 * attributes still dangerous ho sakte hain. Data ko output boundary par escape karo.
 * FOLLOW-UP: Does strip_tags make arbitrary input safe inside an HTML attribute? No; quotes and
 * context still matter.
 *
 * Run: php "Question_18.php". JSON labels explain each result.
 * Expected values and edge cases: tests/run.php and README.md.
 * PHP 8.1+; no Composer dependencies. CODEGULLY / Monu Kumar Giri.
 */
require_once __DIR__ . '/lib/lesson.php';
require_once __DIR__ . '/lib/validation.php';

$text = '<b title="hello">Namaste & Aman</b>';
return example(['escaped' => htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
    'stripped' => strip_tags($text), 'attribute_quotes' => escapeHtml('" onfocus="alert(1)')]);
