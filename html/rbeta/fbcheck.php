<?php

$accesstoken="AAAGTXlmShfABALBe9sIunYWBQphAfwYamwPvxQOScl41u27J70sg80n9vVKcwd46SdbH16IZCobOhfhETcWlviK55BYIVvrmQyIrpHwZDZD"; //mark
//$accesstoken="AAAGTXlmShfABAFiYZCynncqKdk88GLeYizDOlW10dvNgLYsx2E5Ott4hSOwAe00sDMyzdeNiIyw0ssEVQOZCFo2tT3RFZB2eIs8kSdbLgZDZD";//lynn
//$accesstoken="randomefalsestring";//an invalid token;

$url="http://stage.ridezu.com/rbeta/fbauth2.php?accesstoken=$accesstoken";

$results = file_get_contents($url);

echo $results;
echo "<br>".$url
?>