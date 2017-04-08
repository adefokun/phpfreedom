<?php
	class FModel{
	    public $multiTable;
	    //select
	    public $firstPart;
		//condition
		public $secondPart;
		//the order and sorting
		public $thirdPart;
        public $id;
		public $searchCriteria;
		public $limit = 20;
		public $where = 'WHERE 1 = 1 ';
		public $primaryKey;
		public $orderBy;
		public $sort;
		public $mainSelectFrom;
		public $countSelectFrom;
		public $search;
		public $pagerName;
		public $searchName;
		//set value for table only if you are modeling a single table
		public $table;
		public $name;
		
		function __construct($name,$table = null){
			$this->table = $table;
			$this->name = $name;
			
			$this->pagerName = $name.'_pnum';
			$this->searchName = $name.'_search';
		}
		function setFirstPart($firstPart){
			$this->firstPart = $firstPart;
		}
		function getFirstPart($count = false){
		    if($count == true) return $this->countSelectFrom;
			else return $this->mainSelectFrom;
		}
		function setSecondPart($secondPart = null){
			$this->secondPart = $secondPart;
		}	
        function getSecondPart(){
		    if($id  = $this->getId()) $this->addWhere(" AND ".$this->getPrimaryKey()." = '".$id."' ");
			if($word = $this->getSearch()){
				$sc = ($this->getSearchCriteria());
		
				if((sizeof($sc))){
				    
					$searchWhere = " AND (";
				    foreach($sc as $v){
					   $searchWhere .= " $v LIKE '%$word%' ";
					   if($v != end($sc)) $searchWhere .= " OR ";
				    }
					$searchWhere .= " ) ";
					
					$this->addWhere($searchWhere);
				}
			}
			return $this->secondPart . ' ' . $this->getWhere();
		}		
		function setThirdPart($thirdPart){
		    $this->thirdPart = $thirdPart;
		}		
		function getThirdPart($default = false){
		    if($default == true) return $this->thirdPart;
			else{
				if($this->orderBy == null && $this->sort == null) {
					$orderBy = $this->primaryKey;
					$sort = 'ASC';
				}
				else {
					if($this->orderBy != null) $orderBy = $this->orderBy;
					else $orderBy = $this->primaryKey;
					if($this->sort != null) $sort = $this->sort;
					else $sort = 'ASC';
				}
				
				return " ORDER BY $orderBy $sort ";
			}
		}

		function setSearchCriteria($searchCriteria)
		{
			$this->searchCriteria = $searchCriteria;
		}
		function setPrimary($primary){
			$this->primary = $primary;
		}			
		function setTable($table){
			$this->table = $table;
		}			
		function getTable(){
			return $this->table;
		}			
		function setId($id){
			$this->id = $id;
		}
		function getId(){
		    return $this->id;
		}		
		function getTotalQuery(){
		    return $this->getFirstPart(true) . ' ' . $this->getSecondPart();
		}
		function setOrderBy($orderBy = null){
			$this->orderBy = $orderBy;
		}		
		function setSort($sort = null){
			$this->sort = $sort;
		}
		
		function getFinalQuery($offset){
		    return $this->getFirstPart() . ' ' . $this->getSecondPart() . ' ' . $this->getThirdPart() . ' LIMIT ' . $offset . ','. $this->limit ;
		}
		
		function setCountSelectFrom($countSelectFrom){
			$this->countSelectFrom  = $countSelectFrom;
		}		
		function setMainSelectFrom($mainSelectFrom){
			$this->mainSelectFrom  = $mainSelectFrom;
		}
		function addWhere($where){
			$this->where .= $where;
		}
		function getWhere(){
		    return $this->where;
		}
		function setPrimaryKey($primaryKey){
			$this->primaryKey = $primaryKey;
		}		
		function getPrimaryKey(){
			return $this->primaryKey;
		}
		function setSearch($search){
			$this->search = $search;
		}
		function getSearch(){
		    return $this->search;
		}
		function getSearchCriteria(){
			return $this->searchCriteria;
		}
		function setLimit($limit){
		   $this->limit = $limit;
		}		
		function getLimit(){
		   return $this->limit;
		}
		function getMainSelectFrom(){
		   return $this->mainSelectFrom;
		}		
		function getCountSelectFrom(){
		   return $this->countSelectFrom;
		}
		function getName(){
			return $this->name;
		}
		function setProperty($key,$val){
			$this->$key = $val;
		}		
		function getProperty($key){
			return (isset($this->$key)) ? $this->$key : null;
		}
	}
?>