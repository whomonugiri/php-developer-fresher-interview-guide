<?php
declare(strict_types=1);

// Run from ANY working directory: php path/to/examples/stream_and_paths.php
// __DIR__ is stable even when the shell's current directory changes.
$file = __DIR__ . '/data/sample.txt';
if (!is_file($file)) {
    throw new RuntimeException('Required sample file is missing.');
}
$handle = fopen($file, 'rb');
if ($handle === false) {
    throw new RuntimeException('Could not open sample file.');
}
$lines = 0;
try {
    while (($line = fgets($handle)) !== false) {
        $lines++;
        echo trim($line) . PHP_EOL;
    }
    if (!feof($handle)) {
        throw new RuntimeException('Read failed before end of file.');
    }
} finally {
    fclose($handle);
}
echo 'Lines streamed: ' . $lines . PHP_EOL;
// No file_get_contents() or full-file buffer is needed for large inputs.
