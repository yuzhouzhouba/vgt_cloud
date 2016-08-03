<?php 
//Array contents array 1 :: value 
$myArray1 = array('Cat','Mat','Fat','Hat'); 
//Array contents array 2 :: key => value 
$myArray2 = array('c'=>'Cat','m'=>'Mat','f'=>'Fat','h'=>'Hat'); 
//Values from array 1 
echo'<select name="Words">'; 
//for each value of the array assign a variable name word 
foreach($myArray1 as $word){ 
  echo'<option value="'.$word.'">'.$word.'</option>'; 
} 
echo'</select>'; 
//Values from array 2 
echo'<select name="Words">'; 
//for each key of the array assign a variable name let 
//for each value of the array assign a variable name word 
foreach($myArray2 as $let=>$word){ 
  echo'<option value="'.$let.'">'.$word.'</option>'; 
} 
echo'</select>'; 
?>