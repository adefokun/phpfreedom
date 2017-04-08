<?php
/**
Author: ADEFOKUN Tomiwa M.
Email: Tomiwa.adefokun@progenicscorp.com,tomiwa.adefokun@gmail.com
*/
class FMail{
   private $to;
   private $toName;
   private $cc;
   private $bcc;
   private $from;
   private $fromName;
   private $subject = 'No Message Subject';
   private $body;
   public $info;
   
   function __construct(){
 
   }
   function prepare($options = null){
       if(isset($options['to'])) $this->to = $options['to'];
       if(isset($options['to_name'])) $this->toName = $options['to_name'];
       if(isset($options['cc'])) $this->cc = $options['cc'];
       if(isset($options['bcc'])) $this->bcc = $options['bcc'];
       if(isset($options['from'])) $this->from = $options['from'];
       if(isset($options['from_name'])) $this->fromName = $options['from_name'];
       if(isset($options['subject'])) $this->subject = $options['subject'];
       if(isset($options['body'])) $this->body = $options['body'];
   }
   function send(){
       if(!$this->to || !$this->from) return false;
	   else{
	        
	        //headers
			$headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	        
			// Additional headers
            $headers .= "To: ".$this->toName." <".$this->to. ">\r\n" ;
            $headers .= "From: ".$this->fromName." <".$this->from. ">\r\n" ;
			if($this->cc) $headers .= "Cc: ".$this->cc. "\r\n";
            if($this->bcc) $headers .= "Bcc: ".$this->bcc. "\r\n";
			// Mail it
			if(@mail($this->to, $this->subject, $this->body,$headers)) return true;
			else return false;
	   }
	   
   }
}

?>
