<?php
/*
===============================================================================
FRESHER PHP DEVELOPER INTERVIEW GUIDE
PART 2: ARRAYS, STRINGS & FORMS
By CODEGULLY, Monu Kumar Giri
===============================================================================

QUESTION 13 | STRINGS
trim(), strtolower(), strtoupper() aur ucwords() kya karte hain?

DEFINITION / INTERVIEW ANSWER — HINGLISH
-------------------------------------------------------------------------------
trim() string ke start aur end se default whitespace characters remove karta
hai; beech ke spaces nahi.

strtolower() aur strtoupper() ASCII letters ka case change karte hain.
ucwords() har word ke first ASCII letter ko uppercase kar sakta hai.

DETAILED EXPLANATION — HINGLISH
-------------------------------------------------------------------------------
"   aman sharma   " par trim() lagane se "aman sharma" milega.
strtoupper() se "AMAN SHARMA" aur ucwords() se "Aman Sharma" milega.
strtolower("PHP DEVELOPER") ka result "php developer" hai.

"  Aman   Sharma  " ke start/end spaces remove honge, lekin Aman aur Sharma
ke beech ke multiple spaces rahenge.

IMPORTANT INTERVIEW POINTS / COMMON MISTAKES
-------------------------------------------------------------------------------
In functions ka result assign ya use karna hota hai. Sirf trim($name);
likhne se $name ki value update nahi hogi. $name = trim($name); likho.

HOW TO USE THIS FILE
-------------------------------------------------------------------------------
VS Code mein comments padho aur neeche diye gaye complete examples run karo.
Expected output aur step-by-step explanation code ke paas comments mein hain.
Har Question file ko separately run karo; sabko ek saath include mat karo.

REFERENCE LINKS FROM THE EARLIER GUIDE
-------------------------------------------------------------------------------
https://www.php.net/manual/en/function.trim.php
https://www.php.net/manual/en/function.strtolower.php
https://www.php.net/manual/en/function.strtoupper.php
https://www.php.net/manual/en/function.ucwords.php

CONTENT NOTE
-------------------------------------------------------------------------------
Yeh file chat mein diye gaye Question 13 ko package karti hai. Koi naya
interview topic add nahi kiya gaya. Form action/redirect filenames ko runnable
package ke paths se match kiya gaya hai; relevant changes neeche noted hain.
===============================================================================
*/

header("Content-Type: text/html; charset=UTF-8");
echo "<pre>"; // Internal spaces ko browser mein visibly preserve karta hai.

$name = "   aman sharma   ";
$cleanName = trim($name);

echo "[" . $cleanName . "]";
// [aman sharma]
echo "<br>";

echo strtoupper($cleanName);
// AMAN SHARMA
echo "<br>";

echo ucwords($cleanName);
// Aman Sharma
echo "<br>";

echo strtolower("PHP DEVELOPER");
// php developer
echo "<br>";

echo trim("  Aman   Sharma  ");
// Aman   Sharma
// Beech ke extra spaces abhi bhi present hain.

echo "</pre>";
