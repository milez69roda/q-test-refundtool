<?php

class States extends Model {

	function __construct() {
		parent::Model();
	}
	
	function get(){
		$this->db->order_by("country", "asc");
		$this->db->order_by("state_usps", "asc");
		$query = $this->db->get("states");
		return $query;
	}
	
	function get_by_id($id){
		
		$this->db->where("state_id", $id);
		
		$query = $this->db->get("states");
		return $query;
		
	}
	
}

?>