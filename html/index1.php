<?php

require_once 'rzconfig.php';

$desc="Ridezu is a community for carpooling to and from the office. It's convenient, economical and green.  Join today!";
$title="Ridezu Mobile";

// these are init variables
$t="";$fbid="";$seckey="";$scriptset="";$c="";$client1="";$camp="";$msg="";

$p="myridesp";
$client="mweb";

if(isset($_GET["p"])){$p=$_GET["p"];}
if(isset($_GET["t"])){$t=$_GET["t"];}
if(isset($_GET["ref"])){$camp=$_GET["ref"];}
if(isset($_GET["fbid"])){$fbid=$_GET["fbid"];}
if(isset($_GET["seckey"])){$seckey=$_GET["seckey"];}
if(isset($_GET["client"])){$client=$_GET["client"];}
if(isset($_GET["c"])){$c=$_GET["c"];}
if(isset($_GET["msg"])){$msg=$_GET["msg"];}


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


if($client=="iOS" or $client=="android"){
	$clstring="$client fb: $fbid sc: $seckey";
	$scriptset=$scriptset."
		<script>
		localStorage.fbid=\"$fbid\";
		localStorage.seckey=\"$seckey\";
		myinfo.fbid=localStorage.fbid;
		myinfo.seckey=localStorage.seckey;
		clstring = client+\":\"+myinfo.fbid+\":\"+myinfo.seckey;
		</script>

		<style>
		   #w #pagebody {
			   padding-top:0px;
				}
		
		   #w {
			   min-height:500px;padding-bottom:10px;
				}		
		</style>
		";
	}
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="description" content="Ridezu is a community for carpooling to and from the office. It's convenient, economical and green.  Join today!">
	<meta property="og:site_name" content="Ridezu"/>
	<meta property="fb:app_id" content="443508415694320"/>  
	<meta property="og:title" content="Ridezu"/>
	<meta property="og:description" content="Ridezu is a community for carpooling to and from the office. It's convenient, economical and green.  Join today!" /> 
	<meta property="og:type" content="company"/>
	<meta property="og:url" content="https://www.ridezu.com"/>
	<meta property="og:image" content="https://www.ridezu.com/images/ridezuAppIcon200.png" />
	<link rel="apple-touch-icon" href="../images/ridezuAppIcon72.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="../images/ridezuAppIcon72.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="../images/ridezuAppIcon72.png" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link type='text/css' rel='stylesheet' href='css/style.css?v=<?php echo $rzversion;?>'>
	<script type="text/javascript">
		var ts = Math.round(new Date().getTime() / 1000);
		var startpage="<?php echo $p;?>";
		var client="<?php echo $client;?>";
		var device="<?php echo $device;?>";
		var displayversion="<?php echo $displayversion;?>";
		var v="<?php echo $rzversion;?>";
		var env="<?php echo $rzsystem;?>";
	    var myinfo={};
	    var msg="<?php echo $msg;?>";
	    var info={};
	    var tm="0";
	    myinfo.company="<?php echo $c;?>";
	    if(myinfo.company!=""){localStorage.company=myinfo.company;}
    	info.camp="<?php echo $camp;?>";
	</script>		
	<!--<script src="//cdn.optimizely.com/js/157370915.js"></script>-->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4touwfWlpbCpS0SKYvqfUOVddPnd0OBA&sensor=true&libraries=places"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

<?php echo $scriptset;?>

	<script type='text/javascript' src='js/script.js?v=<?php echo $rzversion;?>'></script>
	<script type='text/javascript' src='js/ridezu.js?v=<?php echo $rzversion;?>'></script>
	<title>Ridezu Mobile</title>
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
				<div id="corploginp"></div> 
				<div id="checkpinp"></div> 
				<div id="fbconnectp"></div> 
				<div id="nearbyp"></div> 

