<?php
require 'handle.php';
require 'list.php';
include('lib/spyc-master/Spyc.php');
#error_reporting(E_ALL || ~E_NOTICE);
$ret=0;	
$name=$s1;
#check status
echo "==== checking status ====<br/>";
if($machine_status_list["$s1"]=="unavailable")
{
	echo "ok";
	echo "<br/>";
}
else
{
	echo "your machine is available ";
	echo "<br/>";
	exit();
}

#check user
echo "==== checking disk ====<br/>";
if($machine_user_list["$s1"]==$user)
{
	echo "you are the right user";
	echo "<br/>";
}
else
{
	echo "you are not the right user";
	echo "<br/>";
	exit();
}


#check safety,we need to insure the machine is poweroff,or let him poweroff the machine from ilab
echo "=== checking power ===<br/>";
$time=3;
$ip=$machine_ip_list[$s1];
$out=exec("ping -c $time $ip");
$out=substr($out,-2);
$out="ms";
if ($out=="ms")
{
	echo "fail:you need to shutdown the machine";
	$ret=1;

}
else
{
	echo "pass!";
}


#exec the cmd
if($ret==0)
{
echo "successfully release the machine!";
$status="available";
$array = Spyc::YAMLLoad("yaml/".$s1.".yaml");
$array['status'] = $status;
$array['user'] = "nobody";
$yaml = Spyc::YAMLDump($array,4,60);
$file='yaml/'.$s1.'.yaml';
$fp = fopen($file,'w');
fwrite($fp, $yaml);
fclose($fp);
#system ("/root/remote_fs/backend/machine.py $file");
#pkill inotify
}
echo "<br/>";

?>
<a href="<?php echo "cmd/shutdown.php?name=".$name ?>"><input type="button" name="img" value="force_shut" size=20></a>
<a href="<?php echo "cmd/reboot.php?name=".$name ?>"><input type="button" name="img" value="force_reboot" size=20></a>