<?php
require ABSPATH."Services/Twilio.php";
 
class NotifyBySMS
{
	private $accountSid;
	private $authToken;
	private $client;
 
	public function __construct()
	{
		$this->accountSid = TWILIO_ACCSID; //get your own after trial registration on Twilio.com
		$this->authToken = TWILIO_AUTHTOKEN;
		$this->client = new Services_Twilio($this->accountSid, $this->authToken);
	}
 
	public function sendSMS($from, $to, $body){		
			$smsStatus = false;
			try{
				$response = $this->client->account->sms_messages->create( $from,  $to,   $body);
				//print_r($response);
				$smsStatus = true;
            }catch (Exception $e) {
				echo $e->getMessage(), "\n";
			}
			return $smsStatus;
	}
 
 
	public function __destruct()
	{	 
		unset($this->accountSid);
		unset($this->authToken);	 
	}
 
}
 
/* 
$s = new NotifyBySMS();
$s->sendSMS('+15005550006','5103646948','this is a test SMS.');
*/
 
?>