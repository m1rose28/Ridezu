<?php
/**
 * Facebook Login - Log in via Facebook
 * @author Daniel15 <dan.cx>
 */
class FacebookLogin
{
  const AUTHORIZE_URL = 'https://graph.facebook.com/oauth/authorize';
  const TOKEN_URL = 'https://graph.facebook.com/oauth/access_token';
  const PROFILE_URL = 'https://graph.facebook.com/me';
  
  private $client_id;
  private $client_secret;
  private $my_url;
  private $user_data;
  
  /**
   * Create an instance of the FacebookLogin class
   */
  public function __construct($client_id, $client_secret)
  {
    $this->client_id = $client_id;
    $this->client_secret = $client_secret;
    $this->my_url = 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];
  }
  
  /**
   * Do a Facebook login - either redirects to Facebook or reads the returned result
   */
  public function doLogin()
  {
    // Are we not returning from Facebook (ie. starting the login)?
    return !isset($_GET['code']) ? $this->startLogin() : $this->verifyLogin();
  }
  
  /**
   * Start a login with Facebook - Redirect to their authentication URL
   */
  private function startLogin()
  {
    $data = array(
		  'client_id' => $this->client_id,
		  'redirect_uri' => $this->my_url,
		  'type' => 'web_server',
		  );
    
    header('Location: ' . self::AUTHORIZE_URL . '?' . http_build_query($data));
    die();
  }
  
  /**
   * Verify the token we receive from Facebook is valid, and get the user's details
   */
  private function verifyLogin()
  {
    $data = array(
		  'client_id' => $this->client_id,
		  'redirect_uri' => $this->my_url,
		  'client_secret' => $this->client_secret,
		  'code' => $_GET['code'],
		  );

    // Get an access token
    $result = @file_get_contents(self::TOKEN_URL . '?' . http_build_query($data));
    parse_str($result, $result_array);
    
    // Make sure we actually have a token
    if (empty($result_array['access_token']))
      throw new Exception('Invalid response received from Facebook. Response = "' . $result . '"');
    
    // Grab the user's data
    $this->access_token = $result_array['access_token'];
    $this->user_data = json_decode(file_get_contents(self::PROFILE_URL . '?access_token=' . $this->access_token));
    return $this->user_data;
  }
  
  /**
   * Helper function to get the user's Facebook info
   */
  public function getUser()
  {
    return $this->user_data;
  }
}
?>
