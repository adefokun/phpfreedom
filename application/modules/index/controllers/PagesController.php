<?php
/**
Author: ADEFOKUN Tomiwa M.
Email: Tomiwa.adefokun@progenicscorp.com,tomiwa.adefokun@gmail.com
*/
require_once 'FController.php';

class PagesController extends FController{
    public $template;
	public $page = null;
	public $tab = null;
	public $subsection = null;
	public $mainContent;
	public $subContent;
	public $contentId;
	public $action;
	public $title;
	public $where = "IF(item_exp_dt = 0, item_exp_dt = 0, item_exp_dt >= curdate())";
	
    function __construct($block){
	   
	   $this->db = $this->getConnection();
       $role = $this->getUserRole();
	   $this->where .= " AND IF(role_id != '', instr(role_id,".$role.") != 0, role_id = '') ";
		
    }
	function indexAction(){
	    $this->_forward('display');
	}
	function displayAction(){
	   
		if($page = strtoupper($this->getParam('page'))){
			$this->page = $page;
		}			
		
		if($subsection = strtoupper($this->getParam('subsection'))){
			$this->subsection = $subsection;
		}
		
		if($contentId = $this->getParam('content_id'))
			$this->contentId = $contentId;
			
		if($tab = strtoupper($this->getParam('tab'))){
			$this->tab = $tab;
		}
	    $this->build();
	}
	function build(){
	    if($this->page == null && $this->contentId == null) return false; 
			
			if($this->page && $this->subsection)
			    $mainContent = $this->getMainContentBySubsection($this->page,$this->subsection);
			else if($this->page)
			    $mainContent = $this->getMainContentByCategory($this->page);
			else if($this->contentId)
			    $mainContent = $this->getContentById($this->contentId);
				
		  	if($mainContent){
			    if(!$this->template && $mainContent->item_template != ''){
				    if($mainContent->item_template == 'PARENT'){
					    $this->template =  $this->getParentTemplate($mainContent->item_cat,'item_template');
					}
				    else if($mainContent->item_template == 'DEFAULT_TYPE'){
					    $this->template =  $this->getDefaultTemplate($mainContent->content_type_key,'content_type_template');
					}
					else  $this->template = $mainContent->item_template;
				}
				if($mainContent->item_subtemplate != ''){
				    if($mainContent->item_subtemplate == 'PARENT'){
					    $mainContent->item_subtemplate =  $this->getParentTemplate($mainContent->item_cat,'item_subtemplate');
					}
				    else if($mainContent->item_subtemplate == 'DEFAULT_TYPE'){
					    $mainContent->item_subtemplate =  $this->getDefaultTemplate($mainContent->content_type_key,'content_type_subtemplate');
					}
				}
				
		        if(!$this->template) $this->template = $this->getDefaultTemplate($mainContent->content_type_key);
				if(!$mainContent->item_subtemplate) 
					$mainContent->item_subtemplate = $this->getDefaultTemplate($mainContent->content_type_key,'content_type_subtemplate');
				$this->assign('view',$this->template);
				$this->assign('mainContent',$mainContent);
				$this->assign('title',$mainContent->item_title);
				$this->assign('tab',$this->tab);
		    }
	}

	 public function getContentById($id){
      if($id == null) return false;
	  $db = $this->db;
	  return $db->fetchRow("SELECT * FROM content WHERE ".$this->where." AND content_id = '{$id}'",'OBJ');
	  }

	  public function getMainContentByCategory($section = null){
	      if($section == null) return false;
		  return $this->db->fetchRow("SELECT * FROM content WHERE ".$this->where." AND   item_cat = '{$section}' AND item_subcat = '{$section}' ",'OBJ');
	  }  
	  function getMainContentBySubsection($section = null,$subsection = null){
	      if($section == null|| $subsection == null) return false;
		  return $this->db->fetchRow("SELECT * FROM content WHERE ".$this->where." AND   item_cat = '{$section}' AND item_subcat = '{$subsection}' ",'OBJ');	  
	  }
    function getParentTemplate($parent,$tm = 'item_template'){
	     if($temps = $this->db->fetchRow("SELECT item_template,item_subtemplate,content_type_key FROM content WHERE item_cat = '".$parent."' AND item_subcat = '".$parent."'",'OBJ')){
		     if($temps->$tm == 'PARENT' || $temps->$tm == 'DEFAULT_TYPE'){
			    $t = ($tm == 'item_template') ? 'content_type_template': 'content_type_subtemplate';
				return $this->getDefaultTemplate($temps->content_type_key,$t);
			 }
			 else return $temps->$tm;
		 }
		 else return null;	    
	}    
	function getDefaultTemplate($type,$tm = 'content_type_template'){
	     if($type == '') $type = 'GENERAL';
	     if($temps = $this->db->fetchRow("SELECT content_type_template,content_type_subtemplate FROM content_types WHERE content_type_key = '".$type."'",'OBJ')){
		     return $temps->$tm;
		 }
		 else return null;
	}
  
}
?>
