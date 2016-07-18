<?php 
require 'list.php';
//Array contents array 1 :: value 
$myArray1 = array('Cat','Mat','Fat','Hat'); 
//Array contents array 2 :: key => value 
$myArray2 = array('c'=>'Cat','m'=>'Mat','f'=>'Fat','h'=>'Hat'); 
//Values from array 1 
echo'<select name="Words">'; 
//for each value of the array assign a variable name word 
foreach($user_form as $word){ 
  echo'<option value="$word">'.$word.'</option>'; 
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


#debug
#var_dump($user_form);
#check if you're new user
####################################################
#如果不是新用户，直接走下面的流程
#如果是新用户，让他确认一次，防止他写错了，弹个框什么的或者跳转个页面。。。
#他确认之后，会把他的名字写入user_form,然后执行后面的流程
echo "==== checking new ====<br/>";
$ret1=0;
$l=count($user_form);
for($i=0;$i<$l;$i++)
{
	if($user_form[$i]=="$user".PHP_EOL)
		{
			$ret1=1;	
		}
}

if($ret1==0)
{
	#file_put_contents("user_form", "$user".PHP_EOL, FILE_APPEND);
	echo "you are applying for a new image please wait for 5 mins";
	echo "<br/>";
}
else
{
	echo "the system is going to use your os to boot<br/>";
}
######################################################



if($ret1==0)
{
file_put_contents("user_form", "$user".PHP_EOL, FILE_APPEND);
}