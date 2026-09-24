<!-- 1. Function
A function is a self-contained, reusable block of code designed to perform a specific task. Instead of writing the same logic multiple times throughout your application, you wrap it inside a function and call it whenever needed. -->

<?php


function add(int $num1,int $num2=0):string{
$answer =  $num1+$num2;
return "Addition of $num1 + $num2 is $answer <br>";
}

add(5,10);
add(8,10);
add(9,10);
add(5,230);
add(5,70);

echo add(1);

$result = add('a',965);
echo $result;


?>