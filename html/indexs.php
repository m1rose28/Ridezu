<?php

$p="myridesp";
if(isset($_GET["p"])){$p=$_GET["p"];}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<script type="text/javascript">
		var startpage="<?php echo $p;?>";
	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4touwfWlpbCpS0SKYvqfUOVddPnd0OBA&sensor=true&libraries=places"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Ridezu</title>
	<link rel="icon" href="favicon.ico" type="image/x-icon"> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<link type="text/css" rel="stylesheet" href="css/ridezu.css"> 
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/ridezuadmin.js"></script>
	<script type="text/javascript" src="js/ridezu.js"></script>
	<link type="text/css" rel="stylesheet" href="css/style.css">
	
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
				<div id="pricingp"></div> 

				<div id="confirm-background">
					<div id="confirm-box">
						<div id="confirm-message"></div>
						<center>
						<a href="#" id="cancel-button" style="display:none;" onclick="closeconfirm('cancel');" class="cancel"></a>
						<a href="#" id="ok-button" onclick="closeconfirm('ok');"></a>
						</center>
					</div>
				</div>
		
		<div id="testbar" style="background-color:#878787;color:#fff;font-size:14px;padding:5px;"></div>
		</div>		
		
		<div id="navmenu">
				<ul>
					<li><p class="mainnavlink">Ridezu</p></li>
					<li><a class="navlink" onclick="nav1('loginp');" class="navlink">Login - Testing Only</a></li>
					<li><a class="navlink" onclick="nav1('myridesp');" class="navlink">My Rides</a></li>
					<li><a class="navlink" onclick="nav1('riderequestp');" class="navlink">Request a Ride</a></li>
					<li><a class="navlink" onclick="nav1('ridepostp');" class="navlink">Post a Ride</a></li>
					<li><a class="navlink" onclick="nav1('accountp');" class="navlink">My Account</a></li>
					<li><a class="navlink" onclick="nav1('profilep');" class="navlink">My Profile</a></li>
					<li><a class="navlink" onclick="nav1('howitworksp');" class="navlink">How it Works</a></li>
					<li><a class="navlink" onclick="nav1('startp');" class="navlink">Enroll Flow - Testing</a></li>
					<li><a class="navlink" onclick="nav1('calcp');" class="navlink">Ridezunomics</a></li>
					<li><a class="navlink" onclick="nav1('faqp');" class="navlink">FAQ</a></li>
					<li><a class="navlink" onclick="nav1('termsp');" class="navlink">Terms of Service</a></li>
					<li>Ridezu &copy; 2012</li>
				</ul>
			</div>
		</div>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36391790-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
	
</body></html>




