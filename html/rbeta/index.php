<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>ridezu</title>
	  	<link rel="stylesheet" href="../themes/ridezu.min.css" />
  		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.1/jquery.mobile.structure-1.1.1.min.css" /> 
  		<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script> 
  		<script src="http://code.jquery.com/mobile/1.1.1/jquery.mobile-1.1.1.min.js"></script> 
	</head>
 <body>
 
 		<div id="home" data-role="page" data-theme="a">

			<div data-role="header" data-position="inline">
				<h1>Welcome</h1>
			</div>
			<div data-role="content" data-theme="a">
 			
			<center>
			<img src="http://i.imgur.com/bvTCX.jpg"/>
			</center>

<div id="p1" style="position:absolute;top:0px;left:0px;z-index:100;width:40px;height:20px;background-color:#cccccc;">yo</div>
<div id="a1" style="width:100%;height:60%;background-color:#dddddd;">swipe left or right on me</div>
<div id="a2" data-role="button" data-icon="grid">width</div>
<div id="a3" data-role="button" data-icon="grid">height</div>
<div id="a4" data-role="button" data-icon="grid">show me</div>

<script>
$(document).ready(function() {
	$("#a1").swipeleft(function() {
		alert("swipe left giddyup");
	});

	$("#a1").swiperight(function() {
		alert("swipe right yee haa");
	});

	$("#a2").click(function() {
		x=$(window).width();
		alert(x);
	});
	$("#a3").click(function() {
		y=$(window).height()
		alert(y);
	});
	$("#a4").click(function() {
		x=$(window).width()+"px";
		y=$(window).height()+"px";
		alert(x+":"+y);
		document.getElementById('p1').style.backgroundColor="#ddd000";
		document.getElementById('p1').style.width=x;
	});
});
</script>
			 						
</div>


</body>
</html>