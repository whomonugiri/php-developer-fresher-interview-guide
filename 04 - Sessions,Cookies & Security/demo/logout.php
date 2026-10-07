<?php
declare(strict_types=1);
require __DIR__ . '/bootstrap.php';
demo_require_post_and_csrf();

$_SESSION = [];
demo_expire_session_cookie();
session_destroy();
header('Location: login.php', true, 303);
exit;
