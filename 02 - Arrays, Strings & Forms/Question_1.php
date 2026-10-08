<?php
declare(strict_types=1);
/**
 * Question 1: PHP mein array kya hota hai? Indexed, associative aur multidimensional arrays mein
 * kya difference hai?
 *
 * INTERVIEW ANSWER: Arrays are ordered maps, not three different PHP types.
 * EXPLANATION (Hinglish): Indexed mein integer keys, associative mein meaningful string keys,
 * aur multidimensional mein nested arrays hote hain. Access exact key se hota hai; array ka
 * first key hamesha 0 nahi hota. PHP integer-like string keys ko integers mein convert kar sakta
 * hai.
 * FOLLOW-UP: What happens to ["1" => "first", 1 => "second"]? One key remains: integer 1 with
 * value "second".
 *
 * Run: php "Question_1.php". JSON labels explain each result.
 * Expected values and edge cases: tests/run.php and README.md.
 * PHP 8.1+; no Composer dependencies. CODEGULLY / Monu Kumar Giri.
 */
require_once __DIR__ . '/lib/lesson.php';
require_once __DIR__ . '/lib/validation.php';

$cities = ['Delhi', 'Mumbai', 'Pune'];
$student = ['name' => 'Priya', 'city' => 'Jaipur'];
$students = [['name' => 'Aman', 'marks' => 85], ['name' => 'Neha', 'marks' => 92]];
return example(['first_city' => $cities[0], 'name' => $student['name'],
    'second_student' => $students[1], 'key_collision' => ['1' => 'first', 1 => 'second']]);
