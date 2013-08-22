<?php

class Dashboard extends Controller {

	var $roleId = '';
	var $userId = '';
	var $centerId = '';
	
	function __construct() {
	
		parent::Controller();	
		
		$this->load->library('DX_Auth');	
		
		if ( !$this->dx_auth->is_logged_in() )
			redirect('auth/login', 'location');		
		
		$this->roleId = $this->session->userdata('DX_role_id');
		$this->userId = $this->session->userdata('DX_user_id');
		$this->centerId = $this->session->userdata('DX_center_id');		
	}
	
	function index(){
		/* $this->load->view('includes/header');
		$this->load->view('home');
		$this->load->view('includes/footer'); */
		redirect("dashboard/listing", "location");
	}
	

	function newlog(){
		
		$this->load->model('supplier');
		$this->load->model('brand');
		$this->load->model('states');
		
		/*if( isset($_POST["savebtn"]) ){
			
			$pData['user_id'] 			= $this->userId;
			//trim($this->input->post("custfname")).substr(trim($this->input->post("custlname")), 0, 1)
			$pData['supplier_num']		= $this->input->post("supplier");
			$pData['supplier_site_num'] = $this->input->post("sup_site_num");
			$pData['address_line1'] 	= $this->input->post("custfname").' '.$this->input->post("custlname");
			$pData['address_line2'] 	= $this->input->post("addr_line2");
			$pData['address_line3'] 	= $this->input->post("addr_line3");
			$pData['city'] 				= $this->input->post("city");
			$pData['state'] 			= $this->input->post("state");
			$pData['zip'] 				= $this->input->post("zip");
			$pData['country'] 			= $this->input->post("country");
			$pData['invoice_num'] 		= $this->input->post("inv_num");
			$pData['invoice_date'] 		= $this->input->post("inv_date");
			$pData['invoice_amount'] 	= $this->input->post("inv_amnt");
			$pData['invoice_descer'] 	= $this->input->post("inv_descer");
			$pData['brand'] 			= $this->input->post("brand");
			$pData['gl_account'] 		= $this->input->post("glaccount");			
			$pData['reason'] 			= $this->input->post("reason");			
			
			if( $this->db->insert('refundlog', $pData) ){
				redirect("dashboard/listing", "location");
			}
			//print_r($pData);
		}*/
		
		$data['supplier'] = $this->supplier->get()->result();
		$data['brand'] = $this->brand->get()->result();
		$data['states'] = $this->states->get()->result();
	
		$this->load->view('includes/header');
		$this->load->view('logs/new', $data);
		$this->load->view('includes/footer');	
	}
	
	function newtemp(){
	
		$this->load->model('supplier');
		$this->load->model('brand');
		$this->load->model('states');
		
		$data['supplier'] = $this->supplier->get()->result();
		$data['brand'] = $this->brand->get()->result();
		$data['states'] = $this->states->get()->result();
	
		$data["hTitle"] = "Create New Log";
		
		$this->load->view('includes/header');
		$this->load->view('logs/new2', $data);
		$this->load->view('includes/footer');	
		
	}
	
	function listing(){
		$this->load->model("LogStatus", "logs");	
		
		$data["logstatus"] = $this->logs->get()->result();
		
		$this->load->view('includes/header');
		$data["isAudit"]=false;
		
		
		if( $this->roleId == 5 ){
		
			$this->load->view('logs/listing_vewonly', $data);
		}else{
		$this->load->view('logs/listing', $data);
		}
		/* if( $this->roleId == 3 ){
			$this->load->view('logs/listing');
		}else{
			//if( $this->roleId == 4)
				$data["isAudit"] = true;
				
				
			$this->load->view('logs/listing2', $data);
		} */
		
		
		$this->load->view('includes/footer');
		
	}
	
