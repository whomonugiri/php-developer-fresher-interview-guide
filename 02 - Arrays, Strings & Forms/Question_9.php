<?php
/*
===============================================================================
FRESHER PHP DEVELOPER INTERVIEW GUIDE
PART 2: ARRAYS, STRINGS & FORMS
By CODEGULLY, Monu Kumar Giri
===============================================================================

QUESTION 9 | ARRAYS
Duplicate values, array keys aur array columns kaise extract karte hain?

DEFINITION / INTERVIEW ANSWER — HINGLISH
-------------------------------------------------------------------------------
array_unique() duplicate values remove karta hai. array_keys() keys nikalta
hai aur array_values() values ko sequential indexes ke saath return karta
hai. array_column() rows ke array se ek particular column extract karta hai.

DETAILED EXPLANATION — HINGLISH
-------------------------------------------------------------------------------
Repeated city list se unique cities nikal sakte hain.
Student details se keys aur values separately extract kar sakte hain.
Students ki list se sirf names chahiye toh array_column($students, "name").
Names ke result mein ID ko key banana ho toh third argument "id" de sakte hain.

IMPORTANT INTERVIEW POINTS / COMMON MISTAKES
-------------------------------------------------------------------------------
array_unique() original keys preserve karta hai. Fresh 0, 1, 2... indexing
chahiye toh array_values() use kar sakte ho.

HOW TO USE THIS FILE
-------------------------------------------------------------------------------
VS Code mein comments padho aur neeche diye gaye complete examples run karo.
Expected output aur step-by-step explanation code ke paas comments mein hain.
Har Question file ko separately run karo; sabko ek saath include mat karo.

REFERENCE LINKS FROM THE EARLIER GUIDE
-------------------------------------------------------------------------------
https://www.php.net/manual/en/function.array-unique.php
https://www.php.net/manual/en/function.array-keys.php
https://www.php.net/manual/en/function.array-values.php
https://www.php.net/manual/en/function.array-column.php

CONTENT NOTE
-------------------------------------------------------------------------------
Yeh file chat mein diye gaye Question 9 ko package karti hai. Koi naya
interview topic add nahi kiya gaya. Form action/redirect filenames ko runnable
package ke paths se match kiya gaya hai; relevant changes neeche noted hain.
===============================================================================
*/

header("Content-Type: text/html; charset=UTF-8");
echo "<pre>";

// EXAMPLE 1: Duplicate cities remove karna.
$cities = ["Delhi", "Pune", "Delhi", "Mumbai"];
$uniqueCities = array_values(array_unique($cities));
print_r($uniqueCities);
// ["Delhi", "Pune", "Mumbai"]

// EXAMPLE 2: Keys aur values extract karna.
$student = [
    "name" => "Priya",
    "course" => "BCA"
];
print_r(array_keys($student));
// ["name", "course"]
print_r(array_values($student));
// ["Priya", "BCA"]

// EXAMPLE 3: Multiple students mein se names nikalna.
$students = [
    ["id" => 101, "name" => "Aman"],
    ["id" => 102, "name" => "Neha"]
];
print_r(array_column($students, "name"));
// ["Aman", "Neha"]

// EXAMPLE 4: ID ko result ki key banana.
print_r(array_column($students, "name", "id"));
// [101 => "Aman", 102 => "Neha"]

echo "</pre>";
