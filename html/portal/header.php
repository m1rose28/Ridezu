<?php require_once '../rzconfig.php';

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

$script="";

if(isset($_GET["logoff"])){
	$_SESSION['corpuserid']="";
	$_SESSION['corpseckey']="";
	$_SESSION['companyname']="";
	$script=$script."
			localStorage.removeItem(\"corplogin\");
			localStorage.removeItem(\"corpuserid\");
			localStorage.removeItem(\"corpseckey\");
			";
	}
	
$companyname=$_SESSION['companyname'];
$corpuserid=$_SESSION['corpuserid'];
$corpseckey=$_SESSION['corpseckey'];
$email=$_SESSION['email'];

if($corpseckey=="" and $title!="Login" and $title!="Register" and $title!="Corporate Solutions"){header("Location: login.php");}

$dbh=mysql_connect ("localhost", "ridezu", "ridezu123") or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("ridezu");

?>


<!DOCTYPE html>

<html lang="en">

    <head>
		<script>
      		<?php echo $script;?>
      		var page="<?php echo $title;?>";
      		var mycorpinfo={};
      		var info={};
	    	mycorpinfo.company="<?php echo $companyname;?>";
      		mycorpinfo.corpuserid="<?php echo $corpuserid;?>";
      		mycorpinfo.corpseckey="<?php echo $corpseckey;?>";

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
        <script src="../js/ridezuportal.js?v=<?php echo $rzversion;?>"></script>
    </head>
    <body>
        <header>
	        
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
						<li class="dropdown"><a href="#" alt="Messaging">Messaging</a>
							<ul style="left:145px;">
								<li><a href="welcomemessage.php">Welcome Message</a></li>
								<li><a href="messaging.php">Ad Hoc Message</a></li>
							</ul>
						</li>
						<li><a href="rides.php" alt="Rides">Rides</a></li>
						<li><a href="admin.php" alt="Admin">Admin</a></li>
						<?php 	if($corpseckey!=""){?>
							<li><a href="login.php?logoff=true" alt="Logoff">Logoff</a></li>
							<?php } ?>

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
