<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

include "auth.php";

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Ridezu</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body style="padding:10px;">
  <div class="row">
	<div class="span9"><img src="../images/logo200.png"/></div>
	<div class="span3"><br><br>Logged in as: <strong><?php echo $_SESSION['login']; ?></strong></div>
  </div>

	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4touwfWlpbCpS0SKYvqfUOVddPnd0OBA&sensor=true"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>

<script>
	function search(){
		searchurl="csr.php?search="+document.getElementById("searchname").value;
		window.location = searchurl;
	}
</script>

<div class="navbar">
  <div class="navbar-inner">
    <ul class="nav">
      <li><a href="csr.php">CSR Tool</a></li>
      <li><a href="servicetest.php">API</a></li>
      <li><a href="frame.php">Mobile App</a></li>
      <li><a href="pickup.php">Ridezu Map</a></li>
      <li><a href="testlinks.php">Test Links</a></li>
      <li style="padding-top:5px;10px;"><input type="text" name="searchname" id="searchname"></li>
      <li style="padding-top:8px;padding-left:10px;"> <input type="button" onclick="search();" value="Search"/></li>
    </ul>
  </div>
</div>
