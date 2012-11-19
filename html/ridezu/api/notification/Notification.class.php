<?php
class Notification{
		
	protected $notifyType;
	protected $conn = NULL;
	
    public function __construct($nType) {
			
			$this->notifyType = $nType;
			$this->sendNotification();
			
    }
   
	public function getNotifyInfo() {
	    global $db;
        $notify_data = array();
		
		//$stmt = $db->prepare("SELECT * FROM `notification` where status = :status and notifyGMT < NOW()"); //1.usage of notifytime check?
		$stmt = $db->prepare("SELECT * FROM `notification` where status = :status"); //1.usage of notifytime check?
		$stmt->execute(array('status' => $this->notifyType));
		$result = $stmt->fetchAll();
		if ( count($result) ) {
			foreach($result as $row) {
			  $notify_data[] = $row;
			}
			return $notify_data;
		} else {
			echo "No rows returned.";
			exit();
		}   
	}
	
	public function updateNotificationStatus($process_status,$id){
	global $db;
	    $updStatus = false;
		$sql = "UPDATE `notification` SET `status` = :status WHERE `notification`.`id` = :id";
		try {
			$updstmt = $db->prepare($sql);
			$updstmt->bindParam("status", $process_status);
			$updstmt->bindParam("id", $id);
			$updstmt->execute();
			$updStatus = true;
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
        return $updStatus;		
	}
	
	public function getNotificationTemplate($data){
	global $db;
		$tpldata = "";
		$sql = "SELECT notifytemplatefile FROM `notifytemplate` WHERE notifyevent=:event and notifyformat = :format";
			try {
				$stmt = $db->prepare($sql);
				$stmt->bindParam("event", $data['notifyevent']);
				$stmt->bindParam("format", $data['notifytype']);
				$stmt->execute();
				$row = $stmt->fetch();
				
				$tplData=$row['notifytemplatefile'];			
				$notifyMsg = new NotificationTemplate($row['notifytemplatefile']);
				$tpldata = $notifyMsg->output($data['notifydata']);			
			   
			} 
			catch(PDOException $e) {
				echo '{"error":{"text":'. $e->getMessage() .'}}';
			}
			catch (Exception $e) {
				echo $e->getMessage(), "\n";
			}
       return $tpldata;		
	}
   
	public function sendNotification(){
		
		$notifyInfo = $this->getNotifyInfo(); 
		if(count($notifyInfo)>0){
			foreach($notifyInfo as $ntf){
				if($this->updateNotificationStatus(NotificationStatus::RZ_READY, $ntf['id'])){
				    // get the template and return the string
					 $tplMsg = $this->getNotificationTemplate($ntf);
					
					switch($ntf['notifytype']){
						case NotificationType::RZ_SMS :
						
							$sms = new NotifyBySMS();
							if($sms->sendSMS(TWILIO_FROM , $ntf['notifycontact'], $tplMsg)){
								$this->updateNotificationStatus(NotificationStatus::RZ_DELIVERED, $ntf['id']);
							}else{
								$this->updateNotificationStatus(NotificationStatus::RZ_FAILED, $ntf['id']);						
							}							
						break;
						case NotificationType::RZ_EMAIL :
							$from = "";
							$subj = "";
							$fromresult = preg_match("/#from\:(.*)/", $tplMsg, $mailfrom);
							$subresult = preg_match("/#subject\:(.*)/", $tplMsg, $mailsub);
							
							
							if($fromresult == 0)
							{
								 $from = "no-reply@ridezu.com";   
							}
							else
							{
								 $from = $mailfrom[1];
								 $tplMsg = preg_replace('/#from\:(.*)/', '', $tplMsg);

							}
							
							if($subresult == 0)
							{
								 $subj = "Ridezu Notification";   
							}
							else
							{
								 $subj = $mailsub[1];
								 $tplMsg = preg_replace('/#subject\:(.*)/', '', $tplMsg);

							}
							
							$mail = new NotifyByEmail(); 
							$mail->SetTo($ntf['notifycontact']);  						
							$mail->SetSubject($subj);   //3. subject needs to be dynamic 
							$mail->SetBody(nl2br($tplMsg));
							$mail->addHeader("From: $from" . "\r\n" .   
										   "Reply-To: $from" . "\r\n" .   
												   "X-Mailer: PHP/" . phpversion() . "\r\n");
							$mail->addHeader("MIME-Version: 1.0\r\n");   
							$mail->addHeader("Content-Type: text/html; charset=ISO-8859-1\r\n");   

																				
							if($mail->send()){
								$this->updateNotificationStatus(NotificationStatus::RZ_DELIVERED, $ntf['id']);
							}else{
								$this->updateNotificationStatus(NotificationStatus::RZ_FAILED, $ntf['id']);						
							}
						break;
						default:
						break;				
					}					
				}
			}
		}else{
			echo "No Results Found";
			exit;
		}

	}
}
?> 