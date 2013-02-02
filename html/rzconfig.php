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

if($s=="demo.ridezu.com"){
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
	$rzversion="201"; // this is the version for javascript and css
	}

$rzdomain='ridezu.com';
$rzhost="$rzsystem.$rzdomain";

// this is the display version

if($_SESSION['mode']=="dev"){$displayversion="dev".$rzversion;}
if($_SESSION['mode']=="prod"){$displayversion="P".$rzversion;}

// this is to detect the user agent 

$device = $_SERVER['HTTP_USER_AGENT'];

  if ( stripos($device, 'Firefox') !== false ) {$device = 'Firefox Mobile Browser';}
   elseif ( stripos($device, 'MSIE') !== false ) {$device = 'IE Mobile Browser';} 
   elseif ( stripos($device, 'iPad') !== false ) {$device = 'iPad';}
   elseif ( stripos($device, 'iTouch') !== false ) {$device = 'iTouch';} 
   elseif ( stripos($device, 'iPhone') !== false ) {$device = 'iPhone';}
   elseif ( stripos($device, 'Android') !== false ) {$device = 'Android Mobile';}
   elseif ( stripos($device, 'Chrome') !== false ) {$device = 'Chrome Mobile Browser';}
   elseif ( stripos($device, 'Safari') !== false ) {$device = 'Safari Mobile Browser';}
   elseif ( stripos($device, 'AIR') !== false ) {$device = 'Air';} 
   elseif ( stripos($device, 'Fluid') !== false ) {$device = 'Fluid';}

if($rzsystem!='stage'){
  if($h==false or $s!=$rzhost){
    $url = "https://".$rzhost.$u;
    header("Location: $url");
    exit;
  }
}

?>


