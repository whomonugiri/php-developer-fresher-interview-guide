<?php
// Question 27 ka original separate PRG sample.
// Important: header() se pehle output nahi bhejna.
header("Content-Type: text/html; charset=UTF-8");

if (($_SERVER["REQUEST_METHOD"] ?? "") === "POST") {
    $name = $_POST["name"] ?? "";
    if (!is_string($name) || trim($name) === "") {
        exit("Valid name required hai.");
    }

    // Demo mein sirf validation hui hai, database save nahi.
    header("Location: thank-you.php", true, 303);
    exit;
}
?>
<!DOCTYPE html>
<html lang="hi-Latn">
<head>
    <meta charset="UTF-8">
    <title>Question 27 — Original PRG Sample</title>
</head>
<body>
<form method="post" action="prg.php">
    <input type="text" name="name" required>
    <button type="submit">Continue</button>
</form>
</body>
</html>
