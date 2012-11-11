<?php

// harness function. include the query string ?p=pagename 
// for example
// ?p=requestp
// will fetch
// requestp.html in the pages directory

$p="myridesp";
if(isset($_GET["p"])){$p=$_GET["p"];}

?>

<!DOCTYPE html>

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Ridezu</title>
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link type="text/css" rel="stylesheet" href="css/style.css">
	
</head>

<body>
		<div id="w">
		
		<div id="pagebody" style="left: 0px;">
			<div id="topbar" style="display:block;">
			<header id="toolbarnav" style="left:0px; ">
				<h1 id="pTitle">Welcome</h1>
			</header>
			</div>

		<div id="content" style="background-color:#ffffff;">
		
				<center>
			<img style="padding-top:50px;padding-bottom:20px;" src="../images/logo200.png"/>


<p style="font-size:18px;padding-bottom:50px;">Coming soon to<br>a theater near you...</p>


			</center>	
		
		</div>
		</div>
		</div>

	
</body></html>

