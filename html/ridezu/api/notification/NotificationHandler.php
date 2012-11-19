<?php
require "NotifyFilesIncludes.php";
 
	try {
		// assign PDO object to db variable
		$db = new PDO( "mysql:host=".DB_SERVER.";dbname=".DB_DATABASE."", DB_SERVER_USERNAME, '' );
		$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		
		$notify = new Notification(NotificationStatus::RZ_PENDING);
		echo "Done";

	}
	catch (PDOException $e) {
		//Output error - would normally log this to error file rather than output to user.
		echo "Connection Error: " . $e->getMessage();
	} 
	catch (Exception $e) {
		echo $e->getMessage(), "\n";
	}
 
?>