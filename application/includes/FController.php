<?php
/**
Author: ADEFOKUN Tomiwa M.
Email: Tomiwa.adefokun@progenicscorp.com,tomiwa.adefokun@gmail.com
*/

require_once 'FDB.php';
require_once 'Display.php';
require_once 'FValidate.php';

class FController{
  public $module;
  public $viewObject;
  public $page;
  public $view;
  public $pager;
  public $primary;
  public $orderBy = null;
  public $sort = null;
  public $table;
  public $where;
  public $template;
  public $templates;
  public $sid;
  protected $dbConn = array();
  public $title;
  public $action;
  public $limit = 20;
  public $headStyle = '';
  public $menu;
  public $display;
  public $controller = 'index';
  public $user;
  public $dto;
  public $params;
  private $conf;
  
  public $defaultAction = 'index';
  public $searchCriteria;
  public $isBlock = false;
  public $search;
  public $siteTitle;
  public $useLayout = true;
  public $layout = 'master';
  public $model;
  public $errors;
  public $request;
  public $postProcessAction;
  public $_access = true;
  public $insertMessage = 'Record was inserted successfully';
  public $updateMessage = 'Record was updated successfully';
  public $errorMessage  = 'Oops... some errors occured!';
  
  function __construct(){	
      $this->setConf();
      $this->setSiteTitle();
	  
	  //check if a theme is specified in the url, and set it accordingly.
	  if($theme = $this->getParam('theme')) $this->setTheme($theme);
  }
  function setSiteTitle($title = '',$append = true){
	  $siteTitle = ':: ';
      $siteTitle .= ($append) ? $this->getConf()->site['title'] . ' :: ' . $title  : $title;
	  $siteTitle .= ($title != '') ? ' ::' : '';
      $this->siteTitle = $siteTitle;
  }
	public function myaddslashes($aList, $aIsTopLevel = true) { 
	    $gpcList = array(); 
	    $isMagic = get_magic_quotes_gpc(); 
	    if(!is_array($aList)){
			$not_array = true;
			$aList = array($aList);
		}
	    foreach ($aList as $key => $value) { 
	        if (is_array($value)) { 
	            $decodedKey = (!$isMagic && !$aIsTopLevel)?addslashes($key):$key; 
	            $decodedValue = FController::myaddslashes($value, false); 
	        } else { 
	            $decodedKey = addslashes($key); 
	            $decodedValue = (!$isMagic)?addslashes($value):$value; 
	        } 
	        $gpcList[$decodedKey] = $decodedValue; 
	    } 
		if(isset($not_array)) $gpcList = $gpcList[0];
	    return $gpcList; 
	}
	
	public function deephtmlentities($aList, $aIsTopLevel = true) { 
	    $inputList = array(); 
	    if(!is_array($aList)){
			$not_array = true;
			$aList = array($aList);
		}
	    foreach ($aList as $key => $value) { 
	        if (is_array($value)) { 
	            $encodedKey = (!$aIsTopLevel) ? htmlentities($key):$key; 
	            $encodedValue = FController::deephtmlentities($value, false); 
	        } else { 
	            $encodedKey = htmlentities($key); 
	            $encodedValue = htmlentities($value); 
	        } 
	        $inputList[$encodedKey] = $encodedValue; 
	    } 
		if(isset($not_array)) $inputList = $inputList[0];
	    return $inputList; 
	}
	function mystripslashes($aList, $aIsTopLevel = true) { 
	    $gpcList = array(); 
	    $isMagic = get_magic_quotes_gpc(); 
	    if(!is_array($aList)){
			$not_array = true;
			$aList = array($aList);
		}
	    foreach ($aList as $key => $value) { 
	        if (is_array($value)) { 
	            $decodedKey = (!$aIsTopLevel)?stripslashes($key):$key; 
	            $decodedValue = FController::mystripslashes($value, false); 
	        } else { 
	            $decodedKey = stripslashes($key); 
	            $decodedValue = stripslashes($value); 
	        } 
	        $gpcList[$decodedKey] = $decodedValue; 
	    } 
		if(isset($not_array)) $gpcList = $gpcList[0];
	    return $gpcList; 
    }
	function doPageAction($action = null){
	
	  if(!$this->isBlock){
		$action = ($action) ? $action : $this->getAction(); 
	  }
	  if($action == null) $action = $this->defaultAction;
	  $action = ($action != null) ? $action : $this->action;
	  
	  $this->action = $action;
	  if($this->userHasAccessTo($this->getModule(),$this->controller,$action) != true) {
			if(!$this->isBlock) $this->addAlert('You do not have required priviledge to the requested resource!');
			$this->_access = false;
	   }
	  else{
		$thisAction = $action.'Action';
		if(method_exists($this,$thisAction))
			$this->$thisAction();
		else die('Error processing request, invalid action specified!');
	  }
	}
    function _forward($action){
		$this->doPageAction($action);
	}
	public function getConnection($name = 'default',$connectionParameters = null){
		if(!isset($this->dbConn[$name])) $this->dbConnect($name,$connectionParameters);
		return $this->dbConn[$name];
	}
  
