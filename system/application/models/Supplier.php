<?php

class Supplier extends Model {

	function __construct() {
		parent::Model();
	}
	
	function get(){
		
		$query = $this->db->get("supplier");
		return $query;
	}
	
	function getCenter_by_id(){
		
	}
	

}

?>