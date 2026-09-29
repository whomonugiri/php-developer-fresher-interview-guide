<?php
// Question 19 ka original separate processor. Definition Question_19.php mein hai.
header("Content-Type: text/html; charset=UTF-8");

if (($_SERVER["REQUEST_METHOD"] ?? "") !== "POST") {
    http_response_code(405);
    exit("Sirf POST request allowed hai.");
}

$name = $_POST["student_name"] ?? "";

// Crafted request mein string ki jagah array bhi aa sakta hai.
if (!is_string($name)) {
    http_response_code(400);
    exit("Invalid name format.");
}

$name = trim($name);
if ($name === "") {
    exit("Student name required hai.");
}

echo "Namaste, " . htmlspecialchars(
    $name,
    ENT_QUOTES | ENT_SUBSTITUTE,
    "UTF-8"
);
