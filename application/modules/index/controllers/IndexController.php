<?php
/**
Author: ADEFOKUN Tomiwa M.
Email: Tomiwa.adefokun@progenicscorp.com
*/

require_once 'FController.php';

class IndexController extends FController{
    function __construct(){
	
	}
	function indexAction(){
	    $this->assign('view','index');
	}
	function searchAction($q = null){
	    $searchWord = ($q != null) ? $q : $this->getParam('q');
        $this->assign('searchWord',$searchWord);
        $this->assign('pnum',$this->getParam('pnum'));
     	$this->assign('view','search');
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
