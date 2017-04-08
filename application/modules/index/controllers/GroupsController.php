<?php
/**
Author: ADEFOKUN Tomiwa M.
Email: Tomiwa.adefokun@progenicscorp.com,tomiwa.adefokun@gmail.com
*/

require_once 'FModel.php';
class GroupsController extends FController{
  public $action;
  public $title;
  public $group;
  public $tab;
  public $template;
  function __construct($block = false){
    $this->model = new FModel('groups','content');
	$this->model->setPrimaryKey('content_id');
	$this->model->setOrderBy('item_last_update DESC, item_title ');

	$this->model->addWhere(" AND item_cat = item_subcat  AND IF(item_exp_dt = 0, item_exp_dt = 0, item_exp_dt >= curdate())");

	$this->model->setLimit(20);
	$db = $this->getConnection();
	$this->db = $db;
	$this->searchCriteria = array('item_title','item_desc','item_details');

  }
  function prepareGroup(){
    
    $group = ($this->group) ? $this->group : strtoupper($this->getParam('group'));
	//if(!$group) $group = 'GENERAL'; 
	if($ctype = $this->db->getRowById('content_types','content_type_key',$group)){
	    $this->assign('ctype',$ctype);
	    if($group != 'GENERAL') $this->model->addWhere(" AND content_type_key = '".$group."'");
		if(!$this->title) $this->title = $ctype->content_type_name;
		if(!$this->template) $this->template = $ctype->content_type_list_template;
		$this->assign('searchParams',array('group' => strtolower($group)));
		$this->assign('title',$this->title);
		$this->assign('tab',strtoupper($this->tab));	
		return true;
	}
	else {
	    $this->addAlert('Invalid content group defined');
		return false;
	}
  }
  function indexAction(){
      if($tab = strtoupper($this->getParam('tab'))) $this->tab = $tab;
      if($this->prepareGroup())  $this->_forward('list');//parent::listAction();
  }

  function build(){  
		if($this->prepareGroup()) $this->_forward('list');//parent::listAction();
  }

 /*
  The following functions are defined in the FController, you may overide them if need be.
  function getData(){}
  function listAction(){}

  */  
  function addAction(){}
  function editAction(){}
  function saveAction(){}
  //function deleteAction(){}
}
?>
