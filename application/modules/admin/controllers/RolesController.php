<?php
/**
Author: ADEFOKUN Tomiwa M.
Email: Tomiwa.adefokun@progenicscorp.com,tomiwa.adefokun@gmail.com
*/

class RolesController extends FController{

	function __construct(){
		$this->primary = 'role_id';
		$this->orderBy = 'role_name';
		$this->table = 'user_roles';
		$this->where = "";
		$this->template = 'roles';
		$this->limit = 10;
		$this->assign('title','Manage User Roles');
		$db = $this->getConnection();
		$this->db = $db; 	
	}
	function indexAction(){
	    $this->_forward('list');
	}
	function prepare($input){
		foreach($input as $k => $v){
		  if($v == ''){
			  $this->trackError($k,'The field must not be empty');
		  }
		  if($this->rowExists($this->model->getTable(),$this->model->getPrimaryKey(),array('role_key'=>$input['role_key']),$this->getParam('eid'))){
				$this->trackError('role_key','The role key has already been used');
		  }
		}
		return $input;
	}
	function confirmDelete($ids){
		$keys = array('0','1');
		return $this->checkPreservedKeys($ids,'role_key',$keys);
	}
 /*
  The following functions are defined in the FController, you may overide them if need be.
  function getData(){}
  function listAction(){}
  function addAction(){}
  function editAction(){}
  function saveAction(){}
  function deleteAction(){}
  */
}
?>
