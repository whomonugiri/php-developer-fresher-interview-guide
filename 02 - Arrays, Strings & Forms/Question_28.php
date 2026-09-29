<?php
/*
===============================================================================
FRESHER PHP DEVELOPER INTERVIEW GUIDE
PART 2: ARRAYS, STRINGS & FORMS
By CODEGULLY, Monu Kumar Giri
===============================================================================

QUESTION 28 | FORMS
hidden, readonly aur disabled fields mein kya difference hai? Kya inki values trust kar sakte hain?

DEFINITION / INTERVIEW ANSWER — HINGLISH
-------------------------------------------------------------------------------
Hidden input screen par visible nahi hota, lekin form ke saath submit hota
hai. Readonly text input normal editing prevent karta hai, lekin uski value
submit hoti hai. Disabled controls normally form submission mein include
nahi hote.

Hidden ya readonly hona value ko trustworthy nahi banata. User request
modify kar sakta hai.

DETAILED EXPLANATION — HINGLISH
-------------------------------------------------------------------------------
EXAMPLE: Course fee server se decide hogi.
Trusted server array: php => 2500, web => 4000.
Form course hidden input mein bhejta hai; displayed fee readonly input hai.
Coupon disabled hai, isliye normal form submission mein include nahi hoga.

Server course ka type aur allowed key check karta hai, phir trusted array
se actual fee leta hai. Client ke posted fee ko use nahi karta.

IMPORTANT INTERVIEW POINTS / COMMON MISTAKES
-------------------------------------------------------------------------------
Koi fee=1 bhej de, tab bhi server ke trusted courseFees array se PHP course
ke liye 2500 calculate hoga. Readonly input ko security control nahi maana gaya.

EXPECTED RESULT:
Normal submit for php: Course fee: ₹2500
Tampered posted fee=1 but course=php: Course fee: ₹2500
Unknown course: Invalid course.

Form fields ki visibility/editability validation ka substitute nahi hai.

HOW TO USE THIS FILE
-------------------------------------------------------------------------------
VS Code mein comments padho aur neeche diye gaye complete examples run karo.
Expected output aur step-by-step explanation code ke paas comments mein hain.
Har Question file ko separately run karo; sabko ek saath include mat karo.

REFERENCE LINKS FROM THE EARLIER GUIDE
-------------------------------------------------------------------------------
https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Attributes/disabled
https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Attributes/readonly
https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/input/hidden

CONTENT NOTE
-------------------------------------------------------------------------------
Yeh file chat mein diye gaye Question 28 ko package karti hai. Koi naya
interview topic add nahi kiya gaya. Form action/redirect filenames ko runnable
package ke paths se match kiya gaya hai; relevant changes neeche noted hain.
===============================================================================
*/

header("Content-Type: text/html; charset=UTF-8");

$courseFees = [
    "php" => 2500,
    "web" => 4000
];

if (($_SERVER["REQUEST_METHOD"] ?? "") === "POST") {
    $course = $_POST["course"] ?? "";

    if (
        !is_string($course) ||
        !array_key_exists($course, $courseFees)
    ) {
        exit("Invalid course.");
    }

    // Client ke posted fee ko trust nahi kiya.
    $actualFee = $courseFees[$course];
    echo "Course fee: ₹" . $actualFee;
}
?>
<!DOCTYPE html>
<html lang="hi-Latn">
<head>
    <meta charset="UTF-8">
    <title>Question 28 — Hidden, Readonly and Disabled</title>
</head>
<body>
<form method="post">
    <input type="hidden" name="course" value="php">
    <label>
        Displayed fee:
        <input type="text" name="fee" value="2500" readonly>
    </label>
    <label>
        Demo coupon:
        <input type="text" name="coupon" value="NONE" disabled>
    </label>
    <button type="submit">Check fee</button>
</form>
</body>
</html>
