<?php
/**
Author: ADEFOKUN Tomiwa M.
Email: Tomiwa.adefokun@progenicscorp.com,tomiwa.adefokun@gmail.com
*/

class CtypeController extends FController{

  function __construct(){
	$this->primary = 'content_type_id';
	$this->orderBy = 'content_type_name';
	$this->table = 'content_types';
	$this->where = "";
	$this->template = 'ctype';
	$this->limit = 20;
	$this->assign('title','Manage Content Type');
	$db = $this->getConnection();
	$this->db = $db;
	
	$pageTemplates = $this->listFiles(P2F_APP_DIR . '/modules/index/views/pages','phtml','.phtml','pages_');
	$sectionTemplates = $this->listFiles(P2F_APP_DIR . '/modules/index/views/pages/sections','phtml','.phtml','pages_sections_');
	
	$this->assign('pageTemplates',$pageTemplates);
	$this->assign('sectionTemplates',$sectionTemplates);
	
  }
  function indexAction(){
      $this->_forward('list');
  }
  function prepare($input){
	 $done = true;
	 if($input['content_type_name'] == '') {
	     $this->trackError('content_type_name','The content type name must no be empty'); 
		 $done = false;
    }
	 if($input['content_type_key'] == '') {
	     $done = false;
	     $this->trackError('content_type_key','The content type key must no be empty');
     }
	 if(!ctype_alpha($input['content_type_key'])){
		 $done = false;
		 $this->trackError('content_type_key','The content type key characters must be alphabets');
	 }
	 if($input['content_type_list_template'] == '') {
	     $done = false;
	     $this->trackError('content_type_list_template','The default listing template must no be empty');
     }
	 if($input['content_type_template'] == '') {
	     $done = false;
	     $this->trackError('content_type_template','The default page display template must no be empty');
     }		 
	 if($input['content_attach_size'] < 1) {
	     $done = false;
	     $this->trackError('content_attach_size','The attachement size must be greater than 0');
     }	 
	 if($input['content_type_subtemplate'] == '') {
	     $done = false;
	     $this->trackError('content_type_subtemplate','The default subsection template must no be empty');
     }
	  if($this->rowExists($this->model->getTable(),$this->model->getPrimaryKey(),array('content_type_key'=>$input['content_type_key']),$this->getParam('eid'))){
		 $done = false;
		 $this->trackError('content_type_key','The content type key already exists');
	 }
	 if($done == true){
	     $input['content_type_key'] = strtoupper($input['content_type_key']);
	 }
	 return $input;
  }
	function confirmDelete($ids){
		return $this->checkPreservedKeys($ids,'content_type_key',array('NEWS','GENERAL'));
		//the third parameter can be an array of preserved keys
	}
 /*
  The following functions are defined in the manager, you may overide them if need be.
  function getData(){}
  function listAction(){}
  function addAction(){}
  function editAction(){}
  function deleteAction(){}
  */
}
?>