	function dbConnect($name = 'default',$connectionParameters = null){
		
		
		if($connectionParameters){ 
			$connection = $connectionParameters;
		}
		else{
			$db = (object) FController::getConf()->database;
			$connection = array('hostname' => $db->host,
								    'user' => $db->username,
								'database' => $db->dbname,
								'password' => $db->password);
								
			
		}
		$this->dbConn[$name] = new FDB($connection);
	}
  
	private function loader($controller,$module){
	    if($controller && $module){
		     if(!file_exists(P2F_APP_DIR . '/modules/'.$module.'/controllers/'.$controller.'.php')) 
				die('Error loading the requested application module: '.$module.'/'.$controller);
				require_once(P2F_APP_DIR . '/modules/'.$module.'/controllers/'.$controller.'.php');
	    }
	    else die('Loading error!');
	}
  function buildBlock($request,$block = true){
     if(is_array($request)){
	     $module = (isset($request['module'])) ? $request['module'] : 'index';
	     $controller = (isset($request['controller'])) ? $request['controller'] : 'index';
	     $action = (isset($request['action']) && $request['action']) ? $request['action'] : 'index';
	 }
	 else {
		$controller = $request;
		$module = 'index';
		$action = 'index';
	}
	 
	$modulePath = P2F_APP_DIR . '/modules/'.$module;
	$controllers = $modulePath.'/controllers';
	$views = $modulePath.'/views';

     $pageController = ucfirst(strtolower($controller)).'Controller';
     $this->loader($pageController,$module);
	 
	 if(!class_exists($pageController)) die('Error instantiating the controller, the controller class does not exist!');
	 
	 $cont = new $pageController($block);
	 $cont->isBlock = $block;
	 
	 if(isset($module)) $cont->module = $module;
	 $cont->controller = $controller;
	 if(isset($action)) $cont->action = $action;
	 if($cont->getParam('ajax') == 'true') $cont->noLayout();
	 return $cont;
  }  

    function displayContent(){
	    if($this->view === false || $this->_access === false) return;
		
	    if(!isset($this->viewObject->view) && is_array($this->templates)){
		    if(isset($this->templates[$this->action])) $this->viewObject->view = $this->templates[$this->action];
		}
		
	    if(isset($this->viewObject->view)){
			if(isset($this->module))$this->viewObject->module = $this->module;
			if(isset($this->controller))$this->viewObject->controller = $this->controller;
			if(isset($this->model)) $this->viewObject->primaryKey = $this->model->getPrimaryKey();
			if(isset($this->model)) $this->viewObject->table = $this->model->getTable();
			if(isset($this->action))$this->viewObject->action = $this->action;
			if(isset($this->model)) $this->viewObject->modelName = $this->model->getName();
			if(isset($this->errors)) $this->viewObject->errors = $this->errors;
			$display = new Display();
			$display->render($this->viewObject);
		}
    }
  function getParams(){
    if(!$this->isBlock){
	    $thisGet = (object) FController::myaddslashes($_GET);
	    return $thisGet;
  	}
	else return null;
  }
  function getParam($param){
   if(isset($this->getParams()->$param)) return $this->getParams()->$param;
   else return null;
  }
  function postParams(){
    if(!$this->isBlock){
	    $thisPost = (object) FController::myaddslashes($_POST);
	    return $thisPost;
	}
	else return null;
  }
  function postParam($param){
    if(isset($this->postParams()->$param)) return $this->postParams()->$param;
	else return null;
  }

  function output($k, $v, $f = ''){

    switch($f){
    	case 'htmlspecialchars': $rVal = htmlspecialchars($v);
    	break;
    	case 'htmlentities': $rVal = htmlentities($v);
    	break;
    	default: $rVal = $v;
    }  
	$this->viewObject->$k = $v;
  }

