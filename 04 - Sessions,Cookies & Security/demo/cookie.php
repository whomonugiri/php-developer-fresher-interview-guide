<?php
declare(strict_types=1);
require __DIR__ . '/bootstrap.php';

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    demo_require_post_and_csrf();
    $action = $_POST['action'] ?? null;
    if ($action !== 'dark' && $action !== 'light' && $action !== 'delete') {
        http_response_code(400);
        exit('Invalid preference.');
    }
    setcookie('demo_theme', $action === 'delete' ? '' : $action, [
        'expires' => $action === 'delete' ? time() - 3600 : time() + 86400 * 30,
        'path' => demo_cookie_path(),
        'secure' => demo_https(),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    header('Location: cookie.php', true, 303);
    exit;
}

// A cookie is user-controlled. Only these harmless display values are accepted.
$theme = $_COOKIE['demo_theme'] ?? null;
if ($theme !== 'dark' && $theme !== 'light') {
    $theme = 'none';
}
?>
<!doctype html>
<html lang="en"><meta charset="utf-8"><title>Cookie demo</title>
<h1>Cookie preference</h1>
<p>Current preference on this request: <?= demo_escape($theme) ?>.</p>
<p>After a POST, the browser stores or deletes the cookie and sends the new state on the redirected GET.</p>
<form method="post" action="cookie.php">
  <input type="hidden" name="csrf" value="<?= demo_escape(demo_csrf_token()) ?>">
  <button name="action" value="dark">Dark</button>
  <button name="action" value="light">Light</button>
  <button name="action" value="delete">Delete preference</button>
</form>
<p><a href="index.php">Back to demo</a></p>
</html>
