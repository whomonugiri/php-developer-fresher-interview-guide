<?php
/*
===============================================================================
FRESHER PHP DEVELOPER INTERVIEW GUIDE
PART 2: ARRAYS, STRINGS & FORMS
By CODEGULLY, Monu Kumar Giri
===============================================================================

QUESTION 14 | STRINGS
explode() aur implode() mein kya difference hai?

DEFINITION / INTERVIEW ANSWER — HINGLISH
-------------------------------------------------------------------------------
explode() ek separator ke basis par string ko array mein todta hai.
implode() array ke elements ko separator ke saath join karke string banata hai.

DETAILED EXPLANATION — HINGLISH
-------------------------------------------------------------------------------
Input "PHP, MySQL, JavaScript" ko comma separator se explode() karenge toh
skills ka array milega. Comma ke baad ke spaces values mein reh sakte hain,
isliye array_map("trim", $skills) se har value ke surrounding spaces remove kiye hain.

implode(" | ", $skills) array ko readable string mein join karega.
Practical use: Job-application skills, simple comma-separated tags aur
readable selected-options lists.

IMPORTANT INTERVIEW POINTS / COMMON MISTAKES
-------------------------------------------------------------------------------
explode = string to array.
implode = array to string.
Separator ko consciously choose karo; example mein comma split aur pipe display hai.

HOW TO USE THIS FILE
-------------------------------------------------------------------------------
VS Code mein comments padho aur neeche diye gaye complete examples run karo.
Expected output aur step-by-step explanation code ke paas comments mein hain.
Har Question file ko separately run karo; sabko ek saath include mat karo.

REFERENCE LINKS FROM THE EARLIER GUIDE
-------------------------------------------------------------------------------
https://www.php.net/manual/en/function.explode.php
https://www.php.net/manual/en/function.implode.php

CONTENT NOTE
-------------------------------------------------------------------------------
Yeh file chat mein diye gaye Question 14 ko package karti hai. Koi naya
interview topic add nahi kiya gaya. Form action/redirect filenames ko runnable
package ke paths se match kiya gaya hai; relevant changes neeche noted hain.
===============================================================================
*/

header("Content-Type: text/html; charset=UTF-8");
echo "<pre>";

$skillsText = "PHP, MySQL, JavaScript,React";

// EXAMPLE 1: String to array.
$skills = explode(",", $skillsText);

// Har skill ke surrounding spaces remove karo.
$skills = array_map("trim", $skills);
print_r($skills);
// Expected array: ["PHP", "MySQL", "JavaScript"]

// EXAMPLE 2: Array to string.
$displayText = implode(" # ", $skills);
echo $displayText;
// Output: PHP | MySQL | JavaScript

echo "</pre>";
