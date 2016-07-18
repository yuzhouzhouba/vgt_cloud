<?php
require_once('main.php');
 if(is_uploaded_file($_FILES['filename']['tmp_name'])){
	$root_dir ="yaml-to-upload/";
	$filename =  $_FILES['filename']['name'];
	$uploadfile = $root_dir . $filename;
	if (move_uploaded_file($_FILES['filename']['tmp_name'], $uploadfile)) {
     		include('spyc-master/Spyc.php');
			$array = Spyc::YAMLLoad($uploadfile);
			session_start();
			$_SESSION['machine'] = $array['machine'];
			$_SESSION['state'] = $array['state'];
			$_SESSION['img'] = $array['img'];
			$_SESSION['itp'] = $array['itp'];
			$_SESSION['type'] = $array['type'];
			$_SESSION['ip'] = $array['ip'];
			$_SESSION['vnc'] = $array['vnc'];
			$_SESSION['comip'] = $array['comip'];
			$_SESSION['user'] = $array['user'];
			$_SESSION['xenc'] = $array['xenc'];
			$_SESSION['boot'] = $array['boot'];
			$_SESSION['locate'] = $array['locate'];
			$_SESSION['kernel'] = $array['kernel'];
			
	}  
	unlink($uploadfile);
}
do_html();
?>