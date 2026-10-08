<?php
declare(strict_types=1);
/**
 * Question 24: Multiple checkboxes ka data PHP mein array ke form mein kaise receive karte hain?
 *
 * INTERVIEW ANSWER: Use skills[] for multiple selected values; unchecked controls are normally absent.
 * EXPLANATION (Hinglish): Default missing skills to [], require a list of strings, limit count,
 * then use a strict allowlist. Nested/scalar/tampered values reject karo. Deduplicate only after
 * validation, and escape joined output.
 * FOLLOW-UP: Should an unknown value simply be dropped? This example rejects the request so bad
 * input is visible.
 *
 * Browser run and expected outcomes: README.md. PHP 8.1+.
 * Read lib/web.php for localhost, CSRF, method and output safeguards.
 * CODEGULLY / Monu Kumar Giri.
 */
require_once __DIR__ . '/lib/web.php';

$method = webStart();
$result = ['values' => [], 'error' => null];
if ($method === 'POST') {
    $result = validateSkills($_POST['skills'] ?? []);
    if ($result['error'] !== null) { http_response_code(422); }
}
pageStart('Q24: Checkbox arrays', 'Missing checkboxes become an empty list. Every submitted value is checked against a server allowlist.');
showErrors($result['error'] === null ? [] : [$result['error']]);
if ($method === 'POST' && $result['error'] === null) {
    echo '<p>Selected skills: ' . escapeHtml(implode(', ', $result['values']) ?: '(none)') . '</p>';
}
?>
<form method="post" action="/Question_24.php">
    <?php csrfField(); ?>
    <?php foreach (ALLOWED_SKILLS as $skill): ?>
        <label><input type="checkbox" name="skills[]" value="<?= escapeHtml($skill) ?>"
            <?= in_array($skill, $result['values'], true) ? 'checked' : '' ?>> <?= escapeHtml($skill) ?></label>
    <?php endforeach; ?>
    <button>Check skills</button>
</form>
<?php pageEnd();
