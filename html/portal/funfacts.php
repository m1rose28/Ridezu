<?php 

$title="Fun Facts";
	
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
	
include 'header.php';

$company="Tesla";
	
// this gets the trip data 

	$query = "SELECT sum(ShuttleUsers),sum(VanpoolUsers),sum(CarpoolUsers),sum(Bike) from chartdata where type='month' and Company='$company'";
	$tripdata = mysql_query($query) or die(mysql_error());
	$td = mysql_fetch_array($tripdata);
	$totaltrips=number_format($td[0]+$td[1]+$td[2]+$td[3]);
	
// co2 savings

	$query = "SELECT sum(ShuttleC02Savings),sum(VanpoolCO2Savings),sum(CarpoolCO2Savings),sum(BikeCO2savings) from chartdata where type='month' and Company='$company'";
	$co2data = mysql_query($query) or die(mysql_error());
	$co2 = mysql_fetch_array($co2data);
	$totalco2=number_format($co2[0]+$co2[1]+$co2[2]+$co2[3]);

// cars removed from road (total vehicles-(total cars/density)

	$query = "SELECT AVG(ShuttleDensity),AVG(VanpoolDensity),AVG(CarpoolDensity) from chartdata where type='month' and Company='$company'";
	$den = mysql_query($query) or die(mysql_error());
	$cardensity = mysql_fetch_array($den);
	$s=array();
	$s[0]=round($td[0]-($td[0]/$cardensity[0]));
	$s[1]=round($td[1]-($td[1]/$cardensity[1]));
	$s[2]=round($td[2]-($td[2]/$cardensity[2]));
	$s[3]=round($td[3]);
	$totalcar=number_format(round($s[0]+$s[1]+$s[2]+$s[3]));

// money saved from not driving to work.  need to get average commute data for users here.
// use average of 20 for motor and 5 for bike, mpg=20, cost of gas is $4.25

	$m1=20;
	$mb=5;
	$costofgas=4.25;
	$mpg=20;
	$ms=array();
	$ms[0]=$td[0]*$m1/$mpg*$costofgas*2;
	$ms[1]=$td[1]*$m1/$mpg*$costofgas*2;
	$ms[2]=$td[2]*$m1/$mpg*$costofgas*2;
	$ms[3]=$td[3]*$mb/$mpg*$costofgas*2;
	$totalms=number_format(round($ms[0]+$ms[1]+$ms[2]+$ms[3]));

// gallons of gas not consumed need to get average commute data for users here.
// use average of 20 for motor and 5 for bike, mpg=20, cost of gas is $4.25

	$gs=array();
	$gs[0]=$td[0]*$m1/$mpg*2;
	$gs[1]=$td[1]*$m1/$mpg*2;
	$gs[2]=$td[2]*$m1/$mpg*2;
	$gs[3]=$td[3]*$mb/$mpg*2;
	$totalgs=number_format(round($gs[0]+$gs[1]+$gs[2]+$gs[3]));


// now that we have the data let's start printing it out

