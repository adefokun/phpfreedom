<?php
/**
Author: ADEFOKUN Tomiwa M.
Email: Tomiwa.adefokun@progenicscorp.com,tomiwa.adefokun@gmail.com
*/
require_once 'FController.php';

class LoginController extends FController{

	public $db;
    function __construct(){
	    $this->templates = array(
						'login' => 'login_login',
						'logout' => 'login_login',
						'reminder' => 'login_reminder'
					   );
	    $this->db = $this->getConnection();
	    //$this->defaultAction = 'login';
    }
	function indexAction(){
		$this->_forward('login');
	}
	function loginAction(){
	
	   $credentials = (object) $this->postParam('login');
		if($this->getLoggedUser()) {
			$this->addAlert('A user is already logged on');
			return false;
		}
	   if(isset($credentials->username)){
		   if($credentials->username == '' && $credentials->password == '')  $this->trackError('all','Please enter your username and password');
		   else if(!$credentials->username) $this->trackError('username','Please enter your username');
		   else if(!$credentials->password) $this->trackError('password','Please enter your password');
		   
		   if($this->getErrors()){
		   
		       $this->assign('credentials',$credentials);
			   return false;
		   }
		   
		   $result = $this->db->fetchRow("SELECT * FROM users WHERE username = '".$credentials->username."' AND password = '".md5($credentials->password)."'");
		   if(!$result) $this->trackError('all','Invalid credentials');
		   else{
		       $user = (object)$result;
			   $this->setUser($user);
			   $home = $this->getBaseUrl();
			   $this->redirect($home);
		   }
		   if($this->getErrors()){
		       $this->assign('credentials',$credentials);
		   }
	   }
	}
	function logoutAction(){
	    if($this->getUser()){
		    $this->destroyUser();
            $this->addAlert('You have been logged out successfully!');			
		}
		else $this->addAlert('There are no authenticated user, you may login immediately');
	}
	function reminderAction(){
		if($email = $this->getParam('email')){
			if(!FValidate::email($email)){
				$this->noView();
				$this->writeFCAlert('Invalid email provided!');
			}
			else if($q = $this->db->fetchOne("SELECT security_question FROM users WHERE email_address = '{$email}'")){
				$this->assign('label',$q);
				$this->assign('entry','answer');
				$this->assign('jsValidator','FValidate.notEmpty');
				$this->assign('errorAlert','Please answer the security question...');
				$this->addToSession('credentials_reminder_email',$email);
			}
			else {
			    $this->noView();
				$this->writeFCAlert('The email provided is not identified!');
			}
		}
		else if($answer = $this->getParam('answer')) {
			$this->noView();
			$email = $this->getSession(true)->credentials_reminder_email;
			$data = $this->db->fetchRow("SELECT 
											username, concat(firstname,' ',lastname) name, security_answer 
										FROM users WHERE email_address = '{$email}'");
			
			if(strtolower($answer) == strtolower($data['security_answer'])){
			    $confEmail = $this->getConf()->email;
			    $newPassword = $this->generateKey(6,true);
				if($this->db->update('users',array('password'=>md5($newPassword)),"email_address = '".$email."'")){
					require_once 'FMail.php';
					$inform = new FMail();
					$mailOptions['subject'] = 'New password for your account';
					$mailOptions['from'] = $confEmail['admin'];
					
					$mailOptions['body'] = 'Dear '.$data['name'].', the password for your account has been changed successfully. The new credentials are: <br /><br />Username: '.$data['username'].'<br /> Password: '.$newPassword.'<br /><br />Best regards,<br /><br />'.$confEmail['admin_name'].'';
					
					$mailOptions['from_name'] = $confEmail['admin_name'];
					$mailOptions['to_name'] = $data['name'];
				    $mailOptions['to'] = $email;
					$inform->prepare($mailOptions);
					$inform->send();
					$this->writeFCAlert('Credentials updated successfully! <br />Details sent to your email.');
				}
				else{
					$this->writeFCAlert('Error updating redentials!');
				}
			}
			else $this->writeFCAlert('Invalid security answer provided!');
		}
		else {
			$this->assign('entry','email');
			$this->assign('label','Enter account email');	
			$this->assign('jsValidator','FValidate.email');			
			$this->assign('errorAlert','Please enter a valid email address...');
		}
	}
	function writeFCAlert($string){
		echo '<div style="color: red; text-align: center;">'.$string.'</div>';
	}
}
?>
