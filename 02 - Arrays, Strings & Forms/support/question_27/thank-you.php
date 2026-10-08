<?php
declare(strict_types=1);
require_once dirname(__DIR__, 2) . '/lib/web.php';
webStart(['GET']);
$name = $_SESSION['prg_name'] ?? null;
unset($_SESSION['prg_name']); // Consume once; refreshing remains a harmless GET.
pageStart('Q27: Demo complete', 'This result page is loaded with GET. Refreshing does not repeat the previous POST.');
if (is_string($name)) {
    echo '<p>Namaste, ' . escapeHtml($name) . '. The demo validated your name.</p>';
} else {
    echo '<p>No new submission to display. Submit the form to see a one-time greeting.</p>';
}
echo '<p><a href="/Question_27.php">Return to the form</a></p>';
pageEnd();
