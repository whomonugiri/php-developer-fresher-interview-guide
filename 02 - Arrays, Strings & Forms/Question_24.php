<?php
/*
===============================================================================
FRESHER PHP DEVELOPER INTERVIEW GUIDE
PART 2: ARRAYS, STRINGS & FORMS
By CODEGULLY, Monu Kumar Giri
===============================================================================

QUESTION 24 | FORMS
Multiple checkboxes ka data PHP mein array ke form mein kaise receive karte hain?

DEFINITION / INTERVIEW ANSWER — HINGLISH
-------------------------------------------------------------------------------
Multiple selected values receive karne ke liye input ke name mein square
brackets use karte hain, jaise skills[]. PHP un values ko array ke form
mein receive karta hai.

Unchecked checkboxes normally submit nahi hote, isliye missing field ke liye
default empty array handle karna chahiye.

DETAILED EXPLANATION — HINGLISH
-------------------------------------------------------------------------------
$_POST["skills"] ?? [] se missing selection empty array ban jati hai.
is_array() outer input type validate karta hai.
Har skill string honi chahiye aur allowedSkills mein strictly present honi chahiye.
array_unique() duplicates remove karta hai; array_values() keys reset karta hai.
implode() selected skills ko readable comma-separated string banata hai.
Final display htmlspecialchars() se HTML-escaped hai.

PACKAGING NOTE: Earlier skills.php ka action ab Question_24.php hai.

IMPORTANT INTERVIEW POINTS / COMMON MISTAKES
-------------------------------------------------------------------------------
Sirf browser mein teen options dikhane se server par wahi teen values aayengi,
yeh assume mat karo. Server-side allowed-values check bhi karo.

EXPECTED RESULT:
PHP aur MySQL selected: Selected skills: PHP, MySQL
No selection: Koi skill select nahi hui.
Scalar input instead of array: Skills ka format invalid hai.
Unknown/nested skill value: Invalid skill selected.

HOW TO USE THIS FILE
-------------------------------------------------------------------------------
VS Code mein comments padho aur neeche diye gaye complete examples run karo.
Expected output aur step-by-step explanation code ke paas comments mein hain.
Har Question file ko separately run karo; sabko ek saath include mat karo.

REFERENCE LINKS FROM THE EARLIER GUIDE
-------------------------------------------------------------------------------
https://www.php.net/manual/en/language.variables.external.php
https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/input/checkbox
https://cheatsheetseries.owasp.org/cheatsheets/Input_Validation_Cheat_Sheet.html

CONTENT NOTE
-------------------------------------------------------------------------------
Yeh file chat mein diye gaye Question 24 ko package karti hai. Koi naya
interview topic add nahi kiya gaya. Form action/redirect filenames ko runnable
package ke paths se match kiya gaya hai; relevant changes neeche noted hain.
===============================================================================
*/

header("Content-Type: text/html; charset=UTF-8");



if (($_SERVER["REQUEST_METHOD"] ?? "") === "POST") {


    $skills = $_POST["skills"] ?? [];
    $allowedSkills = ["PHP", "MySQL", "JavaScript"];

    if (!is_array($skills)) {
        exit("Skills ka format invalid hai.");
    }

    foreach ($skills as $skill) {
        if (
            !is_string($skill) ||
            !in_array($skill, $allowedSkills, true)
        ) {
            exit("Invalid skill selected.");
        }
    }

    $skills = array_values(array_unique($skills));
    if ($skills === []) {
        echo "Koi skill select nahi hui.";
    } else {
        echo "Selected skills: " . htmlspecialchars(
            implode(", ", $skills),
            ENT_QUOTES | ENT_SUBSTITUTE,
            "UTF-8"
        );
    }
}
?>
<!DOCTYPE html>
<html lang="hi-Latn">
<head>
    <meta charset="UTF-8">
    <title>Question 24 — Checkbox Arrays</title>
</head>
<body>
<form method="post" action="Question_24.php">
    <label>
        <input type="checkbox" name="skills[]" value="PHP">
        PHP
    </label>
    <label>
        <input type="checkbox" name="skills[]" value="MySQL">
        MySQL
    </label>
    <label>
        <input type="checkbox" name="skills[]" value="JavaScript">
        JavaScript
    </label>
    <button type="submit">Submit skills</button>
</form>
</body>
</html>
