<?php
/*
===============================================================================
FRESHER PHP DEVELOPER INTERVIEW GUIDE
PART 2: ARRAYS, STRINGS & FORMS
By CODEGULLY, Monu Kumar Giri
===============================================================================

QUESTION 12 | STRINGS
strlen() aur mb_strlen() mein kya difference hai?

DEFINITION / INTERVIEW ANSWER — HINGLISH
-------------------------------------------------------------------------------
strlen() string ki length bytes mein return karta hai. mb_strlen() specified
encoding ke according characters count karta hai; UTF-8 mein ise Unicode
code points ke count ke taur par samajh sakte hain.

English ASCII text mein bytes aur characters ka count same ho sakta hai,
lekin Hindi text aur rupee symbol jaise characters mein difference aa sakta hai.

DETAILED EXPLANATION — HINGLISH
-------------------------------------------------------------------------------
Example string: ₹100
UTF-8 mein rupee symbol ₹ = 3 bytes. Digits 1, 0, 0 = 1 byte each.
Isliye strlen() ka result 6 hoga.
mb_strlen($text, "UTF-8") rupee symbol aur three digits ko 4 characters count karega.

mb_strlen() ke liye PHP mbstring extension required hai. Neeche extension
missing ho toh fatal error ke bajaye clear message diya gaya hai.

IMPORTANT INTERVIEW POINTS / COMMON MISTAKES
-------------------------------------------------------------------------------
Indian-language interview point: Matra combinations aur complex emojis mein
user ko dikhne wala ek character multiple code points se bana ho sakta hai.
Aise user-perceived characters ke liye grapheme_strlen() relevant hai.

mb_strlen() ko har situation mein user-visible character count bolna accurate
nahi hai. Byte count, code point count aur visible character count alag ho sakte hain.

HOW TO USE THIS FILE
-------------------------------------------------------------------------------
VS Code mein comments padho aur neeche diye gaye complete examples run karo.
Expected output aur step-by-step explanation code ke paas comments mein hain.
Har Question file ko separately run karo; sabko ek saath include mat karo.

REFERENCE LINKS FROM THE EARLIER GUIDE
-------------------------------------------------------------------------------
https://www.php.net/manual/en/function.strlen.php
https://www.php.net/manual/en/function.mb-strlen.php
https://www.php.net/manual/en/function.grapheme-strlen.php

CONTENT NOTE
-------------------------------------------------------------------------------
Yeh file chat mein diye gaye Question 12 ko package karti hai. Koi naya
interview topic add nahi kiya gaya. Form action/redirect filenames ko runnable
package ke paths se match kiya gaya hai; relevant changes neeche noted hain.
===============================================================================
*/

header("Content-Type: text/html; charset=UTF-8");
echo "<pre>";

$text = "₹100";

// EXAMPLE: Same text ki byte length vs UTF-8 character length.
echo strlen($text);
// Output: 6
// ₹ = 3 bytes, and 1, 0, 0 = 1 byte each.
echo "<br>";

if (function_exists("mb_strlen")) {
    echo mb_strlen($text, "UTF-8");
    // Output: 4 characters / code points: ₹, 1, 0, 0
} else {
    echo "Is example ke liye PHP mbstring extension enable karein.";
}

/*
EXPECTED OUTPUT WITH MBSTRING:
6
4

EXPECTED OUTPUT WITHOUT MBSTRING:
6
Is example ke liye PHP mbstring extension enable karein.

File ko UTF-8 encoding mein save rakho.
*/
echo "</pre>";
