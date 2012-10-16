<?php 
$p="mainp";
if(isset($_GET["p"])){$p=$_GET["p"];}
?>

<!DOCTYPE html>

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Ridezu</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
	<script type="text/javascript" src="js/ridezu.js"></script>
	<link type="text/css" rel="stylesheet" href="css/style.css">
	<link type="text/css" rel="stylesheet" href="css/ridezu.css">
	<link rel="stylesheet" href="themes/ridezu.min.css" />

</head>

<body>
<div data-role="page" style="margin:0px;padding:0px;">
<div data-role="content" style="margin:0px;padding:0px;">

	<div id="w">
		
		<div id="pagebody" style="left: 0px; ">
			<header id="toolbarnav" style="left: 0px; ">
				<a href="" id="menu-btn"></a>
			
				<h1 id="pTitle">Ridezu</h1>
			</header>
			
			<section id="content">

				<div id="rpopup" style="display:none;" onclick="rempopup();" class="popup"></div>
				<div id="darkpage" class="dim" style="display:none;"></div>
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
							
			</section>
		</div>
		
		<div id="navmenu">
			<header>
				<h1>Ridezu</h1>
			</header>
			
				<ul>
					<li><a onclick="nav1('loginp');" class="navlink">Login - Testing Only</a></li>
					<li><a onclick="nav1('riderequestp');" class="navlink">Request a Ride</a></li>
					<li><a onclick="nav1('ridepostp');" class="navlink">Post a Ride</a></li>
					<li><a onclick="nav1('accountp');" class="navlink">My Account</a></li>
					<li><a onclick="nav1('profilep');" class="navlink">My Profile</a></li>
					<li><a onclick="nav1('howitworksp');" class="navlink">How it Works</a></li>
					<li><a onclick="nav1('startp');" class="navlink">Enroll Flow - Testing</a></li>
					<li><a onclick="nav1('calcp');" class="navlink">Rizunomics</a></li>
					<li><a onclick="nav1('faqp');" class="navlink">FAQ</a></li>
					<li><a onclick="nav1('termsp');" class="navlink">Terms of Service</a></li>
				</ul>
				Ridezu &copy; 2012
		</div>
	</div>

 <!-- this js declares a page and runs with it -->
<script>
  

	 
  
</script>


</div>
</div>
</body></html>