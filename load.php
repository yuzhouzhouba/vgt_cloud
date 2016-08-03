<?php 

#there is the array need to fill into form
echo '<form action="upload_file.php" method="post"
		enctype="multipart/form-data" style=" color:#999; border:1px solid #bababa; padding:20px 0; text-align:center;background-color:#bfcddb;">
		<h3 for="file" >Filename:  </h3><br>
		<input type="file" name="filename" id="file" /> 
		<input type="submit" name="submit" value="Submit" />
		</form>';


#$username= "192.168.1.xxx" ;
#require_once('main.php');

#yaml for debug
#echo '<pre>YAML Data dumped back:<br/>';
#echo Spyc::YAMLDump($array);
#echo '</pre>';
?>
