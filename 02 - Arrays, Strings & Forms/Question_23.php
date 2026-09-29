<?php
/*
===============================================================================
FRESHER PHP DEVELOPER INTERVIEW GUIDE
PART 2: ARRAYS, STRINGS & FORMS
By CODEGULLY, Monu Kumar Giri
===============================================================================

QUESTION 23 | FORMS
Email, fresher experience aur mobile-number input validate kaise karenge?

DEFINITION / INTERVIEW ANSWER — HINGLISH
-------------------------------------------------------------------------------
Har field ke liye uski requirement ke according validation honi chahiye.
Email ke liye email-format validation, experience ke liye integer range,
aur mobile ke liye application-defined number format check kar sakte hain.

FILTER_VALIDATE_EMAIL aur FILTER_VALIDATE_INT respective validation provide
karte hain. preg_match() custom pattern check ke liye use kar sakte hain.

DETAILED EXPLANATION — HINGLISH
-------------------------------------------------------------------------------
Email: filter_var($email, FILTER_VALIDATE_EMAIL).
Experience: Integer range 0..50; fresher ka 0 years valid hai.
Mobile: Demo rule exactly 10 ASCII digits hai, bina +91 ke.

Mobile pattern /\A[0-9]{10}\z/ complete string ko check karta hai.
Yeh demo format rule hai; universal telephone validation ka claim nahi hai.

IMPORTANT INTERVIEW POINTS / COMMON MISTAKES
-------------------------------------------------------------------------------
Mobile aur email ka format valid hona unke active hone ya user ke ownership
ka proof nahi hai.

Mobile number ko identifier ki tarah string mein rakho; use arithmetic value
samajhkar integer mein convert karna zaroori nahi. International support add
karte waqt country code aur validation rules explicitly design karo.

Neeche fixed demo values hain. Real form mein $_POST se lene par type checks bhi karo.

HOW TO USE THIS FILE
-------------------------------------------------------------------------------
VS Code mein comments padho aur neeche diye gaye complete examples run karo.
Expected output aur step-by-step explanation code ke paas comments mein hain.
Har Question file ko separately run karo; sabko ek saath include mat karo.

REFERENCE LINKS FROM THE EARLIER GUIDE
-------------------------------------------------------------------------------
https://www.php.net/manual/en/function.filter-var.php
https://www.php.net/manual/en/function.preg-match.php

CONTENT NOTE
-------------------------------------------------------------------------------
Yeh file chat mein diye gaye Question 23 ko package karti hai. Koi naya
interview topic add nahi kiya gaya. Form action/redirect filenames ko runnable
package ke paths se match kiya gaya hai; relevant changes neeche noted hain.
===============================================================================
*/

header("Content-Type: text/html; charset=UTF-8");

// Demo values: real form mein type-check karke $_POST se lo.
$email = "priya@example.com";
$experienceInput = "0";
$mobile = "7669006847";

// EXAMPLE 1: Email format.
if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    echo "Invalid email.<br>";
} else {
    echo "Email format valid hai.<br>";
}

// EXAMPLE 2: Experience — fresher ke liye 0 valid hai.
$experience = filter_var(
    $experienceInput,
    FILTER_VALIDATE_INT,
    ["options" => ["min_range" => 0, "max_range" => 50]]
);


if ($experience === false) {
    echo "Invalid experience.<br>";
} else {
    echo "Experience: $experience years.<br>";
}

// EXAMPLE 3: Exactly 10 ASCII digits, without +91 (demo requirement).
if (preg_match('/\A[0-9]{10}\z/', $mobile) === 1) {
    echo "Mobile ka demo format valid hai.";
} else {
    echo "10 digits enter karein, bina +91 ke.";
}

/*
EXPECTED OUTPUT:
Email format valid hai.
Experience: 0 years.
Mobile ka demo format valid hai.
*/
