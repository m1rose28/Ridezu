<?php 
	
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
	
include 'header.php';

$campus="not selected";
$campusd="<select id=\"campus\" onchange=\"selectcampus();\"><option value=\"Select a campus\">Select a campus</option>";
if(isset($_GET["campus"])){$campus=addslashes($_GET["campus"]);}

$q=" and campus='$campus'";
	
$query = "SELECT campus,count(id) from footprint where worklatlong is not null group by campus order by count(id) DESC ";

$result = mysql_query($query) or die(mysql_error());

while($row = mysql_fetch_array($result)){
	$campusd=$campusd."<option value=\"$row[0]\">$row[0] ($row[1])</option>";
	}

$campusd=$campusd."</select>";
	
$query = "SELECT id,add1,city,state,latlong,worklatlong from footprint where latlong is not null".$q;

$result = mysql_query($query) or die(mysql_error());

$data=array();
$mileschart=array();
$usercarpoolnumber=array();
$mileschart["1 Mile"]=0;
$mileschart["1-2 Miles"]=0;
$mileschart["2-5 Miles"]=0;
$mileschart["5-10 Miles"]=0;
$mileschart["10-20 Miles"]=0;
$mileschart["20-30 Miles"]=0;
$mileschart["30-40 Miles"]=0;
$mileschart["40-50 Miles"]=0;
$mileschart["50-100 Miles"]=0;
$carpoolmaxdistance=2;
$carpool=0;
$totalmiles=0;
$c=0;

while($row = mysql_fetch_array($result,MYSQL_ASSOC)){

	$data[$row['id']]=$row;

	}

function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2) {
    $theta = $longitude1 - $longitude2;
    $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
    $miles = acos($miles);
    $miles = rad2deg($miles);
    $miles = $miles * 60 * 1.1515;
    return $miles; 
	}

foreach ($data as $value) {
    $home=explode(",",$value['latlong']);
    $work=explode(",",$value['worklatlong']);
	$id=$value['id'];
	$usercarpoolnumber[$id]=0;
	$c++;
    
    $x=getDistanceBetweenPointsNew($home[0], $home[1], $work[0], $work[1]);

	$totalmiles=$totalmiles+$x;

	if($x<1){$mileschart["1 Mile"]++;}
	if($x>1 and $x<2){$mileschart["1-2 Miles"]++;}
	if($x>2 and $x<5){$mileschart["2-5 Miles"]++;}
	if($x>5 and $x<10){$mileschart["5-10 Miles"]++;}
	if($x>10 and $x<20){$mileschart["10-20 Miles"]++;}
	if($x>20 and $x<30){$mileschart["20-30 Miles"]++;}
	if($x>30 and $x<40){$mileschart["30-40 Miles"]++;}
	if($x>40 and $x<50){$mileschart["40-50 Miles"]++;}
	if($x>50 and $x<100){$mileschart["50-100 Miles"]++;//echo "<br>$x miles: userid $id";
		}
	if($x>100){$totalmiles=$totalmiles-$x;$c=$c-1;}


	foreach ($data as $user){
		$home1=explode(",",$user['latlong']);
		$y=getDistanceBetweenPointsNew($home[0], $home[1], $home1[0], $home1[1]);
		if($y<$carpoolmaxdistance and $user['id']!=$id){
			$usercarpoolnumber[$id]++;
			}
		}

	}

foreach($usercarpoolnumber as $value){
	if($value>0){$carpool++;}
	}

$averagecommutemiles=round($totalmiles/$c,1);
$totalmiles=round($totalmiles);
$penetration=round(($carpool/$c)*100)."%";

// now that we have the data let's start printing it our

?>

    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
    
      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});
      
      // Set a callback to run when the Google Visualization API is loaded.

	  <?php if($campus!="not selected"){ ?>
  
      google.setOnLoadCallback(drawChart);
      google.setOnLoadCallback(drawChart2);
      
      <?php } ?>

      function drawChart() {
      
		 var data = new google.visualization.DataTable();
		 data.addColumn('string', 'Commute Time');
		 data.addColumn('number', 'Minutes');
		 data.addRows([
		 
			 <?php
			   $d="";
			   foreach($mileschart as $key => $value){
				   $d=$d."['$key',$value ],";
				   }
			   $d=substr($d,0,-1);
			   echo $d;
			 ?>
			 ]);
   
		 var options = {'title':'Average Commute',
						'width':800,
						'height':300};
   
		 var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
		 chart.draw(data, options);
	     }
	     
      function drawChart2() {
      
		 var data = google.visualization.arrayToDataTable([
		   ['User Id', 'Potential Carpoolers'],

			 <?php
			   $d="";
			   foreach($usercarpoolnumber as $key => $value){
				   $d=$d."['$key',$value ],";
				   }
			   $d=substr($d,0,-1);
			   echo $d;
			 ?>

		 ]);
 
		 var options = {
		   title: 'Carpool Penetration Test',
		   hAxis: {title: 'User', titleTextStyle: {color: 'blue'}}
		 };
 
		 var chart = new google.visualization.ColumnChart(document.getElementById('chart_div2'));
		 chart.draw(data, options);
	     }	     
    </script>

<div id="control" style="">Select a campus:<?php echo $campusd;?></div> 

<script>

// this function used to select the campus and update the page

		function selectcampus(){
			campus=document.getElementById('campus').value;
			url="carpoolstudy.php?campus="+campus;
			window.location=url;
			}

// this function sets a selected index on a dropdown

		function setSelectedIndex(s, v) {
			for ( var i = 0; i < s.options.length; i++ ) {
				if ( s.options[i].text == v ) {
				   s.options[i].selected = true;
				   return;				   
				}
			}
		}

	setSelectedIndex(document.getElementById('campus'),"<?php echo $campus;?>");

</script>


<!--Div that will hold the pie chart-->
    <div id="chart_div" style="width:800; height:300"></div>
    <div id="chart_div2" style="width:800; height:300"></div>



<?php




//echo "<pre>";
//echo "Average commute from the office<br>";
//print_r($mileschart);
//echo "Number of users this user could carpool with ($carpoolmaxdistance mile radius)<br>";
//print_r($usercarpoolnumber);
//echo "</pre>";

echo "<br>Total users: $c";
echo "<br>Total carpools: $carpool";
echo "<br>Potential penetration: $penetration";
echo "<br>Total miles: $totalmiles";
echo "<br>Average commute: $averagecommutemiles";
	
?>

<?php 
include 'footer.php';
?>

</html>

