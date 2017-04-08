<?php
/**
Author: ADEFOKUN Tomiwa M.
Email: Tomiwa.adefokun@progenicscorp.com,tomiwa.adefokun@gmail.com,
*/
require_once 'FController.php';
class Display extends FController{
    public $modelName;
	function modelName(){
		return $this->modelName;
	}
    function pluralize($word,$count = 1){
	    return ($count > 1) ? $word.'s' : $word;
	}
	function boxIsChecked($def,$val = null){
	    $checked = '';
	    if($val == $def) $checked = 'checked';
		return $checked;
    }
	function generateOptions($arr = true,$value = null,$multiple = null){

	    if(is_array($arr)){
		     $opts = '';
			foreach($arr as $key => $val){
			    if($multiple){
				    if($value != null && in_array($key,explode(',',$value)))  $selected = 'selected';
					else $selected = '';
				}
			    else{
					if($value != null && $key == $value) $selected = 'selected';
					else $selected = '';
				}
				$opts .= "<option value='".$key."' ".$selected." >".$val."</option>";
			}
			return $opts;
		}
    }
	function highlight($input,$limit = 400){
	    $content = strip_tags(html_entity_decode($input));
		if(strlen($content) <= $limit) return nl2br($content); 
		else  return nl2br(substr($content,0,$limit)).'...';
	}
	function formatDate($date = null){
	    $str = strtotime($date);
	    if($str) return date('l, d F Y h:i',$str);
		else return null;
	}
	function addSearchBlock($params = null){
	    $search = '\'+encodeURIComponent(document.getElementById(\''.$this->module.'_'.$this->controller.'_'.$this->action.'_search\').value)+\'';
	    if(is_array($params)) $params[''.$this->modelName.'_search'] = $search;
		else $params = array(''.$this->modelName.'_search'=>$search);
 
	   echo "<div class='searchBlock'>";
		if(isset($this->searchedWords)){  
		    echo '<span class=\'keywords\'>Search Results for <b>'.$this->searchedWords.'</b></span>';
		}
		
		$block = "<i>Enter Search: </i> <input name=\"search\" id=\"".$this->module."_".$this->controller."_".$this->action."_search\" />
		<input type=\"button\" value=\"Go >>\" onclick=\"window.location='".$this->addQuery($params)."' \"/>";
		$block .= "</div>";
		
		echo $block;
	}
	function mkUrlQuery($params = null,$others = null){
	    $ref = '';
		if(is_array($params)){
			
			foreach($params as $key => $val){
			    $ref .= $key.'='.$val.'&';
			}
			
		}
		if($others) $ref .= $others;
		return $ref;
	}
	function addQuery($params = '',$root = null){
	    if(!$baseUrl = $root){
			$r = FController::getRequestUrl();
			$pos = (strpos($r,'?')) ? strpos($r,'?') : strlen($r);
			$baseUrl = FController::trimslashes(substr($r,0,$pos)).'/';
		}
	    return $baseUrl.'?'.$this->mkUrlQuery($params);
	}
	function render($page){
	    
		foreach($page as $k => $v){
			$this->$k = $v;
		}
		if($this->view) {
		    $view = str_replace('_','/',$this->view).'.phtml';
			$modulePath = P2F_APP_DIR . '/modules/'.$this->getModule();
		    if(file_exists($modulePath.'/views/'.$view)) require($modulePath.'/views/'.$view);
			else {
			    echo $view.' was not found in '. $modulePath. '/views/';
				exit;
			}
			
		}
	}

  
    function getDto($data = null,$form = 'form'){
      return new DTO($data,$form);
    }
	
	function contentPager($data, $ajax = true, $block = 'mainblock',$baseurl = null){
	    if(!$ref = $baseurl){
			$r = FController::getRequestUrl();
			$pos = (strpos($r,'?')) ? strpos($r,'?') : strlen($r);
			$ref = FController::trimslashes(substr($r,0,$pos)).'/?';
			
			foreach($_GET as $key => $val){
			    if($key != ''.$this->modelName.'_pnum' && $key != 'ajax'){
					$ref .= $key.'='.$val.'&';
					$ref .= $key.'='.$val.'&';
				}
			}
		}

		$result = '<div class="pager">';
		if($data['pageCount'] > 2){
			for($i = ($data['current'] - 5); $i < ($data['current'] + 5); $i++){
				if($i > 0){
					if(!$ajax){
						$result .= '<a class="link" href="'.$ref.''.$this->modelName.'_pnum='.$i.'">'.$i.'</a>';
					}
					else{
						$result .= '<a class="link" href="javascript:void(0)" onclick="loadUrl(\''.$ref.$this->modelName.'_pnum='.$i.'\',\''.$block.'\')">'.$i.'</a>';
					}
				}
				if($i == $data['current'] - 1) break;
				
			}
			$result .= '<span class="current link" >'.$data['current'].'</span>';
			for($i = ($data['current'] + 1); $i <= ($data['current'] + 5); $i++){
				if($i > $data['pageCount']) break;
				if(!$ajax){
					$result .= '<a class="link" href="'.$ref.''.$this->modelName.'_pnum='.$i.'">'.$i.'</a>';
				}
				else {
					$result .= '<a class="link" href="javascript:void(0)" onclick="loadUrl(\''.$ref.$this->modelName.'_pnum='.$i.'\',\''.$block.'\')">'.$i.'</a>';
				}
			}
		}
		if(isset($data['last'])) {
		    if(!$ajax){
				$result .= '<a class="link" href="'.$ref.''.$this->modelName.'_pnum='.$data['last'].'" >Previous</a>';
			}
			else {
				$result .= '<a class="link" href="javascript:void(0)" onclick="loadUrl(\''.$ref.$this->modelName.'_pnum='.$data['last'].'\',\''.$block.'\')" >Previous</a>';
			}
		}
		else $result .= '<span class="disabled link" >Previous</span>';
		
		if(isset($data['next'])) {
			if(!$ajax){
				$result .= '<a class="link" href="'.$ref.''.$this->modelName.'_pnum='.$data['next'].'">Next</a>';
			}
			else{
				$result .= '<a class="link" href="javascript:void(0)" onclick="loadUrl(\''.$ref.$this->modelName.'_pnum='.$data['next'].'\',\''.$block.'\')">Next</a>';
			}
		}
		else $result .= '<span class="disabled link" >Next</span>';
		$result .= ' <span class="tinytext">Total of <b class="tinytext">'.$data['total'].'</b> '.$this->pluralize('record',$data['total']).' in all<span></div>';
		return $result;
   }
   
