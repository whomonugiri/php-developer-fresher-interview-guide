
<!-- 1.Return Value & Expression Use
• echo does not return any value. Because it has no return value, you cannot use it inside conditional statements or expressions.
• print always returns the integer 1. This behavior allows it to act like a function and participate in expressions. -->
<?php

// $result  = print("Hello World");
// $result2 = echo "Hello World"; it will give syntax error

// var_dump($result);  // Outputs: int(1)

?>



<!-- 2. Number of Arguments
• echo can take multiple parameters separated by commas, provided you do not use parentheses.
• print can only take a single argument. -->

<?php
$name1 = "John";
$name2 = "Mukus";
$name3 = "Sumit";

echo $name1," ",$name2," ",$name3;
print($name1); 
print($name2);
print($name3);

?>