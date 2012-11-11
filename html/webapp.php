<?php

$p="myridesp";
if(isset($_GET["p"])){$p=$_GET["p"];}

?>

<!DOCTYPE html>
    <head>
		<script type="text/javascript">
			var startpage="<?php echo $p;?>";
		</script>
		<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyA4touwfWlpbCpS0SKYvqfUOVddPnd0OBA&sensor=true&libraries=places"></script>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Ridezu</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="css/normalize.min.css">
        <link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/corpstyle.css">

    </head>
    <body>
 
        <header>

			<div class="corpwrapper">
				<div id="corplogo">
					<h1><a href="index.html"><img src="images/ridezulogo.png" alt="Ridezu" /></a></h1>
				</div>
				
				<div id="corpmenu">
					<ul>
						<li><a href="#">how it works</a></li>
						<li><a href="#">benefits</a></li>
						<li><a href="#">safety</a></li>
						<li><a href="faq.html">faq</a></li>
						<li><a href="#">login</a></li>
					</ul>
				</div>
			</div>
		</header>
		
		<section id="homepageintro" class="webapppage">
			<div class="corpwrapper">
				<div id="corpmain">
					<div id="slider">
						<img class="slide" src="images/sanfran.jpg" alt="San Francisco" />
					</div>
					
					<div id="corptitle" class="index80">
						<h2>Something</h2>
					</div>
					
					<div id="webappwrapper" class="index80">
					
						<object data="index1.php" width="340" height="1000"> <embed src="http://www.bellified.com/testing/ridezu/aboutme.html" width="340" height="500"> </embed> Error: Embedded data could not be displayed. </object>
						
					</div>
				</div>
			</div>
		</section>
		
		<section>
			<div class="corpwrapper">
				<div id="space">
				</div>
			</div>
		</section>
		
		<footer>
			<div class="corpwrapper">
				<ul id="corpfootermenu">
					<li><a href="#">about</a></li>
					<li><a href="#">faq</a></li>
					<li><a href="#">safety</a></li>
					<li><a href="#">contact us</a></li>
				</ul>
				
				<ul id="corpsociallinks">
					<li>
						<a href="#"><img src="images/facebook.png" alt="Facebook link" /></a>
					</li>
					<li>
						<a href="#"><img src="images/twitter.png" alt="Twitter link" /></a>
					</li>
				</ul>
				
				<p>Terms of Service &#124; Privacy &#124; &copy; 2012 Ridezu. All rights reserved.</p>
			</div>
		</footer>
		
		
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.2.min.js"><\/script>')</script>



        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>
