<?php
/*
===============================================================================
FRESHER PHP DEVELOPER INTERVIEW GUIDE
PART 2: ARRAYS, STRINGS & FORMS
By CODEGULLY, Monu Kumar Giri
===============================================================================

QUESTION 1 | ARRAYS
PHP mein array kya hota hai? Indexed, associative aur multidimensional arrays mein kya difference hai?

DEFINITION / INTERVIEW ANSWER — HINGLISH
-------------------------------------------------------------------------------
Array ek aisa data structure hai jisme hum ek hi variable ke andar multiple
values store kar sakte hain. PHP array mein har value ki ek key hoti hai,
jiske through hum us value ko access karte hain.

Technically, PHP ka array ek ordered map hai. Indexed, associative aur
multidimensional arrays isi array type ko use karne ke alag patterns hain.

DETAILED EXPLANATION — HINGLISH
-------------------------------------------------------------------------------
1. Indexed array: Integer keys use hoti hain. Simple list mein automatically
   0, 1, 2... keys milti hain. Example: Indian cities ki list.
2. Associative array: Meaningful named keys use karte hain, jaise name, city
   aur course. Example: ek student ki details.
3. Multidimensional array: Ek array ke andar doosre arrays hote hain.
   Example: multiple students ke naam aur marks.

$cities[0] first city access karta hai.
$student["name"] named key ki value access karta hai.
$students[1]["name"] second student ke inner array se name access karta hai.

IMPORTANT INTERVIEW POINTS / COMMON MISTAKES
-------------------------------------------------------------------------------
Har PHP array ka first key 0 hona compulsory nahi hai. Hum keys manually
bhi define kar sakte hain. Example 0-based list ke default behavior ka hai,
har possible PHP array ke liye rule nahi hai.

HOW TO USE THIS FILE
-------------------------------------------------------------------------------
VS Code mein comments padho aur neeche diye gaye complete examples run karo.
Expected output aur step-by-step explanation code ke paas comments mein hain.
Har Question file ko separately run karo; sabko ek saath include mat karo.

REFERENCE LINKS FROM THE EARLIER GUIDE
-------------------------------------------------------------------------------
https://www.php.net/manual/en/language.types.array.php

CONTENT NOTE
-------------------------------------------------------------------------------
Yeh file chat mein diye gaye Question 1 ko package karti hai. Koi naya
interview topic add nahi kiya gaya. Form action/redirect filenames ko runnable
package ke paths se match kiya gaya hai; relevant changes neeche noted hain.
===============================================================================
*/

header("Content-Type: text/html; charset=UTF-8");
echo "<pre>"; // Sirf browser mein output readable banane ke liye.

// EXAMPLE 1: Indexed array
$cities = ["Delhi", "Mumbai", "Pune"];
echo $cities[0]; // Output: Delhi

echo "<br>";

// EXAMPLE 2: Associative array
$student = [
    "name" => "Priya",
    "city" => "Jaipur",
    "course" => "BCA"
];
echo $student["name"]; // Output: Priya

echo "<br>";

// EXAMPLE 3: Multidimensional array
$students = [
    ["name" => "Aman", "marks" => 85],
    ["name" => "Neha", "marks" => 92]
];
echo $students[1]["name"]; // Output: Neha

echo "<br>";
echo $students[1]["marks"]; // Output: 92

/*
COMPLETE EXPECTED OUTPUT:
Delhi
Priya
Neha
92
*/
echo "</pre>";