?>

    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
    
      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});
      
      // Set a callback to run when the Google Visualization API is loaded.
  
      google.setOnLoadCallback(tripChart);
      google.setOnLoadCallback(co2Chart);
      google.setOnLoadCallback(carChart);
      google.setOnLoadCallback(savingsChart);
      google.setOnLoadCallback(gasChart);
      
      function tripChart() {
      
        var data = google.visualization.arrayToDataTable([
          ['Trip', 'Users'],
          ['Shuttle',<?php echo $td[0];?>],
          ['Vanpool', <?php echo $td[1];?>],
          ['Carpool',<?php echo $td[2];?>],
          ['Bike',<?php echo $td[3];?>],
        ]);
           
		 var options = {
						width:400,
						height:200,
						colors:['#86cc30','#33429a','#c02d69','#6773cd','eob035','508510'],
						chartArea:{top:30,left:30,width:370,height:180},
						};

	   var formatter = new google.visualization.NumberFormat(
			 {fractionDigits:00});
		 	formatter.format(data, 1); 
   		   		
        var chart = new google.visualization.PieChart(document.getElementById('chart_div1'));
        chart.draw(data, options);
        }

      function co2Chart() {
      
        var data = google.visualization.arrayToDataTable([
          ['Co2 Saved', 'Pounds of Co2'],
          ['Shuttle',<?php echo $co2[0];?>],
          ['Vanpool', <?php echo $co2[1];?>],
          ['Carpool',<?php echo $co2[2];?>],
          ['Bike',<?php echo $co2[3];?>],
        ]);
           
		 var options = {
						width:400,
						height:200,
						colors:['#86cc30','#33429a','#c02d69','#6773cd','eob035','508510'],
						chartArea:{top:30,left:30,width:370,height:180},
						};
   		   		
	   var formatter = new google.visualization.NumberFormat(
			{ fractionDigits:0});
		 	formatter.format(data, 1);


        var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));
        chart.draw(data, options);
        }

      function carChart() {
      
        var data = google.visualization.arrayToDataTable([
          ['Cars Removed', 'Number of Cars'],
          ['Shuttle',<?php echo $s[0];?>],
          ['Vanpool', <?php echo $s[1];?>],
          ['Carpool',<?php echo $s[2];?>],
          ['Bike',<?php echo $s[3];?>],
        ]);
           
		 var options = {
						width:400,
						height:200,
						colors:['#86cc30','#33429a','#c02d69','#6773cd','eob035','508510'],
						chartArea:{top:30,left:30,width:370,height:180},
						};
   		   		
	   var formatter = new google.visualization.NumberFormat(
			{ fractionDigits:0});
		 	formatter.format(data, 1); 


        var chart = new google.visualization.PieChart(document.getElementById('chart_div3'));
        chart.draw(data, options);
        }

      function savingsChart() {
      
        var data = google.visualization.arrayToDataTable([
          ['Savings', '$ Save'],
          ['Shuttle',<?php echo $ms[0];?>],
          ['Vanpool', <?php echo $ms[1];?>],
          ['Carpool',<?php echo $ms[2];?>],
          ['Bike',<?php echo $ms[3];?>],
        ]);

	   var formatter = new google.visualization.NumberFormat(
			 {prefix: '$',fractionDigits:0});
		 	formatter.format(data, 1); 
           
		 var options = {
						width:400,
						height:200,
						colors:['#86cc30','#33429a','#c02d69','#6773cd','eob035','508510'],
						chartArea:{top:30,left:30,width:370,height:180},
						};
   		   		
        var chart = new google.visualization.PieChart(document.getElementById('chart_div4'));
        chart.draw(data, options);
        }
	     
      function gasChart() {
      
        var data = google.visualization.arrayToDataTable([
          ['Gas Savings', 'Gallons'],
          ['Shuttle',<?php echo $gs[0];?>],
          ['Vanpool', <?php echo $gs[1];?>],
          ['Carpool',<?php echo $gs[2];?>],
          ['Bike',<?php echo $gs[3];?>],
        ]);

	   var formatter = new google.visualization.NumberFormat(
			 {fractionDigits:0});
		 	formatter.format(data, 1); 
           
		 var options = {
						width:400,
						height:200,
						colors:['#86cc30','#33429a','#c02d69','#6773cd','eob035','508510'],
						chartArea:{top:30,left:30,width:370,height:180},
						};
   		   		
        var chart = new google.visualization.PieChart(document.getElementById('chart_div5'));
        chart.draw(data, options);
        }

    </script>

		<section id="homepageintro">
			<div class="portalwrapper">
				<div id="corpmain">
					<div id="slider">
						<img class="slide" src="../images/bannerimage.jpg" alt="San Francisco" />
					</div>
					
					<div id="corptitle" class="index80">
						<h2>Fun Facts</h2>
					</div>
					
				</div>
			</div>
		</section>
		
		<section>
			<div class="portalwrapper">

				<div id="portalcontent" class="left contact">

				<table>
				<tr><td style="padding-bottom:60px;">
					 <div class="charttitle"><?php echo $totaltrips;?> Trips</div>
					 <div id="chart_div1" style="width:400px; height:200px:display:block;"></div>
					</td>
					<td style="padding-bottom:60px;">
					 <div class="charttitle"><?php echo $totalco2;?> Pounds of CO2 Saved</div>
					 <div id="chart_div2" style="width:400px; height:200px:display:block;"></div>
					</td>
				</tr>
				<tr>
					<td style="padding-bottom:60px;">
					 <div class="charttitle"><?php echo $totalcar;?> cars not in traffic </div>
					 <div id="chart_div3" style="width:400px; height:200px:display:block;"></div>
					</td>
					<td style="padding-bottom:60px;">
					 <div class="charttitle">$<?php echo $totalms;?> saved from not driving </div>
					 <div id="chart_div4" style="width:400px; height:200px:display:block;"></div>
					</td>
				</tr> 
				<tr>
					<td style="padding-bottom:60px;">
					 <div class="charttitle"><?php echo $totalgs;?> saved gallons of gas</div>
					 <div id="chart_div5" style="width:400px; height:200px:display:block;"></div>
					</td>
				</tr>
				</table>
				</div>
			</div>
		</section>

	<script>
		// this function used to select the campus and update the page

		function selecttime(){
			charttime=document.getElementById('charttime').value;
			if(charttime=="Daily Chart"){
				document.getElementById('chart_div2').style.display="none";
				document.getElementById('chart_div').style.display="block";				
				document.getElementById('chart_div4').style.display="none";
				document.getElementById('chart_div3').style.display="block";				
				}
			if(charttime=="Monthly Chart"){
				document.getElementById('chart_div').style.display="none";
				document.getElementById('chart_div2').style.display="block";				
				document.getElementById('chart_div3').style.display="none";
				document.getElementById('chart_div4').style.display="block";				
				}
			}
	
	</script>

<?php 
include 'footer.php';
?>

</html>
