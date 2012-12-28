<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

$dbh=mysql_connect ("localhost", "ridezu", "ridezu123") or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("ridezu");


session_start();

if(isset($_SESSION['auth'])==false || isset($_SESSION['login'])==false )
	{
		require_once 'sys/fblogin.php';
		require_once 'sys/users.php';
		
		$fb = new FacebookLogin("443508415694320", "4dfa4c513a904dbf69a46f854b163eeb");
		$user = $fb->doLogin();
		
		$fname=$user->first_name;
		$lname=$user->last_name;
		$fb=$user->id;
		
		if (in_array($fb, $userlist)==false) {
			header('Location: https://www.ridezu.com/');
		}
		
		if (in_array($fb, $userlist)==true) {
			$_SESSION['auth']=1;
			$_SESSION['login']=$fname." ".$lname;
		}		
	}

?>
