<?php
error_reporting(E_ALL);
ini_set( 'display_errors','1'); 
$image = file_get_contents("http://img.youtube.com/vi/Rz8KW4Tveps/1.jpg");
file_put_contents("../photos/imgID.jpg", $image);

?>
