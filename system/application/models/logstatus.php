<?php

class LogStatus extends Model {

	function __construct() {
		parent::Model();
	}
	
	function get(){
		
		
		$query = $this->db->get("refund_status");
		return $query;
	}
	
	function get_by_itemName($name){
		
		$this->db->where("item_name", $name);
		
		$query = $this->db->get("items_category");
		return $query;
		
	}
	
}

?>