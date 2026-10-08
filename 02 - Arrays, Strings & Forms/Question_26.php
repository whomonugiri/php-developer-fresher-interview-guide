<?php
declare(strict_types=1);
/**
 * Question 26: File upload ke liye multipart/form-data aur $_FILES kyun use karte hain?
 *
 * INTERVIEW ANSWER: multipart/form-data carries file parts; $_FILES describes uploads;
 * move_uploaded_file moves genuine uploads.
 * EXPLANATION (Hinglish): Validate PHP upload error, shape, genuine upload, actual size and
 * Fileinfo MIME. Never trust original filename or browser MIME. Save a random name outside
 * public/, with restrictive permissions. PDF MIME is not malware scanning; production also needs
 * authorization, quotas, scanning and serving controls.
 * FOLLOW-UP: Why not save user-supplied names in public/? Traversal, collisions, executable
 * content and direct unauthorized downloads.
 *
 * Browser run and expected outcomes: README.md. PHP 8.1+.
 * Read lib/web.php for localhost, CSRF, method and output safeguards.
 * CODEGULLY / Monu Kumar Giri.
 */
require_once __DIR__ . '/lib/web.php';

$method = webStart();
$error = null;
$saved = null;
if ($method === 'POST') {
    $file = $_FILES['resume'] ?? null;
    if (!is_array($file) || !is_int($file['error'] ?? null) || !is_string($file['tmp_name'] ?? null)) {
        $error = 'Choose one PDF file; malformed or nested file fields are rejected.';
    } elseif ($file['error'] !== UPLOAD_ERR_OK) {
        $error = uploadPolicy($file['error'], false, false);
    } elseif (!is_uploaded_file($file['tmp_name'])) {
        $error = 'A genuine HTTP upload is required.';
    } elseif (!class_exists('finfo')) {
        $error = 'Enable PHP Fileinfo to run the upload exercise.';
        http_response_code(503);
    } else {
        $size = filesize($file['tmp_name']); // Do not trust the browser-supplied size/type/name.
        $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
        $error = uploadPolicy($file['error'], $size, $mime);
        if ($error === null) {
            $directory = __DIR__ . '/storage/uploads'; // Outside the enforced public/ web root.
            if (!is_dir($directory) && !mkdir($directory, 0700, true) && !is_dir($directory)) {
                $error = 'Private storage could not be created.';
                http_response_code(500);
            } else {
                $saved = bin2hex(random_bytes(16)) . '.pdf';
                $destination = $directory . '/' . $saved;
                $moved = move_uploaded_file($file['tmp_name'], $destination);
                // A rename can preserve source permissions; umask alone is insufficient.
                if ($moved && !chmod($destination, 0600)) {
                    unlink($destination);
                    $moved = false;
                }
                if (!$moved) {
                    $saved = null;
                    $error = 'The upload could not be moved into private storage.';
                    http_response_code(500);
                }
            }
        }
    }
    if ($error !== null && http_response_code() < 400) { http_response_code(422); }
}
pageStart('Q26: Local PDF upload', 'Use a fictional PDF (1 byte to 2 MiB). The file is saved outside public/ and has no download endpoint.');
showErrors($error === null ? [] : [$error]);
if ($saved !== null && $error === null) {
    echo '<p>Saved privately as ' . escapeHtml($saved) . '. Delete the demo file from storage/uploads after testing.</p>';
}
?>
<form method="post" action="/Question_26.php" enctype="multipart/form-data">
    <?php csrfField(); ?>
    <label for="resume">Fictional PDF</label>
    <input id="resume" type="file" name="resume" accept="application/pdf,.pdf" required>
    <button>Save local demo PDF</button>
</form>
<p>MIME detection cannot prove a PDF is harmless. This is not a production uploader.</p>
<?php pageEnd();
