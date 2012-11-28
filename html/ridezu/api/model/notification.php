<?php

function generateNotification($tofbid,$fromfbid,$event,$rideid,$notifydata,$notifytype,$notifytime){
        //get user details
		//echo '----1'.$tofbid . ' 2' . $fromfbid . ' 3' . $event. ' 4' . $rideid.' 5'. $notifydata. ' 6'.$notifytype. ' 7'. $notifytime.'----';
		$touser=queryByFB($tofbid);
		if ($notifytype ==null)
		{
			$notifytype=$touser->notificationmethod;
		}
		$fromuser=NULL;
		if ($fromfbid !=NULL)
			$fromuser=queryByFB($fromfbid);

		if ($rideid !=NULL)
		{
			$ride = getRideByKeyAsObj($rideid);
		}
			
					
        $sql = "INSERT INTO `notification` (`fbid`, `fromfbid`,`notifyevent`, `notifytime`, `notifygmttime`,`notifytype`, `notifycontact`, `notifydata`, `status`)
                VALUES (:fbid, :fromfbid,:notifyevent, :notifytime, :notifygmttime, :notifytype, :notifycontact, :notifydata, :status);";
                
			try {	
				
				
				$db   = getConnection();
				$stmt = $db->prepare($sql);
                $stmt->bindParam("fbid", $tofbid);
				$stmt->bindParam("fromfbid", $fromfbid);
                $notifyevent = "RIDE_$event";
                $stmt->bindParam("notifyevent", $notifyevent);
                $stmt->bindParam("notifytime", $notifytime);
				//get touser timezone and convert notifytime to notifygmttime
				if ($notifytime==NULL)
				{
					$notifygmttime = date('Y-m-d H:i:s');
				}
				else	
				{
					$notifygmttime = new DateTime($notifytime,new DateTimeZone($touser->timezone));
					$notifygmttime->setTimezone(new DateTimeZone('GMT'));
		
				}
				//echo $notifygmttime;
				//$notifygmttime=$notifygmttime->format('Y-m-d H:i:s');
				$stmt->bindParam("notifygmttime",$notifygmttime);
                $stmt->bindParam("notifytype", $notifytype);
                if ($notifytype=='SMS')
				{
					$stmt->bindParam("notifycontact",$touser->phone);
				}
				
					$stmt->bindParam("notifycontact",$touser->email);
				
				if ($notifydata==NULL) //use data passed or generate
				{
					if ($rideid !=NULL)
					$notifydata = '$fname='.$touser->fname.',$fbid='.$tofbid.',$rideid='.$rideid.',$eventdatetime='.$ride->eventtime.', $fromlocation = '.$ride->origindesc.', $tolocation= '.$ride->destdesc;
					else 
					$notifydata = '$fname='.$touser->fname;
				}
				else
				{
					$notifydata = '$text='.$notifydata;
				}
                $stmt->bindParam("notifydata", $notifydata);
                $notifystatus = "PENDING";
                $stmt->bindParam("status", $notifystatus );
                $stmt->execute();
                $db = null;           
                       
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
		
}


function sendMessage($tofbid,$fromfbid)
{
	 $request = Slim::getInstance()->request();
		$text = json_decode($request->getBody());
		
            generateNotification($tofbid,$fromfbid,'MESSAGE',NULL,$text->message,'SMS',NULL);
		
}

?>