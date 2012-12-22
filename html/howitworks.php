<?php
$title="How it Works";
include "header.php";
?>

<style>
#BCLcontainingBlock {
  width: 100%;
  margin-left: 10px;
  margin-bottom: 10px;
  float: right;
}
.BCLvideoWrapper {
  position: relative;
  padding-top: 1px;
  padding-bottom: 56.25%;
  height: 0;
}
* html .BCLvideoWrapper {
  margin-bottom: 45px;
  margin-top: 0;
  width: 100%;
  height: 100%;
}
.BCLvideoWrapper div,
.BCLvideoWrapper embed,
.BCLvideoWrapper object,
.BrightcoveExperience {
  position: absolute;
  width: 100%;
  height: 100%;
  left: 0;
  top: 0;
}
</style>
		
		<section id="homepageintro">
			<div class="corpwrapper">
				<div id="corpmain">
					<div id="slider">
						<img class="slide" src="images/bannerimage.jpg" alt="San Francisco" />
					</div>
					
					<div id="corptitle" class="index80">
						<h2>how it works</h2>
					</div>
					
				</div>
			</div>
		</section>
		
		<section>
			<div class="corpwrapper">
				<div id="ridezunomics" class="right">
				<div style="background-color:#15a501;color: #fff;padding:10px;padding-left:20px;font-size:22px;">
					Ridezunomics Calculator
				</div>
									<ul style="list-style-type: none;padding-left:20px;margin-top:10px;"> 
						<li>
						
						<div class="question" style="padding-bottom:15px;">
							<label style="padding-bottom:4px;">Are you a rider or a driver?</label>
								<input type="radio" name="utype1" id="rider" value="Rider">Rider
								<input type="radio" name="utype1" id="driver" value="Driver" checked>Driver
						</div>				
					
						</li>
						<li>
						<div class="question" style="padding-bottom:15px;">
							<label>How far is your commute?</label>
							<div class="slidercontainer">
								<div id="slider1" class="slider">
									<div class="circle"></div>
									<div class="bar"></div>
								</div>
							</div>
							<div class="slidervalue">
								<span id="slidervaluea">25</span>m
							</div>
						</div>
						</li>
						<li>
						<div class="question" style="padding-bottom:15px;">
							<label>How much do you pay for gas?</label>
							<div class="slidercontainer">
								<div id="slider2" class="slider">
									<div class="circle"></div>
									<div class="bar"></div>
								</div>
							</div>
							<div class="slidervalue">
								$<span id="slidervalueb">3.85</span>
							</div>
						</div>
						</li>
						<li>
						<div class="question" style="padding-bottom:15px;">
							<label>What's your car's gas mileage?</label>
							<div class="slidercontainer">
								<div id="slider3" class="slider">
									<div class="circle"></div>
									<div class="bar"></div>
								</div>
							</div>
							<div class="slidervalue">
								<span id="slidervaluec">25</span>
							</div>
						</div>
						</li>
		
		
					</ul>
		
					<input type="submit" id="startbutton" onclick="calcv();" value="Calculate"/>
									
				</div>
				
				<div id="howitworkscontent" class="left" style="padding:0px;">

					<div id="BCLcontainingBlock">
					   <div class="BCLvideoWrapper">
   
							 <!-- Start of Brightcove Player -->
							 
							 <div style="display:none">
							 
							 </div>
							 
							 <!--
							 By use of this code snippet, I agree to the Brightcove Publisher T and C 
							 found at https://accounts.brightcove.com/en/terms-and-conditions/. 
							 -->
							 
							 <script language="JavaScript" type="text/javascript" src="https://sadmin.brightcove.com/js/BrightcoveExperiences.js"></script>
							 
							 <object id="myExperience1988007981001" class="BrightcoveExperience">
							   <param name="secureConnections" value="true" />
							   <param name="bgcolor" value="#FFFFFF" />
							   <param name="width" value="480" />
							   <param name="height" value="270" />
							   <param name="playerID" value="1984188548001" />
							   <param name="playerKey" value="AQ~~,AAABzYvvzME~,6HKNF6LIwNNWuYp0r3w8OnsCdE3dFYL2" />
							   <param name="isVid" value="true" />
							   <param name="isUI" value="true" />
							   <param name="dynamicStreaming" value="true" />
							   
							   <param name="@videoPlayer" value="1988007981001" />
							 </object>
							 
							 <!-- 
							 This script tag will cause the Brightcove Players defined above it to be created as soon
							 as the line is read by the browser. If you wish to have the player instantiated only after
							 the rest of the HTML is processed and the page load is complete, remove the line.
							 -->
							 
							 <!-- End of Brightcove Player -->
						 </div>
					  </div>

				</div>
			</div>
		</section>
		
<?php
include "footer.php";
?>