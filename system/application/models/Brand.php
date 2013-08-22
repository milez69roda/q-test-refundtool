<?php

class Brand extends Model {

	function __construct() {
		parent::Model();
	}
	
	function get(){
		
		$query = $this->db->get("brand");
		return $query;
	}
	
}

?>