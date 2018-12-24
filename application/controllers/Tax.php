<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tax extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
        $this->data['page_title'] = 'Super';
        $this->load->model('model_holiday');
        $this->load->model('model_holiday_doc');
        $this->load->model('model_plan');
        $this->load->model('model_notice');
        $this->load->model('model_manager');
        $this->load->model('model_holiday_users');
        $this->load->model('model_feedback'); 
        $this->data['permission']=$this->session->userdata('permission');
        $this->data['user_name'] = $this->session->userdata('user_id');
	}

	public function index(){
        $this->render_super_template('super/tax',$this->data);
    }
}