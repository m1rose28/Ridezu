<?php 

$dbh=mysql_connect ("localhost", "ridezu", "ridezu123") or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("ridezu");

$f="";

if(isset($_POST['function'])){
	$f=$_POST['function'];
	if($f=="add"){
		$name=$_POST['name'];
		$city=$_POST['city'];
		$state=$_POST['state'];
		$latlng=$_POST['latlng'];
		$spaces=$_POST['spaces'];
		$lighting=$_POST['lighting'];
		$bikeracks=$_POST['bikeracks'];
		}
	if($f=="delete"){
		$id=$_POST['id'];
	}
	}
	
	if($f=="update"){ // then update the reservation
		$result = mysql_query("UPDATE reservations SET firstName='$firstName',lastName='$lastName',email='$email',phone='$phone',startDate='$startDate',endDate='$endDate',adults='$adults',kids='$kids',notes='$notes',occasion='$occasion',status='$status',noemail='$noemail',basefee='$basefee',taxfee='$taxfee',reservefee='$reservefee',cleaningfee='$cleaningfee',fee='$fee',secdepositfee='$secdepositfee' WHERE id='$id'") or die(mysql_error());  
		}

	if($f=="add"){ // then add the new row
		$sql2 = mysql_query("INSERT INTO ridenode(name,city,state,latlong,spaces,lighting,bikeracks) VALUES ('$name','$city','$state','$latlng','$spaces','$lighting','$bikeracks')") or die(mysql_error());
		echo "ride node added";
		}

	if($f=="delete"){ // then delete a specific row
		$sql2 = mysql_query("DELETE FROM ridenode WHERE id='$id'") or die(mysql_error());
		echo "ride node deleted";
		}
?>