<?php 

$name="";
$fbid="";

if(isset($_GET["name"])){$name=$_GET["name"];}
if(isset($_GET["fbid"])){$fbid=$_GET["fbid"];}
if(isset($_GET["n"])){$n=$_GET["n"];}

$title="Get $10 from Ridezu.";
//$desc="As a special referral from $name, sign-up today and get $10 at Ridezu, the newest, coolest ridesharing service.";
$desc="Hi everyone - check out Ridezu, a cool new ridesharing service.  Follow this link and get $10 - for free.";



if($n=="l"){
	$icon="http://stage.ridezu.com/images/getyour10180x110.jpg";
	}
$url="http://stage.ridezu.com";
	$icon="http://stage.ridezu.com/images/getyour10180x110.jpg";

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="https://www.facebook.com/2008/fbml">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $title; ?></title>
        <meta property="og:site_name" content="Ridezu"/>
        <meta property="fb:app_id" content="443508415694320"/>  
        <meta property="og:title" content="Ridezu"/>
        <meta property="og:description" content="<?php echo $desc;?>" /> 
        <meta property="og:type" content="company"/>
        <meta property="og:url" content="<?php echo $url;?>"/>
        <meta property="og:image" content="<?php echo $icon;?>" />
        <meta name="viewport" content="width=device-width">
   </head>
    <body>
		Welcome to Ridezu.

	 <script>
	 	  function fbpopup(){
		  	  url="https://www.facebook.com/dialog/feed?app_id=443508415694320&"+
		  	  "link=http://stage.ridezu.com%3Fr%3D<?php echo $fbid;?>&"+
		  	  "picture=http://stage.ridezu.com/images/getyour10.png&"+
		  	  "name=Get%20$10%20from%20Ridezu&"+
		  	  "caption=Sign-up%20Today&"+
		  	  "display=popup&"+
		  	  "description=Use this special referral from <?php echo $name;?> and get an instant $10 on the newest and coolest ride-sharing network&"+
		  	  "redirect_uri=https://stage.ridezu.com/r/closeme.php";
	          psize="height=300,width=550";
	          popitup(url,psize)	   
	 	   }
		  
		  function twitterpopup(){
		  	  vurl="?r=<?php echo $fbid;?>";
		  	  vurl1="https://www.ridezu.com"+vurl;
		      url="https://twitter.com/share?text=Checkout Ridezu, a cool, new ridesharing service.  Signup today and get $10.&url="+vurl1+"&counturl=https://www.ridezu.com";
	          psize="height=300,width=550";
		      popitup(url,psize);
		  }

		  function linkedinpopup(){
		  	  vurl="https://stage.ridezu.com/r/newsfeed.php?n=l&amp;fbid=<?php echo $fbid;?>&amp;name=<?php echo $name;?>";
		  	  vurl1="https://stage.ridezu.com/r/newsfeed.php?n=l&amp;fbid=<?php echo $fbid;?>&amp;name=<?php echo $name;?>";

		  	  url="https://www.linkedin.com/cws/share?url="+vurl+"&original_referer="+vurl1;
		  	  //+"&original_referer="+vurl1;
	          psize="height=375,width=625";
		      popitup(url,psize);		  	  
		  }
		  
		  function popitup(url) {
		  	  newwindow=window.open(url,'name',psize);
			  if (window.focus) {newwindow.focus()}
			  return false;
		  }

	 </script>

	<!--Facebook button-->
	<a href="#" onclick="fbpopup();">Share on Facebook</a>

	<!--Linkded in button-->

	<script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
	<script type="IN/Share" data-url="https://stage.ridezu.com/r/newsfeed.php?n=l&amp;fbid=<?php echo $fbid;?>&amp;name=<?php echo urlencode($name);?>" data-counter="none"></script>			
	
	
	<!--Twitter button-->
			
	<a href="#" onclick="twitterpopup();">Share on twitter</a>
	
	<script>
	x="https://stage.ridezu.com?r=<?php echo $fbid;?>&name=<?php echo $name;?>";
	//window.location=x;
	</script>
	</body>
</html>