<?php
/**
Author: ADEFOKUN Tomiwa M.
Email: Tomiwa.adefokun@progenicscorp.com,tomiwa.adefokun@gmail.com
*/
require_once 'FModel.php';
class ContentController extends FController{
  public $module;
  public $db;
  public $search;
  public $category = null;

  function __construct($block = false){
    $this->db = $this->getConnection();
	
	$this->model = new FModel('content_manager','content');
	$this->model->setPrimaryKey('content_id');
	$this->model->setLimit(20);
	$this->model->setOrderBy("item_cat, item_subcat");

	$this->template = 'content_list';
	$this->assign('title','Manage Content');
	$ctypes = $this->db->fetchAssoc("SELECT content_type_key, content_type_name FROM content_types");
	$this->assign('ctypes',$ctypes);

	$pageTemplates = $this->listFiles(P2F_APP_DIR . '/modules/index/views/pages','phtml','.phtml','pages_');
	$sectionTemplates = $this->listFiles(P2F_APP_DIR . '/modules/index/views/pages/sections','phtml','.phtml','pages_sections_');
	
	$this->assign('pageTemplates',array_merge(array('PARENT'=>'Use parent page template','DEFAULT_TYPE'=>'Use default content type page template'),$pageTemplates));
	$this->assign('sectionTemplates',array_merge(array('PARENT'=>'Use parent subsection template','DEFAULT_TYPE'=>'Use default content type subsections template'),$sectionTemplates));
	
	$this->assign('roles',$this->db->fetchAssoc("SELECT role_key id, role_name name FROM user_roles ORDER by role_name"));
    
	
	if($this->search || $this->getParam($this->model->getName().'_search')){
	    $this->model->setSearchCriteria = array('item_title','item_cat','item_subcat','item_desc','item_details','content_type_key');
	}
	
	$this->setPostProcessAction('postprocess');
  }
  	function indexAction(){
	    $this->_forward('list');
	}
	function listAction(){
	    $group = $this->getParam('group');
	    $this->model->addWhere(" AND item_cat = item_subcat ");
		if($group) $this->model->addWhere(" AND content_type_key = '{$group}' ");

		$this->assign('group',$group);
	    parent::listAction();
	}
	function sectionsAction(){
	    if($category = $this->category) {
			$this->model->addWhere(" AND item_cat = '{$category}' AND content_id != '{$this->content_id}'");
			$this->assign('title','Page Sections of <u>'.$category.'</u>');
			$this->assign('contentPageName',$category);
			$this->template = 'content_sections';
			parent::listAction();
		}
	}
	function build(){
	    if($this->action) $this->_forward($this->action);
	}
  function prepare($input){
  
    $attachCond = $this->getUploadConditions($input['content_type_key']);
    $allowedExt = $attachCond['content_attach_ext'];
    $allowedSize = $attachCond['content_attach_size'];
    if(!$input) return false;
    $done = true;
	$id = $this->getParam('eid');
	//if($this->postParam('add')){
	if($input['item_cat'] == ''){
		$done = false;
		$this->trackError('item_cat','The content must have a category');
	}
	if($input['item_subcat'] == '') $input['item_subcat'] = strtoupper($input['item_cat']);
	$input['item_cat'] = strtoupper($input['item_cat']);
	$input['item_subcat'] = strtoupper($input['item_subcat']);
	//}
	if($done == true && $input['item_cat'] != $input['item_subcat']){

	    if(!$this->rowExists($this->model->getTable(),$this->model->getPrimaryKey(),array('item_cat'=>$input['item_cat'],'item_subcat'=>$input['item_cat'])))
		{
		    $done = false;
			$this->trackError('item_cat','The category does not exist');
		}

	}

	if($done == true && $this->rowExists($this->model->getTable(),$this->model->getPrimaryKey(),array('item_cat'=>$input['item_cat'],'item_subcat'=>$input['item_subcat']),$id)){
	    $done = false;
		$this->trackError('item_cat','The content already exists');
	}

	if($done == true){
	
		if($input['item_cat'] != $input['item_subcat']){
		    if($input['content_type_key'] == ''){
				$parent = $this->db->fetchRow("SELECT content_id, content_type_key FROM content WHERE item_cat = '".$input['item_cat']."' AND item_subcat = '".$input['item_cat']."'","OBJ");
				$input['content_type_key'] = $parent->content_type_key;
			}
        }	

		$uploadDir = $this->getConf()->path['uploadDir'].'/content';

		$upload = $this->uploadFile('attachment',$uploadDir,$allowedSize,$allowedExt); 
		$label = $this->postParam('label');
		
		if(is_array($upload)){
		    foreach($upload as $k => $v){
			    if($upload[$k]['success'] == false) 
				    unset($upload[$k]);
				else
			        $upload[$k]['label'] = $label[$k];
			}
		}
	}

	if(is_array($input)){
	    foreach($input as $key => $val){
		    if($key != 'item_details')$input[$key] = strip_tags($val);
	    }
    }
	

	
	
    if($id && $done == true && $this->action == 'save'){
		$currentAttch = unserialize(base64_decode($this->db->fetchOne("SELECT item_attch FROM content WHERE {$this->model->getPrimaryKey()} = '{$this->getParam('eid')}'")));
		if(is_array($currentAttch)){
			foreach($currentAttch as $k => $v){
				$updateOption = $this->postParam('updateOptions_'.$k);
				if($updateOption == 'delete') {
					$thefile = $uploadDir.'/'.$v['filename'];
					if(file_exists($thefile)) unlink($thefile);
					unset($currentAttch[$k]);
						
				}
				else if($updateOption == 'update'){
					$fileReplace = 'update_attchment_'.$k;
					$labelReplace = 'update_label_'.$k;
					$theOldFile = $uploadDir.'/'.$v['filename'];
					$replace = $this->uploadFile($fileReplace,$uploadDir,$allowedSize,$allowedExt);

					if(is_array($replace)){
						if(file_exists($theOldFile)) unlink($theOldFile);
						$currentAttch[$k] = $replace;	 
					}							

					$currentAttch[$k]['label'] = $this->postParam($labelReplace);
				}
			}
		}
		if(is_array($upload) && is_array($currentAttch)) $input['item_attch'] = base64_encode(serialize(array_merge_recursive($currentAttch,$upload)));
		else if(is_array($currentAttch)) $input['item_attch'] = base64_encode(serialize($currentAttch));
		else if(is_array($upload)) $input['item_attch'] = base64_encode(serialize($upload));
  
    }
    elseif($done == true && $this->action == 'insert'){        
	    if(is_array($upload)) $input['item_attch'] = base64_encode(serialize($upload));
    }

	return $input;
  }
	function confirmDelete($ids){
	    $done = true;
	    foreach($ids as $key => $id){
		    $page = $this->getSubPageNameById($id);
			if($this->countSubPages($page) > 0){
				$this->trackError($key,'Page ['.$page.'] has sub-pages and cannot be deleted');
				$done = false;
			}
		}
		return $done;
	}
  function addsubpageAction(){
	  if($pagename = $this->getParam('pagename')){
		  $this->assign('contentPageGroup',$this->db->fetchOne("SELECT content_type_key FROM content WHERE item_cat = '{$pagename}' AND item_subcat = '{$pagename}'"));
		  $this->assign('contentPageName',$pagename);
		  $this->_forward('add');
	  }
	  else $this->addAlert('Some errors occured... no page specified');
  }
  function getPageNameById($id){
      if($id){
	      return $this->db->fetchOne("SELECT item_cat FROM content WHERE content_id = '{$id}'");
	  }
	  else return null;
  }  
  function getSubPageNameById($id){
      if($id){
	      return $this->db->fetchOne("SELECT item_subcat FROM content WHERE content_id = '{$id}'");
	  }
	  else return null;
  }
  function countSubPages($page){
	  if($page){
		  return $this->db->fetchOne("SELECT COUNT(*) FROM content WHERE item_cat = '{$page}' AND item_subcat != '{$page}'");
	  }
	  else return 0;
  }
  function postprocessAction(){
      if($page = $this->getParam('pagename')){
			if($id = $this->getContentIdByPageName($page))
				$this->redirect(P2F_BASE_URL . '/admin/content/edit/?eid=' . $id . '#sections');
			else $this->redirect(P2F_BASE_URL . '/admin/content/list');
	  }
	  else $this->redirect(P2F_BASE_URL . '/admin/content/list');
  }
  
