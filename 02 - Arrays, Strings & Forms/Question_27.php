<?php
/*
===============================================================================
FRESHER PHP DEVELOPER INTERVIEW GUIDE
PART 2: ARRAYS, STRINGS & FORMS
By CODEGULLY, Monu Kumar Giri
===============================================================================

QUESTION 27 | FORMS
Form submit karne ke baad refresh par resubmission avoid kaise karte hain?

DEFINITION / INTERVIEW ANSWER — HINGLISH
-------------------------------------------------------------------------------
Post/Redirect/Get, ya PRG, ek pattern hai jisme server POST process karne
ke baad browser ko GET page par redirect karta hai. Isse result page refresh
karne par wahi POST normally dobara submit nahi hota.

Is flow ke liye 303 See Other redirect suitable hai. PHP mein header()
output bhejne se pehle call karna hota hai.

DETAILED EXPLANATION — HINGLISH
-------------------------------------------------------------------------------
Flow: Form submit (POST) -> validation -> 303 redirect -> result page (GET).
Neeche demo mein sirf name validation hui hai, database save nahi.
Successful POST ke baad thank-you.php open hota hai.
header() ke baad exit rakha hai, taaki script aage run na kare.

PACKAGING NOTE:
Earlier prg.php ka main example Question_27.php mein hai. thank-you.php
public/support/question_27/thank-you.php mein diya hai aur uska complete
source neeche comments mein bhi hai. Redirect path isi folder se match hai.
Original two-file prg.php + thank-you.php version support folder mein bhi hai.

IMPORTANT INTERVIEW POINTS / COMMON MISTAKES
-------------------------------------------------------------------------------
PRG double-clicks ya parallel requests ko automatically block nahi karta.
Yeh refresh-resubmission problem address karta hai; duplicate processing
ke rules separately implement karne hote hain.

Header ke pehle echo/HTML/whitespace output mat bhejo. Comments PHP ke andar hain,
isliye output nahi bhejte. PHP file ko UTF-8 without BOM mein save rakho.

EXPECTED RESULT:
Valid POST: HTTP 303 + Location: support/question_27/thank-you.php
Browser follow-up: GET result page showing Demo complete.
Empty/array name: Valid name required hai.

HOW TO USE THIS FILE
-------------------------------------------------------------------------------
VS Code mein comments padho aur neeche diye gaye complete examples run karo.
Expected output aur step-by-step explanation code ke paas comments mein hain.
Har Question file ko separately run karo; sabko ek saath include mat karo.

REFERENCE LINKS FROM THE EARLIER GUIDE
-------------------------------------------------------------------------------
https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Status/303
https://www.php.net/manual/en/function.header.php

CONTENT NOTE
-------------------------------------------------------------------------------
Yeh file chat mein diye gaye Question 27 ko package karti hai. Koi naya
interview topic add nahi kiya gaya. Form action/redirect filenames ko runnable
package ke paths se match kiya gaya hai; relevant changes neeche noted hain.
===============================================================================
*/

header("Content-Type: text/html; charset=UTF-8");

if (($_SERVER["REQUEST_METHOD"] ?? "") === "POST") {
    $name = $_POST["name"] ?? "";
    if (!is_string($name) || trim($name) === "") {
        exit("Valid name required hai.");
    }

    // Demo mein sirf validation hui hai, database save nahi.
    header("Location: support/question_27/thank-you.php", true, 303);
    exit;
}

/*
COMPANION FILE — complete source:
public/support/question_27/thank-you.php

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Demo complete</title>
</head>
<body>
    <h1>Demo complete</h1>
    <p>Ab yeh result page GET request se open hua hai.</p>
</body>
</html>
*/
?>
<!DOCTYPE html>
<html lang="hi-Latn">
<head>
    <meta charset="UTF-8">
    <title>Question 27 — Post/Redirect/Get</title>
</head>
<body>
<form method="post" action="Question_27.php">
    <input type="text" name="name" required>
    <button type="submit">Continue</button>
</form>
</body>
</html>
