<div id="workprofiled">
		<div id="r1" style="display:block;">
			<section id="precontent">
				<h3>Work Address (actual)</h3>
			</section>
				<section id="content" class="overflowhidden">
				<a href="#" onclick="pickwork()">
					<ul>
						<li>
							<div id="add1"></div>
							<div id="city"></div>
						</li>
					</ul>
					<img id="mapa" class="roundedbottom" src=""/>
				</a>
				</section>
			<section id="precontent">
				<h3>Pickup Location</h3>
			</section>
				<section id="content" class="overflowhidden">
				<a href="#" onclick="pickpickupwork()">
					<ul>
						<li>
							<div id="pickupname"></div>
						</li>
					</ul>
					<img id="mapb" class="roundedbottom" src=""/>
				</a>
				</section>
		</div>

		<div id="r2" style="display:none;">
			<section id="content" class="mappage">
 			   	<fieldset style="text-align:center;padding:0px;margin:0px;">				
				<input type="text" class="inputaddress" id="location" onchange="getaddr();">	
				<input type="text" id="lat" value="" style="display:none;"/>
				<input type="text" id="lng" value="" style="display:none;"/>
				<div class="fullmap">
					<div id="map_canvas">
					</div>
    			</div>
    			</fieldset>
								
			</section>

			<input type="button" id="mapselect" onclick="updatework();" data-role="none" class="primarybutton" value="Select" style="position:fixed;top: 86%;left: 0;z-index:300;"/>

		</div>
</div>