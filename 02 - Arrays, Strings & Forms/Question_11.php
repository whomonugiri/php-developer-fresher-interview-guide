<?php
/*
===============================================================================
FRESHER PHP DEVELOPER INTERVIEW GUIDE
PART 2: ARRAYS, STRINGS & FORMS
By CODEGULLY, Monu Kumar Giri
===============================================================================

QUESTION 11 | STRINGS
PHP mein strings concatenate kaise karte hain?

DEFINITION / INTERVIEW ANSWER — HINGLISH
-------------------------------------------------------------------------------
Concatenation ka matlab do ya zyada strings ko join karna hai. PHP mein
strings join karne ke liye dot operator . use hota hai. Existing string
mein text append karne ke liye .= use karte hain.

DETAILED EXPLANATION — HINGLISH
-------------------------------------------------------------------------------
$firstName . " " . $lastName first name, ek space aur last name ko join karega.
$message .= "..." existing message ke end mein aur text add karega.
Neeche full name aur personalised welcome message banaya gaya hai.

IMPORTANT INTERVIEW POINTS / COMMON MISTAKES
-------------------------------------------------------------------------------
PHP mein + string concatenation operator nahi hai. Text join karne ke liye
dot . use karo; existing variable mein append karne ke liye .= use karo.

HOW TO USE THIS FILE
-------------------------------------------------------------------------------
VS Code mein comments padho aur neeche diye gaye complete examples run karo.
Expected output aur step-by-step explanation code ke paas comments mein hain.
Har Question file ko separately run karo; sabko ek saath include mat karo.

REFERENCE LINKS FROM THE EARLIER GUIDE
-------------------------------------------------------------------------------
https://www.php.net/manual/en/language.operators.string.php

CONTENT NOTE
-------------------------------------------------------------------------------
Yeh file chat mein diye gaye Question 11 ko package karti hai. Koi naya
interview topic add nahi kiya gaya. Form action/redirect filenames ko runnable
package ke paths se match kiya gaya hai; relevant changes neeche noted hain.
===============================================================================
*/

header("Content-Type: text/html; charset=UTF-8");
echo "<pre>";

$firstName = "Monu";
$lastName = "Giri";

// EXAMPLE 1: Do strings ke beech space add karke full name banana.
$fullName = $firstName . " " . $lastName;
echo $fullName;
// Output: Monu Giri

echo "<br>";

// EXAMPLE 2: Existing string mein append karna.
$message = "Namaste " . $fullName;
$message .= ", PHP interview preparation mein welcome!";
echo $message;
// Output: Namaste Monu Giri, PHP interview preparation mein welcome!

echo "</pre>";
