<?php
declare(strict_types=1);
/**
 * Question 20: GET aur POST mein kya difference hai? Kya POST automatically secure hai?
 *
 * INTERVIEW ANSWER: GET puts form fields in the query string; POST sends form fields in the body.
 * EXPLANATION (Hinglish): GET search/filter ke liye bookmarkable hai; data-changing actions POST
 * use karte hain. POST encrypted nahi hota: HTTPS transport encryption deta hai. Sensitive
 * values query strings mein mat rakho; history/logs/referrers mein leak ho sakte hain.
 * FOLLOW-UP: Can a POST also have $_GET values? Yes: its URL may include a query string.
 *
 * Browser run and expected outcomes: README.md. PHP 8.1+.
 * Read lib/web.php for localhost, CSRF, method and output safeguards.
 * CODEGULLY / Monu Kumar Giri.
 */
require_once __DIR__ . '/lib/web.php';

webStart(['GET']);
$query = textField($_GET, 'q') ?? '';
$error = isset($_GET['q']) && (!is_string($_GET['q']) || strlen($query) > 200)
    ? 'Search must be a single string of at most 200 bytes.' : null;
if ($error !== null) { http_response_code(422); $query = ''; }
pageStart('Q20: GET versus POST', 'GET search is bookmarkable. POST sends a body but does not provide encryption.');
showErrors($error === null ? [] : [$error]);
?>
<form action="/Question_20.php" method="get">
    <label for="q">Course search</label>
    <input id="q" type="search" name="q" value="<?= escapeHtml($query) ?>">
    <button>Search</button>
</form>
<p>Search: <?= escapeHtml($query) ?></p>
<?php pageEnd();
