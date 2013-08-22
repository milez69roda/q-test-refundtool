<?php

class Centers extends Model {

	function __construct() {
		parent::Model();
	}
	
	function getCenter(){
		
		$query = $this->db->get("center");
		return $query;
	}
	
	function getCenter_by_id(){
		
	}
	
}

?>