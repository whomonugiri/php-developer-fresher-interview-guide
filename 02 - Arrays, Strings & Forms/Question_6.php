<?php
/*
===============================================================================
FRESHER PHP DEVELOPER INTERVIEW GUIDE
PART 2: ARRAYS, STRINGS & FORMS
By CODEGULLY, Monu Kumar Giri
===============================================================================

QUESTION 6 | ARRAYS
array_merge() aur array union operator + mein kya difference hai?

DEFINITION / INTERVIEW ANSWER — HINGLISH
-------------------------------------------------------------------------------
array_merge() arrays ko combine karta hai. Same string key ho toh baad wale
array ki value overwrite karti hai. Integer keys wale elements append hote
hain aur reindex hote hain.

Array union + key ke basis par combine karta hai. Same key dono arrays mein
ho toh left-side array ki value retain hoti hai.

DETAILED EXPLANATION — HINGLISH
-------------------------------------------------------------------------------
Neeche dono arrays mein string key city aur integer key 0 hai.
array_merge(): city ki latest value Pune hogi; PHP aur MySQL dono append honge.
Union +: left array ka city = Delhi aur 0 = PHP retain hoga.

IMPORTANT INTERVIEW POINTS / COMMON MISTAKES
-------------------------------------------------------------------------------
+ duplicate VALUES remove karne wala function nahi hai. Iska decision KEYS
ke basis par hota hai. Same key milne par left-hand value preserve hoti hai.

HOW TO USE THIS FILE
-------------------------------------------------------------------------------
VS Code mein comments padho aur neeche diye gaye complete examples run karo.
Expected output aur step-by-step explanation code ke paas comments mein hain.
Har Question file ko separately run karo; sabko ek saath include mat karo.

REFERENCE LINKS FROM THE EARLIER GUIDE
-------------------------------------------------------------------------------
https://www.php.net/manual/en/function.array-merge.php
https://www.php.net/manual/en/language.operators.array.php

CONTENT NOTE
-------------------------------------------------------------------------------
Yeh file chat mein diye gaye Question 6 ko package karti hai. Koi naya
interview topic add nahi kiya gaya. Form action/redirect filenames ko runnable
package ke paths se match kiya gaya hai; relevant changes neeche noted hain.
===============================================================================
*/

header("Content-Type: text/html; charset=UTF-8");
echo "<pre>";

$first = [
    "city" => "Delhi",
    0 => "PHP"
];
$second = [
    "city" => "Pune",
    0 => "MySQL",
    1=>"React",
    2=>"MySQL"
];

// EXAMPLE 1: Merge
$merged = array_merge($first, $second);
print_r($merged);
/*
EXPECTED ARRAY:
[
    "city" => "Pune",
    0 => "PHP",
    1 => "MySQL"
]
*/

// EXAMPLE 2: Union
$union = $first + $second;
print_r($union);
/*
EXPECTED ARRAY:
[
    "city" => "Delhi",
    0 => "PHP"
]
*/
echo "</pre>";
