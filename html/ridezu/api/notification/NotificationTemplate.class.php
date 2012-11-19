<?php
class NotificationTemplate {
    protected $file;
    protected $values = array();
  
    public function __construct($file) {
        $this->file = $file;
    }
	/**
  * Starts the $haystack string with the prefix $needle?
  * @param  string
  * @param  string
  * @return bool
  */
	public function startsWith($prefix, $string) {
		return (strpos( $prefix, $string) === 0);
    }
	
	public function output($data) {
	 global $db;	
	 global $notificationKeyConst;
	 
		if (!file_exists($this->file)) {
			return "Error loading template file ($this->file).<br />";
		}	
	  $output ="";		
	   try {
	        if(ltrim($data)!="" && $this->startsWith($data, '$')){
				    $output = file_get_contents($this->file);
	                $keys = split(",", $data);
					
					$updatedMsg = "";
					if ( count($keys) ) {
					            //existing keys in database
							    foreach($keys as $value) {	
									if(strpos($value, "=")){
											$params = split("=", $value);
											$output = str_replace("[".trim($params[0])."]", $params[1], $output);
									}
								}
								
								foreach($notificationKeyConst as $fld){
								  		    $output = str_replace("[".trim($fld)."]", "", $output);
								}
					}		 
			 }else{
					$output = $data;		 
			 }
		}	
						
		catch (Exception $e) {
			echo $e->getMessage(), "\n";
	    }	    
		return $output;
	}	
}

?>