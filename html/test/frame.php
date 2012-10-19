<?php 
include 'header.php';

?>

<script>
function qlink(page){
	document.getElementById('i').src="http://ec2-50-18-0-33.us-west-1.compute.amazonaws.com/index1.php?p="+page;
	}
</script>

<div class="container-fluid">
    <div class="row-fluid">
	    <div class="span2">
    	<!--Sidebar content-->
		   <ul class="nav nav-list">
			   <li class="nav-header">Quick Links</li>
			   <li><a href="#" onclick="qlink('loginp')">Switch User (login)</a></li>
			   <li><a href="#" onclick="qlink('startp')">Start Page</a></li>
			   <li><a href="#" onclick="qlink('riderequestp')">Request a Ride</a></li>
			   <li><a href="#" onclick="qlink('ridepostp')">Post a Ride</a></li>
			   <li><a href="#" onclick="qlink('myridesp')">My Rides</a></li>
			   <li><a href="#" onclick="qlink('enrollp')">Enrollment</a></li>
			   <li><a href="#" onclick="qlink('fbp')">Facebook Login</a></li>
			   <li><a href="#" onclick="qlink('calcp')">Ridezunomics</a></li>
			   <li><a href="#" onclick="qlink('profilep')">Profile</a></li>
			   <li><a href="#" onclick="qlink('userprofilep')">User Profile</a></li>
			   <li><a href="#" onclick="qlink('accountp')">My Account</a></li>
			   <li><a href="#" onclick="qlink('transactionp')">Transactions</a></li>


		   </ul>

    	</div>

    <div class="span10">
    <!--Body content-->

		  <div><img src="../images/iphone.png" style="width:397px;height:auto;"/></div>
			 <div style="background-color:#000;position:relative;top:-616px;left:41px;height:480px; width:320px;">
			 <iframe id="i" src="http://ec2-50-18-0-33.us-west-1.compute.amazonaws.com/index1.php" style="width:320px;height:480px;border:none;"/>
			 </div>
		  </div>


    </div>
</div>
</div>







</body>

</html>