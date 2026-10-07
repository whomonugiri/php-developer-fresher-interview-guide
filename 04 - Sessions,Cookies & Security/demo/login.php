<?php
declare(strict_types=1);
require __DIR__ . '/bootstrap.php';

// A fixed hash for the published LOCAL demo password DemoPass!123.
// A real application fetches the hash for this email from its user database.
const DEMO_PASSWORD_HASH = '$2y$10$sk.o4xCaRHsOBBvfHv6Id.9Tx6GY.Kf0piowJCtmajEx.sM9bL1Na';
$error = '';
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    demo_require_post_and_csrf();
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;
    if (is_string($email) && is_string($password)
        && hash_equals('learner@example.test', $email)
        && password_verify($password, DEMO_PASSWORD_HASH)) {
        if (!session_regenerate_id(true)) {
            throw new RuntimeException('Could not rotate session ID.');
        }
        $_SESSION['user_id'] = 1;
        $_SESSION['email'] = 'learner@example.test';
        unset($_SESSION['csrf']);
        header('Location: profile.php', true, 303);
        exit;
    }
    $error = 'Invalid email or password.';
}
?>
<!doctype html>
<html lang="en"><meta charset="utf-8"><title>Demo login</title>
<h1>Demo login</h1>
<p>Use <code>learner@example.test</code> / <code>DemoPass!123</code> on this local demo only.</p>
<?php if ($error !== ''): ?><p role="alert"><?= demo_escape($error) ?></p><?php endif; ?>
<form method="post" action="login.php">
  <input type="hidden" name="csrf" value="<?= demo_escape(demo_csrf_token()) ?>">
  <label>Email <input type="email" name="email" required></label>
  <label>Password <input type="password" name="password" required></label>
  <button type="submit">Log in</button>
</form>
<p><a href="index.php">Back to demo</a></p>
</html>
