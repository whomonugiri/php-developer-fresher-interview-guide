<?php
/*
===============================================================================
FRESHER PHP DEVELOPER INTERVIEW GUIDE
PART 2: ARRAYS, STRINGS & FORMS
By CODEGULLY, Monu Kumar Giri
===============================================================================

QUESTION 16 | STRINGS
substr() aur str_replace() kya karte hain?

DEFINITION / INTERVIEW ANSWER — HINGLISH
-------------------------------------------------------------------------------
substr() string ka selected portion return karta hai.
str_replace() specified text ko doosre text se replace karta hai.

DETAILED EXPLANATION — HINGLISH
-------------------------------------------------------------------------------
substr($orderId, 0, 3) start ke three bytes dega: ORD.
substr($orderId, -4) end ke four bytes dega: 1045.
str_replace("Delhi", "Pune", $message) updated text return karega.
Returned value ko $updatedMessage mein assign kiya hai; $message unchanged hai.

IMPORTANT INTERVIEW POINTS / COMMON MISTAKES
-------------------------------------------------------------------------------
substr() byte-based hai. Multibyte text ke character-based portions ke liye
mb_substr() use karo. Arbitrary byte cutting Hindi text ko damage kar sakti hai.

Neeche order ID ASCII text hai, isliye demonstrated slicing suitable hai.

HOW TO USE THIS FILE
-------------------------------------------------------------------------------
VS Code mein comments padho aur neeche diye gaye complete examples run karo.
Expected output aur step-by-step explanation code ke paas comments mein hain.
Har Question file ko separately run karo; sabko ek saath include mat karo.

REFERENCE LINKS FROM THE EARLIER GUIDE
-------------------------------------------------------------------------------
https://www.php.net/manual/en/function.substr.php
https://www.php.net/manual/en/function.str-replace.php
https://www.php.net/manual/en/function.mb-substr.php

CONTENT NOTE
-------------------------------------------------------------------------------
Yeh file chat mein diye gaye Question 16 ko package karti hai. Koi naya
interview topic add nahi kiya gaya. Form action/redirect filenames ko runnable
package ke paths se match kiya gaya hai; relevant changes neeche noted hain.
===============================================================================
*/

header("Content-Type: text/html; charset=UTF-8");
echo "<pre>";

// EXAMPLE 1: Order ID ka portion lena.
$orderId = "ORD-2026-1045";
echo substr($orderId, 0, 3);
// ORD
echo "<br>";

echo substr($orderId, -4);
// 1045
echo "<br>";

// EXAMPLE 2: City replace karna.
$message = "PHP classes in Delhi";
$updatedMessage = str_replace("Delhi", "Pune", $message);
echo $updatedMessage;
// PHP classes in Pune
echo "<br>";

echo $message;
// PHP classes in Delhi — original variable unchanged hai.

echo "</pre>";
