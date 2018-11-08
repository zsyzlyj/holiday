<?php 

class Dashboard extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Dashboard';

		$this->load->model('model_holiday');

	}

	/* 
	* It only redirects to the manage category page
	* It passes the total product, total paid orders, total users, and total stores information
	into the frontend.
	*/
	public function index()
	{
		$user_id = $this->session->userdata('id');
		$this->data['user_permission']=$this->session->userdata('user_permission');;
		$this->data['user_id']=$user_id;
		$holiday_data = $this->model_holiday->getHolidayData();
		$result = array();

		$this->data['user_permission']=$this->session->userdata('user_permission');;

		$this->data['holiday_data'] = $result;

		#$this->render_template('dashboard', $this->data);
		$this->render_template('holiday/index', $this->data);

	}
}