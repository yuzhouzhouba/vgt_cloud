<?php
include('lib/spyc-master/Spyc.php');
Error_reporting(E_ALL);
INI_Set('display_errors','on');
#error_reporting(E_ALL || ~E_NOTICE);

#read yaml file
$mydir = dir("yaml/"); 
$i=0;
while($file = $mydir->read())
	{ 
		$file="yaml/".$file;	
		#if($file!='yaml/.'&&$file!='yaml/..')
		if(preg_match('/.yaml$/',$file))
		{
			$array = Spyc::YAMLLoad($file);
			$machine_list[$i]=$array['machine'];		
			$status_list[$i]=$array['status'];
			$user_list[$i]=$array['user'];
			$ip_list[$i]=$array['ip'];
			$vnc_list[$i]=$array['vnc'];
			$mac_list[$i]=$array['mac'];
			$comip_list[$i]=$array['comip'];
			$i++;
		}
	}  
$mydir->close(); 
$length=count($machine_list);


#read user
$file = fopen("user_form", "r");
$user_form=array();
$i=0;
while(! feof($file))
{
 $user_form[$i]= fgets($file);//fgets()函数从文件指针中读取一行
 $i++;
}
fclose($file);
$user_form=array_filter($user_form);





#wirte into array
$machine_status_list=array_combine($machine_list, $status_list);
$machine_user_list=array_combine($machine_list, $user_list);
$machine_ip_list=array_combine($machine_list, $ip_list);
$machine_vnc_list=array_combine($machine_list, $vnc_list);
$machine_comip_list=array_combine($machine_list, $comip_list);
$machine_mac_list=array_combine($machine_list, $mac_list);
$_SESSION['ipname'] = $machine_ip_list;
$_SESSION['vncname'] = $machine_vnc_list;
$_SESSION['comname'] = $machine_comip_list;
$_SESSION['macname'] = $machine_mac_list;
$_SESSION['username'] = $machine_user_list;
$_SESSION['statusname'] = $machine_status_list;


?>
