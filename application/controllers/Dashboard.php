<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class dashboard extends Admin_Controller{
	public function __construct(){
        parent::__construct();
        $this->not_logged_in();
        $this->data['page_title'] = 'Dashboard';
	}
    public function index(){
        $this->data['user_name']=$this->session->userdata('user_name');
        $this->render_dashboard_template('dashboard',$this->data);
    }
}