<?php
/**
Author: ADEFOKUN Tomiwa M.
Email: Tomiwa.adefokun@progenicscorp.com,tomiwa.adefokun@gmail.com
*/
require_once 'FController.php';

class SecurityController extends FController{

  function __construct(){
	$this->primary = 'auth_resource_id';
	$this->orderBy = 'resource_module, resource_manager, resource_action';
	$this->table = 'auth_resources';
	$this->where = "";
	$this->searchCriteria = array('resource_module','resource_manager','resource_action','access_roles');
	$this->template = 'security';
	$this->limit = 10;
	$this->assign('title','Manage Securities');
	$db = $this->getConnection();
	$this->db = $db;
	$this->output('roles',$this->db->fetchAssoc("SELECT role_key id, role_name name FROM user_roles ORDER by role_name"));
  	
  }
  	function indexAction(){
	    $this->_forward('list');
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
