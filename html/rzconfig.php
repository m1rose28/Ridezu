<?php

session_start();

$_SESSION['mode']="";

//check server names and https values and re-direct if needed

$s=$_SERVER['SERVER_NAME'];
$h=$_SERVER['HTTPS'];
$u=$_SERVER['REQUEST_URI'];

if($s=="stage.ridezu.com"){
	$rzsystem='stage';
	$ga="UA-37138880-1";
	$_SESSION['mode']="dev";
	$rzversion=time(); // this is the version for javascript and css
	//$rzversion="1204"; // this is the version for javascript and css
	}

if($s=="www.ridezu.com" or $s=="ridezu.com"){
	$rzsystem='www';
	$ga="UA-36391790-1";
	$_SESSION['mode']="prod";
	$rzversion="1212"; // this is the version for javascript and css
	}

$rzdomain='ridezu.com';
$rzhost="$rzsystem.$rzdomain";

if($rzsystem!='stage'){
  if($h==false or $s!=$rzhost){
    $url = "https://".$rzhost."/".$u;
    header("Location: $url");
    exit;
  }
}

?>


