<?php 

$title="Admin";
	
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
	
include 'header.php';

?>

		<section id="homepageintro">
			<div class="portalwrapper">
				<div id="corpmain">
					<div id="slider">
						<img class="slide" src="../images/bannerimage.jpg" alt="San Francisco" />
					</div>
					
					<div id="corptitle" class="index80">
						<h2>Profile</h2>
					</div>
					
				</div>
			</div>
		</section>
		
		<section>
			<div class="portalwrapper">

				<div id="portalcontent" class="left contact">
				<div style="float:left;">
					 <div class="charttitle">Company Info</div>
						 <div style="padding-left:30px;width:600px;">
							<div class="label1">Company Name:</div>
							<div id="company"></div>
							<div class="label1">email domain (yourcompany.com):</div>
							<div id="companyemail"></div>
							<div class="label1">Company logo</div>
							<img id="companylogo" src="">
															 
							<form action="../s3/upload.php" id="myForm" method="POST" name="myForm" enctype="multipart/form-data" target="upload_target" onsubmit="startUpload();">
								<div id="formbutton">
									 <!-- filename to display to the user -->
									 <p id="file-name"></p>
									 <input name="fbid" id="fbid" value="" type="hidden" />
									 <h2 id="uploadprocess" style="display:none;"><img src="../images/loader.gif" /> &nbsp;&nbsp; Loading... </h2>
								 
									 <!-- Hide this from the users view with css display:none; -->
									 <input style="display:none;" id="file-type" name="logo" onchange="addphoto()" type="file" size="4" name="file"/>
									 
									 <!-- Style this button with type image or css whatever you wish -->
									 <div id="browse-click" style="display:block;" class="greybutton" type="button"/>Browse</div>
								 
									 <!-- submit button -->
									 <input id="loadbutton" type="submit" class="greenbutton" style="display:none;" name="submitBtn" onsubmit="startUpload();" value="Upload Logo" />
									 <iframe id="upload_target" name="upload_target" src="../s3/upload.php" style="width:0;height:0;border:0px solid #fff;"></iframe>
								</div>		
							</form>						
								 
							<div class="label1">Locations and People</div>
							<div id="campus_list"></div>
							<input id="startbutton" onclick="window.location='loadusers.php';" type="submit" value="Manage"/>
							<img id="companylogo" src="" style="width:150px;">	

						</div> 
					 </div>
					 <div style="float:left;">
						  <div class="charttitle">My Info</div>
							  <div style="padding-left:30px;width:200px;">
								  <div class="label1">Name:</div>
								  <div id="name"></div>
								  <div class="label1">email</div>
								  <div id="email"></div>
								  <div class="label1">Phone</div>
								  <div id="phone"></div>
								 <input id="startbutton" onclick="window.location='changepassword.php';" type="submit" value="Change Password"/>
							   </div>
						  </div>
					 </div>
				
				</div>
			</div>
		</section>

<script>
	$(window).load(function () {
		var intervalFunc = function () {
			$('#file-name').html($('#file-type').val().split('\\').pop());
			if(document.getElementById('file-name').innerHTML!=""){
				document.getElementById('loadbutton').style.display="block";
				document.getElementById('companylogo').style.height="100px";	
				}
		};
		$('#browse-click').live('click', function () {
			$('#file-type').click();
			setInterval(intervalFunc, 1);
			return false;
		});
	});
</script>

<?php 
include 'footer.php';
?>

</html>
