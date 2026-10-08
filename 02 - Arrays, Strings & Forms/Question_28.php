<?php
declare(strict_types=1);
/**
 * Question 28: hidden, readonly aur disabled fields mein kya difference hai? Kya inki values
 * trust kar sakte hain?
 *
 * INTERVIEW ANSWER: hidden and readonly values submit; disabled controls normally do not. None
 * are trusted inputs.
 * EXPLANATION (Hinglish): Client can edit/recreate every field. Validate course against server
 * allowlist and calculate fee from the server-owned price list; ignore posted fee/coupon. Actual
 * purchase authorization is separate; this example only displays a demo fee.
 * FOLLOW-UP: What if the client posts fee=1 for course=php? The server still returns the
 * configured fee of 2500.
 *
 * Browser run and expected outcomes: README.md. PHP 8.1+.
 * Read lib/web.php for localhost, CSRF, method and output safeguards.
 * CODEGULLY / Monu Kumar Giri.
 */
require_once __DIR__ . '/lib/web.php';

$method = webStart();
$fee = null;
$error = null;
if ($method === 'POST') {
    $fee = courseFee($_POST['course'] ?? null);
    if ($fee === null) { $error = 'Choose an allowed course.'; http_response_code(422); }
    // Deliberately ignore $_POST['fee'] and $_POST['coupon'].
}
pageStart('Q28: Hidden, readonly and disabled', 'The server selects the fee from its own price list. Client controls cannot authorize a price.');
showErrors($error === null ? [] : [$error]);
if ($fee !== null) { echo '<p>Server course fee: ₹' . $fee . '</p>'; }
?>
<form method="post" action="/Question_28.php">
    <?php csrfField(); ?>
    <input type="hidden" name="course" value="php">
    <label>Displayed fee <input name="fee" value="2500" readonly></label>
    <label>Demo coupon <input name="coupon" value="NONE" disabled></label>
    <button>Check demo fee</button>
</form>
<?php pageEnd();
