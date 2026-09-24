<!-- In PHP, $ is used to declare a standard variable, while $$ is used to create a variable variable—a variable whose name is dynamically determined by the value of another variable.  -->
<?php
$variable_name = "myworld";
$$variable_name = "Earth";

echo $myworld;

?>