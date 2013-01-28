<?php

session_start();

if(isset($_GET["corpuserid"])){$_SESSION['corpuserid']=$_GET["corpuserid"];}
if(isset($_GET["corpseckey"])){$_SESSION['corpseckey']=$_GET["corpseckey"];}
if(isset($_GET["company"])){$_SESSION['company']=$_GET["company"];}

?>

<html>
<body>
<script>
parent.document.location = "usagesummary.php"
</script>
</body>
</html>
