<?php
// i want to print to 5
$i=0;
while($i<=5){
    echo "number: $i <br>";
    $i++;
}
echo "<br>";
echo "<br>";
// do while loop
$a=1;
do{
    echo "Score:$a <br>";
    $a++;
}while($a<=5);
echo "<br>";
echo "<br>";
// for loop
for($b=1; $b<=10; $b++){
    echo "number is : $b <br>";
}
echo "<br>";
echo "<br>";
// foreach array for each as key =>$value
$fruits=["mango","apple", "banana", "berry"];
$score=array("math"=>50, "eng"=>70,"hist"=>80);
foreach($fruits as $fruits){
    echo "$fruits <br>";
}
foreach($score as $key =>$value){
    echo "$key= $value <br>";
}
echo "<br>";
echo "<br>";

// 1. While loop: Even numbers between 1 and 20
$even=2;
while($even<=20){
    echo "even no=$even <br>";
    $even+=2;
}
echo "<br>";
// 2. Sum of numbers from 1 to 100
echo " 2. Sum 1 to 100  ";
$sum = 0;
for ($i = 1; $i <= 100; $i++) {
    $sum += $i;
}
echo "Sum: " . $sum . "";
echo "<br>";
// 3. Multiplication table of 5
echo "\n 3. Multiplication Table of 5   ";
$number = 5;
for ($i = 1; $i <= 10; $i++) {
    echo "$number * $i = " . ($number * $i) . "\n";
}
echo "<br>";
// 4. Foreach with associative array
echo " 4.  Array (Ages)  ";
$ages = ["John" => 25, "Mary" => 30];
foreach ($ages as $name => $age) {
    echo "$name is $age years old.";
}
echo "<br>";
// 5. Sum of array elements
echo " 5. Sum of Array Elements   ";
$numbers = [4, 8, 15, 16, 23, 42];
$arraySum = 0;
foreach ($numbers as $num) {
    $arraySum += $num;
}
echo "Total Sum: " . $arraySum . "";
echo "<br>";
// 6. Largest number in array without max()
echo " 6. Largest Number in Array  ";
$largest = $numbers[0];
foreach ($numbers as $num) {
    if ($num > $largest) {
        $largest = $num;
    }
}
echo "Largest Number: " . $largest . "";
echo "<br>";
// 7. Loop stopping (break) when divisible by 7
echo "<br>";
// 8. Loop skipping (continue) even numbers
 
echo "<br>";
// 9. Loop skipping multiples of 3 (1 to 30)
echo " 9. Skip Multiples of 3 (1 to 30)  ";
for ($i = 1; $i <= 30; $i++) {
    if ($i % 3 === 0) {
        continue;
    }
    echo $i . "\n";
}
echo "<br>";
// 10. Code output snippet
echo " 10. Code Output   ";
for ($i = 0; $i < 5; $i++) {
    if ($i == 2) continue;
    echo $i;
}
echo "<br>";
echo "<br>";
$a=2;
while($a>=20){
    echo "even= $a <br>";
    $a=+2;
}
$a=1;
while($a<=100){
    echo "echo $a <br>";
    $a++;
}
$ages [12, 18, 20, 15, 30];
$a=0
foreach($ages as $age $a<=30 $ages++;){
    echo $ages;
}














?>