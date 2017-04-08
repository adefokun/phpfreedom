<?php
/**
Author: ADEFOKUN Tomiwa M.
Email: Tomiwa.adefokun@progenicscorp.com
*/

require_once 'FController.php';

class AjaxController extends FController{
    function __construct(){
	
	}
	function indexAction(){
	}
    function alertsAction(){
	    echo json_encode($this->getAlert(true));
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
