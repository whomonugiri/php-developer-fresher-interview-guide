<?php
/*
===============================================================================
FRESHER PHP DEVELOPER INTERVIEW GUIDE
PART 2: ARRAYS, STRINGS & FORMS
By CODEGULLY, Monu Kumar Giri
===============================================================================

QUESTION 2 | ARRAYS
Array mein elements add, update, remove aur count kaise karte hain?

DEFINITION / INTERVIEW ANSWER — HINGLISH
-------------------------------------------------------------------------------
Array ke end mein naya element add karne ke liye [], existing element update
karne ke liye uski key, aur element remove karne ke liye unset() use karte hain.
count() array ke elements count karta hai.

DETAILED EXPLANATION — HINGLISH
-------------------------------------------------------------------------------
$students[] = "Rohit" end mein Rohit add karega.
$students[1] = "Pooja" index 1 ki existing value update karega.
unset($students[0]) index 0 ka element remove karega.
count($students) remaining elements ki count dega.

unset() ke baad remaining integer keys automatically reindex nahi hoti.
Fresh 0, 1, 2... indexing chahiye toh array_values() use karte hain.
array_values() values ko nayi sequential integer keys ke saath return karta hai.

IMPORTANT INTERVIEW POINTS / COMMON MISTAKES
-------------------------------------------------------------------------------
Element count aur highest numeric key alag cheezein hain. Neeche removal ke
baad 3 elements hain, lekin keys 1, 2, 3 hain. Keys reset karne ke liye
array_values() ka returned array assign karo.

HOW TO USE THIS FILE
-------------------------------------------------------------------------------
VS Code mein comments padho aur neeche diye gaye complete examples run karo.
Expected output aur step-by-step explanation code ke paas comments mein hain.
Har Question file ko separately run karo; sabko ek saath include mat karo.

REFERENCE LINKS FROM THE EARLIER GUIDE
-------------------------------------------------------------------------------
https://www.php.net/manual/en/language.types.array.php
https://www.php.net/manual/en/function.array-values.php

CONTENT NOTE
-------------------------------------------------------------------------------
Yeh file chat mein diye gaye Question 2 ko package karti hai. Koi naya
interview topic add nahi kiya gaya. Form action/redirect filenames ko runnable
package ke paths se match kiya gaya hai; relevant changes neeche noted hain.
===============================================================================
*/

header("Content-Type: text/html; charset=UTF-8");
echo "<pre>";

// EXAMPLE 1: Add, update, remove, count aur loop
$students = ["Aman", "Priya", "Neha"];
$students[] = "Rohit";       // Add at the end.
$students[1] = "Pooja";      // Update index 1.
unset($students[0]);         // Remove Aman; keys reindex nahi hongi.

echo "Total students: " . count($students);
echo "<br>";
foreach ($students as $index => $name) {
    echo "$index: $name <br>";
}
/*
EXPECTED OUTPUT:
Total students: 3
1: Pooja
2: Neha
3: Rohit
*/

// EXAMPLE 2: Remaining keys ko 0, 1, 2... banana
$students = [
    1 => "Pooja",
    2 => "Neha",
    3 => "Rohit"
];
$students = array_values($students);
print_r($students);
/*
EXPECTED ARRAY:
[
    0 => "Pooja",
    1 => "Neha",
    2 => "Rohit"
]
print_r() is data ko apne Array (...) format mein dikhayega.
*/
echo "</pre>";