  function assign($k, $v, $f = ''){
    $this->output($k, $v, $f);
  }
  function selectDefaultOption($tData,$match_col_val){
    if(!$tData) return '';
    if(is_array($tData)){
      $query = "SELECT $tData[match_col] 
                FROM $tData[tbl] 
                WHERE $tData[where_col] = '$tData[where_col_val]' AND $tData[match_col] = '$match_col_val'";
      if(mysql_num_rows(mysql_query($query))) return 'selected';
      else return '';
    }
    else{
      return $return = ($tData == $match_col_val) ? 'selected' : '';
    }
  }

  function changeBool($bool){
    return $return = ($bool) ? 'YES' : 'NO';
  }
  function checkUsername($username = null){
    $return = array();
    $return['valid'] = false;      
    $return['info'] = 'Invalid internal parameters';

	if($username == '') $return['info'] = 'No value provided for username';
	else if(!$this->anum($username)) $return['info'] = 'Username contains characters outside of [a-zA-Z0-9]';
	else if(strlen($username) < 6) $return['info'] = 'Username must not be less than 6 characters';
	else {
		$return['valid'] = true;  
		$return['info'] = 'Username is valid';
	}

    return $return;
  }  
  function rowExists($tbl,$prymaryKey,$arr,$updateval = null){

    $return = false;
	
    if(is_array($arr)){
        $where = " WHERE 1 = 1";
        foreach($arr as $key => $val){
          $where .= ' AND '.$tbl.'.'.$key.' = \''.$val.'\' ';
        }
        $query = "SELECT {$prymaryKey} FROM `$tbl` ". $where . "ORDER BY {$prymaryKey} LIMIT 1" ;
        $key = $this->db->getOne($query);
		if($key){
            if($key == $updateval) $return = false;
			else $return = true;
		}
        else $return = false;  
	}	
    return $return;
  }
  function isValueUsed($tbl,$arr){
    $return = false;      
    if(is_array($arr)){
        $where = " WHERE 1 = 1";
        foreach($arr as $key => $val){
          $where .= ' AND '.$tbl.'.'.$key.' = \''.$val.'\' ';
        }
        $query = "SELECT * FROM `$tbl` ". $where ;
        $row = $this->db->getRow($query);
        if($row) $return = true;
        else $return = false;  
    }
    return $return;
  }
  function valueIsUsed($tbl,$arr){
	 return self::isValueUsed($tbl,$arr);
  }
    function anum($string){
	    $return = true;
	    $sArr = str_split($string);
	    foreach($sArr as $chr){
	      if(!ereg('[a-zA-Z0-9]',$chr)){
	        $return = false;
	        break;
	      }
	      return $return;
	    }
    }
    function pageContent($total = 0, $limit = 10){
	   $pageNum = ($this->getParam(''.$this->getModel()->getProperty('pagerName'))) 
					? $this->getParam(''.$this->getModel()->getProperty('pagerName')) : 1;
	   if(isset($this->pnum)) $pageNum = $this->pnum;

	   $page = ($pageNum > 0) ? ($pageNum - 1) : 0;
	   $return = array();
	   $return['offset'] = $page * $limit;
	   $return['total'] = $total;
	   if($page > 0) $return['last'] = $page;
	   $pageCount = ceil($total/$limit);
	   $next = ($pageNum < $pageCount) ? true : false;
	   if($next == true) $return['next'] = $pageNum + 1;
	   if($page > 0 && $next == true) $return['spacer'] = true;
	   $return['pageCount'] = $pageCount;
	   $return['current'] = $pageNum;
	   return $return;
    }
	function getAlphabets($type = null){
	    if($type == 'consonants') $alpha = array('b','c','d','f','g','h','j','k','l','m','n','p','q','r','s','t','v','w','x','y','z');
		else if($type == 'vowels') $alpha = array('a','e','i','o','u');
		else $alpha = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');   
	
		return $alpha;
	}
	function generateKey($l = 6,$varyingLength = false,$u = 10){
	    $length = ($varyingLength == false) ? $l : rand($l,$u);
		$alpha = self::getAlphabets();
		$i = 0;
		$key = '';
		while($i < $length){
		   $type = rand(1,2);
		   if($type == 1){
		       $key .= rand(0,9);
		   }
		   else{
		       $alphabet = (rand(1,2) == 1) ? strtoupper($alpha[rand(0,25)]) : $alpha[rand(0,25)];
	           $key .= $alphabet;
		   }
		   $i++;
		}
		return $key;
	}
    function uploadFile($fieldname,$filePath,$maxSize = '',$allowedTypes = '',$padName = ''){
      $return = array();
	  $done = false;
	//  var_dump($_FILES[$fieldname]['error']);
	  //exit;
	  if(count($_FILES) == 0) return false;
	  if(!isset($_FILES[$fieldname])) return false;
	  if(is_array($_FILES[$fieldname]['error'])){
		  foreach ($_FILES[$fieldname]['error'] as $key => $error) {
			$return[$key] = array();
			$return[$key]['success'] = false;

			if ($error == UPLOAD_ERR_OK) {
				$tmp_name = $_FILES[$fieldname]["tmp_name"][$key];
				$name = $_FILES[$fieldname]["name"][$key];
				$size = $_FILES[$fieldname]["size"][$key];
				$type = strtolower(substr(strrchr($name, '.'),1));

				//Check file type...
				if ($allowedTypes != '' && !in_array($type,explode(',',$allowedTypes))) continue;
					
				//check file size...
				if($maxSize != '' && $size > $maxSize) continue;
				
				//do file rename
			    $filename = ($padName != '') ? 
						'_'.mktime().'_'.strtoupper(self::generateKey(10)).$padName.'.'.$type : 
						'_'.mktime().'_'.strtoupper(self::generateKey(10)).'.'.$type;
							
				//upload...
				if(move_uploaded_file($tmp_name, $filePath.'/'.$filename)){
					$return[$key]['success'] = true;
					$return[$key]['realname'] = $name;
					$return[$key]['filename'] = $filename;
					$return[$key]['type'] = $type;
					$return[$key]['size'] = $size;
					$done = true;
				}
					
			}
	    }
	}
	else {
	    $return['success'] = false;
	    if ($_FILES[$fieldname]['error'] == UPLOAD_ERR_OK ){

		    $tmp_name = $_FILES[$fieldname]["tmp_name"];
			$name = $_FILES[$fieldname]["name"];
			$size = $_FILES[$fieldname]["size"];
			$type = strtolower(substr(strrchr($name, '.'),1));

			//Check file type...
			if ($allowedTypes != '' && !in_array($type,explode(',',$allowedTypes))) return false;
				
			//check file size...
			if($maxSize != '' && $size > $maxSize) return false;
			
			//do file rename
			$filename = ($padName != '') ? 
						'_'.mktime().'_'.strtoupper(self::generateKey(10)).$padName.'.'.$type : 
						'_'.mktime().'_'.strtoupper(self::generateKey(10)).'.'.$type;
						
			//upload...
				
			if(move_uploaded_file($tmp_name, $filePath.'/'.$filename)){
				$return['success'] = true;
				$return['realname'] = addslashes($name);
				$return['filename'] = addslashes($filename);
				$return['type'] = $type;
				$return['size'] = $size;
				$done = true;
			}
		}
	}
	  return ($done) ? $return : false;
  }
  function getUploadUrl(){
	return $this->getConf(true)->path['uploadUrl'];
  }  
  function _getUploadUrl(){
	return self::_getConf(true)->path['uploadUrl'];
  }
  function getBaseUrl(){
        if($config = FController::_getConf()){
		    $protocol = self::getServerProtocol().'://';
		    return preg_replace('/https?\:{1}\/\//',$protocol,$config->path['baseUrl'],1);
		}
		else return null;
  }   
  function getWebUrl(){
        if($config = FController::_getConf()){
		    $protocol = self::getServerProtocol().'://';
		    return preg_replace('/https?\:{1}\/\//',$protocol,$config->path['webUrl'],1);
		}
		else return null;
  }  
  function setConf(){
       $conf = parse_ini_file(P2F_APP_DIR . '/config/freedom.ini',true);
	   $this->conf = $conf;
  }
  function getConf($array = 'object'){
       if($this->conf){
	       if($array == 'object') return (object)$this->conf;
		   else return $this->conf;
	   }
	   else{
	       $this->setConf();
	       if($array == 'object') return (object)$this->conf;
		   else return $this->conf;
	   }
  }
    function _getConf($array = 'object'){
	   $conf = parse_ini_file(P2F_APP_DIR . '/config/freedom.ini',true);
	   if($array == 'object') return (object)$conf;
	   else return $conf;
    }
  function listFiles($dir = null,$type = null,$strip = null,$pad = null){
      if($dir == null) return null;
	  if(!file_exists($dir)) return null;
	  else{
	      $content  = scandir($dir);
	      foreach($content as $k => $v){
		      if(!is_file($dir.'/'.$v)) unset($content[$k]);
			  else {
				 if($type){
				     $pathinfo = pathinfo($dir.'/'.$v);
					 if($pathinfo['extension'] != $type) unset($content[$k]);
				 }
				 
				 if($strip) {
				     if(isset($content[$k])) $v = $content[$k] = str_replace($strip,'',$v);
				 }
				 
				if($pad){
				    if(isset($content[$k])) $v = $content[$k] = $pad.$v;
			    }
		     }
		  }
		  $array = array();
		  if(sizeof($content)){
		      foreach($content as $v){
			      $array[$v] = $v;
			  }
		  }
		  return $array;
	  }
  }
  
