<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

require 'facebooksdk/src/facebook.php';

if(isset($_GET["accesstoken"])){$accesstoken=$_GET["accesstoken"];}

$facebook = new Facebook(array(
  'appId'  => '443508415694320',
  'secret' => '4dfa4c513a904dbf69a46f854b163eeb',
));

//$fbtoken="AAAGTXlmShfABALmSbzfNgRzYYZBu0O6hJ59E2js10UWqZAfBAqar9lZBvXwvyZAbhi418seafyzFZCN3qC7hC4J3HjBqM2zWNqezFewqSKAZDZD"; //mark
//$fbtoken="AAAGTXlmShfABAFiYZCynncqKdk88GLeYizDOlW10dvNgLYsx2E5Ott4hSOwAe00sDMyzdeNiIyw0ssEVQOZCFo2tT3RFZB2eIs8kSdbLgZDZD";//lynn

//set access token
//$facebook->setAccessToken($accesstoken);

// Get User ID
$user = $facebook->getUser();

//connect to db

$dbh=mysql_connect ("localhost", "ridezu", "ridezu123") or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("ridezu");
				
$result = mysql_query("SELECT seckey FROM userprofile WHERE fbid='$user'");
		
while($row = mysql_fetch_array($result))
	{
	 $seckey=$row['seckey'];
	  }
?>

<html>
  <body>
   <script>

 	  var x1;
 	  

<?php if(isset($seckey)) { ?>	 	 

	  x1= "{\"fbid\":\"<?php echo $user;?>\",\"seckey\":\"<?php echo $seckey;?>\"}";
	  parent.authuser(x1);
	
<?php }	?>		 

<?php if(isset($seckey)==false) { ?>	 	 

	  x1= "{\"nouser\":\"true\"}";
	  parent.authuser(x1);
	
<?php }	?>		 


		 
  </script>
</body>
</html>