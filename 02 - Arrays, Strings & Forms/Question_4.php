<?php
declare(strict_types=1);
/**
 * Question 4: in_array() aur array_search() mein kya difference hai?
 *
 * INTERVIEW ANSWER: in_array() returns a boolean; array_search() returns the first matching key
 * or false.
 * EXPLANATION (Hinglish): Third argument true se value aur type dono compare hote hain. Found
 * key 0 valid hai. Result !== false check karo; if ($key) index-zero match miss karega.
 * FOLLOW-UP: Why use strict membership for IDs? String "101" and integer 101 need not mean the
 * same allowed input.
 *
 * Run: php "Question_4.php". JSON labels explain each result.
 * Expected values and edge cases: tests/run.php and README.md.
 * PHP 8.1+; no Composer dependencies. CODEGULLY / Monu Kumar Giri.
 */
require_once __DIR__ . '/lib/lesson.php';
require_once __DIR__ . '/lib/validation.php';

$skills = ['PHP', 'MySQL', 'JavaScript'];
$key = array_search('PHP', $skills, true);
return example(['has_php' => in_array('PHP', $skills, true), 'first_key' => $key,
    'found' => $key !== false, 'missing' => array_search('Go', $skills, true),
    'loose_id' => in_array('101', [101, 102]), 'strict_id' => in_array('101', [101, 102], true)]);
