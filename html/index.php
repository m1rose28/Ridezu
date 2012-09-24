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
	<link type="text/css" rel="stylesheet" href="css/style.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/ridezu.js"></script>
	<link type="text/css" rel="stylesheet" href="css/ridezu.css">
</head>

<body>

	<div id="w">
		
		<div id="pagebody" style="left: 0px; ">
			<header id="toolbarnav" style="left: 0px; ">
				<a href="index.htm#navmenu" id="menu-btn"></a>
			
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
				<div id="enrollp"></div>
							
			</section>
		</div>
		
		<div id="navmenu">
			<header>
				<h1>Ridezu</h1>
			</header>
			
				<ul>
					<li><a onclick="nav('nav','ridesp');" class="navlink">My Rides</a></li>
					<li><a onclick="nav('nav','accountp');" class="navlink">My Account</a></li>
					<li><a onclick="nav('nav','profilep');" class="navlink">My Profile</a></li>
					<li><a onclick="nav('nav','howitworksp');" class="navlink">How it Works</a></li>
					<li><a onclick="nav('nav','calcp');" class="navlink">Rizunomics</a></li>
					<li><a onclick="nav('nav','faqp');" class="navlink">FAQ</a></li>
					<li><a onclick="nav('nav','termsp');" class="navlink">Terms of Service</a></li>
				</ul>
				Ridezu &copy; 2012
		</div>
	</div>

 <!-- this js declares a page and runs with it -->
 <script>
  $(document).ready(function() {
  var p="<?php echo $p;?>";
  nav("mainp",p);
  });
  </script>

</body></html>