<?php
$cars=["brand"=>"ford","model"=>"mustang","year"=>1946];
// var_dump($cars);
// accessing
echo $cars["year"];
echo "<br>";
foreach($cars as $key=>$value){
    echo "$key:$value <br>";
    // crud
     
}
// updating or editing
$cars["year"]=2008;
var_dump($cars);
echo "$key";
echo"<br>";
// adding arrays items
$scores=["math"=>70,"eng"=>40,"comp"=>80];
// $scores+=["kisw"=>70, "french"=>55, "sci"=>32];
var_dump($scores);
// remove array items
// unset remove item from an array
// unset($scores["eng"]);
$newArray=array_diff($scores,[50]);
var_dump($newArray);
// indexed
// associative
// multidimensional arrays 2d 3d
// 




































?>