<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

session_start();

		require_once 'rtest/sys/fblogin.php';

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

Hello <?php echo $fname;?>,
<br><br>
facebook id: <?php echo $fb;?>
<br>seckey: <?php echo $seckey;?>

</body>
</html>