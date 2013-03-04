<?php

session_start();

$reg=0;
if(isset($_GET["corpuserid"])){$_SESSION['corpuserid']=$_GET["corpuserid"];}
if(isset($_GET["corpseckey"])){$_SESSION['corpseckey']=$_GET["corpseckey"];}
if(isset($_GET["company"])){$_SESSION['companyname']=$_GET["company"];}
if(isset($_GET["email"])){$_SESSION['email']=$_GET["email"];}
if(isset($_GET["reg"])){$reg=$_GET["reg"];}

?>

<html>
<body>
<script>
var reg=<?php echo $reg;?>;
if(reg==0){
	parent.document.location = "usagesummary.php"
	}
if(reg==1){
	parent.document.location = "admin.php"
	}
</script>
</body>
</html>
