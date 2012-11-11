<?php
function getNearestNode($latlon,  $distance){
       
        $pos = split(",",$latlon);
        if(count($pos) > 0){
           
            $lat = $pos[0]; // latitude
            $lon = $pos[1]; // longitude
           
            try {
                $db = getConnection();
                $sql = "SELECT  `latlong` , ((ACOS(SIN($lat * PI() / 180) * SIN(SUBSTRING_INDEX( `latlong` , ',', 1 ) * PI() / 180)
                + COS($lat * PI() / 180) * COS(SUBSTRING_INDEX( `latlong` , ',', 1 ) * PI() / 180) * COS(($lon - SUBSTRING_INDEX( `latlong` , ',', -1 )) * PI() / 180))
                * 180 / PI()) * 60 * 1.1515) AS `distance` FROM `ridenode` HAVING `distance` <= ".$distance." ORDER BY `distance` ASC limit 1";
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $count = $stmt->rowCount();
                if($count > 0){
                    $latlon = $stmt->fetch(PDO::FETCH_ASSOC);
                    $db = null;
                    return $latlon['latlong'];
                }else{
                   return null;
                }
                  
            } catch(PDOException $e) {
                echo '{"error":{"text":'. $e->getMessage() .'}}';
            }      
        }
    }
?>