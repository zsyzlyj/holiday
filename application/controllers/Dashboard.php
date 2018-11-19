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
		跳转到主页，目前的主页是年假的列表，后续修改可能是另外一个dashboard，这里暂时
	*/
	public function index()
	{

		$user_id = $this->session->userdata('id');
		$this->data['user_permission']=$this->session->userdata('user_permission');;
		#$this->data['user_id']=$user_id;
		#$holiday_data = $this->model_holiday->getHolidayData();
		$result = array();

		$this->data['user_permission']=$this->session->userdata('user_permission');;

		#$this->data['holiday_data'] = $result;

		$this->render_template('dashboard', $this->data);
		#$this->render_template('holiday/index', $this->data);

	}
}