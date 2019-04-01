<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class hr extends Admin_Controller{
	public function __construct(){
        parent::__construct();
        $this->not_logged_in();
        $this->data['page_title'] = 'Hr';
        $this->load->model('model_wage_tag');
        $this->data['permission'] = $this->session->userdata('permission');
        $this->data['user_name'] = $this->session->userdata('user_name');
        $this->data['user_id'] = $this->session->userdata('user_id');
        $this->data['service_mode']= $this->model_wage_tag->getModeById($this->session->userdata('user_id'))['service_mode'];
	}
    public function index(){
        $this->data['user_name']=$this->session->userdata('user_name');
        $this->render_super_template('hr/apply',$this->data);
    }
    
}