<?php

class ItemCategory extends Model {

	function __construct() {
		parent::Model();
	}
	
	function get(){
		
		$this->db->select("item_name");
		$query = $this->db->get("items_category");
		return $query;
	}
	
	function get_by_itemName($name){
		
		$this->db->where("item_name", $name);
		
		$query = $this->db->get("items_category");
		return $query;
		
	}
	
}

?>