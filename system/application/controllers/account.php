<?php

class Account extends Controller {

	function __construct(){
		parent::Controller();	
		
		$this->load->library('DX_Auth');
		
		if ( !$this->dx_auth->is_logged_in() )
			redirect('auth/login', 'location');
			
		$this->roleId = $this->session->userdata('DX_role_id');
		$this->userId = $this->session->userdata('DX_user_id');
		$this->centerId = $this->session->userdata('DX_center_id');
		
			
	}
	
	function index(){
		$this->listing();
	}
	
	function newaccount(){
		
		if ($this->dx_auth->is_logged_in() AND $this->session->userdata('DX_role_id') != 3 AND $this->session->userdata('DX_role_id') != 5){
		
			$this->load->model("Centers","center");
		
			$data["centers"] = $this->center->getCenter()->result();
		
			$this->load->view('includes/header');
			$this->load->view('accounts/new', $data);
			$this->load->view('includes/footer');	
		
		}else{
			redirect('dashboard/', 'location');
		}
	}
	
	function listing(){
		
		if ($this->dx_auth->is_logged_in() AND $this->session->userdata('DX_role_id') != 3){
			$this->load->view('includes/header');
			$this->load->view('accounts/listing');
			$this->load->view('includes/footer');		
		}else{
			redirect('dashboard/', 'location');
		}
	}
	
	function changepassword(){
	
		$this->load->model("dx_auth/users","users");

		if( isset($_POST["changepassbtn"]) ){
			
			$upData['password'] = trim($this->input->post('newpassword'));
			
			$this->users->set_user($this->userId, $upData);
		}		
		
		$data["info"] = $this->users->get_user_by_id($this->userId)->row();
		
		$this->load->view('includes/header');
		$this->load->view('accounts/changepass', $data);
		$this->load->view('includes/footer');		
		
		
	}
	
	function update(){
		
		if ($this->dx_auth->is_logged_in() AND $this->session->userdata('DX_role_id') != 3){
		
			$this->load->model("Centers","center");
			$this->load->model("dx_auth/users","users");
			
			$data["centers"] = $this->center->getCenter()->result();			
			
			$id = $this->uri->segment(3);
			$data["users"] = $this->users->get_user_by_id($id)->row();
				
			$this->load->view('includes/header');
			$this->load->view('accounts/update', $data);
			$this->load->view('includes/footer');	
			
		}else{
			redirect('dashboard/', 'location');
		}
	}
	
	function delete(){
		if ($this->dx_auth->is_logged_in() AND $this->session->userdata('DX_role_id') != 3){
			
			$id = $this->uri->segment(3);
			
			if( $id != "" ){
				
				$data["banned"] = 1;				
				$this->db->where("id", $id);
				
				if( $this->db->update("users", $data) ){
					
					redirect('account/', 'location');
					
				}
				
			}
				
		}else{
			redirect('dashboard/', 'location');
		}
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/account.php */