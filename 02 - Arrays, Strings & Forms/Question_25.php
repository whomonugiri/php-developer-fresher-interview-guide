<?php
declare(strict_types=1);
/**
 * Question 25: Validation error ke baad form ki old values kaise retain karte hain?
 *
 * INTERVIEW ANSWER: A sticky form re-renders submitted values after validation errors.
 * EXPLANATION (Hinglish): Normalize scalar values, collect field errors, render value/selected
 * with HTML escaping. Password/file controls should not be prefilled with secret data. Name
 * limit here is 200 bytes, not characters. Data is validated/displayed, not sent or persisted.
 * FOLLOW-UP: Why is escaping necessary on an error page? Malicious input is still untrusted when
 * redisplayed.
 *
 * Browser run and expected outcomes: README.md. PHP 8.1+.
 * Read lib/web.php for localhost, CSRF, method and output safeguards.
 * CODEGULLY / Monu Kumar Giri.
 */
require_once __DIR__ . '/lib/web.php';

$method = webStart();
$result = $method === 'POST' ? validateEnquiry($_POST)
    : ['values' => ['name' => '', 'email' => '', 'course' => ''], 'errors' => []];
$values = $result['values'];
if ($result['errors'] !== []) { http_response_code(422); }
pageStart('Q25: Sticky enquiry form', 'Invalid submissions keep safe old values. This demo validates without saving or sending an enquiry.');
showErrors($result['errors']);
if ($method === 'POST' && $result['errors'] === []) {
    echo '<p>Namaste ' . escapeHtml($values['name']) . '! Selected: '
        . escapeHtml(COURSES[$values['course']]) . '. Validated only; nothing saved.</p>';
}
?>
<form method="post" action="/Question_25.php">
    <?php csrfField(); ?>
    <label for="name">Full name (maximum 200 bytes)</label>
    <input id="name" name="name" value="<?= escapeHtml($values['name']) ?>" required>
    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="<?= escapeHtml($values['email']) ?>" required>
    <label for="course">Course</label>
    <select id="course" name="course" required>
        <option value="">Select a course</option>
        <?php foreach (COURSES as $key => $label): ?>
            <option value="<?= escapeHtml($key) ?>" <?= $values['course'] === $key ? 'selected' : '' ?>><?= escapeHtml($label) ?></option>
        <?php endforeach; ?>
    </select>
    <p><button>Check enquiry</button></p>
</form>
<?php pageEnd();
