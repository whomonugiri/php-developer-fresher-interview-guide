<?php
declare(strict_types=1);
require __DIR__ . '/bootstrap.php';
demo_require_auth();

$id = $_GET['id'] ?? null;
$upload = $_SESSION['upload'] ?? null;
if (!is_string($id) || !preg_match('/^[a-f0-9]{32}$/D', $id)
    || !is_array($upload) || ($upload['id'] ?? null) !== $id
    || ($upload['owner'] ?? null) !== $_SESSION['user_id']) {
    http_response_code(404);
    exit('File not found.');
}

// Rebuild the path from allowlisted server-side MIME data, not a user filename.
$extensions = ['image/png' => 'png', 'image/jpeg' => 'jpg', 'application/pdf' => 'pdf'];
$mime = $upload['mime'] ?? null;
if (!is_string($mime) || !isset($extensions[$mime])) {
    http_response_code(404);
    exit('File not found.');
}
$path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'dev-ninja-guide-private-uploads'
    . DIRECTORY_SEPARATOR . $id . '.' . $extensions[$mime];
if (!is_file($path)) {
    http_response_code(404);
    exit('File not found.');
}

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="demo-download.' . $extensions[$mime] . '"');
header('Content-Length: ' . filesize($path));
session_write_close(); // Let other requests using this session proceed while streaming.
readfile($path);
