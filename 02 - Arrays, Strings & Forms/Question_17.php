<?php
/*
===============================================================================
FRESHER PHP DEVELOPER INTERVIEW GUIDE
PART 2: ARRAYS, STRINGS & FORMS
By CODEGULLY, Monu Kumar Giri
===============================================================================

QUESTION 17 | STRINGS
strcmp() aur strcasecmp() mein kya difference hai?

DEFINITION / INTERVIEW ANSWER — HINGLISH
-------------------------------------------------------------------------------
strcmp() strings ko case-sensitive way mein compare karta hai.
strcasecmp() ASCII letter case ignore karke compare karta hai.

Dono equal strings ke liye 0 return karte hain. Different strings ke liye
negative ya positive integer milta hai.

DETAILED EXPLANATION — HINGLISH
-------------------------------------------------------------------------------
strcmp("PHP", "PHP") equal hai, toh 0.
strcmp("PHP", "php") case difference ki wajah se equal nahi hai.
strcasecmp("PHP", "php") ASCII case ignore karega, toh 0.

City example mein user "delhi" enter kare aur allowed city "Delhi" ho, toh
strcasecmp() ke through case-insensitive equality check dikha rahe hain.

IMPORTANT INTERVIEW POINTS / COMMON MISTAKES
-------------------------------------------------------------------------------
Equality ka result 0 hai, true nahi. Isliye return value ko samajhkar condition
likho. Neeche === 0 ko use karke boolean equality result nikala gaya hai.

HOW TO USE THIS FILE
-------------------------------------------------------------------------------
VS Code mein comments padho aur neeche diye gaye complete examples run karo.
Expected output aur step-by-step explanation code ke paas comments mein hain.
Har Question file ko separately run karo; sabko ek saath include mat karo.

REFERENCE LINKS FROM THE EARLIER GUIDE
-------------------------------------------------------------------------------
https://www.php.net/manual/en/function.strcmp.php
https://www.php.net/manual/en/function.strcasecmp.php

CONTENT NOTE
-------------------------------------------------------------------------------
Yeh file chat mein diye gaye Question 17 ko package karti hai. Koi naya
interview topic add nahi kiya gaya. Form action/redirect filenames ko runnable
package ke paths se match kiya gaya hai; relevant changes neeche noted hain.
===============================================================================
*/

header("Content-Type: text/html; charset=UTF-8");
echo "<pre>";

// EXAMPLE 1: Case-sensitive aur case-insensitive comparison.
var_dump(strcmp("PHP", "PHP") === 0);
// bool(true)

var_dump(strcmp("PHP", "php") === 0);
// bool(false)

var_dump(strcasecmp("PHP", "pHp") === 0);
// bool(true)

// EXAMPLE 2: Case-insensitive city comparison.
$enteredCity = "delhi";
$allowedCity = "Delhi";
if (strcasecmp($enteredCity, $allowedCity) === 0) {
    echo "City match ho gayi.";
}
// Output: City match ho gayi.

echo "</pre>";
