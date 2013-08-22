<?php

class AccountAjax extends Controller {

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
	
	function supervisorDropdown(){
		
		$this->load->model("dx_auth/users");
		
		$id = $this->uri->segment(3);
		
		$sup = $this->users->get_supervisor_by_center($id)->result();
		
		
		$opt = '';
		foreach( $sup as $row ){
		
			$opt .= '<option value="'.$row->id.'">'.$row->fname.' '.$row->lname.'</option>';
		}
		echo $opt;
	}
	
	function getAccountListing1(){
	
		//echo $this->userId.' asdfa sdf asdf';
		
		
		$aColumns = array( 'fname', 'lname', 'centerdesc', 'username', 'password', 'name', 'last_login', 'modified' );
		
		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "users.id";
		
		/* DB table to use */
		$sTable = "users";
		$sJoin = "LEFT OUTER JOIN center ON center.centerid = users.centerid
				   LEFT OUTER JOIN roles ON roles.id = users.role_id";
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ) {
			$sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".mysql_real_escape_string( $_GET['iDisplayLength'] );
				
			
			//$this->db->limit( $_GET['iDisplayLength'] ),  $_GET['iDisplayStart']  );
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
						
					//$this->db->order_by($aColumns[ intval( $_GET['iSortCol_'.$i] ) ], $_GET['sSortDir_'.$i] );	
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
		$sWhere = "WHERE viewable=1 AND banned = 0 ";
		
		//$sWhere .= "users.role_id = 4";
		
		if ( $_GET['sSearch'] != "" ){
			$sWhere .= " AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ ){
				$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
				
				/*if( $i == 0 )
					$this->db->like($_GET['sSearch'], 'match');
				else
					$this->db->or_like($_GET['sSearch'], 'match');*/
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
		
		

			if( $this->roleId == 4 ){
				$sWhere .= " AND users.role_id = 3 AND users.centerid =".$this->centerId;
			}
	
		
		
		/*
		 * SQL queries
		 * Get data to display
		 */
		$sQuery = "
			SELECT SQL_CALC_FOUND_ROWS  users.id,".str_replace(" , ", " ", implode(", ", $aColumns))."
			FROM   $sTable
			$sJoin
			$sWhere
			$sOrder
			$sLimit
		";
		
		//$rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
		
		$rResult = $this->db->query($sQuery);
		
		/* Data set length after filtering */
		/*$sQuery = "
			SELECT FOUND_ROWS()
		";*/
		//$rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
		
		//$rResultFilterTotal = $rResult->num_rows();
		
		//$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
		
		
		//$iFilteredTotal = $aResultFilterTotal[0];
		
		//echo $this->db->last_query();
		$iFilteredTotal = $rResult->num_rows();
		
		/* Total data set length */
		$sQuery = "
			SELECT COUNT(".$sIndexColumn.") as numrow
			FROM   $sTable
			$sJoin
			$sWhere
		";
		//$rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
		//$aResultTotal = mysql_fetch_array($rResultTotal);
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
		
		//print_r($rResult);
		foreach( $rResult as $row ){
		
			$rows = array();
			
			$rows['DT_RowId'] = $row->id;
			
			for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
				 
					$rows[] = $row->$aColumns[$i];
				
			}

			
			$output['aaData'][] = $rows;
		}
		
		echo json_encode( $output );	
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/account.php */