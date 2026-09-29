<?php
/*
===============================================================================
FRESHER PHP DEVELOPER INTERVIEW GUIDE
PART 2: ARRAYS, STRINGS & FORMS
By CODEGULLY, Monu Kumar Giri
===============================================================================

QUESTION 18 | STRINGS
htmlspecialchars() aur strip_tags() mein kya difference hai?

DEFINITION / INTERVIEW ANSWER — HINGLISH
-------------------------------------------------------------------------------
htmlspecialchars() HTML ke special characters ko entities mein convert karta
hai, jisse unhe normal text ki tarah display kiya ja sake.

strip_tags() HTML/PHP tags remove karta hai. Yeh HTML output escaping ka
replacement nahi hai aur ise general XSS protection nahi samajhna chahiye.

DETAILED EXPLANATION — HINGLISH
-------------------------------------------------------------------------------
Example text mein <b>Namaste Aman</b> hai.
htmlspecialchars() ke baad browser literal opening/closing tags dikhayega;
text par bold formatting apply nahi hogi.
strip_tags() tags ko hata kar sirf Namaste Aman dega.

ENT_QUOTES single aur double quotes handle karta hai; ENT_SUBSTITUTE aur
UTF-8 options ko example mein explicitly diya gaya hai.

IMPORTANT INTERVIEW POINTS / COMMON MISTAKES
-------------------------------------------------------------------------------
htmlspecialchars() HTML text aur appropriately quoted HTML attributes ke
context mein useful hai. JavaScript, SQL aur doosre contexts ke liye ise
universal security function mat samjho.

strip_tags() ko complete XSS protection ka replacement mat bolo.

HOW TO USE THIS FILE
-------------------------------------------------------------------------------
VS Code mein comments padho aur neeche diye gaye complete examples run karo.
Expected output aur step-by-step explanation code ke paas comments mein hain.
Har Question file ko separately run karo; sabko ek saath include mat karo.

REFERENCE LINKS FROM THE EARLIER GUIDE
-------------------------------------------------------------------------------
https://www.php.net/manual/en/function.htmlspecialchars.php
https://www.php.net/manual/en/function.strip-tags.php
https://cheatsheetseries.owasp.org/cheatsheets/Input_Validation_Cheat_Sheet.html

CONTENT NOTE
-------------------------------------------------------------------------------
Yeh file chat mein diye gaye Question 18 ko package karti hai. Koi naya
interview topic add nahi kiya gaya. Form action/redirect filenames ko runnable
package ke paths se match kiya gaya hai; relevant changes neeche noted hain.
===============================================================================
*/

header("Content-Type: text/html; charset=UTF-8");
echo "<pre>";

$text = "<b><h1><div>Namaste Aman</b>";
// EXAMPLE 1: HTML special characters ko display-safe text banana.
echo htmlspecialchars($text);
// Browser mein literal text dikhega: <b>Namaste Aman</b>
// Bold formatting apply nahi hogi.
echo "<br>";

// EXAMPLE 2: Tags remove karna.
echo strip_tags($text);
// Browser output: Namaste Aman

echo "</pre>";
