<?php
require_once "Spreadsheet/Excel/Writer.php";

class Refund extends Model {

	function __construct() {
		parent::Model();
	}
	
	function get(){
		$this->db->where("deleted", 0);
		$query = $this->db->get("refundlog");
		return $query;
	}
	
	function getRefund_by_id($id){
		
		//$this->db->select("DATE_FORMAT("Y"),*")
		
		$this->db->where("logid", $id);
		$this->db->where("deleted", 0);
		
		$this->db->join("users", "users.id = refundlog.user_id", "LEFT OUTER");
		$this->db->join("center", "center.centerid = users.centerid", "LEFT OUTER");
		$query = $this->db->get("refundlog");
		return $query;
	}
	
	function getRefundItem_by_id($id){
	
		$this->db->where("logid", $id);
		$this->db->where("status", 1);
	
		$query = $this->db->get("refundlog_items");
		
		return $query;
	}
	

	function excelwriter_factory1( $query ){

		
		ini_set('memory_limit', '-1');
		error_reporting(0);
		ini_set('display_errors',0);
		
		
		list($usec, $sec) = explode(" ", microtime());
		$now = ((float)$usec + (float)$sec);		
		

			
		$dir = "files/";
		$current_dir = @opendir($dir);

		//delete files
		while( $filename = @readdir($current_dir) ) {
			
			if ($filename != "." and $filename != ".." and $filename != "index.html") {
				$name = str_replace(".xls", "", $filename);
				
				if (($name + 3600) < $now) {
					@unlink($dir.$filename);
				}
			}
		}

		@closedir($current_dir); 

		$query = $this->db->query($query);
		
		$ifields = 0;
		foreach ( $query->list_fields() as $field ){
				$colNames[] =  $field;
			
			$ifields++;	
		}
		

		$name = number_format($now, 0, '.', '').'.xls';
		$filename = $dir.$name;

		$wxsheet = '1';		

		$xls =& new Spreadsheet_Excel_Writer( $filename );
		
		$sheet = 'sheet'.$wxsheet;
		$$sheet = &$xls->addWorksheet("Page ".$wxsheet);
		

		
		$colHeadingFormat = &$xls->addFormat();
		$colHeadingFormat->setBold();
		$colHeadingFormat->setFontFamily('Arial');
		$colHeadingFormat->setSize('10');
		$colHeadingFormat->setColor(1);
		$colHeadingFormat->setFgColor(12);
		$colHeadingFormat->setAlign('center');
		$colHeadingFormat->setTextWrap();
	
		$$sheet->writeRow(0,0,$colNames,$colHeadingFormat);
		$$sheet->setColumn(0,50,10);				
		
		
		$rowformat =& $xls->addFormat();
		$rowformat1 =& $xls->addFormat();
		$rowformat2 =& $xls->addFormat();		
		//$rowformat->setTextWrap();
		
		$i = 1;					
		foreach( $query->result() as $row ){
			$j = 0;  
			$sales_tax = $row->sales_tax;
			$other_tax = $row->other_tax;
			$sales_tax_percent = $row->sales_tax_percent;
			
			if(  ($i%10001) == 0 && ($i != 1) ){
			
				$wxsheet++;				
				$i = 1;

				$sheet = 'sheet'.$wxsheet;
				$$sheet = &$xls->addWorksheet("Page ".$wxsheet);
				
				$$sheet->writeRow(0,0,$colNames,$colHeadingFormat);
				$$sheet->setColumn(0,50,10);	
								
			}	
			
			foreach( $row as $value ){
		
				$$sheet->writestring( $i, $j, " ".$value." ", $rowformat );
				$j++;
			}

			//details 
			$this->db->where('logid', $row->logid);
			$de_query = $this->db->get('refundlog_items');
			//echo $de_query->num_rows(); 
			if( $de_query->num_rows() > 0 ){
				$de_res = $de_query->result(); 
				$i++;
				
				$rowformat2->setColor(1);
				$rowformat2->setFgColor(4);				
				  
				$$sheet->writestring( $i, 2, "QTY ", $rowformat2 ); 	
				$$sheet->writestring( $i, 3, "Item # ", $rowformat2 ); 	
				$$sheet->writestring( $i, 4, "Description", $rowformat2 ); 	
				$$sheet->writestring( $i, 5, "Unit Price", $rowformat2 ); 	
				$$sheet->writestring( $i, 6, "Line Total", $rowformat2 ); 
					
				$rowformat1->setColor(3);
				$rowformat1->setFgColor(10);
				
				foreach( $de_res as $row ){
					$i++;	
					 
					$$sheet->writestring( $i, 2," ".$row->qty." ", $rowformat1 ); 	
					$$sheet->writestring( $i, 3, " ".$row->item_num." ", $rowformat1 ); 	
					$$sheet->writestring( $i, 4, " ".$row->description." ", $rowformat1 ); 	
					$$sheet->writestring( $i, 5, " ".$row->unit_price." ", $rowformat1 ); 	
					$$sheet->writestring( $i, 6, " ".$row->line_total." ", $rowformat1 ); 	
				
				}
				/* $$sheet->writestring( ++$i, 5," Sales Tax (".$sales_tax_percent.")", $rowformat1 ); 	
				$$sheet->writestring( $i, 6, ' '.$sales_tax.' ' , $rowformat1 ); 	
				$$sheet->writestring( ++$i, 5," Other Tax ", $rowformat1 ); 	
				$$sheet->writestring( $i, 6, ' '.$other_tax.' ' , $rowformat1 );  */	
				 	
				
			}			
			
			$i++;
		}

		$xls->close();
	
		$exreturn["name"] =  $name;
		$exreturn["filename"] =  $filename;
		
		 
		return  $exreturn;
	}	
	

}

?>