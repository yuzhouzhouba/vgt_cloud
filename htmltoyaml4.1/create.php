<?php
require 'handle.php';
#error_reporting(E_ALL || ~E_NOTICE);
$ret=1;
#check image

if ( $s2=="copy_other" )
{
	$s2=$copyuser;
}

echo "==========checking image=======<br/>";

if($newuser=="")
{
	echo "input name empty!!!!!";
	exit();
}
for($i=0;$i<count($user_form);$i++)
{
	$user_form[$i]=chop($user_form[$i]);
	if($user_form[$i]==$newuser)
	{
		echo "the name is being use";
		$ret=0;
		exit();
	}
}




if($ret==1)
{
	echo "you are creating image:".$newuser."<br/>please waiting for 5 mins<br/>";
	echo "from: ".$s2."<br/>";
	file_put_contents("user_form", "$newuser".PHP_EOL, FILE_APPEND);
	system("cp /remote_fs/$s2 /remote_fs/$newuser 2>&1 &");

}



?>
<div style='float:left;background-color:#FFFFFF;width:200px;height:8px;padding:1px;border:#CCCCCC 1px solid;overflow:hidden;'>
    <div id='jindu' style='float:left;width:0;height:8px;background-color:#669966;overflow:hidden;'>&nbsp;</div>
  </div>
<?php

set_time_limit(0);
$step = 0;

for ($i = 0; $i < 200; $i++) {
  sleep(2); //这个是为了测试
  $step+=1; //实际步点你自己掌握
  echo '<script> document.getElementById("jindu").style.width = "'.$step.'px"; </script>';
  ob_flush(); //这个是为了测试
  flush(); //这个是为了测试 
}
?>