 /*
  CRUD operations overide in controllers for specific functionality.
  */
	function getModel(){
	   if($this->model) return $this->model;
	   else {
	    
		require_once 'FModel.php';
		$model = new FModel($this->table,$this->table);	
		$search = ($this->search) ? $this->search : $this->getParam($model->getName().'_search');
		$model->setPrimaryKey($this->primary);
		if($search){		
			$searchCriteria = ($this->searchCriteria) ? $this->searchCriteria : $this->db->listFields($this->table);
			$model->setSearchCriteria($searchCriteria);
		}
		$model->setMainSelectFrom("SELECT * FROM ".$this->table."");		
		$model->setCountSelectFrom("SELECT COUNT(*) FROM ".$this->table."");
		//$condition = "Any other condition that is not in where statement. For any where condition user, $model->addWhere($where)"
		//$model->setSecondPart($condition);
		$model->addWhere($this->where);
		$model->setOrderBy($this->orderBy);
		$model->setSort($this->sort);
		$model->setLimit($this->limit);
		$this->model = $model;
		return $model;
	   }
	}
  function getdata($id = null){
    $model = $this->getModel();
    $search = ($this->search) ? $this->search : $this->getParam($model->getName().'_search');
	$model->setSearch($search);
	if($table = $model->getTable()){
		if($search && !$model->getSearchCriteria()) {
			$searchCriteria = $this->db->listFields($table);
			$model->setSearchCriteria($searchCriteria);
		}
		if(!$model->getMainSelectFrom()) $model->setMainSelectFrom("SELECT * FROM ".$table."");
		if(!$model->getCountSelectFrom()) $model->setCountSelectFrom("SELECT COUNT(*) FROM ".$table."");
	}
	$model->setId($id);
	$cntQry = $model->getTotalQuery();
    $limit = $model->getLimit();
	$total = $this->db->fetchOne($cntQry);
	
    if($total > $limit) $pager = $this->pageContent($total,$limit);        
    if(isset($pager))$this->assign('pager',$pager);

    $offset = (!isset($pager)) ? 0 : $pager['offset'];

    $query = $model->getFinalQuery($offset);
    $return = ($id == null) ? $this->db->fetchAll($query) : $this->db->fetchRow($query);
	
	$this->assign('searchedWords',$model->getSearch());
    if($return) return $return;
  }
  function listAction(){
    $template = (isset($this->template)) ? $this->template : $this->templates['list'];
    $this->assign('view',$template);
    $this->assign('list',true);
    $this->assign('data',$this->getdata());
  }  
  
