<!-- In PHP, a constant is an identifier (name) for a simple value that cannot be changed or undefined during the execution of the script. Unlike variables, constants are immutable and remain fixed once set -->

<!-- Key Characteristics of PHP Constants
No Dollar Sign ($): Unlike variables, constants are declared and accessed without a leading $ symbol.

Global Scope: Constants are automatically global. You can access them anywhere in your script—including inside functions and classes—without needing the global

Naming Conventions: A valid constant name must start with a letter or an underscore, followed by any combination of letters, numbers, or underscores. By convention, they are always written in UPPERCASE. -->

<?php
const API_KEY = "ASDVBHAVDHAGSHDHASHDASD";

const api_key = "ASDASD ";

define("API_SECRET","asd5a6s5da6s5d6as");

echo API_KEY;
echo API_SECRET;

if(1==1){
    define("NAME","monu");
}

//define can be used in loops, conditional statements adn functions also.

//const can be only used in top level scope or classes




?>

