<!-- In PHP, if, elseif, switch, and match are all control structures used to make decisions in your code. While they handle conditional logic, they differ significantly in syntax, use cases, and how they evaluate data -->
<!-- 
1. if and elseif
The if and elseif statements are the most flexible, general-purpose conditional structures. They evaluate boolean conditions (expressions that turn out to be true or false) and are ideal for handling complex logic, ranges, or multiple unrelated variables -->

<?php

$balance = 100;
$wallet = 0;

if($balance==$wallet){
    echo "ok";
}elseif($wallet == 0){
    echo "empty";
}else{
    echo "not ok";
}

?>

<!-- 2. switch
The switch statement compares a single value against multiple specific cases. It provides a cleaner look than a long chain of if/elseif blocks. However, it uses loose comparison (==), which can sometimes lead to unexpected matches if your types do not align perfectly. -->

<?php
$weekday = 8;

switch($weekday){
    case 1:
        echo "Sunday";
        break;
    case 2:
        echo "Monday";
        break;
    case 3:
        echo "Tuesday";
        break;
    case 4:
        echo "Wednesday";
        break;
    case 5:
        echo "Thusday";
        break;
    case 6:
        echo "Friday";
        break;
    case 7:
        echo "Saturday";
        break;
    default:
        echo "Invalid Week day";
        break;
}

?>

<!-- 3. match (PHP 8.0+)
Introduced in PHP 8.0, the match expression is a modernized, cleaner alternative to switch. It maps a single value directly to a single result. -->

<?php

$dayname = match($weekday){
    1=>"Sunday",
    2=>"Monday",
    3=>"Tuesday",
    4=>"Wednesday",
    5=>"Thusday",
    6=>"Friday",
    7,8=>"Saturday",
    default => "invalid week day"
};


echo $dayname;

?>