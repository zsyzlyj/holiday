<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

        $this->data['page_title'] = 'Notification';
        
        $this->load->model('model_notice');
    }
    public function index()
    {
        $notice_data = $this->model_notice->getNoticeData();

		$result = array();
		
		foreach ($notice_data as $k => $v) {
			$result[$k] = $v;
		}
		$this->data['user_permission']=$this->session->userdata('user_permission');

		$this->data['notice_data'] = $result;
		
        $this->render_template('notification/index', $this->data);
    }
    public function publish()
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
			$this->data['user_permission']=$this->session->userdata('user_permission');
			$this->data['notice_data'] = $result;
            $this->render_template('notification/publish', $this->data);
        }	
		$this->render_template('notification/publish', $this->data);
	}
}