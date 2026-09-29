<?php
/*
===============================================================================
FRESHER PHP DEVELOPER INTERVIEW GUIDE
PART 2: ARRAYS, STRINGS & FORMS
By CODEGULLY, Monu Kumar Giri
===============================================================================

QUESTION 21 | FORMS
$_GET, $_POST aur $_REQUEST kya hain? Form input ka data type kya hota hai?

DEFINITION / INTERVIEW ANSWER — HINGLISH
-------------------------------------------------------------------------------
Ye PHP ke superglobal arrays hain. $_GET URL query parameters contain karta
hai. $_POST supported form-encoded POST body ke fields contain karta hai.

$_REQUEST mein GET, POST aur potentially cookie values ka combination aa
sakta hai; exact inclusion aur priority PHP configuration par depend karti hai.
Isliye expected source explicitly use karna clearer hai.

DETAILED EXPLANATION — HINGLISH
-------------------------------------------------------------------------------
Normal HTML form ke scalar values generally strings hoti hain. Bracket-style
field names se arrays bhi aa sakte hain.

Age input se "21" string receive ho sakti hai. Pehle is_string() check karke
FILTER_VALIDATE_INT aur allowed range 0..120 lagayi hai. Valid result integer
hoga. Validation fail ho toh false aayega.

POST request ke URL mein query string ho toh $_GET bhi populated ho sakta hai.
JSON request body automatically $_POST mein decode nahi hoti.

PACKAGING NOTE:
Earlier processing snippet complete neeche hai. Use browser se try karne
ke liye ek small age form add kiya gaya hai; processing sirf POST par chalegi.
Yeh convenience form hai, additional interview topic nahi.

IMPORTANT INTERVIEW POINTS / COMMON MISTAKES
-------------------------------------------------------------------------------
Number input ka value automatically trusted integer assume mat karo.
Explicit input source aur expected type check karo.
false ko === false se check karo, kyunki integer 0 valid result ho sakta hai.

EXPECTED RESULT:
21 submit: int(21)
0 submit: int(0)
Out-of-range/non-integer input: Valid age enter karein.
Array input: Age single value honi chahiye.

HOW TO USE THIS FILE
-------------------------------------------------------------------------------
VS Code mein comments padho aur neeche diye gaye complete examples run karo.
Expected output aur step-by-step explanation code ke paas comments mein hain.
Har Question file ko separately run karo; sabko ek saath include mat karo.

REFERENCE LINKS FROM THE EARLIER GUIDE
-------------------------------------------------------------------------------
https://www.php.net/manual/en/reserved.variables.get.php
https://www.php.net/manual/en/reserved.variables.post.php
https://www.php.net/manual/en/reserved.variables.request.php
https://www.php.net/manual/en/language.variables.external.php

CONTENT NOTE
-------------------------------------------------------------------------------
Yeh file chat mein diye gaye Question 21 ko package karti hai. Koi naya
interview topic add nahi kiya gaya. Form action/redirect filenames ko runnable
package ke paths se match kiya gaya hai; relevant changes neeche noted hain.
===============================================================================
*/

header("Content-Type: text/html; charset=UTF-8");

print_r($_REQUEST);
print_r($_POST);


if (($_SERVER["REQUEST_METHOD"] ?? "") === "POST") {
    // Example: number input se "21" receive hua.
    $ageInput = $_POST["age"] ?? "";

    if (!is_string($ageInput)) {
        exit("Age single value honi chahiye.");
    }

    $age = filter_var(
        $ageInput,
        FILTER_VALIDATE_INT,
        ["options" => ["min_range" => 0, "max_range" => 120]]
    );

    if ($age === false) {
        echo "Valid age enter karein.";
    } else {
        echo "<pre>";
        var_dump($age);
        // Valid input ke liye integer, for example int(21).
        echo "</pre>";
    }
}
?>
<!DOCTYPE html>
<html lang="hi-Latn">
<head>
    <meta charset="UTF-8">
    <title>Question 21 — Form Data Types</title>
</head>
<body>
<!-- Convenience form: upar ke original validation example ko test karo. -->
<form method="GET" action="Question_21.php">
    <label for="age">Age</label>
    <input id="age" type="number" name="age" min="0" max="120" value="21" required>
    <button type="submit">Check age</button>
</form>
</body>
</html>
