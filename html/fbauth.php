<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

//check server names and https values and re-direct if needed
$s=$_SERVER['SERVER_NAME'];
$h=$_SERVER['HTTPS'];
$u=$_SERVER['REQUEST_URI'];
if($h==false or $s=="ridezu.com"){header('Location: https://www.ridezu.com'.$u);}

session_start();

		require_once 'test/sys/fblogin.php';

		$dbh=mysql_connect ("localhost", "ridezu", "ridezu123") or die ('I cannot connect to the database because: ' . mysql_error());
		mysql_select_db ("ridezu");
		
		$fb = new FacebookLogin("443508415694320", "4dfa4c513a904dbf69a46f854b163eeb");
		$user = $fb->doLogin();
		
		$fname=$user->first_name;
		$fb=$user->id;
		
		$result = mysql_query("SELECT seckey FROM userprofile WHERE fbid='$fb'");
		
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

	  x1= "{\"fbid\":\"<?php echo $fb;?>\",\"seckey\":\"<?php echo $seckey;?>\"}";
	  parent.authuser(x1);
	
<?php }	?>		 

<?php if(isset($seckey)==false) { ?>	 	 

	  x1= "{\"nouser\":\"true\"}";
	  parent.authuser(x1);
	
<?php }	?>		 


		 
  </script>
</body>
</html>