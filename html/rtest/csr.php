<?php 
		
include 'header.php';

$searchstring="";
$c=0;$c1=20;$c2=0;
$limit="limit 20";

if(isset($_GET["search"])){
	$search=$_GET["search"];
	$pos = strpos($search, "@");
	if($pos>0){
		$searchstring=" where email=\"$search\" ";
		}
	if(strlen($search)==10 and intval(substr($search,-3))>0){
		$searchstring=" where phone=\"$search\" ";
		}
	if($searchstring==""){
		$searchstring=" where lname LIKE \"%$search%\" or fname LIKE \"%$search%\"";
		}		
	}			

if(isset($_GET["c"])){
	$c=intval($_GET["c"]);
	$c1=$c+20;
	$c2=$c-20;
	$limit="limit $c,$c1";
	}

$query = "SELECT * FROM `userprofile` $searchstring order by `id` desc $limit";

$result = mysql_query($query) or die(mysql_error());

?>

<script>
   function profile(id){
	   document.getElementById("framedetail").src="profile.php?u="+id;
	   }
</script>

<div class="row">

	<div class="span5">

	  <ul class="nav nav-tabs">
		<li class="active">
		  <a href="#">User List</a>
		</li>
	  </ul>

	   <table class="table table-striped">
	   
<?php

while($row = mysql_fetch_array($result,MYSQL_ASSOC)){
	
	$e=$row['email'];
	$f=$row['fbid'];
	
	echo "<tr><td><a href=\"#\" onclick=\"profile('$f');\">$row[fname] $row[lname]</a></td>";
	echo "<td><a href=\"mailto:$e\" target=\"_myframe\">email</a> <a href=\"http://www.facebook.com/profile.php?id=$f\" target=\"_myframe\">fb</a></td>";
	echo "<td>$row[createdon]</td>";
	echo "<td>$row[balance]</td>";
	echo "</td></<tr>";
	
 }

?>


		</table>
	<br><br>
	<a href="csr.php?c=<?php echo $c2;?>">Previous</a> | <a href="csr.php?c=<?php echo $c1;?>">Next</a>

	</div>
	

	<div class="span9">
		<iframe src="" id="framedetail" style="padding:0px;margin:0px;border:none;width:100%;height:5000px;"/>
	</div>

</div>

?>
 



</div>

  </body>
</html>