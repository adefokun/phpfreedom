<?php
/**
Author: ADEFOKUN Tomiwa M.
Email: Tomiwa.adefokun@progenicscorp.com,tomiwa.adefokun@gmail.com
*/

class FScriptLoader {
	public $file;
	public $scriptType;
	public $content;
	public $isHeadScript;
	public $namespace;
	
	function __construct($file = null,$scriptType = 'js',$isHeadScript = false,$isLink = false){
		$this->file = $file;
		$this->scriptType = $scriptType;
		$this->isHeadScript = $isHeadScript;

		if($file){
			if($isLink == false) {
				$this->setContent();
			}
			else if($scriptType == 'js'){
				$this->isJSLink();
			}
			else if ($scriptType == 'css'){
			    $this->isCSSLink();
			}
			if($this->content != '' && $this->namespace != '') $this->write();
		}
	}
	function setContent($content = null,$namespace = null){
	    if(isset($content)) {
			$this->content = $content;
			$this->namespace = trim($namespace);
		}
		else if($this->file != null && is_file($this->file) && file_exists($this->file)){
			$this->content = file_get_contents($this->file);
			$this->namespace = trim($this->file);
		}
		else FController::addAlert('File '. $this->file . ' could not be loaded.');
	}
	function write(){
	    $loader = $this->getLoader();
		
		$current_content = (isset(FController::getSession(true)->loader[$loader])) ? 
							FController::getSession(true)->loader[$loader] : '';
		$beginString = '/*Begin: '.$this->namespace.'*/';
		$endString = '/*End: '. $this->namespace. '*/';
		if(!strstr($current_content,$beginString)){
		    $content = $current_content . $beginString . $this->content . $endString;
			FController::addToSession('loader',$content,true,$loader);
		}
	}
	function getLoader(){
	    $loader = '';
		if($this->scriptType == 'js'){
			if($this->isHeadScript) $loader .= 'jsTop';
			else $loader .= 'jsBottom';
		}
		else if($this->scriptType == 'css') $loader .= 'style';
		return $loader;
	}
	function isCSSLink(){
		$content = '@import url(\''. $this->file . '\');';
	    $this->content = $content;
		$this->namespace = trim($this->file);
	}	
	function isJSLink(){
	    $content = 'document.write(\'<script type="text/javascript" src="' . $this->file . '"></scr\' + \'ipt>\');';
	    $this->content = $content;
		$this->namespace = trim($this->file);
	}
	static function cleanAll(){
	    FController::removeFromSession('loader');
	}
}