   function setAltBg($i,$col1 = '#e0ecff',$col2 = '#eeeeee'){
      $color = (($i % 2) == 0) ? $col1 : $col2;
      echo "style='background-color: ".$color.";' onmouseover=\"highlightRow(this);\"";
   }
   
   //use ONLY within blocks  that are under page controller...
   function mkExplicitUrl($params = null, $b = null){
        $base = ($b) ? $b : './';
        $ref = '?';
		
		foreach($_GET as $key => $val){
		    if($key != ''.$this->modelName.'_pnum')$ref .= $key.'='.$val.'&';
		}
		if($params) $ref .= $params;
		
		return $base.$ref;
   }
   function setUrl(Array $params = null, $a = null,$c = null,$m = null){
		$action = ($a) ? $a : $this->action;
		$controller = ($c) ? $c : $this->controller;
		$module = ($m) ? $m : $this->module;
		$ref = $this->mkUrlQuery($params);
		return $this->getBaseUrl(). '/' . $module . '/' . $controller . '/' . $action . '/?' .$ref;
   }
   function renderErrors(){
       if($this->errors){
	       $string = '<ul class="alert" id="errors_'.$this->modelName.'">';
		   foreach($this->errors as $v){
		       $string .= '<li>' . $v . '</li>';
		   }
		   $string .= '</ul>';
		   echo $string;
	   }
   }
	function isReadOnly($case = null,$value = null,$strict = false){
		if(!is_array($case) 
		&& (($strict == true && $case === $value) || ($strict == false && $case == $value))) echo 'readonly';
		else if(is_array($case) && in_array($value,$case,$strict)) echo 'readonly';
	}
	function addScript($file,$type = null, $isHeadScript = null,$isLink = false){
	    require_once 'FScriptLoader.php';
		$loader = new FScriptLoader($file,$type,$isHeadScript,$isLink);
	}
	function addStyleSheet($file){
		self::addScript($file,'css');
	}	
	function addCSSLink($file){
		self::addScript($file,'css',null,true);
	}
	function addScriptAsString($string,$namespace,$type,$isHeadScript = true){
		require_once 'FScriptLoader.php';
		$loader = new FScriptLoader(null,$type,$isHeadScript);
		$loader->setContent($string,$namespace);
		$loader->write();
	}
	function addJSString($string,$namespace,$isHeadScript = false){
		self::addScriptAsString($string,$namespace,'js',$isHeadScript);
	}	
	function addCSSString($string,$namespace){
		self::addScriptAsString($string,$namespace,'css');
	}
	function addJavaScript($file,$isHeadScript = null){
		self::addScript($file,'js',$isHeadScript);
	}	
	function addJSLink($file,$isHeadScript = null){
		self::addScript($file,'js',$isHeadScript,true);
	}
	function getJavaScripts($head = false){
	    $loader = ($head == true) ? 'jsTop' : 'jsBottom';
		$loaderPath = P2F_BASE_URL.'/index/loader/js/?loader=' . $loader;
		echo '<script src="'.$loaderPath.'"></script>' . "\n";
	}
	
	function getStyleSheets(){
	    $href = P2F_BASE_URL.'/index/loader/css/';	
		echo '<link  rel="stylesheet"  href="'.$href.'" />' . "\n";
	}
}

class DTO{
   public $form;
   public $data;
   function __construct($data = null,$form = 'form'){
       $this->form = $form;
	   $this->data = FController::mystripslashes($data);
   }
   function setField($name = null){
       if($name) return $this->form.'['.$name.']';
   }
   function setPrimary($primary = null){
      if($primary)$this->primaryKey = $primary;
   }
   function getField($name = null,$default = null,$noStrip = false){
      if($this->data == null || !is_array($this->data) || !$name) $return = $default;
	  else if(key_exists($name,$this->data)) $return = $this->data[$name];
	  else $return = $default;
	  
	  return ($noStrip == true) ? html_entity_decode($return) : $return;
   }
}

?>