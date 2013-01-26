<?php 

$title="Usage Summary";
	
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
	
include 'header.php';

$company="Tesla";
	
$query = "SELECT Date,ShuttleUsers,VanPoolUsers,CarpoolUsers,Bike from chartdata where type='day' and Company='$company' order by Date ASC limit 0,31";

$dailydata = mysql_query($query) or die(mysql_error());

$query = "SELECT Date,ShuttleUsers,VanPoolUsers,CarpoolUsers,Bike from chartdata where type='month' and Company='$company' order by Date ASC limit 0,31";

$monthlydata = mysql_query($query) or die(mysql_error());

// now that we have the data let's start printing it out

?>

    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
    
      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});
      
      // Set a callback to run when the Google Visualization API is loaded.
  
      google.setOnLoadCallback(dailyChart);
      google.setOnLoadCallback(monthlyChart);
      
      function dailyChart() {
      
		 var data = google.visualization.arrayToDataTable([
          ['Date', 'Shuttle Users','Vanpool Users','Carpool Users','Bikers'],
         
          <?php
          	   $d="";
			   while($row = mysql_fetch_array($dailydata)){
				   $d1=date('n/j', strtotime($row[0]));
				   $d=$d."['$d1',$row[1],$row[2],$row[3],$row[4]],\n";
				   }
			   $d=substr($d,0,-1);
			   echo $d;             	 
		  ?>
			 ]);
   
   
		 var options = {
						width:980,
						height:500,
						colors:['#86cc30','#33429a','#c02d69','#6773cd','eob035','508510'],
						isStacked: true,
						chartArea:{top:30,left:70,width:700,height:400},
						hAxis:{showTextEvery: 7}
						};
   		   		
		  var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
          chart.draw(data, options);
	     }
	     
      function monthlyChart() {
		 var data = google.visualization.arrayToDataTable([
          ['Date', 'Shuttle Users','Vanpool Users','Carpool Users','Bikers'],
         
          <?php
          	   $d="";
			   while($row = mysql_fetch_array($monthlydata)){
				   $d1=date('M', strtotime($row[0]));
				   $d=$d."['$d1',$row[1],$row[2],$row[3],$row[4]],\n";
				   }
			   $d=substr($d,0,-1);
			   echo $d;             	 
		  ?>
			 ]);
   
		 var options = {
						width:980,
						height:500,
						colors:['#86cc30','#33429a','#c02d69','#6773cd','eob035','508510'],
						chartArea:{top:30,left:70,width:700,height:400},
						isStacked: true
						};
   
		  var chart = new google.visualization.ColumnChart(document.getElementById('chart_div2'));
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
						<h2>Usage Summary</h2>
					</div>
					
				</div>
			</div>
		</section>
		
		<section>
			<div class="portalwrapper">

				<div id="portalcontent" class="left contact">

					<div id="control" style="margin:5px;">
						<select id="charttime" onchange="selecttime();">
							<option value="Daily Chart">Daily Chart</option>
							<option value="Monthly Chart">Monthly Chart</option>
						</select>
					</div> 

					 <div id="chart_div" style="width:980px; height:500px:display:block;"></div>
					 <div id="chart_div2" style="width:980px; height:500px;display:none;"></div>

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
				}
			if(charttime=="Monthly Chart"){
				document.getElementById('chart_div').style.display="none";
				document.getElementById('chart_div2').style.display="block";				
				}
			}
	
	</script>

<?php 
include 'footer.php';
?>

</html>
