<?php
declare(strict_types=1);
/**
 * Question 19: HTML form ka data PHP tak kaise pahunchta hai? action, method, name aur id ka kya
 * role hai?
 *
 * INTERVIEW ANSWER: action is the destination, method the HTTP verb, name the submitted key, id
 * a DOM/label identifier.
 * EXPLANATION (Hinglish): GET displays this form; POST validates student_name. Scalar input
 * expected hone par arrays reject karo. HTML required server-side validation replace nahi karta.
 * Shared web bootstrap checks CSRF and request method before processing.
 * FOLLOW-UP: If an input has only id="name", what key reaches PHP? None: successful controls
 * need a name.
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
    $name = textField($_POST, 'student_name') ?? '';
    $error = validateName($_POST['student_name'] ?? null);
    if ($error !== null) { http_response_code(422); }
}
pageStart('Q19: Form fields and PHP', 'name="student_name" becomes the PHP key; id="student-name" connects the label.');
showErrors($error === null ? [] : [$error]);
if ($method === 'POST' && $error === null) {
    echo '<p>Namaste, ' . escapeHtml($name) . '</p>';
}
nameForm('/Question_19.php', $name);
echo '<p><a href="/support/question_19/form.php">Try the separate form and processor</a></p>';
pageEnd();
