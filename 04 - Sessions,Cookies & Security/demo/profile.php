<?php
declare(strict_types=1);
require __DIR__ . '/bootstrap.php';
demo_require_auth();
$email = $_SESSION['email'] ?? '';
if (!is_string($email)) {
    $email = '';
}
?>
<!doctype html>
<html lang="en"><meta charset="utf-8"><title>Demo profile</title>
<h1>Protected profile</h1>
<p>Signed in as <?= demo_escape($email) ?>. Authorization is checked on this request.</p>
<p>A cookie named <code>dev_ninja_demo</code> contains a session ID, not your password or role.</p>
<p><a href="upload.php">Private upload demo</a> · <a href="cookie.php">Theme cookie demo</a></p>
<form method="post" action="logout.php">
  <input type="hidden" name="csrf" value="<?= demo_escape(demo_csrf_token()) ?>">
  <button type="submit">Log out</button>
</form>
</html>
