<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/lib/web.php';
webStart(['GET']);
$topics = json_decode(file_get_contents(dirname(__DIR__) . '/lib/topics.json'), true, 512, JSON_THROW_ON_ERROR);
pageStart('Part 2: Arrays, Strings & Forms', '28 original interview topics, rewritten with matched examples and tests. Source files contain the Hinglish explanation and a follow-up question.');
echo '<ol>';
foreach ($topics as $number => $topic) {
    echo '<li><a href="/Question_' . (int) $number . '.php">' . escapeHtml($topic['question']) . '</a></li>';
}
echo '</ol>';
pageEnd();
