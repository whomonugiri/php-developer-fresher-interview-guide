<?php
/*
===============================================================================
FRESHER PHP DEVELOPER INTERVIEW GUIDE
PART 2: ARRAYS, STRINGS & FORMS
By CODEGULLY, Monu Kumar Giri
===============================================================================

QUESTION 20 | FORMS
GET aur POST mein kya difference hai? Kya POST automatically secure hai?

DEFINITION / INTERVIEW ANSWER — HINGLISH
-------------------------------------------------------------------------------
GET form mein submitted data URL ki query string mein jata hai.
POST form mein data request body mein jata hai.

Search aur filters ke liye GET useful hai. Registration, login aur
data-changing submissions ke liye generally POST use karte hain.
Lekin POST khud encryption provide nahi karta; transport encryption HTTPS
se milti hai.

DETAILED EXPLANATION — HINGLISH
-------------------------------------------------------------------------------
COMPARISON:
Point                  | GET form                     | POST form
-----------------------|------------------------------|-------------------------
Submitted data         | URL query string             | Request body
Example use            | Course search, filters       | Registration, enquiry
Form values in URL     | Shareable/bookmarkable URL    | Body values URL mein nahi
Automatically encrypted| Nahi                         | Nahi

Example: PHP search karne par URL Question_20.php?q=PHP banega.
$_GET["q"] query read karta hai. String type check aur trim() ke baad
HTML output ko escape karke dikhate hain.

PACKAGING NOTE:
Earlier sample ka search.php filename yahan Question_20.php kiya gaya hai.
GET behavior aur complete example logic same hai.

IMPORTANT INTERVIEW POINTS / COMMON MISTAKES
-------------------------------------------------------------------------------
"POST secure hai kyunki URL mein data nahi dikhta" incomplete aur misleading
answer hai. URL mein na dikhna encryption ke barabar nahi hai.

EXPECTED RESULT:
Initially empty search field aur Search: output.
PHP submit karne ke baad URL mein ?q=PHP aur page par Search: PHP.

HOW TO USE THIS FILE
-------------------------------------------------------------------------------
VS Code mein comments padho aur neeche diye gaye complete examples run karo.
Expected output aur step-by-step explanation code ke paas comments mein hain.
Har Question file ko separately run karo; sabko ek saath include mat karo.

REFERENCE LINKS FROM THE EARLIER GUIDE
-------------------------------------------------------------------------------
https://developer.mozilla.org/en-US/docs/Learn_web_development/Extensions/Forms/Sending_and_retrieving_form_data

CONTENT NOTE
-------------------------------------------------------------------------------
Yeh file chat mein diye gaye Question 20 ko package karti hai. Koi naya
interview topic add nahi kiya gaya. Form action/redirect filenames ko runnable
package ke paths se match kiya gaya hai; relevant changes neeche noted hain.
===============================================================================
*/

header("Content-Type: text/html; charset=UTF-8");

$query = $_GET["q"] ?? "";
$query = is_string($query) ? trim($query) : "";
?>
<!DOCTYPE html>
<html lang="hi-Latn">
<head>
    <meta charset="UTF-8">
    <title>Question 20 — GET vs POST</title>
</head>
<body>
<form method="get" action="Question_20.php">
    <input type="search" name="q" placeholder="Search course">
    <button type="submit">Search</button>
</form>

<p>
    Search:
    <?= htmlspecialchars(
        $query
    ) ?>
</p>
</body>
</html>
