<?php 
require 'list.php';
#get checkbox value
$c1="";
$c2="";
$c3="";
if(isset($_POST['c1'])){
foreach( $_POST['c1'] as $i)
{
 $c1 .= $i;
}
}


#get select option value
/*if ( $s1 ) {
    echo htmlentities($_POST['s1'], ENT_QUOTES, "UTF-8");
   }else{
    echo "task option is required";
    exit; 
}
echo "<br>";
*/
$s1 = isset($_POST['s1']) ? $_POST['s1'] : false;
$s2 = isset($_POST['s2']) ? $_POST['s2'] : false;


#get radio value
$status = isset($_POST['status']) ? $_POST['status'] : false;
$type = isset($_POST['type']) ? $_POST['type'] : false;
#get input value
$ip = isset($_POST['ip']) ? $_POST['ip'] : false;
#$mac = isset($_POST['ip']) ? $_POST['mac'] : false;
$vnc = isset($_POST['vnc']) ? $_POST['vnc'] : false;
$comip = isset($_POST['comip']) ? $_POST['comip'] : false;
$user = isset($_POST['user']) ? $_POST['user'] : false;
$user=chop($user);
$newuser = isset($_POST['newuser']) ? $_POST['newuser'] : false;
$copyuser = isset($_POST['copyuser']) ? $_POST['copyuser'] : false;
$xenc = isset($_POST['xenc']) ? $_POST['xenc'] : false;
$kernel = isset($_POST['kernel']) ? $_POST['kernel'] : false;

#covert into yaml
include('lib/spyc-master/Spyc.php');
if(file_exists("yaml/".$s1.".yaml"))
{$array = Spyc::YAMLLoad("yaml/".$s1.".yaml");}	
$array['machine'] = "$s1";
#$array['status'] = "$status";
$array['img'] = "$s2";
#$array['itp'] = "$c1";
$array['type'] = "$type";
#$array['ip'] = "$ip";
#$array['mac'] = "$mac";
#$array['vnc'] = "$vnc";
#$array['comip'] = "$comip";
$array['user'] = "$user";
$array['xenc'] = "$xenc";
$array['kernel'] = "$kernel";
$yaml = Spyc::YAMLDump($array,4,60);

?>
