<html>




<?php
require 'list.php';
echo "<br/>=============the machine_list===================<br/>";
#var_dump($machine_list);
	echo "|machine_name|"."      ";
	echo "state|"."      ";
	echo "img_name|"."<br/>      ";
for($i=0;$i<$length;$i++)
{
	echo $machine_list[$i]."      ";
	echo $status_list[$i]." ";
	echo $user_list[$i];
	echo "<br/>";
}


echo "<br/>=============the image_list===================<br/>";
foreach($user_form as $x=>$x_value) {
	$num=$x+1;
echo "<script>
    function myFunction".$num."() {
    document.getElementById(".$num.").style.textDecoration='line-through';
    }
</script>";
 echo  '<div id='.$num.'> num:' .$num.'     image_name: ' . $x_value.'</div>';
 #echo "<input type='button' name='disable' value='disable' size=20 onclick='myFunction".$num."()'>"; 
}




echo "<a href='index.php'><input type='button' name='img' value='back' size=20></a>";
?>

</html>