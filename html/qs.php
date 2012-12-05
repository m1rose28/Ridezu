<?php

	$dbh=mysql_connect ("localhost", "ridezu", "ridezu123") or die ('I cannot connect to the database because: ' . mysql_error());
	mysql_select_db ("ridezu");
	

$sqlCommand = "SELECT COUNT(*) FROM userprofile";  
$query = mysql_query($sqlCommand) or die (mysql_error());  
$row = mysql_fetch_row($query); 
echo $row[0]; 

?>
