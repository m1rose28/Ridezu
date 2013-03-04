<?php 

$title="Ride Schedule";
	
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
						<h2>Ride Schedule</h2>
					</div>
					
				</div>
			</div>
		</section>
		
		<section>
			<div class="portalwrapper">

				<div id="portalcontent" class="left contact">				
					<div class="charttitle">Ride Schedule</div>
					<div class="charttext">The Ride Schedule is a single, simple resource to show you and your employees all the options to get to the office or get home.</div>
					
					<div id="portalbox" class="ridetable">
						<h3>Shuttles</h3>
						<a href="#">add a shuttle</a>
						<table>
							<colgroup>
								<col id="col1">
								<col id="col2">
								<col id="col3">
								<col id="col4">
								<col id="col5">
								<col id="col6">
								<col id="col7">
								<col id="col8">
							</colgroup>
							<thead>
								<tr>
									<td>Name</td>
									<td>Seating</td>
									<td>Active</td>
									<td>Capacity</td>
									<td>Next departure</td>
									<td colspan="3">Arrive</td>
								</tr>
							</thead>
							
							<tr>
								<td>SF Shuttle</td>
								<td>60</td>
								<td>38</td>
								<td>63%</td>
								<td>HQ 5:00pm</td>
								<td>SF* 6:00pm</td>
								<td><a href="#">details</a></td>
								<td></td>
							</tr>
							
							<tr>
								<td>Cal Train Express</td>
								<td>25</td>
								<td>15</td>
								<td>60%</td>
								<td>HQ 5:30pm</td>
								<td>Caltrain 5:40pm</td>
								<td><a href="#">details</a></td>
								<td></td>
							</tr>
							
							<tr>
								<td>San Jose Shuttle</td>
								<td>60</td>
								<td>48</td>
								<td>80%</td>
								<td>HQ 6:00pm</td>
								<td>Livermore* 7:00pm</td>
								<td><a href="#">details</a></td>
								<td></td>
							</tr>
							
							<tr>
								<td>...</td>
								<td>...</td>
								<td><a href="#">...</a></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</table>
						
						<h3>Vanpools</h3>
						<a href="#">add a vanpool</a>
						<table>
							<colgroup>
								<col id="col1">
								<col id="col2">
								<col id="col3">
								<col id="col4">
								<col id="col5">
								<col id="col6">
								<col id="col7">
								<col id="col8">
							</colgroup>
							<thead>
								<tr>
									<td>Name</td>
									<td>Seating</td>
									<td>Active</td>
									<td>Capacity</td>
									<td>Next departure</td>
									<td colspan="3">Arrive</td>
								</tr>
							</thead>
							
							<tr>
								<td>Marty's Missile</td>
								<td>6</td>
								<td>4</td>
								<td>67%</td>
								<td>HQ 5:00pm</td>
								<td>SF* 6:00pm</td>
								<td><a href="#">details</a></td>
								<td><a href="#">message</a></td>
							</tr>
							
							<tr>
								<td>Honda Oddyseus</td>
								<td>6</td>
								<td>3</td>
								<td>50%</td>
								<td>HQ 5:30pm</td>
								<td>SF* 6:30pm</td>
								<td><a href="#">details</a></td>
								<td><a href="#">message</a></td>
							</tr>
							
							<tr>
								<td>Blue Van from Hell.com</td>
								<td>6</td>
								<td>3</td>
								<td>50%</td>
								<td>HQ 6:00pm</td>
								<td>Fremont* 7:00pm</td>
								<td><a href="#">details</a></td>
								<td><a href="#">message</a></td>
							</tr>
							
							<tr>
								<td>South Bay Maniacs</td>
								<td>6</td>
								<td>5</td>
								<td>83%</td>
								<td>HQ 6:00pm</td>
								<td>San Jose* 7:00pm</td>
								<td><a href="#">details</a></td>
								<td><a href="#">message</a></td>
							</tr>
							
							<tr>
								<td>...</td>
								<td>...</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td><a href="#">...</a></td>
								<td><a href="#">...</a></td>
							</tr>
						</table>
						
						<h3>Carpools</h3>
						<table>
							<colgroup>
								<col id="col1">
								<col id="col2">
								<col id="col3">
								<col id="col4">
								<col id="col5">
								<col id="col6">
								<col id="col7">
								<col id="col8">
							</colgroup>
							<thead>
								<tr>
									<td>Name</td>
									<td>Seating</td>
									<td>Active</td>
									<td>Capacity</td>
									<td>Leave</td>
									<td colspan="3">Arrive</td>
								</tr>
							</thead>
							
							<tr>
								<td>Mike Smith</td>
								<td>4</td>
								<td>2</td>
								<td>50%</td>
								<td>HQ 5:00pm</td>
								<td>San Jose 5:40pm</td>
								<td><a href="#">details</a></td>
								<td><a href="#">message</a></td>
							</tr>
							
							<tr>
								<td>Tim Delaney</td>
								<td>4</td>
								<td>2</td>
								<td>50%</td>
								<td>HQ 5:30pm</td>
								<td>Fremont 6:10pm</td>
								<td><a href="#">details</a></td>
								<td><a href="#">message</a></td>
							</tr>
							
							<tr>
								<td>Bob Snodgrass</td>
								<td>4</td>
								<td>3</td>
								<td>75%</td>
								<td>HQ 6:00pm</td>
								<td>San Francisco 6:50pm</td>
								<td><a href="#">details</a></td>
								<td><a href="#">message</a></td>
							</tr>
						</table>
						
						<h3>Bike Buddy</h3>
						<table>
							<colgroup>
								<col id="col1">
								<col id="col2">
								<col id="col3">
								<col id="col4">
								<col id="col5">
								<col id="col6">
								<col id="col7">
								<col id="col8">
							</colgroup>
							<thead>
								<tr>
									<td>Name</td>
									<td></td>
									<td></td>
									<td></td>
									<td>Leave</td>
									<td colspan="3">Arrive</td>
								</tr>
							</thead>
							
							<tr>
								<td>Jim Baloushi</td>
								<td></td>
								<td></td>
								<td></td>
								<td>HQ 5:00pm</td>
								<td>Palo Alto 5:30pm</td>
								<td><a href="#">details</a></td>
								<td><a href="#">message</a></td>
							</tr>
							
							<tr>
								<td>Sandy Yamasaki</td>
								<td></td>
								<td></td>
								<td></td>
								<td>HQ 5:00pm</td>
								<td>Palo Alto 5:30pm</td>
								<td><a href="#">details</a></td>
								<td><a href="#">message</a></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</section>


<?php 

include 'footer.php';
?>

</html>
