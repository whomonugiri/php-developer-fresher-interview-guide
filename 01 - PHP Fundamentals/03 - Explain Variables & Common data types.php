<!-- Rules for PHP variables:

- A variable must start with the $ sign, followed by the name of the variable
- A variable name must start with a letter or the underscore character
- A variable name cannot start with a number
- A variable name can only contain alpha-numeric characters and underscores (A-z, 0-9, and _ )
- Variable names are case-sensitive ($age and $AGE are two different variables) -->

<?php

$my_home_address = "new delhi";


$NAME="Sumit";
$name="Mohan";

// echo $name," ",$NAME;

?>

<!-- PHP is a dynamically typed language. This means that you do not need to explicitly declare a variable's data type when creating it. Instead, PHP automatically determines the data type at runtime based on the value assigned to the variable
common data types:
string (text values)
int (whole numbers)
float (decimal numbers)
bool (true or false)
array (multiple values)
object (stores data as objects)
null (empty variable) -->

<?php
$data = "my name is supermanm";
var_dump($data);

$data = 100;
var_dump($data);

$data = 100.55;
var_dump($data);

$data = true;
var_dump($data);

$data = [1,2,3,4,5,6,"chsds",true];
var_dump($data);

$data = new stdClass();
var_dump($data);

$data = null;
var_dump($data);


?>