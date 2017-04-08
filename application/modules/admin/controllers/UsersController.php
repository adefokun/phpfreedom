<?php
/**
Author: ADEFOKUN Tomiwa M.
Email: Tomiwa.adefokun@progenicscorp.com,tomiwa.adefokun@gmail.com
*/
require_once 'FController.php';

class UsersController extends FController{

  function __construct(){
	$this->primary = 'user_id';
	$this->orderBy = 'lastname,firstname ';
	$this->table = 'users';
	$this->where = "";
	$this->template = 'users';
	$this->limit = 20;
	$this->assign('title','Manage User Accounts');
	$db = $this->getConnection();
	$this->db = $db;
	
	$this->assign('roles',$this->db->fetchAssoc("SELECT role_key id, role_name name FROM user_roles"));
  }
  function indexAction(){
      $this->_forward('list');
  }
  function prepare($input){
    $model = $this->getModel();
    /*Perform validations and stuff*/
	$done = true;
	foreach($input as $v){
	    if($v == '') {
	        $done = false;
		    $this->trackError('all','All information except user credentials are required');
			break;
		}
	}
	if($done == true && (
	$this->rowExists($this->model->getTable(),
	$this->model->getPrimaryKey(),
	array('email_address'=>$input['email_address']),
	$this->getParam('eid')))
	){
	    $done = false;
		$this->trackError('email_address','The email address has been used');
	}
	if(!FValidate::email($input['email_address'])){
		$done = false;
		$this->trackError('email_address','Invalid email address provided');
	}
	if($this->postParam('edit_credentials')){

	   if(!$username = $this->postParam('username')){
	       $done = false;
		   $this->trackError('username','No username provided');
	   }
	   else {

			if($this->rowExists($this->model->getTable(),$this->model->getPrimaryKey(),array('username'=>$username),$this->getParam('eid'))){
				$done = false;
				$this->trackError('username','The username has already been used');
			}

		   $chkU = $this->checkUsername($username);
		   if(!$chkU['valid']){
			   $done = false;
			   $this->trackError('username',$chkU['info']);
		   }
		  

	   }
	   
	   $password = $this->postParam('password');	   
	   if(!$password && $this->action == 'insert') {
			$done = false;
			$this->trackError('password','No password provided');
	   }
	   if($password != $this->postParam('cpassword')){
		   $done = false;
		   $this->trackError('password','Password does not match the confirmation');
	   }
	   else if($password && strlen($password) < 6){
		   $done = false;
		   $this->trackError('password','Password should not be less than 6 characters');
	   } 

	}   	

	if(isset($username)) $input['username'] = $username;
	if(isset($password)) $input['password'] = md5($password);


	 return $input;
  }
  
 /*
  The following functions are defined in the FController, you may overide them if need be.
  function getData(){}
  function listAction(){}
  function addAction(){}
  function editAction(){}
  function deleteAction(){}
  */
}
?>
