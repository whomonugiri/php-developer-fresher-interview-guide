<!-- n PHP, the ternary operator (?:) is a shorthand alternative to writing a basic if...else conditional statement. It is called a "ternary" operator because it takes three operands: a condition to evaluate, a value to return if the condition is true, and a value to return if the condition is false -->

<?php
$num=8;
if($num==8){
    echo "number is eight";
}else{
    echo "number is not eight";
}

echo $num==8?"number is eight":"number is not eight";
?>