  function addAction($input = null){
    $template = (isset($this->template)) ? $this->template : $this->templates['add'];
    $model = $this->getModel();
    $this->output('view',$template);
    $this->output('edit',true);
    $this->output('postAction','insert');
	$this->output('actionLabel','Add');
	$this->assign('data',$this->postParam($model->getName()));
  } 

  function editAction(){
	$template = (isset($this->template)) ? $this->template : $this->templates['edit'];
    $this->output('view',$template);
    $this->output('edit',true);
    if(!$id = $this->getParam('eid')) die('No item to edit!');
    $this->assign('data',$this->getdata($id));
    $this->output('cpClass','hiddenDiv');
	$this->assign('postAction','save');
	$this->output('actionLabel','Save');
  }
  function detailsAction(){
    $template = (isset($this->template)) ? $this->template : $this->templates['details'];
    $this->output('view',$template);
    $this->output('details',true);
    if(!$id = $this->getParam('eid')) die('No item selected');
    $this->assign('data',$this->getdata($id));
    $this->output('cpClass','hiddenDiv');
  }
  function saveAction($in = null,$id = null){
    $model = $this->getModel();
    $post = ($in) ? $in : $this->postParam($model->getName());

	$done = true;
	
	if(!$post) return false;
	if($id == null && !$id = $this->getParam('eid')) return false;
	
	$input = $this->prepare($this->deephtmlentities($post));
	
    if($errors = $this->getErrors()) $done = false;
	
	if($done == true){
	   if($this->db->update($model->getTable(),$input,"".$model->getPrimaryKey() ."= '".$id."'"))
	      $this->addAlert($this->updateMessage);
	   else $this->addAlert('No changes was made to record');
	
	}
	else $this->addAlert($this->errorMessage);
	$this->assign('data',$input);

	if(!$this->getParam('ajax')) $this->_forward('edit');
	else {
	    $result = array();
		$errorsVal = array();
		$errorsKey = array();
		$errors = array('keys' => $errorsKey,'values' => $errorsVal);
		foreach($this->getErrors(true) as $k => $v){
		    $errors['keys'][] = $k;
		    $errors['values'][] = $v;
		}
		$result['errors'] = $errors;
		$result['response'] = $this->getAlert(true);
		
		$identifier = array();
		$identifier['name'] = $model->getPrimaryKey();
		$identifier['value'] = $id;
		
		$result['identifier'] = $identifier;
		echo json_encode($result);
	}
  }
  function prepare($input){
	 return $input;
  }
  function confirmDelete($id = null){
	  return true;
  }
  function getPreservedKeys($key_col,$keys){
		if (!is_array($keys)) $keys = array($keys);
        
		$where = '';
		$i = 1;
		foreach($keys as $key){
			$where .= $key_col.' = \''.$key.'\'';
			if($i < sizeOf($keys)) $where .= ' OR ';
			$i++;
		}
		$query = "SELECT {$this->model->getPrimaryKey()} , {$key_col} 
						FROM {$this->model->getTable()} ";
		if($where != '')	$query .= " WHERE {$where} ";

		return $this->db->fetchAssoc($query);
  }
	function checkPreservedKeys($ids,$key_col,$keys){
		if (!is_array($ids)) $ids = array($ids);
		$preservedKeys = $this->getPreservedKeys($key_col,$keys);
		$done = true;
		foreach($ids as $id){
			if(key_exists($id,$preservedKeys)) {
				$this->trackError($id,'The entry with key  = '.$preservedKeys[$id].' is reserved');
				$done = false;
			}
		}

		return $done;
	}
	
