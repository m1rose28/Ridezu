<?php
require 'node.php';
require '../util.php';


$latlong = $_GET["latlong"];
$distance = $_GET["distance"];
//echo 'latlong:'.$latlong;
//echo 'distance:'.$distance;
echo '=======Nearest Node=========';
$return = getNearestNode($latlong,  $distance);
print_r($return);
echo '=======PNR Node=======';
$return1 = getNearestPNRNode($latlong,  $distance);
print_r($return1);

?>
       