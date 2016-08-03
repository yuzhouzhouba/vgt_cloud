<?php
require 'handle.php';

#write into file
$file='yaml-to-download/'.$s1.'.yaml';
echo $file;
$fp = fopen($file,'w');
fwrite($fp, $yaml);
fclose($fp);

#show the imformation
echo "config export success!";
echo '<pre>YAML Data dumped back:<br/>';
echo Spyc::YAMLDump($array);
echo '</pre>';
echo "<a href='$file' download=''>click to download</a>";

?>