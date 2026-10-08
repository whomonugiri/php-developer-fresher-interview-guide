<?php
declare(strict_types=1);
/**
 * Question 9: Duplicate values, array keys aur array columns kaise extract karte hain?
 *
 * INTERVIEW ANSWER: unique removes repeated values; keys/values extract keys/values; column
 * extracts one field from rows.
 * EXPLANATION (Hinglish): array_unique original keys preserve karta hai. array_values se list
 * ban sakti hai. array_column ka third argument output keys choose karta hai; duplicate IDs
 * overwrite earlier rows. Missing column values skip ho sakti hain.
 * FOLLOW-UP: Why avoid array_unique() as a general nested-object deduplicator? Its comparison
 * rules are not a domain-specific identity rule.
 *
 * Run: php "Question_9.php". JSON labels explain each result.
 * Expected values and edge cases: tests/run.php and README.md.
 * PHP 8.1+; no Composer dependencies. CODEGULLY / Monu Kumar Giri.
 */
require_once __DIR__ . '/lib/lesson.php';
require_once __DIR__ . '/lib/validation.php';

$cities = ['Delhi', 'Pune', 'Delhi', 'Mumbai'];
$student = ['name' => 'Priya', 'course' => 'BCA'];
$rows = [['id' => 101, 'name' => 'Aman'], ['id' => 102, 'name' => 'Neha']];
return example(['unique_keys' => array_keys(array_unique($cities)),
    'unique_list' => array_values(array_unique($cities)), 'keys' => array_keys($student),
    'values' => array_values($student), 'names' => array_column($rows, 'name'),
    'names_by_id' => array_column($rows, 'name', 'id')]);
