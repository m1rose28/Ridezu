<?php

require_once 'rzconfig.php';

$_SESSION['m']="";

$t="";
$c="";

//checks if the session is set for which type of browser to display

if(isset($_GET["m"])){$_SESSION['m']=$_GET["m"];}
if(isset($_GET["t"])){$t=$_GET["t"];}
if(isset($_GET["c"])){$c=$_GET["c"];}

if($_SESSION['m']=="0"){ include "corphome.php"; }
if($_SESSION['m']=="1"){ include "index1.php"; }

$url="";
if($t!=""){$url=$url."&t=".$t;}
if($c!=""){$url=$url."&c=".$c;}

if($_SESSION['m']==""){ ?>
	<!DOCTYPE html>
	<html lang="en">
	<body>
	<script type="text/javascript">
	x="index.php?m=1"+"<?php echo $url;?>";
	y="index.php?m=0"+"<?php echo $url;?>";
	if(screen.width<700){window.location = x;}
	if(screen.width>699){window.location = y;}
	</script>
	</body></html>
<?php } ?>


