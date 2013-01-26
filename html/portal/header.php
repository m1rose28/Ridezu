<?php require_once '../rzconfig.php';

//error_reporting(E_ALL);
//ini_set('display_errors', '1');
$c="";

if(isset($_GET["c"])){$c=$_GET["c"];}
if(isset($_GET["t"])){$t=$_GET["t"];}

$dbh=mysql_connect ("localhost", "ridezu", "ridezu123") or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("ridezu");

?>


<!DOCTYPE html>

<html lang="en">

    <head>
		<script>
      		var page="<?php echo $title;?>";
      		var myinfo={};
      		var info={};
	    	myinfo.company="<?php echo $c;?>";
	    	if(localStorage.seckey!=undefined){
				var optimizely = optimizely || [];
				optimizely.push("disable");	
	    		}		
      	</script>		
      	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4touwfWlpbCpS0SKYvqfUOVddPnd0OBA&sensor=true&libraries=places"></script>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $desc;?>">
        <meta property="og:site_name" content="Ridezu"/>
        <meta property="fb:app_id" content="443508415694320"/>  
        <meta property="og:title" content="Ridezu"/>
        <meta property="og:description" content="Ridezu is a community for carpooling to and from the office. It's convenient, economical and green.  Join today!" /> 
        <meta property="og:type" content="company"/>
        <meta property="og:url" content="https://www.ridezu.com"/>
        <meta property="og:image" content="https://www.ridezu.com/images/ridezuAppIcon200.png" />
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="../css/normalize.min.css?v=<?php echo $rzversion;?>">
		<link rel="stylesheet" href="../css/style.css?v=<?php echo $rzversion;?>">
		<link rel="stylesheet" href="../css/corpstyle.css?v=<?php echo $rzversion;?>">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script src="../js/ridezucorp.js?v=<?php echo $rzversion;?>"></script>
    </head>
    <body>
        <header>
			<style>
				body.connected #login { display: none; }
				body.connected #logout { display: block; }
				body.not_connected #login { display: block; }
				body.not_connected #logout { display: none; }
			</style>
	        
			<div class="corpwrapper">
				<div id="corplogo">
					<h1><a href="../index.php"><img src="../images/ridezulogo.png" alt="Ridezu" /></a></h1>
					
					<img id="cobrand" src=""/>
				</div>
				
				<div id="corpmenu">
					<ul>
						<li class="dropdown"><a href="#" alt="Analytics">Analytics</a>
							<ul>
								<li><a href="usagesummary.php">Usage Summary</a></li>
								<li><a href="footprint.php">Footprint Analysis</a></li>
								<li><a href="carpoolstudy.php">Carpool Report</a></li>
								<li><a href="co2savings.php">C02 Savings</a></li>
								<li><a href="funfacts.php">Fun Facts</a></li>
							</ul>
						</li>
						<li><a href="messaging.php" alt="Benefits">Messaging</a></li>
						<li><a href="rides.php" alt="Safety">Rides</a></li>
						<li><a href="admin.php" alt="Faq">Admin</a></li>
						<li><a href="login.php" alt="Faq">Login</a></li>
					</ul>
				</div>
			</div>
		</header>

				<div id="confirm-background">
					<div id="confirm-box">
						<div id="confirm-message"></div>
						<center>
						<a href="#" id="cancel-button" style="display:none;" onclick="closeconfirm('cancel');" class="cancel"></a>
						<a href="#" id="ok-button" onclick="closeconfirm('ok');"></a>
						</center>
					</div>
				</div>
