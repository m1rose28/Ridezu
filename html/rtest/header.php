<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

//check server names and https values and re-direct if needed
$s=$_SERVER['SERVER_NAME'];
$h=$_SERVER['HTTPS'];
$u=$_SERVER['REQUEST_URI'];
if($h==false or $s=="ridezu.com"){header('Location: https://www.ridezu.com'.$u);}

session_start();

if(isset($_SESSION['auth'])==false)
	{
		require_once 'sys/fblogin.php';
		require_once 'sys/users.php';
		
		$fb = new FacebookLogin("443508415694320", "4dfa4c513a904dbf69a46f854b163eeb");
		$user = $fb->doLogin();
		
		$fname=$user->first_name;
		$fb=$user->id;
		
		if (in_array($fb, $userlist)==false) {
			header('Location: https://www.ridezu.com/');
		}
		
		if (in_array($fb, $userlist)==true) {
			$_SESSION['auth']=1;
		}		
	}

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Ridezu Test Tool</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body style="padding:10px;">
    <h1>Ridezu Test Suite</h1>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4touwfWlpbCpS0SKYvqfUOVddPnd0OBA&sensor=true"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>

<div class="navbar">
  <div class="navbar-inner">
    <ul class="nav">
      <li><a href="servicetest.php">API</a></li>
      <li><a href="frame.php">Mobile App</a></li>
      <li><a href="pickup.php">Ridezu Map</a></li>
      <li><a href="testlinks.php">Test Links</a></li>
    </ul>
  </div>
</div>
