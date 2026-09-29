<?php
/*
===============================================================================
FRESHER PHP DEVELOPER INTERVIEW GUIDE
PART 2: ARRAYS, STRINGS & FORMS
By CODEGULLY, Monu Kumar Giri
===============================================================================

QUESTION 5 | ARRAYS
array_push(), array_pop(), array_shift() aur array_unshift() kya karte hain?

DEFINITION / INTERVIEW ANSWER — HINGLISH
-------------------------------------------------------------------------------
array_push() end mein elements add karta hai aur array_pop() last element
remove karke return karta hai. array_unshift() beginning mein elements add
karta hai aur array_shift() first element remove karke return karta hai.

DETAILED EXPLANATION — HINGLISH
-------------------------------------------------------------------------------
Student queue ko example lo. Rohit ko end mein add karke array_pop() se
nikalenge. Phir Neha ko beginning mein add karke array_shift() se nikalenge.
Final queue mein original Aman aur Priya bachenge.

Sirf ek element append karna ho toh $array[] = $value straightforward hai.

IMPORTANT INTERVIEW POINTS / COMMON MISTAKES
-------------------------------------------------------------------------------
array_push() ka return value updated element count hota hai, updated array
nahi. array_pop() aur array_shift() removed element return karte hain.

HOW TO USE THIS FILE
-------------------------------------------------------------------------------
VS Code mein comments padho aur neeche diye gaye complete examples run karo.
Expected output aur step-by-step explanation code ke paas comments mein hain.
Har Question file ko separately run karo; sabko ek saath include mat karo.

REFERENCE LINKS FROM THE EARLIER GUIDE
-------------------------------------------------------------------------------
https://www.php.net/manual/en/function.array-push.php
https://www.php.net/manual/en/function.array-pop.php
https://www.php.net/manual/en/function.array-shift.php
https://www.php.net/manual/en/function.array-unshift.php

CONTENT NOTE
-------------------------------------------------------------------------------
Yeh file chat mein diye gaye Question 5 ko package karti hai. Koi naya
interview topic add nahi kiya gaya. Form action/redirect filenames ko runnable
package ke paths se match kiya gaya hai; relevant changes neeche noted hain.
===============================================================================
*/

header("Content-Type: text/html; charset=UTF-8");
echo "<pre>";

$queue = ["Aman", "Priya"];

// End mein add.
array_push($queue, "Rohit");
// Current array: ["Aman", "Priya", "Rohit"]

// End se remove.
$lastStudent = array_pop($queue);
echo $lastStudent; // Rohit
echo "<br>";

// Beginning mein add.
array_unshift($queue, "Neha");
// Current array: ["Neha", "Aman", "Priya"]

// Beginning se remove.
$firstStudent = array_shift($queue);
echo $firstStudent; // Neha
echo "<br>";

print_r($queue);
// Final array: ["Aman", "Priya"]

echo "</pre>";
