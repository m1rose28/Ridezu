<?php

$rzsystem='stage';
$rzversion="1204"; // this is the version for javascript and css
$rzdomain='ridezu.com';
$rzhost="$rzsystem.$rzdomain";

//check server names and https values and re-direct if needed

$s=$_SERVER['SERVER_NAME'];
$h=$_SERVER['HTTPS'];
$u=$_SERVER['REQUEST_URI'];

if($h==false or $s==$rzdomain){
  $url = "https://" . $rzhost . $u;
  header("Location: $url");
  exit;
}

session_start(); 

?>