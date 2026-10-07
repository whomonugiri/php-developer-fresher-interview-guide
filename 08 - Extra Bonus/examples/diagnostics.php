<?php
declare(strict_types=1);

// Run: php examples/diagnostics.php
// Keep these details in a protected CLI/admin context; do not expose phpinfo()
// or server paths to anonymous web visitors.
$requestId = bin2hex(random_bytes(8));
echo 'Request ID: ' . $requestId . PHP_EOL;
echo 'SAPI: ' . PHP_SAPI . PHP_EOL;
echo 'PHP version: ' . PHP_VERSION . PHP_EOL;
echo 'Loaded ini: ' . (php_ini_loaded_file() ?: 'none') . PHP_EOL;
echo 'Memory limit: ' . ini_get('memory_limit') . PHP_EOL;
echo 'Execution limit: ' . ini_get('max_execution_time') . PHP_EOL;
echo 'Upload limit: ' . ini_get('upload_max_filesize') . PHP_EOL;
echo 'POST limit: ' . ini_get('post_max_size') . PHP_EOL;
echo 'OPcache extension: ' . (extension_loaded('Zend OPcache') ? 'loaded' : 'not loaded') . PHP_EOL;
// Include the same request ID in protected logs across services. Never log
// request passwords, authorization headers, reset tokens or full session IDs.
