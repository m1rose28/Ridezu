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
  <body style="padding:0px;">

	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4touwfWlpbCpS0SKYvqfUOVddPnd0OBA&sensor=true"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>


	  <ul class="nav nav-tabs">
		<li class="active">
		  <a href="#">Profile</a>
		</li>
		<li >
		  <a href="#">Rides</a>
		</li>
	  </ul>
	  
<?php

$query = "SELECT * FROM `userprofile` $searchstring order by `id` desc limit 20";

$result = mysql_query($query) or die(mysql_error());

?>

<script>
   function profile(id){
	   document.getElementById("framedetail").src="profile.php?u="+id;
	   }
</script>
	   
<?php

if(isset($_GET["u"])){
	$u=$_GET["u"];	
	}			

$query = "SELECT * FROM `userprofile` where fbid='$u'";

$result = mysql_query($query) or die(mysql_error());

while($row = mysql_fetch_array($result,MYSQL_ASSOC)){

	echo "<h3><image class='profilephoto' src='https://graph.facebook.com/$row[fbid]/picture'/> $row[fname] $row[lname]</h3>";
	echo "<img src=\"https://maps.googleapis.com/maps/api/staticmap?center=$row[worklatlong]&size=600x300&maptype=roadmap&markers=icon:http://www.ridezu.com/images/basecmarker.png%7C$row[worklatlong]&markers=icon:http://www.ridezu.com/images/basehmarker.png%7C$row[homelatlong]&sensor=false\" style=\"width:600px;height:300px;\"/>";

	echo "<br><br>";
	echo "<table class=\"table table-striped\">";
	echo "<tr><td><b>db field</b></td><td><b>db value</b></td>";

	   foreach ($row as $key => $value) {
		  echo "<tr><td>$key</td><td>$value</td>";
		  }
	echo "</table>";	
 }

?>