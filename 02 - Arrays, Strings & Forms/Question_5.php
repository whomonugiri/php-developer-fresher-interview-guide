<?php
declare(strict_types=1);
/**
 * Question 5: array_push(), array_pop(), array_shift() aur array_unshift() kya karte hain?
 *
 * INTERVIEW ANSWER: push/unshift add at the end/start; pop/shift remove and return the end/start item.
 * EXPLANATION (Hinglish): push/unshift updated count return karte hain. pop/shift empty array
 * par null dete hain. Single append ke liye [] simple hai. shift/unshift integer keys reindex
 * karte hain; large queues mein repeated shifting costly ho sakta hai.
 * FOLLOW-UP: How would you distinguish an empty stack from a popped null item? Check the array
 * before popping.
 *
 * Run: php "Question_5.php". JSON labels explain each result.
 * Expected values and edge cases: tests/run.php and README.md.
 * PHP 8.1+; no Composer dependencies. CODEGULLY / Monu Kumar Giri.
 */
require_once __DIR__ . '/lib/lesson.php';
require_once __DIR__ . '/lib/validation.php';

$queue = ['Aman', 'Priya'];
$count = array_push($queue, 'Rohit');
$last = array_pop($queue);
array_unshift($queue, 'Neha');
$first = array_shift($queue);
$empty = [];
return example(['count_after_push' => $count, 'popped' => $last, 'shifted' => $first,
    'queue' => $queue, 'empty_pop' => array_pop($empty)]);
