<?php
// Bucket Name
$bucket="ridezu";
if (!class_exists('S3'))require_once('S3.php');
			
//AWS access info
if (!defined('awsAccessKey')) define('awsAccessKey', '0N7FSS4P9GTP5W0FGFG2');
if (!defined('awsSecretKey')) define('awsSecretKey', 'i06SoE595rIfMFehXj7Lqh6RDeT68v8umRarSSMe');
			
//instantiate the class
$s3 = new S3(awsAccessKey, awsSecretKey);

$s3->putBucket($bucket, S3::ACL_PUBLIC_READ);

?>