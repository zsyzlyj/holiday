<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Wage extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Wage';

        $this->load->model('model_wage');
        $this->load->model('model_users');
        $this->load->model('model_manager');
        $this->data['permission'] = $this->session->userdata('permission');
        $this->data['user_name'] = $this->session->userdata('user_name');
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
        echo $data;
        
		foreach ($data as $key => $value) {
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

        echo json_encode($result);
       /* */
	}
    /*
    ==============================================================================
    普通员工
    ==============================================================================
    */

    public function staff()
	{
        $user_id=$this->session->userdata('user_id');        
        $this->data['wage_data'] = $this->model_wage->getWageById($user_id);
		$this->render_template('wage/staff', $this->data);
    }

    public function mydeptwage()
    {
        $result=array();
        $user_id=$this->session->userdata('user_id');
        $this->data['current_dept']="";
        if($_POST){
            $select_dept=$_POST['selected_dept'];
            $wage_data = $this->model_wage->getWageByDept($select_dept);
            $result = array();
            foreach ($wage_data as $k => $v)
            {
                $result[$k] = $v;
            }

            $this->data['wage_data'] = $result;
            $this->data['current_dept']=$select_dept;

        }
        
        $admin_data = $this->model_manager->getManagerById($user_id);

        $admin_result=array();
        $admin_result=explode('/',$admin_data['dept']);

        $this->data['dept_options']=$admin_result;

        $this->data['wage_data'] = $result;
        
        
		$this->render_template('wage/mydeptwage', $this->data);
    }

}