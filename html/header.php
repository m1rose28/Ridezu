<?php require_once 'rzconfig.php';

$c="";$t="";$r="";$camp="";$ref="";$msg="";

if(isset($_GET["c"])){$c=$_GET["c"];}
if(isset($_GET["t"])){$t=$_GET["t"];}
if(isset($_GET["r"])){$r=$_GET["r"];}
if(isset($_GET["ref"])){$camp=$_GET["ref"];}
if(isset($_GET["msg"])){$msg=$_GET["msg"];}

?>


<!DOCTYPE html>

<html lang="en">

    <head>
		<script>
      		var page="<?php echo $title;?>";
      		var myinfo={};
      		var info={};
      		var referrer="<?php echo $r;?>";
      		var rname="<?php echo $rname;?>";
      		var msg="<?php echo $msg;?>";
	    	if(msg!=""){localStorage.msg=msg;}
	    	myinfo.company="<?php echo $c;?>";
	    	if(myinfo.company!=""){localStorage.company=myinfo.company;}
	    	info.camp="<?php echo $camp;?>";
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
        <link rel="stylesheet" href="css/style.css?v=<?php echo $rzversion;?>">
        <link rel="stylesheet" href="css/normalize.min.css?v=<?php echo $rzversion;?>">
		<link rel="stylesheet" href="css/corpstyle.css?v=<?php echo $rzversion;?>">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script src="js/ridezucorp.js?v=<?php echo $rzversion;?>"></script>
    </head>
    <body>
        <header>
	        
			<div class="corpwrapper">
				<div id="corplogo">
					<h1><a href="/index.php"><img src="images/ridezulogo.png" alt="Ridezu" /></a></h1>
					
					<img id="cobrand" src=""/>
				</div>
				
				<div id="corpmenu">
					<ul>
						<li><a href="/howitworks.php" alt="How it Works">how it works</a></li>
						<li><a href="/benefits.php" alt="Benefits">benefits</a></li>
						<li><a href="/safety.php" alt="Safety">safety</a></li>
						<li><a href="/faq.php" alt="Faq">faq</a></li>
						<li id="lin" style="display:none;"><a href="#" onclick="loginUser();" alt="Login">login</a></li>
						<li id="lout" style="display:none;"><a href="#" onclick="logoutUser();" alt="Logout">logout</a></li>
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
