<?php
include('image_check.php');
$msg='';
if($_SERVER['REQUEST_METHOD'] == "POST")
	 {
	 
	 $name = $_FILES['file']['name'];
	 $size = $_FILES['file']['size'];
	 $tmp = $_FILES['file']['tmp_name'];
	 $ext = getExtension($name);
	 $type = $_POST["side"];
	 $fbid = $_POST["fbid"];
	 
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
								$msg = "S3 Upload Successful.";	
								$s3file='http://'.$bucket.'.s3.amazonaws.com/'.$actual_image_name;
								echo "<img src='$s3file' style='max-width:400px'/><br/>";
								echo '<b>S3 File URL:</b>'.$s3file;							
								}
								else
								$msg = "S3 Upload Fail.";					  
				  				echo $a;
				  }
				  else
				  $msg = "Image size Max 5,000,000";
			 
				  }
			  else
			  $msg = "Invalid file, please upload image file.";
		 
			  }
		  else
		  $msg = "Please select image file.";
	 
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upload Files to Amazon S3 PHP</title>
</head>

<body>
<form action="" method='post' enctype="multipart/form-data">
<h3>Upload image file here</h3><br/>
<input type="text" name="side" value="right"/><br/>
<input type="text" name="fbid" value="504711218"/><br/>
<div style='margin:10px'><input type='file' name='file'/> <input type='submit' value='Upload Image'/></div>
</form>
<?php 
echo $msg.'<br/>'; 
?>
		

</body>
</html>
