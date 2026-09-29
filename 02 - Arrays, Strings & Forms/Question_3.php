<?php
/*
===============================================================================
FRESHER PHP DEVELOPER INTERVIEW GUIDE
PART 2: ARRAYS, STRINGS & FORMS
By CODEGULLY, Monu Kumar Giri
===============================================================================

QUESTION 3 | ARRAYS
isset(), empty() aur array_key_exists() mein kya difference hai?

DEFINITION / INTERVIEW ANSWER — HINGLISH
-------------------------------------------------------------------------------
isset() check karta hai ki variable ya array element exist karta hai aur uski
value null nahi hai. array_key_exists() sirf key ki existence check karta hai:
value null ho tab bhi true milta hai.

empty() missing variable ya false-like value ke liye true deta hai. Ismein
0, "0", false, null, "" aur empty array bhi aa sakte hain.

DETAILED EXPLANATION — HINGLISH
-------------------------------------------------------------------------------
Student ka middle_name null ho sakta hai. Key exist karti hai, isliye
array_key_exists() true dega; null ki wajah se isset() false dega.

Fresher ki experience 0 ho sakti hai. Yeh valid value hai. empty() 0 ko
empty maane toh use automatically "experience missing" mat bolo.
Agar requirement sirf empty string check karna hai, toh === "" use karo.

IMPORTANT INTERVIEW POINTS / COMMON MISTAKES
-------------------------------------------------------------------------------
isset() aur array_key_exists() interchangeable nahi hain jab null allowed ho.
empty() se valid zero ko reject karna common fresher mistake hai.

HOW TO USE THIS FILE
-------------------------------------------------------------------------------
VS Code mein comments padho aur neeche diye gaye complete examples run karo.
Expected output aur step-by-step explanation code ke paas comments mein hain.
Har Question file ko separately run karo; sabko ek saath include mat karo.

REFERENCE LINKS FROM THE EARLIER GUIDE
-------------------------------------------------------------------------------
https://www.php.net/manual/en/function.array-key-exists.php
https://www.php.net/manual/en/function.isset.php
https://www.php.net/manual/en/function.empty.php

CONTENT NOTE
-------------------------------------------------------------------------------
Yeh file chat mein diye gaye Question 3 ko package karti hai. Koi naya
interview topic add nahi kiya gaya. Form action/redirect filenames ko runnable
package ke paths se match kiya gaya hai; relevant changes neeche noted hain.
===============================================================================
*/

header("Content-Type: text/html; charset=UTF-8");
echo "<pre>";

// EXAMPLE 1: null, key existence aur zero ka difference
$student = [
    "name" => "Aman",
    "middle_name" => null,
    "experience" => 0
];
var_dump(isset($student["name"]));                  // bool(true)
var_dump(isset($student["middle_name"]));           // bool(false)
var_dump(array_key_exists("middle_name", $student)); // bool(true)
var_dump(empty($student["experience"]));            // bool(true)
var_dump(isset($student["experience"]));            // bool(true)

// EXAMPLE 2: Fresher ka zero years experience missing nahi hai.
$experience = "0";
if ($experience === "") {
    echo "Experience missing hai.";
} else {
    echo "Experience diya gaya hai.";
}
// Output: Experience diya gaya hai.

echo "</pre>";
