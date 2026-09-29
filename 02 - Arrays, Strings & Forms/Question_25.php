<?php
/*
===============================================================================
FRESHER PHP DEVELOPER INTERVIEW GUIDE
PART 2: ARRAYS, STRINGS & FORMS
By CODEGULLY, Monu Kumar Giri
===============================================================================

QUESTION 25 | FORMS
Validation error ke baad form ki old values kaise retain karte hain?

DEFINITION / INTERVIEW ANSWER — HINGLISH
-------------------------------------------------------------------------------
Jab validation fail ho aur user ka entered data form mein preserve rahe,
usse commonly sticky form bolte hain. Text fields mein old value wapas set
karte hain aur dropdown mein matching option ko selected mark karte hain.

User-entered values ko HTML mein wapas render karte waqt escape karna zaroori hai.

DETAILED EXPLANATION — HINGLISH
-------------------------------------------------------------------------------
COMPLETE PRACTICAL EXAMPLE: Course enquiry form.
Yeh demo data validate aur display karta hai; database mein save nahi karta.

1. escapeHtml() repeated HTML escaping ko reusable function mein rakhta hai.
2. postText() string input ko trim karta hai; wrong/missing type par empty string.
3. $courses associative array se dropdown options generate hote hain.
4. $errors array mein validation errors collect hote hain.
5. Name required hai; example ka server limit 200 bytes hai.
6. Email format aur allowed course key validate karte hain.
7. value attribute mein old name/email render karte hain.
8. Matching course option ko selected mark karte hain.
9. All validation pass hone par confirmation display hota hai, save nahi.

PACKAGING NOTE: Earlier course-enquiry.php filename ab Question_25.php hai.

IMPORTANT INTERVIEW POINTS / COMMON MISTAKES
-------------------------------------------------------------------------------
Name ka demonstrated strlen() limit 200 BYTES hai, 200 characters nahi.
Array-based dropdown se aaya course bhi server-side validate hota hai.
Sticky values output karte waqt htmlspecialchars() remove mat karo.

EXPECTED RESULT:
Valid name/email/course: personalised confirmation + demo-not-saved message.
Invalid email: error message aur previously entered values retained.
Missing/unknown course: Valid course select karein.

VIDEO CONNECTION:
$errors ek array hai, trim() string process karta hai, dropdown array se
banta hai aur form data PHP validate karta hai. Teenon topics ek demo mein.

HOW TO USE THIS FILE
-------------------------------------------------------------------------------
VS Code mein comments padho aur neeche diye gaye complete examples run karo.
Expected output aur step-by-step explanation code ke paas comments mein hain.
Har Question file ko separately run karo; sabko ek saath include mat karo.

REFERENCE LINKS FROM THE EARLIER GUIDE
-------------------------------------------------------------------------------
https://www.php.net/manual/en/function.htmlspecialchars.php

CONTENT NOTE
-------------------------------------------------------------------------------
Yeh file chat mein diye gaye Question 25 ko package karti hai. Koi naya
interview topic add nahi kiya gaya. Form action/redirect filenames ko runnable
package ke paths se match kiya gaya hai; relevant changes neeche noted hain.
===============================================================================
*/

header("Content-Type: text/html; charset=UTF-8");

print_r($_POST);
function escapeHtml(string $value): string
{
    return htmlspecialchars(
        $value,
        ENT_QUOTES | ENT_SUBSTITUTE,
        "UTF-8"
    );
}

function postText(string $key): string
{
    $value = $_POST[$key] ?? "";
    return is_string($value) ? trim($value) : "";
}

$courses = [
    "php" => "PHP Development",
    "web" => "Web Development",
    "bca" => "BCA Coaching"
];

$name = "";
$email = "";
$course = "";
$errors = [];
$success = false;

if (($_SERVER["REQUEST_METHOD"] ?? "") === "POST") {
    $name = postText("name");
    $email = postText("email");
    $course = postText("course");

    if ($name === "") {
        $errors[] = "Apna naam enter karein.";
    } elseif (strlen($name) > 200) {
        // Demo server limit: 200 bytes, not 200 characters.
        $errors[] = "Naam bahut lamba hai.";
    }

    if (
        $email === "" ||
        filter_var($email, FILTER_VALIDATE_EMAIL) === false
    ) {
        $errors[] = "Valid email address enter karein.";
    }

    if (!array_key_exists($course, $courses)) {
        $errors[] = "Valid course select karein.";
    }

    $success = ($errors === []);
}
?>
<!DOCTYPE html>
<html lang="hi-Latn">
<head>
    <meta charset="UTF-8">
    <title>Course Enquiry — Question 25</title>
</head>
<body>
<h1>Course Enquiry</h1>

<?php foreach ($errors as $error): ?>
    <p style="color: red;">
        <?= escapeHtml($error) ?>
    </p>
<?php endforeach; ?>

<?php if ($success): ?>
    <p>
        Namaste <?= escapeHtml($name) ?>!
        Aapne <?= escapeHtml($courses[$course]) ?> select kiya.
    </p>
    <p>Input valid hai. Is demo mein data save nahi hua.</p>
<?php endif; ?>

<form method="post" action="Question_25.php">
    <p>
        <label for="name">Full name</label><br>
        <input
            id="name"
            type="text"
            name="name"
            value="<?= escapeHtml($name) ?>"
            required
        >
    </p>
    <p>
        <label for="email">Email</label><br>
        <input
            id="email"
            type="email"
            name="email"
            value="<?= escapeHtml($email) ?>"
            required
        >
    </p>
    <p>
        <label for="course">Course</label><br>
        <select id="course" name="course" required>
            <option value="">Select course</option>

            <?php foreach ($courses as $key => $label): ?>

                <option
                    value="<?= escapeHtml($key) ?>"
                    <?= $course === $key ? "selected" : "" ?>
                >
                    <?= escapeHtml($label) ?>
                </option>

            <?php endforeach; ?>
        </select>
    </p>
    <button type="submit">Check enquiry</button>
</form>
</body>
</html>
