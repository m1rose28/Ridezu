<!DOCTYPE html>

<html lang="en">

    <head>
		<script>
      		var page="<?php echo $title;?>";
      		var myinfo={};
      		var info={};
	    	myinfo.company="<?php echo $c;?>";
	    	if(localStorage.seckey!=undefined){
				//var optimizely = optimizely || [];
				//optimizely.push("disable");	
	    		}		
      	</script>		
      	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4touwfWlpbCpS0SKYvqfUOVddPnd0OBA&sensor=true&libraries=places"></script>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $title; ?></title>
        <meta name="description" content="Sign-up for Ridezu it is pretty kick ass.">
        <meta property="og:site_name" content="Ridezu"/>
        <meta property="fb:app_id" content="443508415694320"/>  
        <meta property="og:title" content="Ridezu"/>
        <meta property="og:description" content="Sign-up for the new site.  It is a really amazing service." /> 
        <meta property="og:type" content="company"/>
        <meta property="og:url" content="https://www.ridezu.com"/>
        <meta property="og:image" content="https://www.ridezu.com/images/ridezuAppIcon200.png" />
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="../css/style.css?v=<?php echo $rzversion;?>">
        <link rel="stylesheet" href="../css/normalize.min.css?v=<?php echo $rzversion;?>">
		<link rel="stylesheet" href="../css/corpstyle.css?v=<?php echo $rzversion;?>">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script src="../js/ridezucorp.js?v=<?php echo $rzversion;?>"></script>
    </head>
    <body>
        <header>
			<style>

#emailbutton {
	width: 200px;
	padding: 3px 10px 3px 40px;
	margin: 5px auto;
	color: #fff;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	background: #5BC200;
	background-image:url('../images/emailbutton.png');
	background-size:25px 25px;
	background-repeat:no-repeat;
	background-position:5px 2px;
	text-align: center;
	text-shadow: -1px -1px #2b6818;
	font-family: Helvetica, Arial, Sans-serif;
	font-size: 20px;
	font-weight: bold;
	border: 1px solid #2f6a2f;
	-moz-box-shadow: 0 1px 0 0 #2d4a24;
	-webkit-box-shadow: 0 1px 0 0 #2d4a24;
	box-shadow: 0 1px 0 0 #2d4a24;
}

#emailbutton:hover {
	background: #12A401;
	background-image:url('../images/emailbutton.png');
	background-size:25px 25px;
	background-repeat:no-repeat;
	background-position:5px 2px;
}

#twitterbutton {
	width: 200px;
	padding: 3px 10px 3px 40px;
	margin: 5px auto;
	color: #fff;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	background: #a4d7e8;
	background-image:url('../images/tbutton.png');
	background-size:25px 25px;
	background-repeat:no-repeat;
	background-position:5px 2px;
	text-align: center;
	text-shadow: -1px -1px #2b6818;
	font-family: Helvetica, Arial, Sans-serif;
	font-size: 20px;
	font-weight: bold;
	border: 1px solid #2f6a2f;
	-moz-box-shadow: 0 1px 0 0 #2d4a24;
	-webkit-box-shadow: 0 1px 0 0 #2d4a24;
	box-shadow: 0 1px 0 0 #2d4a24;
}

#twitterbutton:hover {
	background: #619cb6;
	background-image:url('../images/tbutton.png');
	background-size:25px 25px;
	background-repeat:no-repeat;
	background-position:5px 2px;
}

#facebookbutton {
	width: 200px;
	padding: 3px 10px 3px 40px;
	margin: 5px auto;
	color: #fff;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	background: #3e5a85;
	background-image:url('../images/fbutton.png');
	background-size:25px 25px;
	background-repeat:no-repeat;
	background-position:5px 2px;
	text-align: center;
	text-shadow: -1px -1px #2b6818;
	font-family: Helvetica, Arial, Sans-serif;
	font-size: 20px;
	font-weight: bold;
	border: 1px solid #2f6a2f;
	-moz-box-shadow: 0 1px 0 0 #2d4a24;
	-webkit-box-shadow: 0 1px 0 0 #2d4a24;
	box-shadow: 0 1px 0 0 #2d4a24;
}

#facebookbutton:hover {
	background: #3b5998;
	background-image:url('../images/fbutton.png');
	background-size:25px 25px;
	background-repeat:no-repeat;
	background-position:5px 2px;
}

#referbuttons {
	list-style:none;
	margin:0px;
	padding:0px;
}

#referbuttons li{
	margin:10px;
}
	
			</style>
	        
			<div class="corpwrapper">
				<div id="corplogo">
					<h1><a href="/index.php"><img src="../images/ridezulogo.png" alt="Ridezu" /></a></h1>
					
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
<ul id="referbuttons">
	<li><a id="facebookbutton">Share</a></li>
	<li><a id="twitterbutton">Share</a></li>
	<li><a id="emailbutton">Share</a></li>
</ul>


</html>