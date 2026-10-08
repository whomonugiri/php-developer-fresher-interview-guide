<?php
declare(strict_types=1);
/**
 * Question 12: strlen() aur mb_strlen() mein kya difference hai?
 *
 * INTERVIEW ANSWER: strlen counts bytes; mb_strlen with UTF-8 counts code points.
 * EXPLANATION (Hinglish): Rupee sign 3 UTF-8 bytes hai: "₹100" = 6 bytes, 4 code points.
 * User-perceived graphemes multiple code points ho sakte hain. mbstring optional extension hai;
 * grapheme_strlen needs intl. File UTF-8 rakho.
 * FOLLOW-UP: Why can even mb_strlen overcount visible letters? Combining marks and emoji
 * sequences can form one grapheme.
 *
 * Run: php "Question_12.php". JSON labels explain each result.
 * Expected values and edge cases: tests/run.php and README.md.
 * PHP 8.1+; no Composer dependencies. CODEGULLY / Monu Kumar Giri.
 */
require_once __DIR__ . '/lib/lesson.php';
require_once __DIR__ . '/lib/validation.php';

$text = '₹100';
return example(['text' => $text, 'bytes' => strlen($text),
    'code_points' => function_exists('mb_strlen') ? mb_strlen($text, 'UTF-8') : null,
    'graphemes' => function_exists('grapheme_strlen') ? grapheme_strlen($text) : null,
    'extension_note' => 'null means the optional mbstring/intl extension is unavailable']);
