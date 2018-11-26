<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Super extends Admin_Controller 
{

	public function __construct()
	{
		parent::__construct();
    }

    public function wage(){
        $this->data['permission']=$this->session->userdata('permission');
        $this->data['user_name'] = $this->session->userdata('user_id');
        $this->render_super_template('super/wage',$this->data);
    }
    
    public function holiday(){
        $this->data['permission']=$this->session->userdata('permission');
        $this->data['user_name'] = $this->session->userdata('user_id');
        $this->render_super_template('super/holiday',$this->data);
    }
    public function achievement (){
        $this->data['permission']=$this->session->userdata('permission');
        $this->data['user_name'] = $this->session->userdata('user_id');
        $this->render_super_template('super/achievement',$this->data);
    }
}