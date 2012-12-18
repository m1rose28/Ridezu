  <section id="content">

		<style>
  			body.connected #login { display: none; }
  			body.connected #logout { display: block; }
  			body.not_connected #login { display: block; }
  			body.not_connected #logout { display: none; }
		</style>
 	
		<h2 class="last">Please login with Facebook.  
		<br/><br/>
		We're a green company focused on social good.  We'll never spam you, share your private information, or abuse your trust.
		<center>
		<br>
		<img src="images/fb.png"/>
		
		</center>
		<br>
		</h2>
	</section>
	
			<input type="submit" id="login" onclick="loginUser();" data-role="none" class="primarybutton" value="Login with Facebook"/>
