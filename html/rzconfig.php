<?php

session_start();
$_SESSION['mode']="";

//check server names and https values and re-direct if needed

$s=$_SERVER['SERVER_NAME'];
$h=$_SERVER['HTTPS'];
$u=$_SERVER['REQUEST_URI'];

if($s=="stage.ridezu.com"){
	$rzsystem='stage';
	$_SESSION['mode']="dev";
	}

if($s=="www.ridezu.com"){
	$rzsystem='www';
	$_SESSION['mode']="prod";
	}


$rzversion="1204"; // this is the version for javascript and css
$rzdomain='ridezu.com';
$rzhost="$rzsystem.$rzdomain";

if($h==false or $s!=$rzhost){
  $url = "https://".$rzhost."/".$u;
  header("Location: $url");
  exit;
  }

?>