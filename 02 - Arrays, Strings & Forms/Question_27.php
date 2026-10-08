<?php
declare(strict_types=1);
/**
 * Question 27: Form submit karne ke baad refresh par resubmission avoid kaise karte hain?
 *
 * INTERVIEW ANSWER: Post/Redirect/Get processes POST then sends 303 to a GET result page.
 * EXPLANATION (Hinglish): header must precede output and redirect ke baad exit zaroori hai.
 * Session flash keeps the result without exposing names in a URL. Refresh of the final GET does
 * not repost. PRG does not stop concurrent/double-click submissions; production needs
 * idempotency rules.
 * FOLLOW-UP: Why use 303 rather than 307? 303 changes the follow-up to GET; 307 preserves the
 * original method.
 *
 * Browser run and expected outcomes: README.md. PHP 8.1+.
 * Read lib/web.php for localhost, CSRF, method and output safeguards.
 * CODEGULLY / Monu Kumar Giri.
 */
require_once __DIR__ . '/lib/web.php';

$method = webStart();
$name = '';
$error = null;
if ($method === 'POST') {
    $name = textField($_POST, 'name') ?? '';
    $error = validateName($_POST['name'] ?? null);
    if ($error === null) {
        $_SESSION['prg_name'] = $name; // Short-lived flash data, no database write.
        header('Location: /support/question_27/thank-you.php', true, 303);
        exit; // No response body before the redirect.
    }
    http_response_code(422);
}
pageStart('Q27: Post/Redirect/Get', 'A valid POST redirects with 303 to a GET page. PRG does not provide idempotency for repeated POST requests.');
showErrors($error === null ? [] : [$error]);
?>
<form method="post" action="/Question_27.php">
    <?php csrfField(); ?>
    <label for="name">Name</label>
    <input id="name" name="name" value="<?= escapeHtml($name) ?>" required>
    <button>Continue</button>
</form>
<?php pageEnd();
