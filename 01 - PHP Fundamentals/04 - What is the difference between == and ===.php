<!-- The primary difference is that == (loose equality) compares only values after converting types if necessary, whereas === (strict equality) compares both values and data types without converting them. -->

<?php
$num1 = 10;
$num2 = "10";

if($num1 == $num2) echo "both are equal";
else echo "both are not equal";

if($num1 === $num2) echo "both are equal";
else echo "both are not equal";



?>