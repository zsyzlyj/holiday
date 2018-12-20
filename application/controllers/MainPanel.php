<?php 

class Function_module extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->holiday_not_logged_in();

		$this->data['page_title'] = '模块选择';

		#$this->load->model('model_holiday');

	}

	/* 
		跳转到主页，目前的主页是年假的列表，后续修改可能是另外一个dashboard，这里暂时
	*/
	public function index()
	{
        #$this->load->view('functionboard', $this->data);
        #$this->redirect('functionboard','refresh');
		

	}
}