<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Onpost extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->holiday_not_logged_in();

		$this->data['page_title'] = 'Wage';

        $this->load->model('model_wage');
        $this->load->model('model_holiday');
        $this->load->model('model_wage_doc');
        $this->load->model('model_holiday_users');
        $this->load->model('model_wage_tag');
        $this->data['permission'] = $this->session->userdata('permission');
        $this->data['user_name'] = $this->session->userdata('user_name');
        $this->data['user_id'] = $this->session->userdata('user_id');
	}
    
	public function index()
	{        
		$this->render_template('wage/', $this->data);
    }
    /*
    * It Fetches the products data from the product table 
    * this function is called from the datatable ajax function
    */
	public function fetchWageData()
	{
		$result = array('data' => array());

        $data = $this->model_wage->getWageData();
        
		foreach ($data as $key => $value){
			$result['data'][$key] = array(
				$value['name'],
				$value['indate'],
                $value['companyage'],
                $value['sumage'],
                $value['sumday'],
                $value['lastyear'],
                $value['thisyear'],
                $value['bonus'],
                $value['used'],
                $value['rest'],
            );
            console($result['data']['name']);
		} // /foreach
       /* */
	}
    public function apply_on_post_proof(){
        $this->data['submitted']=0;
        $this->render_template('onpost/apply', $this->data);
    }
}