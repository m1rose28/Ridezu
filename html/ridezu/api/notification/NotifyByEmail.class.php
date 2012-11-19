<?php
class NotifyByEmail {   

  private $to;   

  public $subject;   
  public $body;   

  public function send() {   
   $sent = mail($this->to, $this->subject, $this->body, $this->headers);   
   return $sent;   
  }   

  public function addHeader($header) {   
   $this->headers .= $header;   
  }


  public function SetSubject($subject) {   
   $this->subject = $subject;   
  }
  
  public function SetTo($to) {   
   $this->to = $to;   
  }

  public function SetBody($body) {   
   $this->body= $body;   
  }
 }
?>