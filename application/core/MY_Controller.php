<?php 

class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
}

class Admin_Controller extends MY_Controller 
{
	var $permission = array();

	public function __construct() 
	{
		parent::__construct();
		if(empty($this->session->userdata('logged_in_super'))){
			$session_data = array('logged_in_super' => FALSE);
			$this->session->set_userdata($session_data);
		}
		else{
			$user_id = $this->session->userdata('user_id');
			$this->load->model('model_super_user');
			$user_data = $this->model_super_user->getUserById($user_id);
			$this->data['permission'] = $user_data['permission'];
		}
		if(empty($this->session->userdata('logged_in'))){
			$session_data = array('logged_in' => FALSE);
			$this->session->set_userdata($session_data);
		}
		else{
			$user_id = $this->session->userdata('user_id');
			$this->load->model('model_users');
			$user_data = $this->model_users->getUserById($user_id);
			$this->data['permission'] = $user_data['permission'];
		}
		$this->load->model('model_log_action');
		#$this->session->set_flashdata('success', '');
		#$this->session->set_flashdata('error', '');
	}
	public function logged_in_super(){
		$session_data = $this->session->userdata();
		if($session_data['logged_in_super'] == TRUE){
			if($session_data['permission'] == '工资'){              
				redirect('super_wage/index', 'refresh');
			}
			elseif($session_data['permission'] == '休假'){              
				redirect('super_holiday/index', 'refresh');
			}
			elseif($session_data['permission'] == '人员'){              
				redirect('super_hr/index', 'refresh');
			}
		}
	}
	public function not_logged_in_super(){
		$session_data = $this->session->userdata();
		if($session_data['logged_in_super'] == FALSE){
			redirect('super_auth/login', 'refresh');
		}
	}
	public function logged_in(){
		$session_data = $this->session->userdata();
		if($session_data['logged_in'] == TRUE){
			redirect('dashboard', 'refresh');
		}
	}
	public function not_logged_in(){
		$session_data = $this->session->userdata();
		if($session_data['logged_in'] == FALSE){
			redirect('login', 'refresh');
		}
	}
	
	public function render_template($page = null, $data = array()){
		$this->load->view('templates/header',$data);
		$this->load->view('templates/header_menu',$data);
		$this->load->view('templates/side_menubar',$data);
		$this->load->view($page, $data);
		$this->load->view('templates/footer',$data);
	}
	public function render_super_template($page = null, $data = array()){

		$this->load->view('templates/super_header',$data);
		$this->load->view('templates/super_header_menu',$data);
		$this->load->view('templates/super_side_menubar',$data);
		$this->load->view($page, $data);
		$this->load->view('templates/super_footer',$data);
	}
	public function render_dashboard_template($page = null, $data = array()){
		$this->load->view('templates/dashboard_header',$data);
		$this->load->view('templates/dashboard_header_menu',$data);
		$this->load->view($page, $data);
		$this->load->view('templates/footer',$data);
	}
}