	function insertAction(){
	    $model = $this->getModel();
		$done = true;
		if(!$post = $this->postParam($model->getName())) $done = false;
		
		$input = $this->prepare($this->deephtmlentities($post));
		
		if($done && !$this->getErrors()){
			if($this->db->insert($model->getTable(),$input))
				$this->addAlert($this->insertMessage);
		}
		else {
			$done = false;
			$this->addAlert('Opps... Some errors occured!');
		}
		if($done == true) {
		    if(isset($this->postProcessAction)){
			   $this->_forward($this->postProcessAction);
			}
			else{
				$rurl = P2F_BASE_URL . '/' .$this->module . '/' . $this->controller . '/list';
				if($ajax = $this->getParam('ajax')) $rurl .= '/?ajax=' . $ajax;
				$this->redirect($rurl);
			}
		}
		else{
		
			$this->assign('data',$input);
			$this->_forward('add');
		}
	}
	function setPostProcessAction($ppa = 'list'){
		if($ppa) $this->postProcessAction = $ppa;
	}
  function deleteAction($id = null){
    $done = true;
    $model = $this->getModel();
    if($id == null){
	    if($eids = $this->postParam('delete')){
		    $id = implode($eids,',');
		}
		else $id = $this->getParam('eid');
    }
	$eidArr = explode(',',$id); 

	if($this->confirmDelete($eidArr)){
		$where = '';
		if($id && is_array($eidArr)){
		    foreach($eidArr as $k => $v){
			   $where .= "".$model->getPrimaryKey()." = '".$v."' ";
			   if($v != end($eidArr)) $where .= " OR ";
			}
		}
		
		if($where != '' && $count = $this->db->delete($model->getTable(),$where)){
		   
			$this->addAlert('Total of '.$count.' '.Display::pluralize('item',$count).' has been deleted successfully'); 
		}
		else $done = false;
	}
	else $done = false;
	
	if($done == false){
		$this->addAlert('Oops... Some errors occured!');
		$this->_forward('list');
	}
	else {
		if(isset($this->postProcessAction)){
		   $this->_forward($this->postProcessAction);
		}
		else{
			$rurl = P2F_BASE_URL . '/' .$this->module . '/' . $this->controller . '/list';
			if($ajax = $this->getParam('ajax')) $rurl .= '/?ajax=' . $ajax;
			$this->redirect($rurl);
		}
	}

  }
  /*End crud actions*/
  
