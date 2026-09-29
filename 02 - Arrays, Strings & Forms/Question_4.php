<?php
/*
===============================================================================
FRESHER PHP DEVELOPER INTERVIEW GUIDE
PART 2: ARRAYS, STRINGS & FORMS
By CODEGULLY, Monu Kumar Giri
===============================================================================

QUESTION 4 | ARRAYS
in_array() aur array_search() mein kya difference hai?

DEFINITION / INTERVIEW ANSWER — HINGLISH
-------------------------------------------------------------------------------
in_array() batata hai ki array mein koi value present hai ya nahi. Iska
result boolean hota hai.

array_search() value milne par uski key return karta hai. Value nahi milne
par false return karta hai.

DETAILED EXPLANATION — HINGLISH
-------------------------------------------------------------------------------
Third argument true strict checking enable karta hai: value ke saath type
bhi match hona chahiye. Integer 101 aur string "101" strict check mein alag hain.

PHP skills array mein first value hai, isliye array_search() uske liye 0
return karega. 0 ek valid array key hai; false ka meaning "not found" hai.

IMPORTANT INTERVIEW POINTS / COMMON MISTAKES
-------------------------------------------------------------------------------
array_search() ke result ko if ($position) se check mat karo. Index 0 false-like
hota hai. if ($position !== false) use karo.

HOW TO USE THIS FILE
-------------------------------------------------------------------------------
VS Code mein comments padho aur neeche diye gaye complete examples run karo.
Expected output aur step-by-step explanation code ke paas comments mein hain.
Har Question file ko separately run karo; sabko ek saath include mat karo.

REFERENCE LINKS FROM THE EARLIER GUIDE
-------------------------------------------------------------------------------
https://www.php.net/manual/en/function.in-array.php
https://www.php.net/manual/en/function.array-search.php

CONTENT NOTE
-------------------------------------------------------------------------------
Yeh file chat mein diye gaye Question 4 ko package karti hai. Koi naya
interview topic add nahi kiya gaya. Form action/redirect filenames ko runnable
package ke paths se match kiya gaya hai; relevant changes neeche noted hain.
===============================================================================
*/

header("Content-Type: text/html; charset=UTF-8");
echo "<pre>";

// EXAMPLE 1: Value exists? Aur value ki key kya hai?
$skills = ["PHP", "MySQL", "JavaScript"];
var_dump(in_array("PHP", $skills, true)); // bool(true)

$position = array_search("PHP", $skills, true);
var_dump($position); // int(0)

if ($position !== false) {
    echo "PHP index $position par mila.";
}
// Output: PHP index 0 par mila.
echo "<br>";

// EXAMPLE 2: Loose vs strict search
$ids = [101, 102, 103];
var_dump(in_array("101", $ids));       // bool(true): loose comparison
var_dump(in_array("101", $ids, true)); // bool(false): type bhi check hua

/*
WRONG APPROACH — sirf samajhne ke liye, run nahi kar rahe:
if ($position) {
    // Position 0 ho toh yahan enter nahi karega, even though value found hai.
}
*/
echo "</pre>";
