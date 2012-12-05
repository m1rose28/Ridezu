<HTML>
<HEAD>
<TITLE>Upload Success!</TITLE>
<link href="style.css" rel="stylesheet" type="text/css" />
</HEAD>
<BODY>
<H1>Upload Success!</H1>
 
<?php
 
echo "<P>Successfully uploaded ".$_GET['key']." to bucket ".$_GET['bucket'].".</P>\n";
$url = "https://".$_GET['bucket'].".s3.amazonaws.com/".$_GET['key'];
echo '<P>Direct URL to the file is <A HREF="'.$url.'">'.$url."</A></P>\n";
 
include '../footer.php';
?>
</BODY>
</HTML>