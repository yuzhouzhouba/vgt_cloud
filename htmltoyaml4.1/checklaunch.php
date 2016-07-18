<?php
require 'handle.php';
require 'list.php';
include('lib/spyc-master/Spyc.php');
#error_reporting(E_ALL || ~E_NOTICE);
$ret=0;	

#check status
echo "========= checking status ========<br/>";
if($machine_status_list["$s1"]=="unavailable")
{
	echo "your machine is unavailable";
	echo "<br/>";
	exit;
	$ret=1;
}
else
{
	echo "your machine is available";
	echo "<br/>";
}

$ret=1;
#check image
echo "==========checking image=======<br/>";
for($i=0;$i<count($user_form);$i++)
{
	$user_form[$i]=chop($user_form[$i]);
	if($user_form[$i]==$user)
	{
		echo "you own your os,ready to boot<br/>";
		$ret=0;
	}
}
if($ret==1)
{
	echo "you don't have your os to boot<br/>";
}


#check user
echo "========checking disk =======<br/>";
foreach($machine_user_list as $x=>$x_value)
{
if ($x_value==$user)
{
	$ret=1;
}
}




#exec and change yaml
if($ret==0)
{
#change user and copy the file get ready to run
echo "launch the machine!"	;
$file='yaml/'.$s1.'.yaml';
$array = Spyc::YAMLLoad("yaml/".$s1.".yaml");
$array['user'] = $user;
$yaml = Spyc::YAMLDump($array,4,60);
$file_to_run='yaml-to-run/'.$s1.'.yaml';
$fp = fopen($file_to_run,'w');
fwrite($fp, $yaml);
fclose($fp);


#run!!!!!!!!!!!
system ("./machine.py $file_to_run >result 2>&1 &");
sleep(2);
#change user and status to keep the yaml saving the ture imformation
$status="unavailable";
$array = Spyc::YAMLLoad("yaml/".$s1.".yaml");
$array['status'] = $status;
$array['user'] = $user;
$yaml = Spyc::YAMLDump($array,4,60);
$fp = fopen($file,'w');
fwrite($fp, $yaml);
fclose($fp);

#show the data
$url="http://ilab.intel.com/index.php?main_page=environments&group_id=2923801#env-5703101";
echo "<br/><br/>";
echo "config export success!";
echo '<pre>YAML Data dumped back:<br/>';
echo Spyc::YAMLDump($array);
echo '</pre>';
echo "<a href='$file' download=''>click to download</a>";
echo "<br/>";
echo "<a href='$url' target='view_window'>ilab</a>";
}
else
{
	echo "image name illegal<br/>";
}

?>
<br/>
<a href="showlist.php"><input type="button" name="img" value="show list" size=20></a>
