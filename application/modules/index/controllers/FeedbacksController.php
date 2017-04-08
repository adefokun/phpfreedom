<?php
/**
Author: ADEFOKUN Tomiwa M.
Email:  tomiwa.adefokun@gmail.com
*/
require_once 'FController.php';

class FeedbacksController extends FController{

  function __construct($block){
	$this->primary = 'feedback_id';
	$this->orderBy = 'fb_date';
	$this->table = 'feedbacks';
	$this->where = "";
	$this->limit = 10;
	$this->template = 'feedbacks';
	$this->assign('title','User Feedbacks');
	$db = $this->getConnection();
	$this->db = $db;
  }
	function indexAction(){
	    $this->_forward('list');
	}
  	function contactAction(){
	    $this->assign('view','contact');
		$this->assign('title','Contact Us');
		
		if($feedback = $this->postParam('feedbacks')){	
            $done = true;
            foreach($feedback as $val){
			    if($val == ''){
				    $this->addAlert('The message was not sent... all the fields are required');
				    $done = false;
				    break;
				}
			}			

			if($done == true){
			    require_once('FMail.php');
			    $mail = new FMail();
				$mailOptions['subject'] = $feedback['fb_subject'];
				$mailOptions['from'] = $feedback['fb_email'];
				$mailOptions['body'] = nl2br($feedback['fb_message']);
				$mailOptions['from_name'] = $feedback['fb_name'];
				$mailOptions['to_name'] = $this->getConf()->email['info_name'];
			    $mailOptions['to'] = $this->getConf()->email['info'];
				$mail->prepare($mailOptions);
			    if($mail->send()){
			        $this->db->insert('feedbacks',$feedback);
					$this->assign('feedbackSent',true);
					$this->addAlert('Your message has been sent, thank you');
				}
				else {
				    $done = false;
					$this->addAlert('The message was not sent... unknown errors');
				}
			}
			
			if($done == false){
				$this->assign('data',$feedback);
			}
		}
		
	}
 /*
  The following functions are defined in the FController, you may overide them if need be.
  function getData(){}
  function listAction(){}
  function deleteAction(){}
  */
  function addAction(){}
  function editAction(){}
  function saveAction(){}
}
?>
