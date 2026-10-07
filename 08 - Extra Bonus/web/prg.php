<?php
declare(strict_types=1);

// Harmless Post/Redirect/Get exercise: no database write or persistent state.
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $name = $_POST['name'] ?? null;
    if (!is_string($name) || trim($name) === '') {
        http_response_code(422);
        exit('A name is required.');
    }
    header('Location: prg.php?done=1', true, 303);
    exit; // The redirect must stop processing before rendering HTML.
}
header('Content-Type: text/html; charset=UTF-8');
header('X-Content-Type-Options: nosniff');
header("Content-Security-Policy: default-src 'none'; form-action 'self'; base-uri 'none'");
$done = ($_GET['done'] ?? null) === '1';
?>
<!doctype html>
<html lang="en"><meta charset="utf-8"><title>PRG demo</title>
<h1>Post / Redirect / Get</h1>
<?php if ($done): ?><p>Demo complete. Refresh is now a GET.</p><?php endif; ?>
<form method="post" action="prg.php">
  <label>Name <input name="name" required></label>
  <button type="submit">Continue</button>
</form>
</html>
