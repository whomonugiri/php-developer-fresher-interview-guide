<?php
declare(strict_types=1);

// Tiny local autoloader. Composer's PSR-4 loader is preferable for real projects.
spl_autoload_register(static function (string $class): void {
    $prefix = 'DevNinja\\Part5\\';
    if (!str_starts_with($class, $prefix)) {
        return;
    }
    $relative = substr($class, strlen($prefix));
    if (!preg_match('/^[A-Za-z][A-Za-z0-9_]*$/D', $relative)) {
        return;
    }
    $file = __DIR__ . '/src/' . $relative . '.php';
    if (is_file($file)) {
        require $file;
    }
});
