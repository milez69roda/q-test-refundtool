<?php

class LogsAjax extends Controller {

	var $roleId = '';
	var $userId = '';
	var $centerId = '';
	
	function __construct(){
		parent::Controller();	
		$this->load->library('DX_Auth');	
		
		if ( !$this->dx_auth->is_logged_in() )
			redirect('auth/login', 'location');
			
		$this->roleId = $this->session->userdata('DX_role_id');
		$this->userId = $this->session->userdata('DX_user_id');
		$this->centerId = $this->session->userdata('DX_center_id');
			
		parse_str( $_SERVER['REQUEST_URI'], $_GET );
	}
	
	function index(){

	}

	
	function getLogListing1(){
	
		//echo $this->userId.' asdfa sdf asdf';
		
		$aColumns = array(  'fname','lname','log_status_name', /*'log_status_desc',*/ 'audited_name',
							'supplier_num', 'supplier_site_num', 'address_line1', 'address_line2', 'address_line3', 
							'city', 'state', 'zip', 'country', 'invoice_num',
							'webcsr',
							'invoice_date', 'invoice_amount', 'invoice_descer', 'brand', 'gl_account',
							'updated_date', 'updated_by_name', 'date_created' );
		
		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "logid";
		
		/* DB table to use */
		$sTable = "refundlog";
		$sJoin = "LEFT OUTER JOIN users ON users.id = refundlog.user_id";
		
		
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ) {
			$sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".mysql_real_escape_string( $_GET['iDisplayLength'] );

		}
		
		
		/*
		 * Ordering
		 */
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ) {
			
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ) {
					
					$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";

				}
			}
			
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" ){
				$sOrder = "";
			}
		}
		
		
		/* 
		 * Filtering
		 * NOTE this does not match the built-in DataTables filtering which does it
		 * word by word on any field. It's possible to do here, but concerned about efficiency
		 * on very large tables, and MySQL's regex functionality is very limited
		 */
		$sWhere = "WHERE";
		
		
		
		/*if( $this->roleId != 2 ){
			$sWhere .= " users.centerid = ".$this->centerId;
			
			if( $this->roleId  == 3 )
				$sWhere .= " AND user_id = ".$this->userId;
			
		}else{
			$sWhere .= " users.centerid <> '' ";
		}*/

		
		if( $this->roleId == 3 ){
			$sWhere .= " deleted = 0 AND updated_date <> '' AND users.centerid = ".$this->centerId;
			
		}else{
			$sWhere .= " deleted = 0 AND updated_date <> '' AND users.centerid <> '' ";
		}
		
		
		if( isset($_GET["logstatus"]) && $_GET["logstatus"] != ""  ){
			$sWhere .= " AND log_status = ".$_GET["logstatus"];		
			
		}else{
		
			//if ( $_GET['sSearch'] != "" ){
				if( $this->roleId == 3 ){
					//$sWhere .= " AND log_status = 3";
				}elseif( $this->roleId == 4 ){
					//$sWhere .= " AND (log_status = 1 OR log_status = 3)" ;
				}else{
					
				}
			//}
		}
		
		
		
		if ( $_GET['sSearch'] != "" ){
			$sWhere .= " AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ ){
				$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
				
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ ){
			if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' ){
				if ( $sWhere == "" ) {
					$sWhere = "WHERE ";
				}
				else {
				
					
					$sWhere .= " AND";
				}
				$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
			}
		}		
		
		if( (isset($_GET['dfrom']) AND $_GET['dfrom'] != "") AND  ( isset($_GET['dfrom']) AND $_GET['dfrom'] != "") ){
			$sWhere .= " AND DATE_FORMAT(updated_date,'%Y-%m-%d') BETWEEN '".$_GET['dfrom']."' AND '".$_GET['dto']."'";
		}
		
		
		if( $sWhere == "WHERE" ) $sWhere = "";
		
		
		/*
		 * SQL queries
		 * Get data to display
		 */
		$sQuery = "
			SELECT SQL_CALC_FOUND_ROWS  $sIndexColumn, log_status, agent_updated_flag, ".str_replace(" , ", " ", implode(", ", $aColumns))."
			FROM   $sTable
			$sJoin
			$sWhere
			$sOrder
			$sLimit
		";
		

		$rResult = $this->db->query($sQuery);
		//echo $this->db->last_query();
		
		/* Data set length after filtering */
		/* $sQuery = "
			SELECT FOUND_ROWS() as id
		"; */
		
		//$rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
		//$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
		
		/* $aResultFilterTotal = $this->db->query($sQuery)->row();
		$iFilteredTotal = $aResultFilterTotal->id;	 */	
		
		//echo $this->db->last_query();
		//$iFilteredTotal = $rResult->num_rows();
		//$iFilteredTotal = $iFilteredTotal;
		
		//print_r($iFilteredTotal);
		
		/* Total data set length */
		$sQuery = "
			SELECT COUNT(".$sIndexColumn.") as numrow
			FROM   $sTable
			$sJoin
			$sWhere
		";
		//echo $sQuery;
		$aResultTotal = $this->db->query($sQuery)->row();
		$iTotal = $aResultTotal->numrow;
		
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			//"iTotalDisplayRecords" => $iFilteredTotal,
			"iTotalDisplayRecords" => $iTotal,
			"aaData" => array()
		);
		
		//while ( $aRow = mysql_fetch_array( $rResult ) ){
		
		$rResult = $rResult->result();
		//echo $rResult->
		
		foreach( $rResult as $row ){
		
			$rows = array();
			
			$rows['DT_RowId'] = $row->logid;
			$rows['DT_RowClass'] = "";
			
			if( $row->log_status == 3 ){						
				$rows['DT_RowClass'] = "tr_notapprove_status";
				
				if( $row->agent_updated_flag == 1 )
					$rows['DT_RowClass'] = "tr_notapprove_flag";
				
			}elseif( $row->log_status == 2 ){
				$rows['DT_RowClass'] = "tr_approved_status";
			}else{
				$rows['DT_RowClass'] = "tr_pending_status";
			}
			
			for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
				 
				$rows[] = $row->$aColumns[$i];
				
			}
			
			$output['aaData'][] = $rows;
			
		}
		//echo $x." - -";
		echo json_encode( $output );	
	}
	
	
	function savebasicInfo(){
	
		if( isset($_POST["savebtn"]) && $_POST["savebtn"]=="save"){
			
			$ret["status"] = false;
			$ret["id"] = '';
			
			$pData['user_id'] 			= $this->userId;
			$pData['updated_date'] 		= date("Y-m-d H:i:s");	
			$pData['log_status_name'] 	= "Pending";		
			
			$pData['supplier_num']		= strtoupper($this->input->post("supplier"));
			$pData['supplier_site_num'] = strtoupper($this->input->post("supsitenum"));
			$pData['address_line1'] 	= strtoupper($this->input->post("custfname").' '.$this->input->post("custlname"));
			$pData['address_line2'] 	= strtoupper($this->input->post("addrline2"));
			$pData['address_line3'] 	= strtoupper($this->input->post("addrline3"));
			$pData['city'] 				= strtoupper($this->input->post("city"));
			$pData['state'] 			= strtoupper($this->input->post("state"));
			$pData['zip'] 				= strtoupper($this->input->post("zip"));
			$pData['country'] 			= strtoupper($this->input->post("country"));
			$pData['invoice_num'] 		= strtoupper($this->input->post("invnum"));
			$pData['invoice_date'] 		= strtoupper($this->input->post("invdate"));
			$pData['invoice_amount'] 	= strtoupper($this->input->post("grandtotal"));
			$pData['invoice_descer'] 	= strtoupper($this->input->post("invdescer"));
			$pData['brand'] 			= strtoupper($this->input->post("brand"));
			$pData['gl_account'] 		= strtoupper($this->input->post("glaccount"));			
			$pData['reason'] 			= strtoupper($this->input->post("reason"));			
			$pData['webcsr'] 			= strtoupper($this->input->post("webcsr"));			
			$pData['invoice_sub_total']	= strtoupper($this->input->post("subtotal"));			
			$pData['sales_tax'] 		= strtoupper($this->input->post("saletax"));			
			$pData['sales_tax_percent'] = strtoupper($this->input->post("taxtpercent"));			
			$pData['cust_fname'] 		= strtoupper($this->input->post("custfname"));			
			$pData['cust_lname'] 		= strtoupper($this->input->post("custlname"));			
			$pData['other_tax'] 		= strtoupper($this->input->post("otherTaxes"));		
			
			$pData['log_ip'] 			= $_SERVER["REMOTE_ADDR"];			
			
			if( $this->db->insert('refundlog', $pData) ){
				
				$id = $this->db->insert_id();
				$ret["id"] = $id;
				$ret["status"] = true;
			
					$items = array();
					$items_update = array();
					
					foreach( $_POST as $key=>$value){
						
						$temp = explode('_',$key); 
						
						if( count($temp) > 1 ){
							$items[$temp[1]]["logid"] = $id;
							switch($temp[0]){
								case "qty":
									$items[$temp[1]]["qty"] = $value;
									break;
								case "type":
									$items[$temp[1]]["item_num"] = $value;
									break;
								case "itemdesc":
									$items[$temp[1]]["description"] = $value;
									break;
								case "price":
									$items[$temp[1]]["unit_price"] = $value;
									break;
								case "total":
									$items[$temp[1]]["line_total"] = $value;
									break;
							}
						}
						
					}
					
					foreach( $items as $key=>$value ){
						$this->db->insert("refundlog_items", $value);
					}
			}
			
			
			//redirect("dashboard/listing", "location");
			

			echo json_encode($ret);
		}	
	}
	
	function saveUpdate(){
		
		if( isset($_POST["savebtn"]) && $_POST["savebtn"]=="save"){
			
			$ret["status"] = false;
			$ret["id"] = '';
			
			$id = $this->input->post("refId");
			
			if( $_POST["isAudit"] == 1 ){
				
				$pData['updated_by'] 		= $this->userId;
				$pData['updated_date'] 		= date("Y-m-d H:i:s");				
				
				$pData['audited_by'] 		= $this->userId;
				$pData['audited_date'] 		= date("Y-m-d H:i:s");
				$pData['audited_name'] 		= $this->session->userdata('DX_firstname')." ".$this->session->userdata('DX_lastname');
				
				$pData['log_status'] 		= $this->input->post("logstatus_audit");
				
				$pData['log_status_name'] 	= $this->input->post("logsname");
				$pData['log_status_desc'] 	= $this->input->post("statusdesc");
				//$pData['log_status_desc'] 		.= "<br/>Date: ".date("Y-m-d H:i:s")."<br />Audited By: ".$this->session->userdata('DX_firstname')." ".$this->session->userdata('DX_lastname')."<br />Reason: ".$this->input->post("statusdesc");
				
				$pData['agent_updated_flag'] = 0;
				
				$pData['updated_by_name'] = $this->session->userdata('DX_firstname')." ".$this->session->userdata('DX_lastname');
				
				//$pData['log_ip'] 			= $_SERVER["REMOTE_ADDR"];			
				
				$ret["status"] = FALSE;
				$ret["id"] = $id;
					
				$this->db->where("logid",$id);
				if( $this->db->update("refundlog", $pData) ){
					$ret["status"] = TRUE;
					$ret["id"] = $id;
				}
				
				//print_r($pData);
				
			}else{			 
				
				if( $this->input->post("logstatus") == 3 ){
					$pData['agent_updated_flag']	= 1;
				}
				
				$pData['updated_by'] 		= $this->userId;	
				$pData['updated_date'] 		= date("Y-m-d H:i:s");		
				$pData['updated_by_name'] 	= strtoupper($this->session->userdata('DX_firstname')." ".$this->session->userdata('DX_lastname'));
				
				$pData['supplier_num']		= strtoupper($this->input->post("supplier"));
				$pData['supplier_site_num'] = strtoupper($this->input->post("supsitenum"));
				$pData['address_line1'] 	= strtoupper($this->input->post("custfname").' '.$this->input->post("custlname"));
				$pData['address_line2'] 	= strtoupper($this->input->post("addrline2"));
				$pData['address_line3'] 	= strtoupper($this->input->post("addrline3"));
				$pData['city'] 				= strtoupper($this->input->post("city"));
				$pData['state'] 			= strtoupper($this->input->post("state"));
				$pData['zip'] 				= strtoupper($this->input->post("zip"));
				$pData['country'] 			= strtoupper($this->input->post("country"));
				$pData['invoice_num'] 		= strtoupper($this->input->post("invnum"));
				$pData['invoice_date'] 		= strtoupper($this->input->post("invdate"));
				$pData['invoice_amount'] 	= strtoupper($this->input->post("grandtotal"));
				$pData['invoice_descer'] 	= strtoupper($this->input->post("invdescer"));
				$pData['brand'] 			= strtoupper($this->input->post("brand"));
				$pData['gl_account'] 		= strtoupper($this->input->post("glaccount"));			
				$pData['reason'] 			= strtoupper($this->input->post("reason"));			
				$pData['webcsr'] 			= strtoupper($this->input->post("webcsr"));			
				$pData['invoice_sub_total']	= strtoupper($this->input->post("subtotal"));			
				$pData['sales_tax'] 		= strtoupper($this->input->post("saletax"));			
				$pData['sales_tax_percent'] = strtoupper($this->input->post("taxtpercent"));			
				$pData['cust_fname'] 		= strtoupper($this->input->post("custfname"));			
				$pData['cust_lname'] 		= strtoupper($this->input->post("custlname"));	
				$pData['other_tax'] 		= strtoupper($this->input->post("otherTaxes"));	
				
				$this->db->where("logid",$id);
				if( $this->db->update("refundlog", $pData) ){
					
					$ret["id"] = $id;
					$ret["status"] = true;
				
					$items = array();
					$items_update = array();
					//print_r($_POST);
					foreach( $_POST as $key=>$value){
						
						$temp = explode('_',$key); 
						$countTemp = count($temp);
						
						//echo $key."  - ".count($temp)." -".(isset($temp[2])?$temp[2]:'')."<br />";
						
						if( $countTemp == 3 ){
						
							switch($temp[0]){
								case "qty":
									$items_update[$temp[1]]["qty"] = $value;
									break;
								case "type":
									$items_update[$temp[1]]["item_num"] = $value;
									break;
								case "itemdesc":
									$items_update[$temp[1]]["description"] = $value;
									break;
								case "price":
									$items_update[$temp[1]]["unit_price"] = $value;
									break;
								case "total":
									$items_update[$temp[1]]["line_total"] = $value;
									break;
								case "itemstatus":
									$items_update[$temp[1]]["status"] = $value;
									break;
							}						
						
						}else if( $countTemp == 2 ){
						
							$items[$temp[1]]["logid"] = $id;
							
							switch($temp[0]){
								case "qty":
									$items[$temp[1]]["qty"] = $value;
									break;
								case "type":
									$items[$temp[1]]["item_num"] = $value;
									break;
								case "itemdesc":
									$items[$temp[1]]["description"] = $value;
									break;
								case "price":
									$items[$temp[1]]["unit_price"] = $value;
									break;
								case "total":
									$items[$temp[1]]["line_total"] = $value;
									break;									
								case "itemstatus":
									$items[$temp[1]]["status"] = $value;
									break;
							}						
						}else{
						
						}
						
					}
					
					foreach( $items as $key=>$value ){
						$this->db->insert("refundlog_items", $value);					
					}
					
					foreach( $items_update as $key=>$value ){
						$this->db->where("itemid", $key);
						$this->db->update("refundlog_items", $value);
					}
					
					//print_r($items);
					//print_r($items_update);
				}
			
			}
			
			//redirect("dashboard/listing", "location");
			echo json_encode($ret);
		}	
	}
	
	
	function itemstemplate(){

		$this->load->model("ItemCategory", "items");	
		
		$items = $this->items->get()->result();
		
		$option = '';
		foreach($items as $row){
			$option .= '<option value="'.$row->item_name.'">'.$row->item_name.'</option>';
		}
		
		$data["options"] = $option;
		//$data["now"] = $now = strtotime(date('Y-m-d H:i:s'));
		$data["now"] = $this->uri->segment(3);
		
		
		
		$this->load->view("logs/item_tpl", $data);
	
	}
	
	function itemscatdesctpl(){
	
		$this->load->model("ItemCategory", "items");
		
		$name = $this->uri->segment(3);
		
		$items = $this->items->get_by_itemName($name)->row();
		echo $items->item_desc_tpl;
	}
	
	
	function updateCompleteStatus(){
		
		$ids = $this->uri->segment(3);
		$return["status"] = false;
		/* $this->db->where("logid", $id);
		$query = $this->db->get("refundlog")->row();
		//echo $this->db->last_query();
		$return["status"] = false;
		
		if( $query->log_status == 2 ){
			$return["status"] = true;
			
			$uData["log_status"] 		= 4;
			$uData["log_status_name"] 	= "Completed";			
			
			$uData['updated_by'] 		= $this->userId;	
			$uData['updated_date'] 		= date("Y-m-d H:i:s");	
			
			$this->db->update( "refundlog", $uData, array("logid"=>$id) );
		} */
		
		$xid = explode("_", $ids);
		$count = 0;
		foreach($xid as $id){
			
			$return["status"] = true;
			$count++;
			
			$uData["log_status"] 		= 4;
			$uData["log_status_name"] 	= "Completed";			
			
			$uData['updated_by'] 		= $this->userId;	
			$uData['updated_date'] 		= date("Y-m-d H:i:s");	
			
			$this->db->update( "refundlog", $uData, array("logid"=>$id) );			
			
		}
		
		$return["message"] = "There are/is $count logs updated successfully";
		echo json_encode($return);
	
	}

	function getAuditorNote(){
	
		$id = $this->uri->segment(3);
		
		$this->db->where("logid", $id);
		$query = $this->db->get("refundlog")->row();
		
		$note = trim($query->log_status_desc);
		
		if( strlen($note) > 0 ) $return["status"] = true;
		else $return["status"] = false;
		
		$return["auditornote"] = $query->log_status_desc;

		
		echo json_encode($return);
	}
	
	function deletelog(){
	
		$return = array("status"=>false);
		$id = $this->uri->segment(3);
		
		$this->db->set("deleted", 1);
		$this->db->set("deleted_by", $this->userId);
		
		$this->db->where("logid", $id);
		
		if( $this->db->update("refundlog") ){
			$return["status"] = true;
		}
		
		echo json_encode($return);
		
	}
	
	function download(){
	
		//$this->load->helper('download');
		$this->load->model("refund");
		
		$date_from = $this->uri->segment(3);
		$date_to = $this->uri->segment(4);
		$status = $this->uri->segment(5);
			
		if( $status != "" )
			$status = "AND log_status = $status";
			
		$sql = 'SELECT
					logid,
					CONCAT(fname," ",lname) AS "Agent Name", 
					log_status_name AS "Status",
					audited_name AS "Audited By",
					supplier_num AS "Supplier Num",
					supplier_site_num AS "Supplier Site Num",
					address_line1 AS "Address Line 1",
					address_line2 AS "Address Line 2",
					address_line3 AS "Address Line 3",
					city AS "City",
					state AS "State",
					zip AS "Zip",
					country AS "Country",
					invoice_num AS "Kana ID/Invoice #",
					webcsr AS "WebCSR Ticket #",
					invoice_date AS "Invoice Date",
					invoice_amount AS "Invoice Amount",
					invoice_descer AS "Invoice Description",
					brand AS "Brand",
					gl_account AS "GL Account",
					updated_date AS "Date Updated",
					sales_tax,
					other_tax
				FROM refundlog 
					LEFT OUTER JOIN users ON users.id = refundlog.user_id
					LEFT OUTER JOIN center ON center.centerid = users.centerid
				WHERE deleted = 0 AND DATE_FORMAT(updated_date,"%Y-%m-%d") BETWEEN "'.$date_from.'" AND "'.$date_to.'"
					'.$status.'
				ORDER BY updated_date desc';
		//echo $sql;
		
		
		$files = $this->refund->excelwriter_factory1($sql);
		
		/*$data = file_get_contents($files["filename"]); // Read the file's contents
		$name = $files["name"];

		force_download($name, $data); */
		//echo json_encode($files);
		echo $files["filename"];
	}	
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/account.php */