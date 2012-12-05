<?php 
include 'header.php';

?>
<div class="container-fluid">
<table class="table table-striped">
   <tr>
	   <td style="width:300px;">
		  <a href="../index1.php" target="test">https://www.ridezu.com/index1.php</a>	   
	   </td>
	   <td>
	   	  This is the main production url for Ridezu.com mobile
	   </td> 
   </tr>

   <tr>
	   <td>
		  <a href="../corphome.php" target="test">https://www.ridezu.com/corphome.php</a>	   
	   </td>
	   <td>
	   	  This is the main production url for Ridezu.com corporate site
	   </td> 
   </tr>
   
   <tr>
	   <td>
		  <a href="../index1.php?t=1" target="test">https://www.ridezu.com/index1.php?t=1</a>	   
	   </td>
	   <td>
	   	  Enter <b>?t=1</b> at the end and you go into dev mode.  Dev mode adds some special links on the side (login), and also uses -dev files, e.g. ridezu-dev.js, ridezu-dev.css and uses sandbox for Braintree credit card processing.
	   </td> 
   </tr>

   <tr>
	   <td>
		  <a href="../index1.php?t=2" target="test">https://www.ridezu.com/index1.php?t=2</a>	   
	   </td>
	   <td>
	   	  Enter <b>?t=2</b> at the end and you "clear your cookies" (localStorage) and go into dev mode just like ?t=1.
	   </td> 
   </tr>

   <tr>
	   <td>
		  <a href="../d.php" target="test">https://www.ridezu.com/d.php</a>	   
	   </td>
	   <td>
	   	  This tool allows you to see if you're logged and what is in your browser.  You can also logout of Facebook, clear your cookies and, even delete your user id (as in totally deletes - careful!).  
	   </td> 
   </tr>

</table>

</div>







</body>

</html>