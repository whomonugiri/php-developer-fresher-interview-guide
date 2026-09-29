<?php
/*
===============================================================================
FRESHER PHP DEVELOPER INTERVIEW GUIDE
PART 2: ARRAYS, STRINGS & FORMS
By CODEGULLY, Monu Kumar Giri
===============================================================================

QUESTION 19 | FORMS
HTML form ka data PHP tak kaise pahunchta hai? action, method, name aur id ka kya role hai?

DEFINITION / INTERVIEW ANSWER — HINGLISH
-------------------------------------------------------------------------------
Form user se input collect karta hai. action batata hai data kis URL par
bhejna hai, method request method decide karta hai, aur input ka name
submitted field ki key banta hai.

id element ko labels, CSS aur JavaScript mein identify karne ke kaam aata
hai. Sirf id dene se field ka data us naam se PHP mein nahi aata.

DETAILED EXPLANATION — HINGLISH
-------------------------------------------------------------------------------
Form mein id="student-name" aur name="student_name" hai.
PHP mein $_POST["student_name"] use hoga; key name attribute se banti hai.
method="post" ki wajah se submitted field $_POST se read karte hain.

Missing input ke liye ?? "" default diya hai. Crafted request mein string
ki jagah array bhi aa sakta hai, isliye is_string() check hai.
trim() ke baad empty string reject hoti hai. Valid name ko HTML mein output
karte waqt htmlspecialchars() use kiya hai.

PACKAGING NOTE:
Pehle explanation mein form.html aur process.php do files the. Neeche same
form aur processing ek standalone Question_19.php mein combined hain.
GET par form dikhta hai; POST par name process hota hai.
Original two-file version public/support/question_19/ mein bhi included hai.
Us version ka process.php non-POST request ke liye 405 return karta hai.

IMPORTANT INTERVIEW POINTS / COMMON MISTAKES
-------------------------------------------------------------------------------
PHP key student_name hogi, student-name nahi, kyunki name attribute wahi hai.
Normal user input aur crafted request dono ke types ko handle karo.

EXPECTED RESULT:
GET: Student name input aur Submit button dikhenge.
POST student_name=Aman: Namaste, Aman
Empty name: Student name required hai.
Array as name: Invalid name format. (HTTP 400)

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
Yeh file chat mein diye gaye Question 19 ko package karti hai. Koi naya
interview topic add nahi kiya gaya. Form action/redirect filenames ko runnable
package ke paths se match kiya gaya hai; relevant changes neeche noted hain.
===============================================================================
*/

header("Content-Type: text/html; charset=UTF-8");

$method = $_SERVER["REQUEST_METHOD"] ?? "GET";

// Same-file adaptation: GET form render karega; POST process karega.
if ($method !== "GET" && $method !== "POST") {
    http_response_code(405);
    exit("Sirf GET aur POST request allowed hai.");
}

if ($method === "POST") {
    $name = $_POST["student_name"] ?? "";

    // Crafted request mein string ki jagah array bhi aa sakta hai.
    if (!is_string($name)) {
        http_response_code(400);
        exit("Invalid name format.");
    }

    $name = trim($name);
    if ($name === "") {
        exit("Student name required hai.");
    }

    echo "Namaste, " . htmlspecialchars(
        $name,
        ENT_QUOTES | ENT_SUBSTITUTE,
        "UTF-8"
    );
    exit;
}
?>
<!DOCTYPE html>
<html lang="hi-Latn">
<head>
    <meta charset="UTF-8">
    <title>Question 19 — Form Basics</title>
</head>
<body>
<!-- name PHP ki field key hai. id label ko input se connect karta hai. -->
<form action="Question_19.php" method="post">
    <label for="student-name">Student name</label>
    <input
        type="text"
        id="student-name"
        name="student_name"
        required
    >
    <button type="submit">Submit</button>
</form>
</body>
</html>
