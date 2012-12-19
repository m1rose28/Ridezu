<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

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
<br/>Facebook state: <span id="fbstate"></span> 
<br/><br/>User id: <span id="fbid"></span>  
<br/><br/>Seckey: <span id="seckey"></span> 

<?php if (isset($d)==false){ ?> 
	<br/><br/>Delete User (kiss your user goodbye): <span id="deleteuser"></span> 
<?php } ?>

<?php if (isset($d)){ ?> 
	<br/><br/>User removed from db 
<?php } ?>


<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    // init the FB JS SDK
    FB.init({
      appId      : '443508415694320', // App ID from the App Dashboard
      channelUrl : 'ridezu.com/channel.html', // Channel File for x-domain communication
      status     : true, // check the login status upon init?
      oauth 	: true,
      cookie     : true, // set sessions cookies to allow your server to access the session?
      xfbml      : true  // parse XFBML tags on this page?
    });

    // Additional initialization code such as adding Event Listeners goes here
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
		showfbstate();
		alert("facebook response:"+response.status);

	 } else if (response.status === 'not_authorized') {
	   // the user is logged in to Facebook, 
	   // but has not authenticated your app
	   fbstate="This user is logged into Facebook but not authorized in this app. <a href=\"#\" onclick=\"logout();\">Logout</a>";
		showfbstate();
		alert("facebook response:"+response.status);

	 } else {
	   // the user isn't logged in to Facebook.
	   fbstate="The user is not logged into Facebook. <a href=\"#\" onclick=\"logout();\">Logout</a>";
		showfbstate();
		alert("facebook response:"+response.status);
	 }
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


</script>


<script>
  var fbstate="";
  var fbid="";
  var seckey="";
  
  if(localStorage.fbid){fbid=localStorage.fbid;}
  if(localStorage.seckey){seckey=localStorage.seckey;}


  

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