  /*Display menu*/
  function getMenu(){
      if($this->menu == null){
	      require_once('Menu.php'); 
		  return $this->menu = new Menu();
	  }
	  return $this->menu;
  }
   public function getDisplay(){
      if($this->display == null){
	      require_once('Display.php'); 
		  return $this->display = new Display();
	  }
	  return $this->display;
  }
  	function getLoggedUser(){
	    $session = $this->getSession();
	    if(isset($session['auth'])) return $session['auth'];
		else return false;
	}
    function redirect($url){
	    header("location: $url");
		exit;
	}
    function setUser($user){
        $this->addToSession('auth',$user);
	}
    function getUser(){
	    $session = $this->getSession();
	    if(isset($session['auth'])) return $session['auth'];
		else return false;
	}
	function destroyUser(){
	    $session = $this->getSession();
	    if($this->getUser()) $this->removeFromSession('auth');
	}
	function userIsAdmin(){
	    if($user = $this->getLoggedUser())
		    return ($user->user_role == 1) ? true : false; 
		else return false;
	}
	function setProperty($option,$value){
	    $this->$option = $value;
	}	
	function setModelProperty($option,$value){
	    $this->getModel()->setProperty($option,$value);
	}
	
	function getModelProperty($option){
	    if(array_key_exists($option,get_object_vars($this->getModel()))) return $this->model->$option;
		else return false;
	}	
	function getProperty($option){
	    if(array_key_exists($option,get_object_vars($this))) return $this->$option;
		else return false;
	}
	function addToSession($ns,$val,$array = false, $key = null){
	    $session = FController::getSession();
		$name = FController::_getConf()->session['name'];
		if($array == true){
		    if(!isset($_SESSION[$name][$ns]) || !is_array($_SESSION[$name][$ns])) $_SESSION[$name][$ns] = array();
			if($key != null) $_SESSION[$name][$ns][$key] = $val;
			else $_SESSION[$name][$ns][] = $val;
		}
		else $_SESSION[$name][$ns] = $val;
	}
	function removeFromSession($ns){
	    $name = self::_getConf()->session['name'];
	    if(isset($_SESSION[$name][$ns])) unset($_SESSION[$name][$ns]);
	}
	function getSession($object = false){
	    $name = FController::_getConf()->session['name'];
		if(isset($_SESSION[$name])){
		    if($object) return (object)$_SESSION[$name];
			else return $_SESSION[$name];
		}
		else {
            session_start();
			if(isset($_SESSION[$name])){
			    if($object) return (object) $_SESSION[$name];
				else return $_SESSION[$name];
			}
			else {
				$_SESSION[$name] = array();
				return false;
			}
		}
	}
	function getUserRole(){
	   if($user = $this->getUser()){
		   $role = $user->user_role;
	   }
	   else $role = 0;
	   
	   return $role;
	}
	function userHasAccessTo($module, $controller = '', $action = ''){
	
	   $db = $this->getConnection();
	   $query = "SELECT access_roles FROM auth_resources 
	   WHERE (resource_module = '".$module."' AND resource_manager = '') 
	   OR (resource_module = '".$module."' AND resource_manager = '".$controller."' AND resource_action = '')  
	   OR (resource_module = '".$module."' AND resource_manager = '".$controller."' AND resource_action = '".$action."') 
	   ORDER BY resource_action DESC, resource_manager DESC, resource_module DESC";

	   $roles = $db->getOne($query);
	   if($roles != null){
		$userRole = ($user = $this->getUser()) ? $user->user_role : 0;
		 if((in_array($userRole,explode(',',$roles)))) return true;
		 else return false;
	   }
	   else return true;
	}
	function setTheme($theme = null){
		if($theme) $this->addToSession('theme',$theme);
	}
	
