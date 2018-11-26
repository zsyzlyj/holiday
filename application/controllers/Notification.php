<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in_super();

        $this->data['page_title'] = 'Notification';
        
		$this->load->model('model_notice');
		permission=$this->session->userdata('permission');
		$this->data['user_name']=$this->session->userdata('user_name');
    }
    public function index()
    {
        $notice_data = $this->model_notice->getNoticeData();

		$result = array();
		
		foreach ($notice_data as $k => $v) {
			$result[$k] = $v;
		}
		
		$this->data['notice_data'] = $result;
		
        $this->render_super_template('notification/index', $this->data);
    }
    public function publish_holiday()
    {
		
		$this->form_validation->set_rules('title', 'title', 'required');
		$this->form_validation->set_rules('content', 'content', 'required');
		
        if ($this->form_validation->run() == TRUE) {
            // true case
			$title=$this->input->post('title');
			$content=$this->input->post('content');
        	$data = array(
				'pubtime' => date('Y-m-d H:i:s'),
				'username' => $this->session->userdata('user_id'),
        		'title' => $this->input->post('title'),
				'content' => $this->input->post('content'),
				'type' => '假期'
			);
			echo $data['pubtime'];
			$create = $this->model_notice->create($data);
        	if($create == true) {
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('notification/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('notification/publish_holiday', 'refresh');
        	}

        }
        else {
            // false case
			$notice_data = $this->model_notice->getNoticeData();

			$result = array();
			
			foreach ($notice_data as $k => $v) {
				$result[$k] = $v;
			}
			$this->data['notice_data'] = $result;
            $this->render_super_template('notification/publish_holiday', $this->data);
        }	
	}
	public function publish_plan()
    {
		
		$this->form_validation->set_rules('title', 'title', 'required');
		$this->form_validation->set_rules('content', 'content', 'required');
		
        if ($this->form_validation->run() == TRUE) {
            // true case
			$title=$this->input->post('title');
			$content=$this->input->post('content');
        	$data = array(
				'pubtime' => date('Y-m-d H:i:s'),
				'username' => $this->session->userdata('user_id'),
        		'title' => $this->input->post('title'),
				'content' => $this->input->post('content'),
				'type' => '计划'
			);
			echo $data['pubtime'];
			$create = $this->model_notice->create($data);
        	if($create == true) {
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('notification/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('notification/publish', 'refresh');
        	}

        }
        else {
            // false case
			$notice_data = $this->model_notice->getNoticeData();

			$result = array();
			
			foreach ($notice_data as $k => $v) {
				$result[$k] = $v;
			}
			$this->data['notice_data'] = $result;
            $this->render_super_template('notification/publish_plan', $this->data);
        }
	}
}