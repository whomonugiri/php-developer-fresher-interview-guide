<?php
declare(strict_types=1);
require_once dirname(__DIR__, 2) . '/lib/web.php';
webStart(['GET']);
pageStart('Q19: Separate form', 'The POST goes to process.php. A PHP form page generates the session-bound CSRF token.');
nameForm('/support/question_19/process.php');
pageEnd();
