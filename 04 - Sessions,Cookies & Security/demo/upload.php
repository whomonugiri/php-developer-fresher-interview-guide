<?php
declare(strict_types=1);
require __DIR__ . '/bootstrap.php';
demo_require_auth();

// Store files in the OS temp folder, never in this web-served repository.
// A real application needs durable private storage, quotas and cleanup jobs.
$storage = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'dev-ninja-guide-private-uploads';
$docroot = realpath($_SERVER['DOCUMENT_ROOT'] ?? '') ?: '';
$tempRoot = realpath(sys_get_temp_dir());
if ($tempRoot === false || ($docroot !== '' && str_starts_with(strtolower($tempRoot . DIRECTORY_SEPARATOR), strtolower($docroot . DIRECTORY_SEPARATOR)))) {
    throw new RuntimeException('Private upload storage is not outside the web root.');
}

$error = '';
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    demo_require_post_and_csrf();
    $file = $_FILES['document'] ?? null;
    if (!is_array($file) || !isset($file['error'], $file['size'], $file['tmp_name'])
        || !is_int($file['error']) || $file['error'] !== UPLOAD_ERR_OK
        || !is_int($file['size']) || $file['size'] < 1 || $file['size'] > 1048576
        || !is_string($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
        $error = 'Choose a nonempty PNG, JPEG or PDF up to 1 MB.';
    } else {
        $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
        $extensions = ['image/png' => 'png', 'image/jpeg' => 'jpg', 'application/pdf' => 'pdf'];
        if (!is_string($mime) || !isset($extensions[$mime])) {
            $error = 'Only PNG, JPEG or PDF files are accepted.';
        } else {
            if (!is_dir($storage) && !mkdir($storage, 0700) && !is_dir($storage)) {
                throw new RuntimeException('Could not create private upload storage.');
            }
            $id = bin2hex(random_bytes(16));
            $name = $id . '.' . $extensions[$mime];
            if (!move_uploaded_file($file['tmp_name'], $storage . DIRECTORY_SEPARATOR . $name)) {
                throw new RuntimeException('Could not store upload.');
            }
            // Metadata is in this server-side session, never supplied by the browser.
            $_SESSION['upload'] = ['id' => $id, 'name' => $name, 'mime' => $mime, 'owner' => $_SESSION['user_id']];
            header('Location: upload.php', true, 303);
            exit;
        }
    }
}
$upload = $_SESSION['upload'] ?? null;
?>
<!doctype html>
<html lang="en"><meta charset="utf-8"><title>Private upload demo</title>
<h1>Private upload and authorized download</h1>
<p>PNG, JPEG or PDF; 1 MB maximum. The original filename is discarded.</p>
<?php if ($error !== ''): ?><p role="alert"><?= demo_escape($error) ?></p><?php endif; ?>
<form method="post" action="upload.php" enctype="multipart/form-data">
  <input type="hidden" name="csrf" value="<?= demo_escape(demo_csrf_token()) ?>">
  <input type="hidden" name="MAX_FILE_SIZE" value="1048576">
  <label>File <input type="file" name="document" accept=".png,.jpg,.jpeg,.pdf" required></label>
  <button type="submit">Upload</button>
</form>
<?php if (is_array($upload) && isset($upload['id']) && is_string($upload['id'])): ?>
  <p><a href="download.php?id=<?= demo_escape($upload['id']) ?>">Download the last file uploaded in this session</a></p>
<?php endif; ?>
<p><a href="profile.php">Back to profile</a></p>
</html>
