<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class dashboard extends Admin_Controller{
	public function __construct(){
		parent::__construct();
	}
    public function index(){
        $this->data['user_name']=$this->session->userdata('user_name');
        $this->render_dashboard_template('dashboard',$this->data);
    }
}