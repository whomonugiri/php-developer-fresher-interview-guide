<!-- 1. Global Scope
A variable declared outside of any function belongs to the global scope. By default, it can only be accessed outside of functions.
a PHP function cannot directly see a global variable unless you explicitly import it inside the function using the global keyword or the $GLOBALS array. -->

<?php
$name="Codegully";

function sayit(){
global $name;    
// echo $name;
// echo $GLOBALS['name'];
}

sayit();
?>

<!-- 2. Local Scope
A variable declared inside a function has a local scope. It can only be accessed within that specific function. As soon as the function finishes executing and returns, the local variable and its data are completely deleted from memory. -->

<?php


function bolbhai(){
$name2 = "sumit";
// echo $name2;
}

bolbhai();
// echo $name;
?>

<!-- 3. Static Scope
A static variable is a special type of local variable. It is defined inside a function using the static keyword.
While a regular local variable is destroyed when a function ends, a static variable retains its value across multiple function calls. It initializes only the first time the function is called. -->

<?php

function jump(){
    static $count = 0;
    $count++;
    echo "Jump".$count;
}

jump();
jump();
jump();
jump();
jump();



?>