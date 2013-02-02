<?php

$dbh=mysql_connect ("localhost", "ridezu", "ridezu123") or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("ridezu");

$query = "SELECT id,latlong from footprint where latlong is not null limit 0,1000";
$result = mysql_query($query) or die(mysql_error());

$data=array();
$jdata="";

while($row = mysql_fetch_array($result,MYSQL_ASSOC)){

	$data[$row['id']]=$row;
	$id=$row['id'];
	$latlng=$row['latlong'];
	$jdata=$jdata."d[$id] = \"$latlng\";";
	}

function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2) {
    $theta = $longitude1 - $longitude2;
    $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
    $miles = acos($miles);
    $miles = rad2deg($miles);
    $miles = $miles * 60 * 1.1515;
    return $miles; 
	}
    

// now that we have the data let's start printing it our

?>

<html>
<body>
Users processed: <div id="p"></div>

Results: <div id="r"></div>

<script>
var d=new Array();
var latlong1=new Array();
var latlong2=new Array();
var results="";
var counter=0;

<?php echo $jdata; ?>

// Define the callback function.
function findmatch(value, index, ar) {
    
    match=0;
        
    user=index;
    latlong1=value.split(",");
        
	d.forEach(checkmatch);
	
	counter++;

	document.getElementById('p').innerHTML=counter;	 

    results=results+"<br>"+user+":"+match;    
}

function checkmatch(value1, index1,ar1){
	user1=index1;
	latlong2=value1.split(",");
	
	x=0;
	x=getDistanceFromLatLonInKm(latlong1[0],latlong1[1],latlong2[0],latlong2[1]);

	if(x<4){
    	match++;
    	}
	
}
	

function getDistanceFromLatLonInKm(lat1,lon1,lat2,lon2) {
  var R = 6371; // Radius of the earth in km
  var dLat = deg2rad(lat2-lat1);  // deg2rad below
  var dLon = deg2rad(lon2-lon1); 
  var a = 
    Math.sin(dLat/2) * Math.sin(dLat/2) +
    Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
    Math.sin(dLon/2) * Math.sin(dLon/2)
    ; 
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
  var x = R * c; // Distance in km
  return x;
}

function deg2rad(deg) {
  return deg * (Math.PI/180)
}

d.forEach(findmatch);

document.getElementById('r').innerHTML=results;	 


</script>
</body>
<html>