	function getTheme(){
	    $session = $this->getSession(true); 
		$theme = isset($session->theme) ? $session->theme : null;
		if(!$theme){
		    $theme = $this->getConf()->themes['default'];
			$this->setTheme($theme);
		}
		return $theme;
		
	}
	function createWidget($widgetName){
	    require_once 'Widget.php';
		if($widgetName){
		    $widgetPath = str_replace('_','/',$widgetName);
		    require_once P2F_WIDGETS_DIR . '/' .$widgetPath.'.php';
			$widget = new $widgetName();
			$widget->name = $widgetName;
			return $widget;
		}
	}
	function trimSlashes($path){
	    if($path[0] == '/')
		    $path = substr($path,1);
		if(substr($path,-1,1) == '/')
		    $path = substr($path,0,-1);
			
		return $path;
	}
	function getRequestUrl() { 
	    $protocol = self::getServerProtocol();
		$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]); 
		return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI']; 
	} 
	function getServerProtocol(){
		$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : ""; 
		$s1 = strtolower($_SERVER["SERVER_PROTOCOL"]);
		return $protocol = substr($s1, 0, strpos($s1, "/")).$s; 
	}
	function getRequest(){
	    if($this->request) return $this->request;
		else{
			$requestPath = split('/',$this->trimSlashes($_SERVER['REQUEST_URI']));
			$baseUrl = parse_url($this->getConf()->path['baseUrl']);
			$baseUrlPath = split('/',$this->trimSlashes($baseUrl['path']));

			if($_SERVER['SERVER_NAME'] != $baseUrl['host']){
				$redirectUrl = preg_replace('/'.$_SERVER['SERVER_NAME'].'/',$baseUrl['host'],$this->getRequestUrl(),1);
				$this->redirect($redirectUrl);
				exit;
			}
			else{
				$request = array_diff_assoc($requestPath,$baseUrlPath);
				$request = array_merge($request);
				$this->request = $request;
				return $request;
			}
		}
	}
	function getAction(){
	    if($this->action) return $this->action;
		else{
			$request = $this->getRequest();
			$action = 'index';
			if(sizeOf($request) > 2 && ctype_alnum($request[2])){
				if($a = $request[2]) $action = $a;
			}
			$this->action = $action;
			return $action;
		}
	}	
	function getController(){
		$request = $this->getRequest();
		$controller = 'index';
		if(sizeOf($request) > 1){
			$controller = ctype_alnum($request[1]) ? $request[1] : 'index';
		}
		return $controller;
	}
	function setModule(){
		
		$module = 'index';
		if(sizeOf($m = $this->getRequest())){
			if($m[0] != '' && is_dir(P2F_APP_DIR . '/modules/'.$m[0])) $module = $m[0];
		}
	    $this->module = $module;
	}
	function getModule(){
	    if(!$this->module) $this->setModule();
	    return $this->module;
	}
	function setLayout($layout){
		$this->layout = $layout;
	}
	function getLayout(){
	    return $this->layout;
	}
	function noView(){
	    $this->view = false;
	}
	function noLayout(){
		$this->useLayout = false;
	}
	function trackError($key,$value){
		if(isset($this->errors) && is_array($this->errors)) $this->errors[$key] = $value;
		else {
			$this->errors = array();
			$this->errors[$key] = $value;
		}
	} 
	function clearErrors(){
		unset($this->errors);
	}
	function removeError($key){
		unset($this->errors[$key]);
	}
	function getErrors($array = false){
	    if(isset($this->errors)) {
			if(is_array($this->errors) && sizeOf($this->errors) > 0) {
			    if($array) return $this->errors;
				else return true;
			}
			else if($array) return array();
			else return false;
		}
		else if($array) return array();
		else return false;
	}
	function addAlert($alert){
	    FController::addToSession('alert',$alert,true);
	}
	function getAlert($array = null){
	    if(isset($this->getSession(true)->alert)){
	        $alert = $this->getSession(true)->alert;
			$this->removeFromSession('alert');

		    return $alert;
		}
		else {
		    if($array) return array();
		    else return null;
		}
	}
}
?>
