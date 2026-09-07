<?php
//  we have 3 type of arrays indexed associative multidimensional
// indexed arrays 
$fruits=["mangoes","berry","oranges", "peaches"];
$cars=[];
$cars[0]="bmw";
$cars[1]="audi";
$cars[2]="benz";
$cars[3]="volvo";
var_dump($cars);
// accesing 
echo $fruits[2];
echo "my name is $fruits[1], i own a $cars[0]";
echo"<br>"; 
foreach($fruits as $student){
    echo "$student <br>";
    
}
    $utensils=["cups","spoons", "knives","trays","whisk",];
    // $utensils=[]="spoons";
    // array_push()"spoons","forks,"sieves",);
    // var_dump($utensils);
    // merge
    $newArray=array_merge($fruits,$cars);
    var_dump($newArray);

    // rem
// array_splice($utensils, 1,1);
var_dump($utensils)
// array_shift($phones);
 

















?>