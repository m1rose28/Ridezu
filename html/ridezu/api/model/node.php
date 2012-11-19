<?php
function getNearestNode($latlon,  $distance){
       
		//echo 'latlong:'.$latlon.',distance:'.$distance;
        $pos = explode(",",$latlon);
        if(count($pos) > 0){
           
            $lat = $pos[0]; // latitude
            $lon = $pos[1]; // longitude
           
            try {
                $db = getConnection();
                $sql = "SELECT  `latlong` ,`name`, ((ACOS(SIN($lat * PI() / 180) * SIN(SUBSTRING_INDEX( `latlong` , ',', 1 ) * PI() / 180)
                + COS($lat * PI() / 180) * COS(SUBSTRING_INDEX( `latlong` , ',', 1 ) * PI() / 180) * COS(($lon - SUBSTRING_INDEX( `latlong` , ',', -1 )) * PI() / 180))
                * 180 / PI()) * 60 * 1.1515) AS `distance` FROM `ridenode` HAVING `distance` <= ".$distance." ORDER BY `distance` ASC limit 1";
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $node = $stmt->fetchObject();
                    $db = null;
                 return $node;
                 
            } catch(PDOException $e) {
                echo '{"error":{"text":'. $e->getMessage() .'}}';
            }      
        }
    }
	
	
	
  function getNodes($fbid,$location){
    setHeader();
	
	$colname = "homelatlong";
	if( $location == 'W'){
	 $colname = "worklatlong";
	}
  
    $sql = "SELECT SUBSTRING($colname, 1, LOCATE(',', $colname) - 1) as lat,
       SUBSTRING($colname, LOCATE(',', $colname) + 1) as lon from userprofile WHERE fbid='".$fbid."'";
    try {
    	$db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        
		$count = $stmt->rowCount();
		if($count > 0){
		    $user = $stmt->fetchObject();
			$nodesql = "SELECT  `latlong` , ((ACOS(SIN($user->lat * PI() / 180) * SIN(SUBSTRING_INDEX( `latlong` , ',', 1 ) * PI() / 180)
			+ COS($user->lat * PI() / 180) * COS(SUBSTRING_INDEX( `latlong` , ',', 1 ) * PI() / 180) * COS(($user->lon - SUBSTRING_INDEX( `latlong` , ',', -1 )) * PI() / 180))
			* 180 / PI()) * 60 * 1.1515) AS `distance` , `name`, `campus`, `type`,`custommarker` FROM `ridenode` HAVING `distance` <= 5 ORDER BY `distance` ASC";
			$ndstmt = $db->prepare($nodesql);
			$ndstmt->execute();
			$ndcount = $ndstmt->rowCount();
            if($ndcount > 0){
				$nodes = $ndstmt->fetchAll(PDO::FETCH_ASSOC);
				$db = null;
				//print_r($nodes);
				echo json_encode($nodes);
			}else{
			    echo '{"msg":{"text":"No Nodes found."}}';
			}
		}else{
			    echo '{"msg":{"text":"No record found for the fbid."}}';
		}		
	} catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    } 
  }
	
?>