<?php
/**
Author: ADEFOKUN Tomiwa M.
Email: Tomiwa.adefokun@progenicscorp.com
*/

class IndexController extends FController{
    function __construct(){
	    $this->setSiteTitle('Demo');
	}
	function indexAction(){
	    //assing the index.phtml file as the view page for this action.
	    $this->assign('view','index');
	}
	function blocksAction(){
	    $this->assign('view','blocks');
	}	
	function tabbedpanesAction(){
	    $this->assign('view','tabbedpanes');
	}
  
  //overide the crude operations since this page has no data stuffs.
  function getData(){}
  function listAction(){}
  function addAction(){}
  function editAction(){}
  function saveAction(){}
  function deleteAction(){}

}
?>