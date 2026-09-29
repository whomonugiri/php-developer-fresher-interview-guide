<?php
/*
===============================================================================
FRESHER PHP DEVELOPER INTERVIEW GUIDE
PART 2: ARRAYS, STRINGS & FORMS
By CODEGULLY, Monu Kumar Giri
===============================================================================

QUESTION 7 | ARRAYS
sort(), asort() aur ksort() mein kya difference hai?

DEFINITION / INTERVIEW ANSWER — HINGLISH
-------------------------------------------------------------------------------
sort() values ke according sort karta hai aur keys ko numeric indexes mein
reset kar deta hai. asort() values ke according sort karta hai lekin key-value
relationship preserve karta hai. ksort() keys ke according sort karta hai.

DETAILED EXPLANATION — HINGLISH
-------------------------------------------------------------------------------
Descending versions respectively rsort(), arsort() aur krsort() hain.
Ye functions original array ko modify karte hain.

Student marks mein names keys hain aur marks values hain.
sort() marks ko ascending karega, lekin names as keys lost ho jayenge.
asort() marks ascending karega aur names preserve karega.
ksort() student names yani keys ko sort karega.

Practical interview question: Highest marks first chahiye aur naam bhi
preserve karne hain? arsort() use karenge.

IMPORTANT INTERVIEW POINTS / COMMON MISTAKES
-------------------------------------------------------------------------------
Names/IDs ko values ke saath preserve karna ho toh blindly sort() mat use karo.
Sorting functions ko naya sorted array return karne wala assume mat karo:
array khud modify hota hai.

HOW TO USE THIS FILE
-------------------------------------------------------------------------------
VS Code mein comments padho aur neeche diye gaye complete examples run karo.
Expected output aur step-by-step explanation code ke paas comments mein hain.
Har Question file ko separately run karo; sabko ek saath include mat karo.

REFERENCE LINKS FROM THE EARLIER GUIDE
-------------------------------------------------------------------------------
https://www.php.net/manual/en/array.sorting.php

CONTENT NOTE
-------------------------------------------------------------------------------
Yeh file chat mein diye gaye Question 7 ko package karti hai. Koi naya
interview topic add nahi kiya gaya. Form action/redirect filenames ko runnable
package ke paths se match kiya gaya hai; relevant changes neeche noted hain.
===============================================================================
*/

header("Content-Type: text/html; charset=UTF-8");
echo "<pre>";

$marks = [
    "Rohit" => 75,
    "Aman" => 90,
    "Priya" => 60
];

// EXAMPLE 1: Values sort hongi, student names as keys lost ho jayenge.
$first = $marks;
sort($first);
print_r($first);
// Expected array: [0 => 60, 1 => 75, 2 => 90]

// EXAMPLE 2: Values sort hongi; names preserved rahenge.
$second = $marks;
asort($second);
print_r($second);
// Expected array: ["Priya" => 60, "Rohit" => 75, "Aman" => 90]

// EXAMPLE 3: Names (keys) ke according sort.
$third = $marks;
ksort($third);
print_r($third);
// Expected array: ["Aman" => 90, "Priya" => 60, "Rohit" => 75]

// EXAMPLE 4: Student leaderboard — highest marks first.
$marks = [
    "Rohit" => 75,
    "Aman" => 90,
    "Priya" => 60
];
arsort($marks);
foreach ($marks as $name => $score) {
    echo "$name: $score <br>";
}
/*
LEADERBOARD OUTPUT:
Aman: 90
Rohit: 75
Priya: 60
*/
echo "</pre>";