<?php if($client1=="android or iOS"){ ?>
			 
			 <script>

			 function updatetitle(){
			    a=Math.random();
			 	window.android.updatetitle(a);
			     }
			 </script>
			 <br><br><section id="content">
				 <ul>
				 <a href="#" onclick="window.android.backbuttonvisible('true')"><li>Show the back button</li></a>
				 <a href="#" onclick="window.android.updatetitle('Hello World')"><li>Update the title to "hello world"</li></a>
				 <a onclick="updatetitle()"><li>Update the title a random name</li></a>
				 <a onclick="document.location.reload(true)"><li>Reload Page</li></a>
				 <a><li>Client: <?php echo $client1;?></li></a>
				 <a><li>fbid: <?php echo $fbid;?></li></a>
				 <a><li>seckey: <?php echo $seckey;?></li></a>
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
				 <a onclick="nav1('startp');" ><li>Start Page</li></a>
				 <a href="index1.php?t=2"><li>Remove Cookies</li></a>
				 <a href="index1.php"><li>Exit Test Mode</li></a>
				 <a onclick="document.location.reload(true)"><li>Reload Page</li></a>
				 </ul>
			 </section>
<?php } ?>		

				<div id="confirm-background">
					<div id="confirm-box">
						<div id="confirm-message"></div>
						<center>
						<a id="cancel-button" style="display:none;" onclick="closeconfirm('cancel');" class="cancel"></a>
						<a id="ok-button" onclick="closeconfirm('ok');"></a>
						</center>
					</div>
				</div>

				<div id="loadingindicator">
					Loading...
					<!-- code from http://cssload.net/-->
					<div id="spinner">
							<style>
							#circleG{
							width:37.333333333333336px;
							}
							
							.circleG{
							background-color:#4B8A4B;
							float:left;
							height:8px;
							margin-left:4px;
							width:8px;
							-moz-animation-name:bounce_circleG;
							-moz-animation-duration:0.8999999999999999s;
							-moz-animation-iteration-count:infinite;
							-moz-animation-direction:linear;
							-moz-border-radius:5px;
							-webkit-animation-name:bounce_circleG;
							-webkit-animation-duration:0.8999999999999999s;
							-webkit-animation-iteration-count:infinite;
							-webkit-animation-direction:linear;
							-webkit-border-radius:5px;
							-ms-animation-name:bounce_circleG;
							-ms-animation-duration:0.8999999999999999s;
							-ms-animation-iteration-count:infinite;
							-ms-animation-direction:linear;
							-ms-border-radius:5px;
							-o-animation-name:bounce_circleG;
							-o-animation-duration:0.8999999999999999s;
							-o-animation-iteration-count:infinite;
							-o-animation-direction:linear;
							-o-border-radius:5px;
							animation-name:bounce_circleG;
							animation-duration:0.8999999999999999s;
							animation-iteration-count:infinite;
							animation-direction:linear;
							border-radius:5px;
							}
							
							#circleG_1{
							-moz-animation-delay:0.18s;
							-webkit-animation-delay:0.18s;
							-ms-animation-delay:0.18s;
							-o-animation-delay:0.18s;
							animation-delay:0.18s;
							}
							
							#circleG_2{
							-moz-animation-delay:0.42000000000000004s;
							-webkit-animation-delay:0.42000000000000004s;
							-ms-animation-delay:0.42000000000000004s;
							-o-animation-delay:0.42000000000000004s;
							animation-delay:0.42000000000000004s;
							}
							
							#circleG_3{
							-moz-animation-delay:0.5399999999999999s;
							-webkit-animation-delay:0.5399999999999999s;
							-ms-animation-delay:0.5399999999999999s;
							-o-animation-delay:0.5399999999999999s;
							animation-delay:0.5399999999999999s;
							}
							
							@-moz-keyframes bounce_circleG{
							0%{
							}
							
							50%{
							background-color:#FFFFFF}
							
							100%{
							}
							
							}
							
							@-webkit-keyframes bounce_circleG{
							0%{
							}
							
							50%{
							background-color:#FFFFFF}
							
							100%{
							}
							
							}
							
							@-ms-keyframes bounce_circleG{
							0%{
							}
							
							50%{
							background-color:#FFFFFF}
							
							100%{
							}
							
							}
							
							@-o-keyframes bounce_circleG{
							0%{
							}
							
							50%{
							background-color:#FFFFFF}
							
							100%{
							}
							
							}
							
							@keyframes bounce_circleG{
							0%{
							}
							
							50%{
							background-color:#FFFFFF}
							
							100%{
							}
							
							}
							
							</style>
							<div id="circleG">
							<div id="circleG_1" class="circleG">
							</div>
							<div id="circleG_2" class="circleG">
							</div>
							<div id="circleG_3" class="circleG">
							</div>
							</div>
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

    <script>
    if(env=="stage"){
    	document.getElementById('w').style.background="#8b8b8b url(../images/mobilebackground_stage.png) repeat";
    }    
    </script>

	<script type="text/javascript">
	
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', '<?php echo $ga;?>']);
	  _gaq.push(['_trackPageview']);
	
	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	
	
	</script>
	</div>

	
</body></html>




