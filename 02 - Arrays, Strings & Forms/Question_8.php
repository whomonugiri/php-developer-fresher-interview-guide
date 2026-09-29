<?php
/*
===============================================================================
FRESHER PHP DEVELOPER INTERVIEW GUIDE
PART 2: ARRAYS, STRINGS & FORMS
By CODEGULLY, Monu Kumar Giri
===============================================================================

QUESTION 8 | ARRAYS
array_slice() aur array_splice() mein kya difference hai?

DEFINITION / INTERVIEW ANSWER — HINGLISH
-------------------------------------------------------------------------------
array_slice() array ka selected portion return karta hai; original array
change nahi karta.

array_splice() original array se elements remove ya replace karta hai aur
removed elements return karta hai.

DETAILED EXPLANATION — HINGLISH
-------------------------------------------------------------------------------
Neeche position 1 se ek element select karne par Mumbai milega.
array_slice() ke baad cities array unchanged rahega.
array_splice() se same position par Mumbai remove karke Jaipur insert hoga.
Removed element Mumbai return hoga aur original cities array update ho jayega.

IMPORTANT INTERVIEW POINTS / COMMON MISTAKES
-------------------------------------------------------------------------------
Yaad rakhne ka simple way:
Slice = portion lena.
Splice = original array mein change karna.

HOW TO USE THIS FILE
-------------------------------------------------------------------------------
VS Code mein comments padho aur neeche diye gaye complete examples run karo.
Expected output aur step-by-step explanation code ke paas comments mein hain.
Har Question file ko separately run karo; sabko ek saath include mat karo.

REFERENCE LINKS FROM THE EARLIER GUIDE
-------------------------------------------------------------------------------
https://www.php.net/manual/en/function.array-slice.php
https://www.php.net/manual/en/function.array-splice.php

CONTENT NOTE
-------------------------------------------------------------------------------
Yeh file chat mein diye gaye Question 8 ko package karti hai. Koi naya
interview topic add nahi kiya gaya. Form action/redirect filenames ko runnable
package ke paths se match kiya gaya hai; relevant changes neeche noted hain.
===============================================================================
*/

header("Content-Type: text/html; charset=UTF-8");
echo "<pre>";

$cities = ["Delhi", "Mumbai", "Pune","Goa","Bihar","UP"];
print_r($cities);
// EXAMPLE 1: Position 1 se ek element lena, without changing the original.
$selected = array_slice($cities, 3, 2);
print_r($selected);
// ["Mumbai"]
print_r($cities);
// ["Delhi", "Mumbai", "Pune"] — unchanged

// EXAMPLE 2: Position 1 ka ek element replace karna.
$removed = array_splice($cities, 1, 1, ["Jaipur"]);
print_r($removed);
// ["Mumbai"] — removed elements
print_r($cities);
// ["Delhi", "Jaipur", "Pune"] — original array changed

echo "</pre>";
