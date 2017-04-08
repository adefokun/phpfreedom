<?php
/**
Author: ADEFOKUN Tomiwa M.
Email: tomiwa.adefokun@gmail.com
*/
class ProcessAlert extends Widget{
    public $widget;
	public $content;
	public function build()
	{   $display = ($this->hasContent()) ? 'block' : 'none';
		$this->widget = "<div id=\"ProcessAlert\" class=\"ProcessAlert\" style=\"display: ".$display."\" align=\"center\"><div class=\"holder\"><a style=\"float: right;font-weight: bold;\" href=\"javascript: void(0)\" onclick=\"document.getElementById('ProcessAlert_holder_content').innerHTML = ''; this.parentNode.parentNode.style.display = 'none'\">Close</a><div id=\"ProcessAlert_holder_content\">" . $this->content. " </div></div></div>";
	}
	function addContent($c = null){
	    if($c){
		    $content = '<span>' . $c . '</span>';
			if(!$this->content) $this->content = $content;
			else $this->content .= $content;
		}
	}
	function addContents($contents){
	    if($contents){
			foreach($contents as $v){
				$this->addContent($v);
			}
		}
	}
	function hasContent(){
        if($this->content) return true;
		else return false;
	}
}

?>