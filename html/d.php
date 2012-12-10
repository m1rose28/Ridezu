<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

//check server names and https values and re-direct if needed
$s=$_SERVER['SERVER_NAME'];
$h=$_SERVER['HTTPS'];
$u=$_SERVER['REQUEST_URI'];
if($h==false or $s=="ridezu.com"){header('Location: https://www.ridezu.com'.$u);}

if(isset($_GET["fbid"])){$fbid=$_GET["fbid"];}
if(isset($_GET["seckey"])){$seckey=$_GET["seckey"];}
if(isset($_GET["d"])){$d=$_GET["d"];}

if($fbid && $seckey){
	$dbh=mysql_connect ("localhost", "ridezu", "ridezu123") or die ('I cannot connect to the database because: ' . mysql_error());
	mysql_select_db ("ridezu");
	mysql_query("DELETE FROM userprofile WHERE fbid='$fbid' and seckey='$seckey'") or die(mysql_error());
	echo "deleted";
	header('Location: d.php?d=1');
	}

?>
<html>
<body>
<div id="fb-root"></div>
<br/>Facebook state: <span id="fbstate"></span> 
<br/><br/>User id: <span id="fbid"></span>  
<br/><br/>Secret: <span id="seckey"></span> 

<?php if (isset($d)==false){ ?> 
	<br/><br/>Delete User (kiss your user goodbye): <span id="deleteuser"></span> 
<?php } ?>

<?php if (isset($d)){ ?> 
	<br/><br/>User removed from db 
<?php } ?>


<script>
  var fbstate="";
  var fbid="";
  var seckey="";
  
  if(localStorage.fbid){fbid=localStorage.fbid;}
  if(localStorage.seckey){seckey=localStorage.seckey;}
  
  window.fbAsyncInit = function() {
    // init the FB JS SDK
	FB.init({
	  appId      : '443508415694320', // App ID
	  channelUrl : 'ridezu.com/channel.html', // Channel File
	  status     : true, // check login status
	  cookie     : true, // enable cookies to allow the server to access the session
	  xfbml      : true  // parse XFBML
    });

   FB.getLoginStatus(function(response) {
	 if (response.status === 'connected') {
	   // the user is logged in and has authenticated your
	   // app, and response.authResponse supplies
	   // the user's ID, a valid access token, a signed
	   // request, and the time the access token 
	   // and signed request each expire
	   var uid = response.authResponse.userID;
	   var accessToken = response.authResponse.accessToken;
	   fbstate="This user is logged into the app <a href=\"#\" onclick=\"logout();\">Logout</a>";
	 } else if (response.status === 'not_authorized') {
	   // the user is logged in to Facebook, 
	   // but has not authenticated your app
	   fbstate="This user is logged into Facebook but not authorized in this app. <a href=\"#\" onclick=\"logout();\">Logout</a>";
	 } else {
	   // the user isn't logged in to Facebook.
	   fbstate="The user is not logged into Facebook. <a href=\"#\" onclick=\"logout();\">Logout</a>";
	 }
	showfbstate();
	});

  };

  // Load the SDK's source Asynchronously
  // Note that the debug version is being actively developed and might 
  // contain some type checks that are overly strict. 
  // Please report such bugs using the bugs tool.
  (function(d, debug){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
     ref.parentNode.insertBefore(js, ref);
   }(document, /*debug*/ false));

function showfbstate(){
	document.getElementById("fbstate").innerHTML=fbstate;
	if(localStorage.fbid){document.getElementById("fbid").innerHTML=fbid+" <a href='#' onclick=\"remove()\";>Remove</a>";}
	if(localStorage.seckey){document.getElementById("seckey").innerHTML=seckey+" <a href='#' onclick=\"remove()\";>Remove</a>";}
	if(localStorage.seckey && localStorage.fbid){document.getElementById("deleteuser").innerHTML="<a href=\"d.php?fbid="+fbid+"&seckey="+seckey+"\">Delete User</a>";}

	}  

function logout(){
	FB.logout(function(response) 
		{location.reload();
		});
	}

function remove(){
	localStorage.removeItem('fbid');
	localStorage.removeItem('seckey');
	location.reload();
	}
	
</script>


</body>
</html>