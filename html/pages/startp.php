<style> 
body, html, #w {
	height: 100% !important;
	min-height: 0 !important;
}
#w {
	background:url(images/splash320.jpg) no-repeat center;
	background-size:100%;
}
@media only screen and (min-width: 479px) {
	background-image:url(images/splashhighres.jpg);
}

@media
only screen and (-webkit-min-device-pixel-ratio : 1.5),
only screen and (min-device-pixel-ratio : 1.5) {
	background-image:url(images/splashhighres.jpg);
}
</style>
	
		<div id="splashwrap">
			<img id="splashlogo" src="images/splashlogo640.png" />
			<div id="splashcontent">
				<center>
					<input type="submit" data-role="none" onclick="startflow('enroll');" class="primarybutton" value="Start"/>
					<br><br><br>
					<a onclick="loginUser2();" style="font-size:14px;color:#fff;">Already registered? Login with Facebook</a>
				</center>
			</div>
			<iframe id="fbauth" src="" style="width:0px;height:0px;"></iframe>
		</div>