<?php
require_once('FController.php');

class NavigationController extends FController
{
    public $style = 'default';
	public $breadcrumbs;
	public $menuDir;
	public $nav;
	
    function __construct(){
		$this->db = $this->getConnection();

		if(!$this->isBlock){
			$this->nav = ($this->getParam('nav')) ? 
				$this->getParam('nav') : isset($this->getSession(true)->navId) ? 
					$this->getSession(true)->navId : '';
			$track = $this->makeTrack($this->nav);
			$this->track = $track;
			$this->template = 'navigation';
		}
    }
	function setStyle($style = null){
	    $this->style = ($style != null) ? $style : 'default';
	}
    function build(){
	    if($this->action == 'breadcrumbs') {
		    $this->_forward('breadcrumbs');
		}
		else{
			$this->assign('style',$this->style);
		    $this->assign('view',$this->template);
		    $nav = $this->displayMenu($this->buildMenu());
		    $this->assign('navigation',$nav);
		}
		
    }   
	
    function buildMenu($parent_id = 0){ 
	if($user = $this->getUser()){
	    $role = $user->user_role;
	}
	else $role = 0;
	 
      $sql = "SELECT * FROM menu WHERE parent_id = '{$parent_id}' order by menu_order";
      $menu = $this->db->fetchAll($sql,'OBJ');
      $returnMenu = array();
      foreach($menu as $val){
        if(in_array($role,explode(',',$val->role_id)) || $val->role_id == ''){
			if($val->use_ajax && !$val->link_is_external){
				$val->href = "javascript:loadUrl('".$this->prepareHref($val->href)."&nav=".$val->menu_id."','mainblock','loadBreadcrumbs')";
			}
			else{
			    $val->href = ($val->link_is_external) ? $val->href : $this->getBaseUrl().'/'.$this->prepareHref($val->href).'&nav='.$val->menu_id;
			}

          $val->aClass = ($val->menu_id == $this->nav) ? 'current' : '';
          $val->subMenu = $this->getSubLinks($val->menu_id);
          $val->isOpen = (in_array($val->menu_id,$this->track))? 1 : 0;
          
          if($val->subMenu){
               $expander = ($val->isOpen) ?  $this->getBaseUrl().'/freedom/images/b_minus.png' 
               			: $this->getBaseUrl().'/freedom/images/b_plus.png';  
          }
          else $expander = $this->getBaseUrl().'/freedom/images/b_none.png';
          $val->hasSubMenu = ($val->subMenu) ? 1 : 0;
          $val->expander = $expander;
          $returnMenu[] = $val;
        }
      }
      return $returnMenu;
    }
    function getSubLinks($parent_id){
      return $this->buildMenu($parent_id);
    }
    function makeTrack($id){       
      $track = array($id); 
      for($i = 0; $i < 10; $i++){
        $qry = "SELECT parent_id FROM menu WHERE menu_id = '{$id}' ";
        $result = $this->db->fetchRow($qry,'OBJ');
        if(isset($result->parent_id)) $track[] = $result->parent_id;
        else break;
        $id = $result->parent_id;
      }
      return $track;
    }
    function getBreadcrumbs(){
    	$track = array_reverse($this->track);
		$string = '';
    	foreach($track as $id){
    		$qry = "SELECT text,use_ajax,href,link_is_external,menu_id, link_target FROM menu WHERE menu_id = '{$id}' ";
        	if($val = $this->db->fetchRow($qry,'OBJ')){
			
			if($val->use_ajax && !$val->link_is_external){
				$href = "javascript:loadUrl('".$this->prepareHref($val->href)."&nav=".$val->menu_id."','mainblock','loadBreadcrumbs')";
			}
			else{
				$href = (!$val->link_is_external) ? $this->getBaseUrl().'/'.$this->prepareHref($val->href)."&nav=".$val->menu_id : $val->href;
			}
			$string .= "<a href=\"".$href."\" target=\"".$val->link_target."\" class=\"breadcrumb\">$val->text</a>";
			if($id != end($track)) $string .= " <img src=\"".$this->getBaseUrl()."/freedom/images/item_sp.png\" style=\"virtical-align: middle\"> ";
			}
    	}
		
		return $string;
	}
	
	
	function displayMenu($menuObj = null){
	$submenu = "<ul id=\"main_menu\">";
	
    foreach($menuObj as $key => $subMenu){
        $class = ($subMenu->isOpen) ? 'current ' : 'notcurrent ';
		if($subMenu->parent_id == 0) $class .= 'parent_link ';
	    $submenu .= "<li class='$class' >";
	    $submenu .= "<img src=\"".$subMenu->expander."\" onclick=\"expandNav(this)\"/>";
		$submenu .= "<a href=\"".$subMenu->href."\" onclick=\"expandNav(this.parentNode.getElementsByTagName('img')[0]); unHighlightLinks(); this.className = 'current'\" class=\"".$subMenu->aClass."\" target=\"".$subMenu->link_target."\">".$subMenu->text."</a>";
		if($subMenu->hasSubMenu)$submenu .= $this->loadOtherSubMenu($subMenu->subMenu);
		$submenu .= "</li>";
	}
	
	$submenu .= "</ul>";
	return $submenu;
}
	function loadOtherSubMenu($subMenuObject){
	    return $this->displayMenu($subMenuObject);
	}
	function getTopNav(){
	    $role = $this->getUserRole();

	    $query = "SELECT text,href,use_ajax,link_is_external,menu_id, link_target FROM menu 
				   WHERE top_nav_yn = 1 
				  AND IF(role_id != '', instr(role_id,".$role.") != 0, role_id = '')
				ORDER BY menu_order ";
				
		$result = $this->db->fetchAll($query,'OBJ');
		$data = array();
		foreach($result as $k => $val){
		    $thisLink = array();
            if($val->use_ajax && !$val->link_is_external){
				$thisLink['href'] = "javascript:loadUrl('".$this->prepareHref($val->href)."&nav=".$val->menu_id."','mainblock','loadBreadcrumbs')";
			}
			else{			
				$thisLink['href'] = (!$val->link_is_external) ? 
					$this->getBaseUrl().'/'.$this->prepareHref($val->href)."&nav=".$val->menu_id : $val->href;
		    }
			$thisLink['text'] = $val->text; 
			$thisLink['attributes'] = array();
			$thisLink['attributes']['target'] = $val->link_target;
			
			$data[] = $thisLink;
		}
		
		return $data;
	}
	function prepareHref($url){
	   $append = '';
	   if(substr_count($url,'?') != 0){}
	   else if(substr_count($url,'?') == 0 && substr(trim($url),-1) == '/') $append .= '?';
	   else $append .= '/?';

	   if($url[0] == '/') $url = substr_replace($url,'',0,1);
	   return $url . $append;
	}
	function breadcrumbsAction(){
	    $this->noLayout();
		$this->track = $this->makeTrack($this->nav);
		echo $this->getBreadCrumbs();
	}
}
?>
