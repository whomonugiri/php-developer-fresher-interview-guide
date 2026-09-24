<!-- 1. The for Loop
Commonly used for counters, pagination logic, or fixed numeric boundaries. It combines initialization, condition checking, and increment/decrement logic in a single statement. -->

<?php

for($i=1;$i<=10;$i++){
  echo "FOR LOOP $i<br>";
}

?>

<!-- 2. The foreach Loop
Designed specifically to cycle through the items of an array without manually managing index increments. It supports both indexed and associative arrays. -->

<?php
$names = ["Monu","Sonu","Sumit","Ankit","Mohit"];
foreach($names as $index=>$name){
    echo "FOREACH LOOP : NAME - $name $index <br>";
}
?>

<!-- 3. The while Loop
Evaluates the conditional statement at the very beginning of the loop. If the condition evaluates to false initially, the internal block is skipped entirely. -->

<?php
$count=1;
while($count<10){
echo "WHILE LOOP : $count <br>";
$count++;
}
?>


<!-- 4. The do...while Loop
Unlike a traditional while loop, this layout checks the condition at the end of an iteration. The code block runs unconditionally the first time. -->

<?php
$count = 0;

do {
    echo "DOWHILE LOOP $count <BR>";
    $count++;
}while($count<0);
?>