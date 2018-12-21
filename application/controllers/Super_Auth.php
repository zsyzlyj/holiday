<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Super_Auth extends Admin_Controller 
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_super_auth');
		$this->load->model('model_super_user');
		$this->data['permission']=$this->session->userdata('permission');
		$this->data['user_id'] = $this->session->userdata('user_id');
		$this->data['user_name'] = $this->session->userdata('user_id');
	}

	/* 
		查看登录的表格是否正确，主要是检查user_id和password是否和数据库的一致
		根据数据库中的permission设置permission，根据permission确定不同用户登录后界面上的功能
		permission的值不同分别跳转：
		0——超级管理员,index
		1——综管员,admin
		2——部门负责人，manager
		3——普通员工,staff
	*/

	public function index(){
		$this->login();
	}
	public function login()
	{
		$this->logged_in_super();

		$this->form_validation->set_rules('user_id', 'user_id', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == TRUE) {
            // true case
           	$id_exists = $this->model_super_auth->check_id($this->input->post('user_id'));
           	if($id_exists == TRUE) {
           		$login = $this->model_super_auth->login($this->input->post('user_id'), $this->input->post('password'));
           		if($login) {
					$log=array(
						'user_id' => $login['user_id'],
						'username' => $login['user_id'],
						'login_ip' => $_SERVER["REMOTE_ADDR"],
						'staff_action' => 'holiday_log_in',
						'action_time' => date('Y-m-d H:i:s')
					);
					$this->model_log_action->create($log);
           			$logged_in_sess = array(
						'user_id' => $login['user_id'],
						'permission' => $login['permission'],
				        'logged_in_super' => TRUE
					);
					$this->session->set_userdata($logged_in_sess);
					switch($login['permission']){
						case '工资':
							redirect('super_wage/index', 'refresh');
							break;
						case '休假':
							redirect('super_holiday/index', 'refresh');
							break;
						default:
							break;
					}

           		}
           		else {
           			$this->data['errors'] = 'Incorrect id/password combination';
           			$this->load->view('super/login', $this->data);
           		}
           	}
           	else {
           		$this->data['errors'] = 'Id does not exists';

           		$this->load->view('super/login', $this->data);
           	}	
        }
        else {
            // false case
            $this->load->view('super/login');
        }	
	}

	/*
		清除session，退出
		
	*/
	public function logout()
	{
		if(array_key_exists('user_id', $this->data)){
			if($this->data['user_id']==NULL){
				$this->session->sess_destroy();
				redirect('super_auth/login', 'refresh');
			}
		}
		else{
			$this->session->sess_destroy();
			redirect('super_auth/login', 'refresh');
		}
		$log=array(
			'user_id' => $this->data['user_id'],
			'username' => $this->data['user_name'],
			'login_ip' => $_SERVER["REMOTE_ADDR"],
			'staff_action' => 'super_log_out',
			'action_time' => date('Y-m-d H:i:s')
		);
		$this->model_log_action->create($log);
		$this->session->sess_destroy();
		redirect('super_auth/login', 'refresh');
	}
	public function holiday_setting(){
		$this->setting('holiday');
	}
	public function wage_setting(){
		$this->setting('wage');
	}
	/*
    ============================================================
    用户密码修改
    ============================================================
    */ 
    public function setting($type=NULL)
	{
		
		$id = $this->session->userdata('user_id');
		if($id) {
			$this->form_validation->set_rules('username', 'username', 'trim|max_length[12]');

			if ($this->form_validation->run() == TRUE) {
	            // true case
		        if(empty($this->input->post('password')) && empty($this->input->post('cpassword'))) {
		        	$data = array(
		        		'username' => $this->input->post('username'),
					);
					$update = $this->model_super_user->edit($data, $id);
		        	
		        	if($update == true) {
		        		$this->session->set_flashdata('success', 'Successfully updated');
		        		redirect('super_auth/setting/', 'refresh');
		        	}
		        	else {
		        		$this->session->set_flashdata('errors', 'Error occurred!!');
		        		redirect('super_auth/setting/', 'refresh');
		        	}
		        }
		        else {
					$this->form_validation->set_rules('password', 'Password', 'trim|required');
					$this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|matches[password]');

					if($this->form_validation->run() == TRUE) {

						$password = md5($this->input->post('password'));

						$data = array(
			        		'username' => $this->input->post('username'),
			        		'password' => $password,
			        	);

						$update = $this->model_super_user->edit($data, $id);
						
			        	if($update == true) {
			        		$this->session->set_flashdata('success', 'Successfully updated');
			        		redirect('super_auth/setting/', 'refresh');
			        	}
			        	else {
			        		$this->session->set_flashdata('errors', 'Error occurred!!');
			        		redirect('super_auth/setting/', 'refresh');
			        	}
					}
			        else {
						// false case
						$user_data = $this->model_super_user->getUserData($id);

			        	$this->data['user_data'] = $user_data;

						$this->render_super_template('super/setting', $this->data);	
			        }	

		        }
	        }
	        else {
	            // false case
	        	$user_data = $this->model_super_user->getUserData($id);
	        	$this->data['user_data'] = $user_data;
				$this->render_super_template('super/setting', $this->data);	
	        }	
		}
    }	
}