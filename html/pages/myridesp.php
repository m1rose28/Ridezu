<style>

textarea {
	width: 265px;
	height: 60px;
	padding: 5px;
	font-size:18px;
}
</style>
			<div id="r0" style="display:none;">
			<section id="precontent">

				<div id="left3">
					<h3>Route</h3>
					<div class="glassbg">
						<div id="routedirection">
							<span id="origindesc"><img src="images/start.png"/>Home</span>
							&rarr;
							<span id="destdesc"><img src="images/start3.png"/>Work</span>
						</div>
					</div>
				</div>
				
				<div id="right3">
					<h3><span id="costcollect"></span></h3>
					<a id="savings" class="glassbg"  onclick="navt('myridesp','commutep');">
						<div class="arrowright">
							<h4><span id="amount"></span></h4>
						</div>
					</a>
				</div>
			</section>
			</div>

			<div id="r1" style="display:none;">
				<section id="content" class="overflowhidden">
						<h2><span id="ridedetails"></span> <span id="godate"></span><span id="leavetime"></span>. <span id="nomatch"></span> <span id="showmore"></span></h2>
						<ul class="info">
						<div id="ridelist1"></div>
						</ul>
						<img class="roundedbottom" id="ridedesta" src=""/>
				</section>
				<div id="myrideaction"></div>
			</div>
				
				<div id="rlate" style="display:none;">
					<section id="content">
						<h2>How late are you running?</h2>
						<ul>
						<a  onclick="runninglatemessage('2 minutes');"><li>2 minutes</li></a>
						<a  onclick="runninglatemessage('5 minutes');"><li>5 minutes</li></a>
						<a  onclick="runninglatemessage('10 minutes');"><li>10 minutes</li></a>
						<a  onclick="runninglatemessage('15 minutes');"><li>15 minutes</li></a>
						<a  onclick="runninglatemessage('20 minutes');"><li>20 minutes</li></a>
						</ul>
					<input type="text" id="txtmessage" style="display:none;" value="">
					</section>
   					<input type="submit" onclick="notlate();" data-role="none" class="primarybutton" value="< back"/>

   				</div>
				
				
				<div id="rcancel" style="display:none;">
 					<section id="content" class="last">
						<h2>Are you sure you want to cancel this ride?</h2>
						<div id="canceltext"></div>
					</section>

   					<input type="submit" onclick="cancelride();" data-role="none" class="primarybutton" value="Cancel Ride"/>
					
   				</div>
   				
				<div id="noride" style="display:none;">
 					<section id="content">
						<h2 id="noridenote">Looks like you don't have any upcoming rides.<br><br></h2>
					</section>

   					<input id="mr1" type="submit" onclick="nav('myridesp','riderequestp');" data-role="none" class="primarybutton" value="Request a ride" style="display:none;"/>
   					<input id="mr2" type="submit" onclick="nav('myridesp','ridepostp');" data-role="none" class="primarybutton" value="Post a ride" style="display:none;"/>
   					<input id="mr3" type="submit" onclick="nav('myridesp','howitworksp');" data-role="none" class="primarybutton" value="How it Works" style="display:none;"/>
   					<input id="mr4" type="submit" onclick="nav('myridesp','profilep');" data-role="none" class="primarybutton" value="My Profile" style="display:none;"/>

					
   				</div>
   
   				<div id="allrides" style="display:none;">
   					<div id="imdriving" style="display:none;">
   						<section id="precontent">
   							<h3>I'm Driving</h3>
   						</section>
   						
   						<section id="content">
   						<ul>
   						<div id="imdrivingrides"></div>
   						</ul>
   						</section>
   					</div>
   					
   					<div id="imriding" style="display:none;">
   						<section id="precontent">
   							<h3>I'm Riding</h3>
   						</section>
   						
   						<section id="content">
   						<ul>
   						<div id="imridingrides"></div>
   						</ul>
   						</section>
   					</div>
   				</div>
   				
			</div>			
			
			<input id="mr5" type="submit" onclick="nav('myridesp','nearbyp');" class="primarybutton" value="Find Ridezu's nearby"/>
			
