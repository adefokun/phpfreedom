<?php
/**
Author: ADEFOKUN Tomiwa M.
Email: Tomiwa.adefokun@progenicscorp.com
*/

require_once 'FController.php';

class IndexController extends FController{
    public $view;
	public $defaultAction = 'index';
    function __construct(){
	}
	function indexAction(){
	    $this->assign('view','index');
	}

	  //overide the crude operations
	function getData(){}
	function listAction(){}
	function addAction(){}
	function editAction(){}
	function saveAction(){}
	function deleteAction(){}
	
	
}
?>
