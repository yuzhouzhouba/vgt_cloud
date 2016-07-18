$ret=0;
$l=count($user_form);
for($i=0;$i<$l;$i++)
{
	if($user_form[$i]=="$user".PHP_EOL)
		{
			$ret=1;	
		}
}

if($ret==0)
{
	#file_put_contents("user_form", "$user".PHP_EOL, FILE_APPEND);
	echo "you are apply for a new image ,you sure to do this?";
	echo "<br/>";
	#echo "<a href='cmd.php'>yes</a>";
}
else
{







#run because the code would change the status, so it need to keep a file to do this
#system ("./machine.py $file >result 2>&1 &");
#sleep(5);