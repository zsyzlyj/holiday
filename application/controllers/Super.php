
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Super extends Admin_Controller 
{

	public function __construct()
	{
        parent::__construct();
        $this->data['page_title'] = 'Super';
        $this->data['permission']=$this->session->userdata('permission');
        $this->data['user_name'] = $this->session->userdata('user_id');
    }
    public function index(){
        $this->render_super_template('super/index', $this->data);
    }
}