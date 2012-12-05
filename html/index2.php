<?php

//check server names and https values and re-direct if needed
$s=$_SERVER['SERVER_NAME'];
$h=$_SERVER['HTTPS'];
$u=$_SERVER['REQUEST_URI'];
if($h==false or $s=="ridezu.com"){header('Location: https://www.ridezu.com'.$u);}

$client="";$fbid="";$secret="";
$p="myridesp";
if(isset($_GET["p"])){$p=$_GET["p"];}
if(isset($_GET["fbid"])){$fbid=$_GET["fbid"];}
if(isset($_GET["secret"])){$secret=$_GET["secret"];}
if(isset($_GET["client"])){$client=$_GET["client"];}

?>

<!DOCTYPE html>

<html lang="en">
<head>
	<script type="text/javascript">
		var startpage="<?php echo $p;?>";
		localStorage.fbid="<?php echo $fbid;?>";
		localStorage.secret="<?php echo $secret;?>";
	    var myinfo={};
	    var client="<?php echo $client;?>";
		myinfo.fbid=localStorage.fbid;
		myinfo.secret=localStorage.secret;
	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4touwfWlpbCpS0SKYvqfUOVddPnd0OBA&sensor=true&libraries=places"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Ridezu</title>
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/ridezu.js"></script>
	<script type="text/javascript" src="js/ridezuadmin.js"></script>
	<link type="text/css" rel="stylesheet" href="css/style.css">
	
</head>

<style>
   #w #pagebody {
	   padding-top:0px;
   		}

<?php if($client!="iOS"){  ?>

   #w {
	   min-height:0px;padding-bottom:5px;
	   -webkit-border-bottom-left-radius: 7px;
	   -webkit-border-bottom-right-radius: 7px;
	   -moz-border-radius-bottomleft: 7px;
	   -moz-border-radius-bottomright: 7px;
	   border-bottom-left-radius: 7px;
	   border-bottom-right-radius: 7px;
   		}

<?php } ?>

</style>
<body>
		<div id="w" style="display:none;">
		
		<div id="pagebody" style="left: 0px;">
		<div id="ios" style="display:none;">
			<div id="topbar" style="display:block;">
			<header id="toolbarnav" style="left:0px; ">
				<a href="#" id="menu-btn"><img id="menub" src="../images/menu.png"/></a>
				<h1 id="pTitle">Ridezu</h1>
			</header>
			</div>
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
		<div id="testios" style="display:none;background-color:#878787;color:#fff;font-size:14px;padding:5px;">
			<a href="ridezu://showbackbutton">Show the back button</a>
			<input type="button" value="Reload Page" onClick="document.location.reload(true)">
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




