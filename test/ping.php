<?php
$time=3;
$ip="192.168.79.17";
$out=exec("ping -c $time $ip");
$out=substr($out,-2);


if ($out=="ms")
echo "ok";
else
echo "fail";

?>
