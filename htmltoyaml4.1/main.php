<?php
#require_once('load.php'); 

require 'list.php';

function do_load(){
include('lib/spyc-master/Spyc.php');
#there is the array need to fill into form
if(file_exists("yaml/bdw-server.yaml"))
{$array = Spyc::YAMLLoad('yaml/bdw-server.yaml');}
#print_r($array);


#session_start();
#header("Location: ".$_SERVER['HTTP_REFERER']);
$_SESSION['machine'] = $array['machine'];
$_SESSION['status'] = $array['status'];
$_SESSION['img'] = $array['img'];
$_SESSION['itp'] = $array['itp'];
$_SESSION['type'] = $array['type'];
$_SESSION['ip'] = $array['ip'];
$_SESSION['mac'] = $array['mac'];
$_SESSION['vnc'] = $array['vnc'];
$_SESSION['comip'] = $array['comip'];
$_SESSION['user'] = $array['user'];
$_SESSION['xenc'] = $array['xenc'];
$_SESSION['kernel'] = $array['kernel'];
}


function do_html() {


$ip= $_SESSION['ip'];
$mac= $_SESSION['mac'];
$machine= $_SESSION['machine'];
$status= $_SESSION['status'];
$img=$_SESSION['img'];
$itp=$_SESSION['itp'];
$type=$_SESSION['type'];
$vnc=$_SESSION['vnc'];
$comip=$_SESSION['comip'];
$user=$_SESSION['user'];
$xenc=$_SESSION['xenc'];
$kernel=$_SESSION['kernel'];

?>

<!DOCTYPE HTML>
<html>
<head>
<title>VGT Cloud-Web</title>
<meta charset=" utf-8"> 
<script type="text/javascript" src="jQuery/jquery.js"></script>
<script type="text/javascript"> 

$(document).ready(function(){
  
  
  $(".bootconf1").hide();
  $(".bootconf2").hide();
   $(".checkbox1").click(function(){
   
  $(".bootconf1").show();
  $(".bootconf2").show();
  });
  
  
 
	$(".checkbox2").click(function(){


  $(".bootconf2").show();
  $(".bootconf1").hide();
  });

  if($(".checkbox1").is(":checked"))
  {$(".bootconf1").show();
   $(".bootconf2").show();}
   
   if($(".checkbox2").is(":checked"))
  {$(".bootconf2").show();
   $(".bootconf1").hide();}
  
  
  });


function submitAction(action_nm) 
{ 
var targetForm = document.qryposfrm; 
targetForm.action = action_nm; 
targetForm.submit(); 
} 

$(document).ready(function(){
   $(".select1").bind("change",function(){ 

    if($(this).val()==0){
      return; 
    } 
    else if ($(this).val()=='bdw-server')
			{
                                $(".ipname").val("<?php echo $_SESSION['ipname']['bdw-server'];?>");
                                $(".vncname").val("<?php echo $_SESSION['vncname']['bdw-server'];?>");
                                $(".comname").val("<?php echo $_SESSION['comname']['bdw-server'];?>");
                                $(".macname").val("<?php echo $_SESSION['macname']['bdw-server'];?>");
                                $(".username").val("<?php echo $_SESSION['username']['bdw-server'];?>");
                                $("input[name=status]").val(["<?php echo $_SESSION['statusname']['bdw-server'];?>"]);
			}

/*
	else if ($(this).val()=='BDW_01')
			{
                                $(".ipname").val("<?php echo $_SESSION['ipname']['BDW_01'];?>");
                                $(".vncname").val("<?php echo $_SESSION['vncname']['BDW_01'];?>");
                                $(".comname").val("<?php echo $_SESSION['comname']['BDW_01'];?>");
                                $(".macname").val("<?php echo $_SESSION['macname']['BDW_01'];?>");
                                $(".username").val("<?php echo $_SESSION['username']['BDW_01'];?>");
                                $("input[name=status]").val(["<?php echo $_SESSION['statusname']['BDW_01'];?>"]);
			}
	else if ($(this).val()=='SKL_01')
			{
				$(".ipname").val("<?php echo $_SESSION['ipname']['SKL_01'];?>");
				$(".vncname").val("<?php echo $_SESSION['vncname']['SKL_01'];?>");
				$(".comname").val("<?php echo $_SESSION['comname']['SKL_01'];?>");
				$(".macname").val("<?php echo $_SESSION['macname']['SKL_01'];?>");
				$(".username").val("<?php echo $_SESSION['username']['SKL_01'];?>");
				$("input[name=status]").val(["<?php echo $_SESSION['statusname']['SKL_01'];?>"]);
			}
	else if ($(this).val()=='SKL_02')
			{
				$(".ipname").val("<?php echo $_SESSION['ipname']['SKL_02'];?>");
				$(".vncname").val("<?php echo $_SESSION['vncname']['SKL_02'];?>");
				$(".comname").val("<?php echo $_SESSION['comname']['SKL_02'];?>");
				$(".macname").val("<?php echo $_SESSION['macname']['SKL_02'];?>");
				$(".username").val("<?php echo $_SESSION['username']['SKL_02'];?>");
				$("input[name=status]").val(["<?php echo $_SESSION['statusname']['SKL_02'];?>"]);
			}
	else if ($(this).val()=='General_x86_CPU')
			{
				$(".ipname").val("<?php echo $_SESSION['ipname']['General_x86_CPU'];?>");
				$(".vncname").val("<?php echo $_SESSION['vncname']['General_x86_CPU'];?>");
				$(".comname").val("<?php echo $_SESSION['comname']['General_x86_CPU'];?>");
				$(".macname").val("<?php echo $_SESSION['macname']['General_x86_CPU'];?>");
				$(".username").val("<?php echo $_SESSION['username']['General_x86_CPU'];?>");
				$("input[name=status]").val(["<?php echo $_SESSION['statusname']['General_x86_CPU'];?>"]);
			}

*/
	  });
    });
	
	$(document).ready(function(){
	$(".imgname").hide();
	$(".select2").bind("change",function(){ 

    if($(this).val()=='copy_other'){
      $(".imgname").show();
    } else 
	{
	$(".imgname").hide();
	}
	 });
    });
</script> 
<style>
A {text-decoration: NONE}
</style>


</head>

<style>

.all{ margin:auto; width:1000px; font-family:"微软雅黑";}
.all  *{ margin:auto; display:}

.title{ color:#999; border:1px solid #bababa; padding:20px 0; text-align:center;}

.ps{ overflow:hidden; margin-top:20px;}
.ps div{ padding:7px; }
.table01{border:1px solid #bababa; margin:10px 0; overflow:hidden;}
.table01 input{ background-color:#bfcddb;}




.action{overflow:hidden; margin-top:20px;}
.contant{border:1px solid #bababa; margin:10px 0; overflow:hidden;}



</style>

<body  style="background-color:#f0f0f0;">

<form method="post" id="qryposfrm" name="qryposfrm">
<div class="all">
	<div class="title">
		<h3>Launch Machine by Selections</h3>
	</div>
	
	<div class="ps">
    
		<span>Platform Selection</span>
        
        
		<div class="table01">
        
        <div style="overflow:hidden; margin:0 10%;">
		<div style="float:left;">Select Machine
		<select id=s1 name="s1" class="select1" action="release.php" >
		<option value="bdw-server" <?php if($machine=="bdw-server") {echo "selected";} ?>>bdw-server</option>
<!--
		<option value="BDW_01" <?php if($machine=="BDW_01") {echo "selected";} ?>>BDW_01</option>
		<option value="SKL_01" <?php if($machine=="SKL_01") {echo "selected";} ?>>SKL_01</option>
		<option value="SKL_02" <?php if($machine=="SKL_02") {echo "selected";} ?>>SKL_02</option>
		<option value="General_x86_CPU" <?php if($machine=="General_x86_CPU") {echo "selected";} ?>>General_x86_CPU</option>
-->

		</select>
		</div>
		
		<div style="float:right;">
		<input type="checkbox" name="c1[]" value="ITP required" <?php if($itp=="ITP required")  {echo "checked";} else {echo "dischecked";}  ?>>ITP required
		</div>
        </div>
		
        <div style="overflow:hidden;  margin:0 10%;">
		<div style="float:left;">
		<div>
		IP address  :<input type="text" class="ipname" readonly name="ip" value="<?php if(isset($ip)) {echo $ip; }?>" size=20>
		vnc: <input type="text" class="vncname" readonly name="vnc" value="<?php if(isset($vnc)) {echo $vnc; }?>" size=20> 
        </div>
        <div>
        COM over IP:<input type="text" class="comname" readonly name="comip" value="<?php if(isset($comip)) {echo $comip; }?>" size=20>
        mac   :<input type="text"  class="macname" readonly name="mac" value="<?php if(isset($mac)) {echo $mac; }?>" size=20>
		</div>
		<div>
<!--		
		Image_name :<input type="text" class="username" name="user" style="background-color: white" value="<?php if(isset($user)) {echo $user; }?>" size=20>
		
-->
		<?php
		require 'list.php';
		echo ' Img_name: <select name="user" >'; 
		foreach($user_form as $word){ 
  		echo'<option value="'.$word.'">'.$word.'</option>'; 
		} 
		echo '</select>'; 
		?>
		</div>
		<div>
		Status :
		<input type="radio"  class="status" disabled="readonly" value="available" name="status" <?php if($status=="available") {echo "checked"; }?>>available
		<input type="radio" class="status" disabled="readonly" value="unavailable" name="status" <?php if($status=="unavailable") {echo "checked"; }?>>unavailable
		
		<div style="width:500px; height:100px">
		<a href="showlist.php" style="float:left;"><input style=" margin:0px;width:250px; height:25px" type="button" name="img" value="show list" size=40></a>
		</div>
		</div>
       </div>
        
	</div >
	
    
    
    
    
	
		<div>Image Creation</div> 
		<div class="contant">
		<div style="margin:auto;margin-top:13px; width:348px;">
		New_img_name: <input   type="text" name="newuser" value="" style="background-color: white" size=20>
		
		<div style="    padding: 7px;">
		<select name="s2" class="select2" style="width:270px;" >
		<option value="Dom0_Ubuntu 16.04" <?php if($img=="Dom0_Ubuntu 16.04") {echo "selected";} ?>>Dom0_Ubuntu 16.04</option>
		<option value="Dom0_CenOS_3.14" <?php if($img=="Dom0_CenOS_3.14") {echo "selected";} ?>>Dom0_CenOS_3.14</option>
		<option value="Dom0_default" <?php if($img=="Dom0_default") {echo "selected";} ?>>Dom0_default</option>
		<option value="copy_other" <?php if($img=="Dom0_SKL_bug1033_longivity_test") {echo "selected";} ?>>copy other</option>
		</select>
		</div>
		<div  style="" class="imgname" >
		<?php
		require 'list.php';
		echo 'Img_name: <select name="copyuser">'; 
		foreach($user_form as $word){ 
  		echo'<option value="'.$word.'">'.$word.'</option>'; 
		} 
		echo '</select>'; 
		?>
		</div>
		<br/>
		
		<input   type="button" name="img" style=" margin:0px;width:270px; height:25px" value="Create Image" onclick="submitAction('create.php')"  size=20>
        </div>
		
        
        
		<div style="margin:auto;width:350px;">Your selected Image:
		<input  class="checkbox1" type="radio" name="type" value="XenGT" <?php if($type=="xen")  {echo "checked";}else {echo "dischecked";} ?>>XenGT
        
		<input  class="checkbox2" type="radio" name="type" value="KvmGT" <?php if($type=="kvm")  {echo "checked";} else {echo "dischecked";}?>>KvmGT
        </div>
        
        <div class="bootconf1" style="margin:auto;width:364px; margin-bottom:13px;">
		Xen config <input type="text" name="xenc" style="width:290px;" value="<?php if(isset($xenc)) {echo $xenc; }?>" size=20 />
        </div>
        <div class="bootconf2" style="margin:auto;width:364px; margin-bottom:13px;">
        
		bzimage kernel <input type="text" name="kernel" style="width:290px;"value="<?php if(isset($kernel)) {echo $kernel; }?>" size=20>
        </div>
		</div>
		
        
        
        
        
        
        
		<div class="action">
		<span>Action...</span>
		<div class="contant">
        <div style="margin:auto; width:550px;">
		<input style="margin:10px 0;background-color:#39f; padding:40px 0;" type="button" type="submit" onclick="submitAction('checklaunch.php')" name="username" value="        Launch         " size=20>
		<input style="margin:10px 0 10px 20px;background-color:#b9d1ea;padding:40px 0;"type="submit" onclick="submitAction('release.php')" name="username" value="       release       " size=20>
	    <input style="margin:10px 0 10px 20px;padding:40px 0;" type="submit" onclick="submitAction('export.php')" name="username" value="Export Config Image" size=20>
		<a href="load.php"><input style="margin:10px 0 10px 20px;padding:40px 0;"type="button" name="username" value="     Import Config    " size=20></a>
        </div>
		</div>
  		</div>
	

</div>

</form>
</body>

</html>
<?php

}

?>
<?php


