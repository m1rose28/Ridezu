<div id="calcd">
			<section id="content">
			<ul class="description"> 

				<li>
				
				<div class="question">
					<label style="padding-bottom:8px;">Are you a rider or a driver?</label>
						<input type="radio" name="utype1" id="rider" value="Rider">Rider
						<input type="radio" name="utype1" id="driver" value="Driver" checked>Driver
				</div>				
			
				</li>
				<li>
				<div class="question">
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
				<div class="question">
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
				<div class="question">
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

			</section>

			<input type="submit" data-role="none" id="calculateBtn" onclick="calcv();" class="primarybutton" value="Calculate"/>
		
			<div id="result" style="display:none;" onclick="rempopup();" class="popup"></div>
		
</div>
