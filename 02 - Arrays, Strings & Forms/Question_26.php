<?php
/*
===============================================================================
FRESHER PHP DEVELOPER INTERVIEW GUIDE
PART 2: ARRAYS, STRINGS & FORMS
By CODEGULLY, Monu Kumar Giri
===============================================================================

QUESTION 26 | FORMS
File upload ke liye multipart/form-data aur $_FILES kyun use karte hain?

DEFINITION / INTERVIEW ANSWER — HINGLISH
-------------------------------------------------------------------------------
Normal text fields $_POST mein milte hain, lekin uploaded files ki
information $_FILES mein milti hai. HTML form se file upload karne ke liye
POST method aur enctype="multipart/form-data" use karte hain.

move_uploaded_file() PHP-uploaded temporary file ko destination par move karta hai.

DETAILED EXPLANATION — HINGLISH
-------------------------------------------------------------------------------
LOCAL PDF-UPLOAD DEMO:
Sirf public folder ko web root banao. private_uploads folder uske bahar rahega.

1. $_FILES["resume"] se uploaded file ki information read karo.
2. Upload error aur tmp_name ka expected format check karo.
3. is_uploaded_file() se genuine PHP upload verify karo.
4. Actual temporary file size check karo: non-empty aur maximum 2 MiB.
5. Server-side Fileinfo MIME detection se application/pdf check karo.
6. Original filename ki jagah random generated filename use karo.
7. move_uploaded_file() se private_uploads folder mein move karo.

PACKAGING NOTE:
Earlier upload.php ka complete example yahan Question_26.php hai. Folder
layout same safety requirement rakhta hai: only public is the web root.
Missing fileinfo extension ke liye clear error guard add kiya gaya hai.

IMPORTANT INTERVIEW POINTS / COMMON MISTAKES
-------------------------------------------------------------------------------
Browser ka accept=".pdf" aur client-supplied MIME type security guarantee nahi hain.
Server-side size/type checks aur generated filename ke baad bhi MIME match
hone se file harmless prove nahi hoti.

Production uploader ke liye authorization, CSRF protection, resource limits
aur appropriate malicious-content checks bhi chahiye. Yeh LOCAL TEACHING
DEMO hai; public production upload endpoint nahi.

EXPECTED RESULT:
Valid small PDF: PDF demo mein save ho gaya.
Wrong MIME: Sirf PDF file allowed hai.
Missing upload/error: File upload fail hua. Valid file select karein.
Saved file: ../private_uploads/<random-name>.pdf (outside public folder).

HOW TO USE THIS FILE
-------------------------------------------------------------------------------
VS Code mein comments padho aur neeche diye gaye complete examples run karo.
Expected output aur step-by-step explanation code ke paas comments mein hain.
Har Question file ko separately run karo; sabko ek saath include mat karo.

REFERENCE LINKS FROM THE EARLIER GUIDE
-------------------------------------------------------------------------------
https://www.php.net/manual/en/features.file-upload.post-method.php
https://www.php.net/manual/en/function.move-uploaded-file.php
https://cheatsheetseries.owasp.org/cheatsheets/File_Upload_Cheat_Sheet.html

CONTENT NOTE
-------------------------------------------------------------------------------
Yeh file chat mein diye gaye Question 26 ko package karti hai. Koi naya
interview topic add nahi kiya gaya. Form action/redirect filenames ko runnable
package ke paths se match kiya gaya hai; relevant changes neeche noted hain.
===============================================================================
*/

header("Content-Type: text/html; charset=UTF-8");

if (($_SERVER["REQUEST_METHOD"] ?? "") === "POST") {
    $file = $_FILES["resume"] ?? null;

    if (
        !is_array($file) ||
        ($file["error"] ?? null) !== UPLOAD_ERR_OK ||
        !is_string($file["tmp_name"] ?? null)
    ) {
        exit("File upload fail hua. Valid file select karein.");
    }

    $temporaryPath = $file["tmp_name"];
    if (!is_uploaded_file($temporaryPath)) {
        exit("Invalid uploaded file.");
    }

    $size = filesize($temporaryPath);
    $maxSize = 2 * 1024 * 1024; // 2 MiB
    if ($size === false || $size < 1 || $size > $maxSize) {
        exit("File empty nahi honi chahiye aur 2 MiB se chhoti ho.");
    }

    // Packaging guard: original example requires PHP fileinfo extension.
    if (!class_exists("finfo")) {
        exit("Is example ke liye PHP fileinfo extension enable karein.");
    }
    $fileInfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $fileInfo->file($temporaryPath);
    if ($mimeType !== "application/pdf") {
        exit("Sirf PDF file allowed hai.");
    }

    // IMPORTANT: Run with ONLY public/ as document root.
    // Question_26.php public folder ke andar hona chahiye.
    $uploadDirectory = dirname(__DIR__) . "/private_uploads";
    if (
        !is_dir($uploadDirectory) &&
        !mkdir($uploadDirectory, 0750, true)
    ) {
        exit("Upload folder create nahi ho paya.");
    }

    // Original user-supplied filename ko storage path mein use nahi kiya.
    $newFileName = bin2hex(random_bytes(16)) . ".pdf";
    $destination = $uploadDirectory . "/" . $newFileName;
    if (!move_uploaded_file($temporaryPath, $destination)) {
        exit("File save nahi ho payi.");
    }

    echo "PDF demo mein save ho gaya.";
}
?>
<!DOCTYPE html>
<html lang="hi-Latn">
<head>
    <meta charset="UTF-8">
    <title>Question 26 — Local PDF Upload Demo</title>
</head>
<body>
<form
    method="post"
    action="Question_26.php"
    enctype="multipart/form-data"
>
    <label for="resume">PDF resume</label>
    <input
        id="resume"
        type="file"
        name="resume"
        accept=".pdf"
        required
    >
    <button type="submit">Upload resume</button>
</form>
</body>
</html>
