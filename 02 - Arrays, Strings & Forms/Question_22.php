<?php
/*
===============================================================================
FRESHER PHP DEVELOPER INTERVIEW GUIDE
PART 2: ARRAYS, STRINGS & FORMS
By CODEGULLY, Monu Kumar Giri
===============================================================================

QUESTION 22 | FORMS
Validation, sanitization aur output escaping mein kya difference hai? Kya HTML validation enough hai?

DEFINITION / INTERVIEW ANSWER — HINGLISH
-------------------------------------------------------------------------------
Validation check karti hai ki input rules follow karta hai ya nahi.
Sanitization ya normalization input ko clean ya transform karti hai.
Output escaping data ko uske output context ke according safely display
karne ke liye hoti hai.

HTML ka required, type="email" ya JavaScript validation user experience
improve karta hai, lekin bypass ho sakta hai. Server-side validation bhi
zaroori hai.

DETAILED EXPLANATION — HINGLISH
-------------------------------------------------------------------------------
Step 1 — Normalization: trim() se surrounding whitespace remove karo.
Step 2 — Validation: Required field empty toh nahi hai, yeh check karo.
Step 3 — Escaping: HTML output ke liye htmlspecialchars() use karo.

Example mein "   Priya Sharma   " ko trim karke validate kiya hai aur phir
HTML text output ke liye escape kiya hai.

IMPORTANT INTERVIEW POINTS / COMMON MISTAKES
-------------------------------------------------------------------------------
Interview answer:
"Main input ko pehle expected type aur business rules ke against validate
karunga. Display karte waqt output context ke according escape karunga.
Sirf input ko clean kar dena complete security nahi hai."

Browser validation ko only validation layer mat samjho.

HOW TO USE THIS FILE
-------------------------------------------------------------------------------
VS Code mein comments padho aur neeche diye gaye complete examples run karo.
Expected output aur step-by-step explanation code ke paas comments mein hain.
Har Question file ko separately run karo; sabko ek saath include mat karo.

REFERENCE LINKS FROM THE EARLIER GUIDE
-------------------------------------------------------------------------------
https://developer.mozilla.org/en-US/docs/Learn_web_development/Extensions/Forms/Form_validation
https://cheatsheetseries.owasp.org/cheatsheets/Input_Validation_Cheat_Sheet.html

CONTENT NOTE
-------------------------------------------------------------------------------
Yeh file chat mein diye gaye Question 22 ko package karti hai. Koi naya
interview topic add nahi kiya gaya. Form action/redirect filenames ko runnable
package ke paths se match kiya gaya hai; relevant changes neeche noted hain.
===============================================================================
*/

header("Content-Type: text/html; charset=UTF-8");

$rawName = "   Priya Sharma><script>alert('XSS')</script>   ";

// 1. Normalization: surrounding whitespace remove.
$name = trim($rawName);

// 2. Validation: required field check.
if ($name === "") {
    exit("Name required hai.");
}

// 3. Escaping: HTML output ke liye.
$safeName = htmlspecialchars($name);
echo "Student: " . $safeName;
// Expected browser output: Student: Priya Sharma
