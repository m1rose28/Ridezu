<?php
// this will be our new index.html file.  
require_once 'rzconfig.php';

session_start();
$_SESSION['m']="";

//checks if the session is set for which type of browser to display

if(isset($_GET["m"])){$_SESSION['m']=$_GET["m"];}

if($_SESSION['m']=="0"){ include "corphome.php"; }
if($_SESSION['m']=="1"){ include "index1.php"; }

if($_SESSION['m']==""){ ?>
	<!DOCTYPE html>
	<html lang="en">
	<body>
	<script type="text/javascript">
	if(screen.width<700){window.location = "index.php?m=1"}
	if(screen.width>699){window.location = "index.php?m=0"}
	</script>
	</body></html>
<?php } ?>


