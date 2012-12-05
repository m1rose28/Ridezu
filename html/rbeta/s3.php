<HTML>
<HEAD>
<TITLE>Upload a file to S3</TITLE>
<link href="style.css" rel="stylesheet" type="text/css" />
</HEAD>
<BODY>
<H1>S3 File Upload</H1>
 
<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

$accesskey='0N7FSS4P9GTP5W0FGFG2';
$secretkey='i06SoE595rIfMFehXj7Lqh6RDeT68v8umRarSSMe';
$name="ridezu";
 
require_once '../awssdk/sdk.class.php';
if (!class_exists('CFRuntime')) die('No direct access allowed.');
CFCredentials::set(array(
        $name => array(
                'key' => $accesskey,
                'secret' => $secretkey,
                'certificate_authority' => false
        ),
        '@default' => $name
));
 
$s3 = new AmazonS3();
 
if(!isset($_GET['bucket'])) {
        echo "<P>Please select a bucket:</P>\n";
        $buckets=$s3->get_bucket_list();
        echo '<FORM ACTION="#">';
        foreach ($buckets as $b) { echo '<INPUT TYPE="radio" name="bucket" value="'.$b.'">'.$b."</INPUT><BR>\n"; }
        echo '<BR><INPUT TYPE="submit" VALUE="Use this bucket">'."\n";
 
        } else {
        $bucket = $_GET['bucket'];
 
        $policy='
{"expiration": "2012-01-31T00:00:00Z",
  "conditions": [
    {"bucket": "'.$bucket.'"},
    ["starts-with", "$key", ""],
    {"acl": "public-read"},
    {"success_action_redirect": "success.php"},
    ["starts-with", "$Content-Type", ""]
  ]
}';
 
/*
 * Calculate HMAC-SHA1 according to RFC2104
 * See http://www.faqs.org/rfcs/rfc2104.html
 */
function hmacsha1($key,$data) {
    $blocksize=64;
    $hashfunc='sha1';
    if (strlen($key)>$blocksize)
        $key=pack('H*', $hashfunc($key));
    $key=str_pad($key,$blocksize,chr(0x00));
    $ipad=str_repeat(chr(0x36),$blocksize);
    $opad=str_repeat(chr(0x5c),$blocksize);
    $hmac = pack(
                'H*',$hashfunc(
                    ($key^$opad).pack(
                        'H*',$hashfunc(
                            ($key^$ipad).$data
 
                        )
                    )
                )
            );
    return bin2hex($hmac);
}
 
/*
 * Used to encode a field for Amazon Auth
 * (taken from the Amazon S3 PHP example library)
 */
function hex2b64($str)
{
    $raw = '';
    for ($i=0; $i < strlen($str); $i+=2)
    {
        $raw .= chr(hexdec(substr($str, $i, 2)));
    }
    return base64_encode($raw);
}
 
/* Create the Amazon S3 Policy that needs to be signed */
 
/*
 * Base64 encode the Policy Document and then
 * create HMAC SHA-1 signature of the base64 encoded policy
 * using the secret key. Finally, encode it for Amazon Authentication.
 */
$base64_policy = base64_encode($policy);
$signature = hex2b64(hmacsha1($secretkey, $base64_policy));
 
?>
    <form action="https://<?php echo $bucket;?>.s3.amazonaws.com/" method="post" enctype="multipart/form-data">
      <input type="hidden" name="key" value="<?php echo ${filename}?>">
      <input type="hidden" name="AWSAccessKeyId" value="<?php echo $accesskey;?>">
      <input type="hidden" name="acl" value="public-read">
      <input type="hidden" name="success_action_redirect" value="http://your.server.here/success.php">
      <input type="hidden" name="policy" value="<?php echo $base64_policy?>">
      <input type="hidden" name="signature" value="<?php echo $signature?>">
      <input type="hidden" name="Content-Type" value="image/jpeg">
      <!-- Include any additional input fields here -->
 
      <input name="file" type="file">
      <br>
      <input type="submit" value="Upload File to S3 bucket <?php echo $bucket?>">
    </form>
        <P><A HREF=".">Use a different bucket</A></P>
<?php
}
?>
  </body>
</html>