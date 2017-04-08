<?php

/**
Author: ADEFOKUN Tomiwa M.
Email: Tomiwa.adefokun@progenicscorp.com,tomiwa.adefokun@gmail.com
*/
class Widget{
    public $widget;	
	public $name;
	
	function setProperty($name,$value = null)
	{
	    if($name) $this->$name = $value;
	}
	function getProperty($name){
	    return isset($this->$name) ? $this->name : null;
	}
	function toString(){
	    return $this->widget;
	}
	function display(){
	    echo $this->widget;
	}
}
?>