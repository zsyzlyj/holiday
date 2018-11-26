<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Admin_Controller 
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_auth');
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

	public function login()
	{

		$this->logged_in();
		#echo $_SERVER['PHP_SELF']."<br>"; 
		$this->form_validation->set_rules('user_id', 'user_id', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == TRUE) {
            // true case
           	$id_exists = $this->model_auth->check_id($this->input->post('user_id'));
           	if($id_exists == TRUE) {
           		$login = $this->model_auth->login($this->input->post('user_id'), $this->input->post('password'));
           		if($login) {
					#echo $login['username'];
           			$logged_in_sess = array(
						'user_name' => $login['username'],
						'user_id' => $login['user_id'],
						'permission' => $login['permission'],
				        'logged_in' => TRUE
					);
					$this->session->set_userdata($logged_in_sess);
					#$this->session->set_userdata('unnn', $login['username']);
					switch($login['permission']){
						case 1:
							redirect('holiday/admin', 'refresh');
							break;
						case 2:
							redirect('holiday/manager', 'refresh');
							break;
						case 3:	
							redirect('holiday/staff', 'refresh');
							break;	
					}

           		}
           		else {
           			$this->data['errors'] = 'Incorrect id/password combination';
           			$this->load->view('login', $this->data);
           		}
           	}
           	else {
           		$this->data['errors'] = 'Id does not exists';

           		$this->load->view('login', $this->data);
           	}	
        }
        else {
            // false case
            $this->load->view('login');
        }	
	}

	/*
		清除session，退出
		
	*/
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('auth/login', 'refresh');
	}
}