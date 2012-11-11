<?php

$p="myridesp";
if(isset($_GET["p"])){$p=$_GET["p"];}

?>

<!DOCTYPE html>

<html lang="en">
<head>
	<script type="text/javascript">
		var startpage="<?php echo $p?>";
	</script>
	<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyA4touwfWlpbCpS0SKYvqfUOVddPnd0OBA&sensor=true&libraries=places"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Ridezu</title>
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
 	<link rel="stylesheet" href="themes/ridezu.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
	<link type="text/css" rel="stylesheet" href="css/ridezu.css"> 
	<script type="text/javascript" src="js/script.js"></script>
	<!-- 	<script type="text/javascript" src="http://www.bellified.com/testing/ridezu/js/script.js"></script>-->
	<script type="text/javascript" src="js/ridezu.js"></script>
	<!-- <link type="text/css" rel="stylesheet" href="css/style.css">-->	
	<link type="text/css" rel="stylesheet" href="http://www.bellified.com/testing/ridezu/css/style.css">
	
</head>

<body>
		<div id="w" style="display:none;">
		
		<div id="pagebody" style="left: 0px;">
			<div id="topbar" style="display:block;">
			<header id="toolbarnav" style="left:0px; ">
				<a href="#" id="menu-btn"><img id="menub" src="../images/menu.png"/></a>
				<h1 id="pTitle">Ridezu</h1>
			</header>
			</div>

				<div id="rpopup" style="display:none;" onclick="rempopup();" class="popup"></div>
				<div id="darkpage" class="dim" style="display:none;"></div>
				<div id="loading" style="height:450px;display:none">
					<div style="height:20px;background-color:#ddd;width:100%">Loading...
					</div>
				</div>
				<!-- list of active pages -->
				
				<div id="mainp"></div> 	
				<div id="calcp"></div>
				<div id="mapp"></div>
				<div id="termsp"></div>
				<div id="howitworksp"></div>
				<div id="drive1p"></div>
				<div id="drive2p"></div>
				<div id="drive3p"></div>
				<div id="ride1p"></div>
				<div id="ride2p"></div>
				<div id="ride3p"></div>
				<div id="faqp"></div>
				<div id="profilep"></div>
				<div id="ridesp"></div>
				<div id="accountp"></div>
				<div id="transactionp"></div>
				<div id="congratp"></div>
				<div id="fbp"></div>
				<div id="startp"></div>
				<div id="rideconfirmp"></div>
				<div id="noroutep"></div>
				<div id="selectdriverp"></div>
				<div id="riderequestp"></div>
				<div id="ridepostp"></div>
				<div id="enrollp"></div>
				<div id="loginp"></div>
				<div id="firstp" style="display:none;"></div> 
				<div id="myridesp"></div> 
				<div id="userprofilep"></div> 
				<div id="homeprofilep"></div> 
				<div id="workprofilep"></div> 
				<div id="contactinfop"></div> 
				<div id="driverp"></div> 
				<div id="ridedetailsp"></div> 
				<div id="paymentp"></div> 
				<div id="payoutp"></div> 
				<div id="notifyp"></div> 
				<div id="temp"></div> 

				<div id="confirm-background">
					<div id="confirm-box">
						<div id="confirm-message"></div>
						<a href="#" id="cancel-button" style="display:none;" onclick="closeconfirm('cancel');" class="cancel"></a><a href="#" id="ok-button" onclick="closeconfirm('ok');"></a>
					</div>
				</div>
		
		<div id="testbar" style="display:none;background-color:#878787;color:#fff;font-size:14px;padding:5px;"></div>
		</div>		
		
		<div id="navmenu">
				<ul>
					<li><p class="mainnavlink">Ridezu</p></li>
					<li><a class="navlink" onclick="nav1('myridesp');" class="navlink">My Rides</a></li>
					<li><a class="navlink" onclick="nav1('riderequestp');" class="navlink">Request a Ride</a></li>
					<li><a class="navlink" onclick="nav1('ridepostp');" class="navlink">Post a Ride</a></li>
					<li><a class="navlink" onclick="nav1('accountp');" class="navlink">My Account</a></li>
					<li><a class="navlink" onclick="nav1('profilep');" class="navlink">My Profile</a></li>
					<li><a class="navlink" onclick="nav1('howitworksp');" class="navlink">How it Works</a></li>
					<li><a class="navlink" onclick="nav1('calcp');" class="navlink">Ridezunomics</a></li>
					<li><a class="navlink" onclick="nav1('faqp');" class="navlink">FAQ</a></li>
					<li><a class="navlink" onclick="nav1('termsp');" class="navlink">Terms of Service</a></li>
					<li><a class="navlink" onclick="nav1('privacyp');" class="navlink">Privacy Policy</a></li>
					<li><p class="mainnavlink">Ridezu &copy; 2012</p></li>
				</ul>
			</div>
		</div>


	
</body></html>




