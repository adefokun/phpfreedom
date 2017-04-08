<?php
/**
Author: ADEFOKUN Tomiwa M.
Email: Tomiwa.adefokun@progenicscorp.com,tomiwa.adefokun@gmail.com
*/
require_once 'FController.php';

class MenuController extends FController{
  function __construct(){
    //use model and model API
    require_once 'FModel.php';
    $this->model = new FModel('menu','menu');
	$this->model->setPrimaryKey('menu_id');
	//$this->defaultAction = 'list';
	
	/*
	This part is ignored because we are facing one table, which is defined in the constructor.
	
	$this->model->setMainSelectFrom('select * from menu');
	$this->model->setCountSelectFrom('select count(*) from menu');
	*/
	$this->model->setSearchCriteria(array('text','href','parent_id'));
	$this->model->setLimit(20);
	$this->model->setOrderBy('text');
	//end
	
	//use traditional -- deprecated
	/*
	$this->primary = 'menu_id';
	$this->orderBy = 'text';
	$this->where = "";
	$this->limit = 20;
	$this->searchCriteria = array('text','href','parent_id');
	$this->table = 'menu';

	*/
	$this->template = 'menu';		
	$this->assign('title','Manage Menu');
	$db = $this->getConnection();
	$this->db = $db;
	
	//set the value of the table and primary key... in case you wish to use the inbuilt CRUD.  If you are not you have to overide the following methods
	/*
	  function addAction(){}
	  function editAction(){}
	  function saveAction(){}
	  function deleteAction(){}
	*/
	//$this->table = $this->model->getTable();
	//$this->primary = $this->model->getPrimaryKey();
	
	$this->assign('menu',$this->db->fetchAssoc("SELECT menu_id, text FROM menu ORDER by text"));
	$this->assign('roles',$this->db->fetchAssoc("SELECT role_key id, role_name name FROM user_roles ORDER by role_name"));

  }
	function indexAction(){
	  $this->_forward('list');
	}
	function prepare($input){
		if($input['text'] != ''){

			if($input['href'] == '') {
				$input['link_is_external'] = 1;
				$input['href'] = 'javascript:void(0);';
			}
		}
		else 
		{
			$this->trackError('text','The title field must be not be empty');
		}
		return $input;
	}
 /*
  The following functions are defined in the manager, you may overide them if need be.
  function getData(){}
  function listAction(){}
  function addAction(){}
  function editAction(){}
  function saveAction(){}
  function deleteAction(){}
  */
}
?>
