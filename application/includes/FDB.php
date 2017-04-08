<?php
/**
Author: ADEFOKUN Tomiwa M.
Email: Tomiwa.adefokun@progenicscorp.com,tomiwa.adefokun@gmail.com,tomiwa.adefokun@gmail.com
*/
class FDB{
	protected $dbHost;
	protected $dbUser;
	protected $dbPassword; 
	protected $dbDatabase;
	protected $connection;

	function __construct(Array $connection){
	    $this->connect($connection);
	}
	public function connect(Array $connection){
		if(!isset($this->connection)){     
			$this->dbHost = $connection['hostname'];
			$this->dbUser = $connection['user'];
			$this->dbPassword = $connection['password'];
			$this->dbDatabase = $connection['database'];


			$link = mysql_connect($this->dbHost,$this->dbUser,$this->dbPassword);
			if(get_resource_type($link) == 'mysql link') $this->connection = $link;
			else die('Cannot connect to database.');
		}
		
  }
 
  function fetchAll($query,$fetchType = ''){
    $data = array();
    $result = $this->query($query);
    while($rowData = $this->fetch($result,$fetchType)){
      $data[] = $rowData;
    }
    return $data; 
  }
  function fetch($result,$fetchType = ''){
    $return = null;
    if($result):
      switch($fetchType){
        case 'ASSOC': $return = mysql_fetch_assoc($result);
        break;
        case 'OBJ': $return = mysql_fetch_object($result);
        break;
        case 'ROW': $return = mysql_fetch_row($result);
        break;
        default: $return = mysql_fetch_array($result);
        break;
      }
    endif;
    return $return;
  }
  function getRow($query){
    $result = $this->query($query);
    $rowData = $this->fetch($result,'ROW');
    return $rowData;
  }
  function fetchRow($query,$fetchType = ''){
    $result = $this->query($query);
    $rowData = $this->fetch($result,$fetchType);
    return $rowData;
  }
  function getRowById($table,$key,$id,$fetchType = 'OBJ'){
    $query = "SELECT * FROM $table WHERE $key = '$id'";
	return $this->fetchRow($query,$fetchType);
  }
  function fetchOne($query){
    $result = $this->query($query);
    $rowData = $this->fetch($result);
    return $rowData[0];     
  }
  function getOne($query){
     return $this->fetchOne($query);
  }
  function query($query){
    if($query && $this->connection) {
	    mysql_select_db($this->dbDatabase,$this->connection);
	    if($result = mysql_query($query,$this->connection)) return $result;
		else{ 
		    echo 'Could not run an SQL query - Process terminated! '.mysql_error();
		    exit;
		}
    }	
    else{ 
	     echo 'There was an error in the request. ';
	     exit;
	}
  }
  function insert($tbl,$qArr){   
	   $vals = implode('\',\'',$qArr); 

	   $values = '\''.$vals.'\'';
	   $cols =  implode(',',array_keys($qArr));
	   $query = "INSERT INTO $tbl ($cols) VALUES ($values)";
	   $return = $this->query($query);
	   return $return;
  }
 function update($tbl,$qArr,$whereQuery){
    $update_string = '';
    foreach($qArr as $key => $val){
      $update_string .= "$key = '$val',";
    }
    $updates =  substr_replace($update_string, '', strlen($update_string) - 1);
    $query = "UPDATE $tbl SET $updates WHERE $whereQuery";
    $return = $this->query($query);
	return mysql_affected_rows();
  }
  function delete($tbl,$whereQ){
    $this->query("DELETE FROM $tbl WHERE $whereQ");
    return mysql_affected_rows();
  }
    function fetchAssoc($query){
     $result = $this->fetchAll($query);
	 
	 if(is_array($result)){
		    $return = array();
		    foreach($result as $val){
			    $key = $val[0];
			    $return[$key] = $val[1];
			}
		}
		
		return $return;
  }
  function listFields($table){
      if(!$result = $this->fetchAll("SHOW COLUMNS FROM $table")){
	      return null;
	  }
	  else {
	      $return = array();
		  foreach($result as $v){
		      $return[] = $v['Field'];
		  }
		  return $return;
	  }
	  
  }
  function fetchOneIntoArray($query,$key = null){
        $result = $this->fetchAll($query);
		$return = array();
		foreach($result as $v){
			$return[] = ($key != null) ? $v[$key] : $v[0];
		}
		return $return;
  }
  function __destruct(){
	if(gettype($this->connection) == 'resource' && get_resource_type($this->connection) == 'mysql link') 
	{
		mysql_close($this->connection);
	}
  }
}
?>
