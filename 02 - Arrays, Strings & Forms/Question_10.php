<?php
/*
===============================================================================
FRESHER PHP DEVELOPER INTERVIEW GUIDE
PART 2: ARRAYS, STRINGS & FORMS
By CODEGULLY, Monu Kumar Giri
===============================================================================

QUESTION 10 | ARRAYS
array_map(), array_filter() aur array_reduce() mein kya difference hai?

DEFINITION / INTERVIEW ANSWER — HINGLISH
-------------------------------------------------------------------------------
array_map() har element ko transform karta hai. array_filter() condition ke
according elements select karta hai. array_reduce() elements ko process karke
ek accumulated result banata hai, jaise total amount.

In functions ko diya gaya function callback kehlata hai.

DETAILED EXPLANATION — HINGLISH
-------------------------------------------------------------------------------
Map example: Har product ki price mein se Rs. 100 discount.
Filter example: Sirf Rs. 1000 ya usse expensive products select karna.
Reduce example: Sabhi prices add karke single total calculate karna.

Reduce mein initial accumulator 0 diya hai. Har call par current total aur
next price aati hai; callback updated total return karta hai.
Filter ke result par array_values() sirf fresh sequential keys ke liye hai.

IMPORTANT INTERVIEW POINTS / COMMON MISTAKES
-------------------------------------------------------------------------------
Callback ke bina array_filter() false-like values remove karta hai, including
0 aur "0". Valid zero amounts wale data par ise blindly use mat karo.

HOW TO USE THIS FILE
-------------------------------------------------------------------------------
VS Code mein comments padho aur neeche diye gaye complete examples run karo.
Expected output aur step-by-step explanation code ke paas comments mein hain.
Har Question file ko separately run karo; sabko ek saath include mat karo.

REFERENCE LINKS FROM THE EARLIER GUIDE
-------------------------------------------------------------------------------
https://www.php.net/manual/en/function.array-map.php
https://www.php.net/manual/en/function.array-filter.php
https://www.php.net/manual/en/function.array-reduce.php

CONTENT NOTE
-------------------------------------------------------------------------------
Yeh file chat mein diye gaye Question 10 ko package karti hai. Koi naya
interview topic add nahi kiya gaya. Form action/redirect filenames ko runnable
package ke paths se match kiya gaya hai; relevant changes neeche noted hain.
===============================================================================
*/

header("Content-Type: text/html; charset=UTF-8");
echo "<pre>";

$prices = [500, 1000, 1500,2000];
print_r($prices);
// EXAMPLE 1 — MAP: Har product par Rs. 100 discount.
$discountedPrices = array_map(function (int $price): int {
    return $price /10;
}, $prices);

print_r($discountedPrices);
// [400, 900, 1400]

// EXAMPLE 2 — FILTER: Sirf Rs. 1000 ya usse expensive products.
// $selectedPrices = array_filter($prices, function (int $price): bool {
//     return $price >= 1000;
// });

$selectedPrices = array_filter($prices, 
function ($price){
    return $price < 1000;
}
);


print_r(array_values($selectedPrices));
// [1000, 1500]

// EXAMPLE 3 — REDUCE: Total amount.
$total = array_reduce(
    $prices,

    function (int $total, int $price): int {

        return $total + $price;
    },

    0
);

echo "Total: ₹" . $total;
// Total: ₹3000

echo "</pre>";
