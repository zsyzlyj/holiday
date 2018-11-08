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
		Check if the login form is submitted, and validates the user credential
		If not submitted it redirects to the login page
	*/
	public function login()
	{

		$this->logged_in();

		$this->form_validation->set_rules('user_id', 'user_id', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == TRUE) {
            // true case
           	$id_exists = $this->model_auth->check_id($this->input->post('user_id'));

           	if($id_exists == TRUE) {
           		$login = $this->model_auth->login($this->input->post('user_id'), $this->input->post('password'));
				#echo $login['user_id'];
				echo $login['permission'];
           		if($login) {
           			$logged_in_sess = array(
						'user_id' => $login['user_id'],
						'user_permission' => $login['permission'],
						#'permission' => $login['permission'],
				        'logged_in' => TRUE
					);

					$this->session->set_userdata($logged_in_sess);
					switch($login['permission']){
						case -1:
						case 0:
						case 1:
							redirect('holiday/index', 'refresh');
							break;
						case 2:
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
		clears the session and redirects to login page
	*/
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('auth/login', 'refresh');
	}
}