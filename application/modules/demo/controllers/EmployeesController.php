<?php
/**
Author: ADEFOKUN Tomiwa M.
Email: Tomiwa.adefokun@progenicscorp.com,tomiwa.adefokun@gmail.com
*/
require_once 'FController.php';

class EmployeesController extends FController{
  function __construct(){
    //use FModel and its model API
    require_once 'FModel.php';
    $this->model = new FModel('employees','demo_employees'); 
	//param 1 is the model name(compulsory) param 2 is the table you want to model... provide a value if your data is from a single table or view
	//set the value of the primary key
	$this->model->setPrimaryKey('employee_id');
	/*
	This part is ignored because we are facing one table, which is defined in the constructor.
	
	$this->model->setMainSelectFrom('select * from demo_employees');
	$this->model->setCountSelectFrom('select count(*) from demo_employees');
	*/
	$this->model->setSearchCriteria(array('employee_firstname','employee_lastname','employee_address'));
	//if the search criteria is not provided, the system generates it if the table is specified. But it is adviced that you set the search criteria.
	$this->model->setLimit(20);
	$this->model->setOrderBy('employee_lastname, employee_firstname, employee_id');
	//end
	
	$this->db = $this->getConnection();
    
    $this->templates = array(
                        'list'=>'employees_list',
                        'edit'=>'employees_edit',
                        'add'=>'employees_edit'
                       );
	
	//Set HTML title for the page
	$this->assign('title','Employees Manager');
	
	$this->setSiteTitle('Employee Manager');
	}
    function prepare($input){
	    /*
		the input is the data filled in the forms for edit and add.... 
		perform validations and stuff in this method....
		
		incase of an error use $this->trackError('name','Error value');
		name = the field name
		value = the error message
		to add a alert message use $this->addAlert('Alert a erro here')
		*/
		if($input['employee_firstname'] == '') $this->trackError('employee_firstname','The firstname cannot be empty');
		if($input['employee_lastname'] == '') $this->trackError('employee_lastname','The lastname cannot be empty');

		return $input;
	}
	function indexAction(){
	    $this->assign('title','Employees Manager');
		$this->_forward('list');
	}
	function build(){
	    if(isset($this->title)) $this->assign('title',$this->title);
		$this->_forward($this->action);
	}
	

	 /*
	  The following functions are defined in FController, you may overide them if need be.
	  function getData(){}
	  function listAction(){}
	  function addAction(){}
	  function editAction(){}
	  function saveAction(){}
	  function deleteAction(){}
	  */
}
?>
