<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include('image_check.php');
$msg='';

	 function putfile($name,$ext,$tmp,$type,$fbid,$valid_formats,$size){
	 
		 if(strlen($name) > 0)
		 {
		 
			 if(in_array($ext,$valid_formats))
			 {
			  
				  if($size<(5000000))
				  {
					  include('s3_config.php');
					  
					  //create name
					  $actual_image_name = $type."-".$fbid."-o.".$ext;

		
						   $a=$s3->putObjectFile($tmp, $bucket , $actual_image_name, S3::ACL_PUBLIC_READ);
						   
						   if($a)
								{
								//successful upload
								$msg = "'{\"type\":\"$type\",\"image\":\"$actual_image_name\"}'";
								?>
									<script language="javascript" type="text/javascript">window.top.window.stopUpload(<?php echo $msg; ?>);</script>   	
								<?php
								}
								else{
								$msg = "Fail";
								echo $type.$actual_image_name.$bucket;
								echo "whoops".$msg;}					  
				  }
				  else
				  $msg = "Image size max 5mb";
			 
				  }
			  else
			  $msg = "Invalid file, please upload image file.";
		 
			  }
		  else
		  $msg = "Please select image file.";
		  
	}


if($_SERVER['REQUEST_METHOD'] == "POST")
	 {
	 
	 $fbid = $_POST["fbid"];

	 foreach ($_FILES as $key => $value) {

		if($value['name']<>""){
		   $name = $value['name'];
		   $size = $value['size'];
		   $tmp = $value['tmp_name'];
		   $ext = getExtension($name);	   
		   $a=putfile($name,$ext,$tmp,$key,$fbid,$valid_formats,$size);
		   }
	 }
	 
}
?>

