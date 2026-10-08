<?php
declare(strict_types=1);
require_once dirname(__DIR__, 2) . '/lib/web.php';
webStart(['POST']);
$name = textField($_POST, 'student_name') ?? '';
$error = validateName($_POST['student_name'] ?? null);
if ($error !== null) { http_response_code(422); }
pageStart('Q19: Separate processor', 'Only POST is accepted; user text is escaped at output.');
showErrors($error === null ? [] : [$error]);
if ($error === null) { echo '<p>Namaste, ' . escapeHtml($name) . '</p>'; }
nameForm('/support/question_19/process.php', $name);
pageEnd();
