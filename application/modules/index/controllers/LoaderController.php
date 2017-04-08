<?php
/**
Author: ADEFOKUN Tomiwa M.
Email: Tomiwa.adefokun@progenicscorp.com
*/

require_once 'FController.php';

class LoaderController extends FController{
    function __construct(){
	
	}
	function indexAction(){
	
	}
	function jsAction(){
	    $this->noLayout();
		$loader = $this->getParam('loader');
	    header('Content-Type: application/x-javascript');
	    header('Cache-Control: no-cache');
		$content = $this->getLoaderContent($loader);

		print($content);
		print("\n");
	}	
	function cssAction(){
	    $this->noLayout();
	    header('Content-Type: text/css');
	    header('Cache-Control: no-cache');
		$content = $this->getLoaderContent('style');

		print($content);
		print("\n");
	}
	function getLoaderContent($loader){
	    $session = $this->getConf()->session['name'];
		$content = '';
		if(isset($_SESSION[$session]['loader'][$loader])){
			$content = $_SESSION[$session]['loader'][$loader];
			unset($_SESSION[$session]['loader'][$loader]);
		}
		return $content;
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
