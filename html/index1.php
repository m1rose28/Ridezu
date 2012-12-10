<?php

require_once 'rzconfig.php';

// these are init variables  
$t="";$fbid="";$seckey="";$scriptset="";

$p="myridesp";
$client="mweb";

if(isset($_GET["p"])){$p=$_GET["p"];}
if(isset($_GET["t"])){$t=$_GET["t"];}
if(isset($_GET["fbid"])){$fbid=$_GET["fbid"];}
if(isset($_GET["seckey"])){$seckey=$_GET["seckey"];}
if(isset($_GET["client"])){$client=$_GET["client"];}


if($t=="1" || $t=="2"){
	$scriptset=$scriptset."
		<script type='text/javascript' src='js/ridezuadmin.js?v=$rzversion'></script>
		<script>
			tm='1';
			if(localStorage.fbid==undefined || localStorage.seckey==undefined){
				localStorage.fbid='500012114';
				localStorage.seckey='f6462731d06d181532acd85a5791621a';
				}
		</script>
		";
		$_SESSION['mode']="dev";
	} else

	{
		$_SESSION['mode']="prod";
		}	
	
if($t=="2"){ 
	$scriptset=$scriptset."
	   <script>localStorage.removeItem('fbid')</script>
	   <script>localStorage.removeItem('seckey')</script>
	   ";
	   }

if($client=="widget"){
	$scriptset=$scriptset."
		<style>
		
		#w {
		    min-height:100px;
		    -webkit-border-bottom-left-radius: 7px;
		    -webkit-border-bottom-right-radius: 7px;
			-moz-border-radius-topleft: 7px;
			-moz-border-radius-topright: 7px;
			border-bottom-left-radius: 7px;
			border-bottom-right-radius: 7px;
			padding-bottom:7px;}
			
		#w #pagebody {
			padding-top:0px;
			 }
		</style>
		";
}


if($client=="iOS"){
	$scriptset=$scriptset."
		<script>
		//localStorage.fbid=\"$fbid\";
		//localStorage.seckey=\"$seckey\";
		localStorage.fbid='500012114';
		localStorage.seckey='f6462731d06d181532acd85a5791621a';
		myinfo.fbid=localStorage.fbid;
		myinfo.seckey=localStorage.seckey;
		alert(client+\":\"+myinfo.fbid+\":\"+myinfo.seckey);
		</script>

		<style>
		   #w #pagebody {
			   padding-top:0px;
				}
		
		   #w {
			   min-height:0px;padding-bottom:5px;
			   -webkit-border-bottom-left-radius: 7px;
			   -webkit-border-bottom-right-radius: 7px;
			   -moz-border-radius-bottomleft: 7px;
			   -moz-border-radius-bottomright: 7px;
			   border-bottom-left-radius: 7px;
			   border-bottom-right-radius: 7px;
				}		
		</style>
		";
	}
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta property="og:title" content="Ridezu" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="/" />
	<meta property="og:image" content="/images/ridezu450.png" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link type='text/css' rel='stylesheet' href='css/style.css?v=<?php echo $rzversion;?>'>
	<script type="text/javascript">
		var startpage="<?php echo $p;?>";
		var client="<?php echo $client;?>";
		var v="<?php echo $rzversion;?>";
	    var myinfo={};
	    var tm="0";
	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4touwfWlpbCpS0SKYvqfUOVddPnd0OBA&sensor=true&libraries=places"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

<?php echo $scriptset;?>

	<script type='text/javascript' src='js/script.js?v=<?php echo $rzversion;?>'></script>
	<script type='text/javascript' src='js/ridezu.js?v=<?php echo $rzversion;?>'></script>
	<title>Ridezu</title>
	<link rel="icon" href="favicon.ico" type="image/x-icon"> 
	
</head>

<body style="display:none;">

	<div id="w">
		
		<div id="pagebody" style="left: 0px;">
		 <div id="showbar" style="display:none;">
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
				<div id="pricingp"></div> 
				<div id="commutep"></div> 

<?php if($client=="iOS"){ ?>
			 <script>
			 function updatetitle(){
			 	a="ridezu://title/update/"+Math.random();
				window.location = a;
			     }
			 </script>
			 <section id="content">
				 <ul>
				 <a href="ridezu://backbutton/visible/true"><li>Show the back button</li></a>
				 <a href="ridezu://title/update/hello%20world"><li>Update the title to "hello world"</li></a>
				 <a href="#" onclick="updatetitle()"><li>Update the title a random name</li></a>
				 <a href="#" onclick="document.location.reload(true)"><li>Reload Page</li></a>
				 </ul>
			 </section>
<?php } ?>

<?php if($t==1){ ?>		
			 <script>
			 var tm=1;
			 </script>
			 <section id="content">
				 <ul>
				 <li class="first" id="testbar" onclick="nav1('loginp');"></li>
				 <a href="#" onclick="nav1('startp');" ><li>Start Page</li></a>
				 <a href="index1.php?t=2"><li>Remove Cookies</li></a>
				 <a href="index1.php"><li>Exit Test Mode</li></a>
				 <a href="#" onclick="document.location.reload(true)"><li>Reload Page</li></a>
				 </ul>
			 </section>
<?php } ?>		

				<div id="confirm-background">
					<div id="confirm-box">
						<div id="confirm-message"></div>
						<center>
						<a href="#" id="cancel-button" style="display:none;" onclick="closeconfirm('cancel');" class="cancel"></a>
						<a href="#" id="ok-button" onclick="closeconfirm('ok');"></a>
						</center>
					</div>
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
					<li>Ridezu &copy; 2012</li>
				</ul>
			</div>
		</div>
		<div id="fb-root"></div>



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
	</div>

	
</body></html>




