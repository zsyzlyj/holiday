<?php 

class Dashboard extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Dashboard';

		$this->load->model('model_holiday');
		permission=$this->session->userdata('permission');;
		$this->data['user_name'] = $this->session->userdata('user_name');

	}

	/* 
		跳转到主页，目前的主页是年假的列表，后续修改可能是另外一个dashboard，这里暂时
	*/
	public function index()
	{

		$user_id = $this->session->userdata('id');

		$result = array();
		$this->render_template('dashboard', $this->data);

	}
}