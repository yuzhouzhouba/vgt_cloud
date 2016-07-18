<?php
require 'handle.php';
require 'list.php';
include('lib/spyc-master/Spyc.php');
#error_reporting(E_ALL || ~E_NOTICE);
$ret=0;	

#check status
echo "==== checking status ====<br/>";
if($machine_status_list["$s1"]=="unavailable")
{
	echo "your machine is unavailable";
	echo "<br/>";
	$ret=1;
}
else
{
	echo "your machine is available";
	echo "<br/>";
}

	


#check user
echo "==== checking disk ====<br/>";
foreach($machine_user_list as $x=>$x_value)
{
if ($x_value==$user)
{
	$ret=1;
}
}


#debug
#var_dump($user_form);
#check if you're new user

#exec and change yaml
if($ret==0)
{
#change user
echo "launch the machine!";
$file='yaml/'.$s1.'.yaml';
$array = Spyc::YAMLLoad("yaml/".$s1.".yaml");
$array['user'] = $user;
$yaml = Spyc::YAMLDump($array,4,60);
$fp = fopen($file,'w');
fwrite($fp, $yaml);
fclose($fp);

#run
#system ("./machine.py $file >result 2>&1 &");
#sleep(5);

#change status
$status="unavailable";
$array = Spyc::YAMLLoad("yaml/".$s1.".yaml");
$array['status'] = $status;
$array['user'] = $user;
$yaml = Spyc::YAMLDump($array,4,60);
$fp = fopen($file,'w');
fwrite($fp, $yaml);
fclose($fp);


$fp = fopen($file,'w');
fwrite($fp, $yaml);
fclose($fp);
$url="http://ilab.intel.com/index.php?main_page=environments&group_id=2923801#env-5703101";
echo "config export success!";
echo '<pre>YAML Data dumped back:<br/>';
echo Spyc::YAMLDump($array);
echo '</pre>';
echo "<a href='$file' download=''>click to download</a>";
echo "<a href='$url' target='view_window'>machine</a>";


}
else
{
	echo "you are not the right user<br/>";
	echo "the disk being using by ".$user."<br/>"; 
}

?>
<a href="showlist.php"><input type="button" name="img" value="show list" size=20></a>
