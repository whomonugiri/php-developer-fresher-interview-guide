<?php
/*
===============================================================================
FRESHER PHP DEVELOPER INTERVIEW GUIDE
PART 2: ARRAYS, STRINGS & FORMS
By CODEGULLY, Monu Kumar Giri
===============================================================================

QUESTION 15 | STRINGS
String mein kisi word ko search kaise karte hain? strpos() mein common mistake kya hai?

DEFINITION / INTERVIEW ANSWER — HINGLISH
-------------------------------------------------------------------------------
strpos() substring ki first position return karta hai. Match nahi mile toh
false return karta hai.

str_contains() sirf true ya false deta hai. stripos() ASCII case-insensitive
position search ke liye use kar sakte hain.

DETAILED EXPLANATION — HINGLISH
-------------------------------------------------------------------------------
"PHP Developer in Delhi" mein PHP start par hai, toh position 0 return hogi.
Position 0 valid match hai; false ka meaning no match hai.
str_contains($title, "Developer") true dega.
stripos($title, "php") letter case ignore karke position 0 dega.

str_contains() wale example ke liye PHP 8+ use karo.

IMPORTANT INTERVIEW POINTS / COMMON MISTAKES
-------------------------------------------------------------------------------
Galat approach: if (strpos($title, "PHP")) { ... }
Position 0 hone par block execute nahi hoga.

Interview answer: Position 0 aur false ko distinguish karne ke liye strict
comparison !== false use karunga.

HOW TO USE THIS FILE
-------------------------------------------------------------------------------
VS Code mein comments padho aur neeche diye gaye complete examples run karo.
Expected output aur step-by-step explanation code ke paas comments mein hain.
Har Question file ko separately run karo; sabko ek saath include mat karo.

REFERENCE LINKS FROM THE EARLIER GUIDE
-------------------------------------------------------------------------------
https://www.php.net/manual/en/function.strpos.php
https://www.php.net/manual/en/function.str-contains.php
https://www.php.net/manual/en/function.stripos.php

CONTENT NOTE
-------------------------------------------------------------------------------
Yeh file chat mein diye gaye Question 15 ko package karti hai. Koi naya
interview topic add nahi kiya gaya. Form action/redirect filenames ko runnable
package ke paths se match kiya gaya hai; relevant changes neeche noted hain.
===============================================================================
*/

header("Content-Type: text/html; charset=UTF-8");
echo "<pre>";

$title = "PHP Developer in Delhi";
$position = strpos($title, "php");
var_dump($position);
// int(0)

// Correct check: 0 ko false se distinguish karta hai.
if ($position !== false) {
    echo "PHP word mila.";
}
// Output: PHP word mila.
echo "<br>";

// PHP 8+: Boolean presence check.
var_dump(str_contains($title, "Developer"));
// bool(true)

// Case-insensitive position search.
var_dump(stripos($title, "php"));
// int(0)

/*
WRONG APPROACH — sirf samajhne ke liye, execute nahi kar rahe:
if (strpos($title, "PHP")) {
    // Position 0 hone par yeh block execute nahi hoga.
}
*/
echo "</pre>";