  function getContentIdByPageName($page){
      if($page){
		  return $this->db->fetchOne("SELECT content_id FROM content WHERE item_cat = '{$page}' AND item_subcat = '{$page}'");
	  }
	  else return false;
  }
  function checkextAction(){
     $type = $this->getParam('content_type_key');
	 $return = ' <div class="tinyHeader" >ALLOWED EXTENTIONS AND SIZE FOR ' . $type .' CONTENT: </div>';
	 $return .= 'File Extensions: ';
	 $upCond = $this->getUploadConditions($type);
	 $extArr = explode(',',$upCond['content_attach_ext']);
     $i = 1;
	 foreach($extArr as $ext){
	    $return .= strtoupper($ext);
		if($i < sizeOf($extArr)) $return .= ', ';
		$i++;
	 }
	 
	 echo $return. '<br/ >Maximum File Size: '. $upCond['content_attach_size']. ' bytes';
  }
  function getUploadConditions($type){
      return $this->db->fetchRow("SELECT content_attach_ext, content_attach_size FROM content_types WHERE content_type_key = '{$type}'");
  }
  function attachmentsAction(){
	  $this->assign('view','content_attachments');
	  
	  if(isset($this->attachments)) $attachments = $this->attachments;
	  else if(isset($this->contentId) || $this->getParam('eid')){
		 $id = (isset($this->contentId)) ? $this->contentId : $this->getParam('eid');
		 $attach = $this->db->fetchOne("SELECT item_attch FROM content WHERE content_id = '{$id}'");
		 $attachments = unserialize(base64_decode($attach));

	  }
	  else $attachments = array();
	  if(!is_array($attachments)) $attachments = array();
	  $this->assign('attachments',$attachments);
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
