<?php
declare(strict_types=1);
/**
 * Question 21: $_GET, $_POST aur $_REQUEST kya hain? Form input ka data type kya hota hai?
 *
 * INTERVIEW ANSWER: $_GET and $_POST identify sources; $_REQUEST merges configured sources and
 * hides precedence.
 * EXPLANATION (Hinglish): Form scalars normally strings, bracket fields arrays hote hain. JSON
 * request body automatically $_POST mein decode nahi hoti. Number control trusted integer nahi
 * hai. Validate shape and range, then strictly compare the false sentinel so 0 survives.
 * FOLLOW-UP: Why avoid $_REQUEST for a field that must be POSTed? Cookie/query precedence
 * depends on PHP configuration.
 *
 * Browser run and expected outcomes: README.md. PHP 8.1+.
 * Read lib/web.php for localhost, CSRF, method and output safeguards.
 * CODEGULLY / Monu Kumar Giri.
 */
require_once __DIR__ . '/lib/web.php';

$method = webStart();
$raw = $method === 'POST' ? ($_POST['age'] ?? null) : '21';
$age = integerInRange($raw, 0, 120);
$error = $method === 'POST' && $age === false ? 'Age must be one integer from 0 to 120.' : null;
if ($error !== null) { http_response_code(422); }
pageStart('Q21: Sources and data types', 'The form uses POST. A valid value is converted from a string to an integer; 0 is valid.');
showErrors($error === null ? [] : [$error]);
if ($method === 'POST' && $error === null) {
    echo '<p>Validated integer age: ' . $age . '</p>';
}
?>
<form method="post" action="/Question_21.php">
    <?php csrfField(); ?>
    <label for="age">Age</label>
    <input id="age" type="number" name="age" min="0" max="120" required
        value="<?= escapeHtml(is_string($raw) ? $raw : '') ?>">
    <button>Check age</button>
</form>
<?php pageEnd();