	function update(){
		
		if ($this->dx_auth->is_logged_in() AND $this->session->userdata('DX_role_id') != 5){
		
		$id = $this->uri->segment(3);
	
		$this->load->model("refund");
		$this->load->model("supplier");
		$this->load->model("brand");
		$this->load->model("ItemCategory", "items");
		$this->load->model("LogStatus", "logs");		
		$this->load->model('states');
		
		
		$data["refund"] = $this->refund->getRefund_by_id($id)->row();
		$data["refundItems"] = $this->refund->getRefundItem_by_id($id)->result();

		$data["supplier"] = $this->supplier->get()->result();
		$data["brand"] = $this->brand->get()->result();
		
		$data["itemsCat"] = $this->items->get()->result();
		$data["logs"] = $this->logs->get()->result();
		
		$data["states"] = $this->states->get()->result();
		
		$data["auditform"] = "";
		$data["isAudit"] = false;
		$data["hTitle"] = "Update";
		
		$this->load->view('includes/header');
		$this->load->view('logs/update', $data);
		$this->load->view('includes/footer');	
		
		}else{
			redirect('dashboard/', 'location');
		}
	}
	
	function viewonly(){
		
		$id = $this->uri->segment(3);
	
		$this->load->model("refund");
		$this->load->model("supplier");
		$this->load->model("brand");
		$this->load->model("ItemCategory", "items");
		$this->load->model("LogStatus", "logs");		
		$this->load->model('states');
		
		
		$data["refund"] = $this->refund->getRefund_by_id($id)->row();
		$data["refundItems"] = $this->refund->getRefundItem_by_id($id)->result();

		$data["supplier"] = $this->supplier->get()->result();
		$data["brand"] = $this->brand->get()->result();
		
		$data["itemsCat"] = $this->items->get()->result();
		$data["logs"] = $this->logs->get()->result();
		
		$data["states"] = $this->states->get()->result();
		
		$data["auditform"] = "";
		$data["isAudit"] = false;
		$data["hTitle"] = "Update";
		
		$this->load->view('includes/header');
		$this->load->view('logs/view_only', $data);
		$this->load->view('includes/footer');	
	}
	
	function audit(){
		
		$id = $this->uri->segment(3);
	
		$this->load->model("refund");
		$this->load->model("supplier");
		$this->load->model("brand");
		$this->load->model("ItemCategory", "items");
		$this->load->model("LogStatus", "logs");		
		$this->load->model('states');
		
		
		$data["refund"] = $this->refund->getRefund_by_id($id)->row();
		$data["refundItems"] = $this->refund->getRefundItem_by_id($id)->result();

		$data["supplier"] = $this->supplier->get()->result();
		$data["brand"] = $this->brand->get()->result();
		$data["itemsCat"] = $this->items->get()->result();
		$data["states"] = $this->states->get()->result();
		
		$logs["logs"] = $this->logs->get()->result();
		$data["auditform"] = $this->load->view('logs/audit_form', $logs, true);
		$data["isAudit"] = true;
		$data["hTitle"] = "Audit";
		
		$this->load->view('includes/header');
		$this->load->view('logs/update', $data);
		$this->load->view('includes/footer');	
	}
	
	function printable(){
	
	
		$id = $this->uri->segment(3);
	
		$this->load->model("refund");
		$this->load->model("supplier");
		$this->load->model("brand");
		$this->load->model("ItemCategory", "items");
		$this->load->model("LogStatus", "logs");		
		$this->load->model('states');
		
		
		$data["refund"] = $this->refund->getRefund_by_id($id)->row();
		$data["refundItems"] = $this->refund->getRefundItem_by_id($id)->result();

		$data["supplier"] = $this->supplier->get()->result();
		$data["brand"] = $this->brand->get()->result();
		
		$data["itemsCat"] = $this->items->get()->result();
		$data["logs"] = $this->logs->get()->result();
		
		$data["states"] = $this->states->get()->result();
		
		$data["auditform"] = "";
		$data["isAudit"] = false;
		$data["hTitle"] = "Update";
		
		//$this->load->view('includes/header');
		$this->load->view('logs/printtable2', $data);
		//$this->load->view('includes/footer');	
		
	}
	
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/dashboard.php */