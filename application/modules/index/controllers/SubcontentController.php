<?php
/**
Author: ADEFOKUN Tomiwa M.
Email: Tomiwa.adefokun@progenicscorp.com,tomiwa.adefokun@gmail.com
*/
require_once 'FModel.php';

class SubcontentController extends FController{
  public $module;
  public $db;
  public $search;
  public $category = null;
  public $tab;
  function __construct($block = false){
	
    $this->db = $this->getConnection();
	$this->model = new FModel('subcontent','content');
	$this->model->setPrimaryKey('content_id');
	$this->model->setLimit(20);
	$this->model->setOrderBy("item_cat, item_subcat");
	//$this->template = 'pages_sections_list';
		

	if($this->search || $this->getParam($this->model->getName().'_search')){
	    $this->model->setSearchCriteria = array('item_title','item_cat','item_subcat','item_desc','item_details','content_type_key');
	}
	
    }
    function indexAction(){
		if($tab = strtoupper($this->getParam('tab'))) $this->tab = $tab;
		$this->_forward('subsections');
	}
  	function subsectionsAction(){        
	    $role = $this->getUserRole();	
	    if($this->template == '') $this->template = 'pages_sections_list';
	    $category = ($this->category) ? $this->category : $this->getParam('category');
		if(!$this->category && $c = $this->getParam('category')) $this->assign('searchParams',array('category' => $c));
	    if($category == null) return false;
		else{
            $this->model->setOrderBy("item_order");
		    $this->model->addWhere(" AND IF(item_exp_dt = 0, item_exp_dt = 0, item_exp_dt >= curdate()) AND item_cat = '".$category."' AND item_subcat != '".$category."' AND  IF(role_id != '', instr(role_id,".$role.") != 0, role_id = '') ");
		    $this->assign('contentPageName',$category);
		    $this->assign('title',$this->title);
			$this->assign('tab',strtoupper($this->tab));
			$this->_forward('list');
		}
	}
	function build(){
	    $this->assign('tab',strtoupper($this->tab));			
		$this->assign('searchParams',array('content_id' => $this->content_id));
		if($this->action) $this->_forward($this->action);
	}
	
  function editAction(){}
  function saveAction(){}
  function deleteAction(){}
  function addAction(){}
  /*
  The following functions are defined in the FController, you may overide them if need be.
  function getData(){}
  */
}
?>
