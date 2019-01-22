<?php 

class Users extends Admin_Controller{
	public function __construct(){
		parent::__construct();

		$this->not_logged_in();
		
		$this->data['page_title'] = 'Users';
		$this->load->model('model_wage_tag');
		$this->load->model('model_holiday_manager');
		$this->load->model('model_holiday');
		$this->data['permission']=$this->session->userdata('permission');
		$this->data['user_name'] = $this->session->userdata('user_name');
		$this->data['user_id'] = $this->session->userdata('user_id');
	}
	
	public function index(){
		$user_data = $this->model_holiday_users->getUserData();

		$holiday = $this->model_holiday->getHolidayData();

		$result = array();
		
		foreach ($user_data as $k => $v){
			$result[$k] = $v;
			foreach($holiday as $a => $b){
				if($b['name'] == $v['username'] )
				{
					$result[$k]['dept']=$b['department'];
				}
			}
			if($v['permission']==0){
				$result[$k]['permission']='超级管理员';
			}
			if($v['permission']==1){
				$result[$k]['permission']='部门经理';
			}
			if($v['permission']==2){
				$result[$k]['permission']='综合管理员';
			}
			if($v['permission']==3){
				$result[$k]['permission']='普通员工';
			}
		}
		$permission_set=array(
			1 => '部门经理',
			2 => '综合管理员',
			3 => '普通员工'
		);

		
		
		$this->data['user_data'] = $result;
		$this->data['permission_set']=$permission_set;
		
		$this->render_template('users/index', $this->data);
	}

	public function password_hash($pass = ''){
		if($pass){
			$password = password_hash($pass, PASSWORD_DEFAULT);
			return $password;
		}
	}
	
	public function delete($id){
		if($id){
			if($this->input->post('confirm')){

					$delete = $this->model_holiday_users->delete($id);
					
					if($delete == true){
		        		$this->session->set_flashdata('success', '用户删除成功');
		        		redirect('users/', 'refresh');
		        	}
		        	else{
		        		$this->session->set_flashdata('error', '系统发生未知错误!!');
		        		redirect('users/delete/'.$id, 'refresh');
		        	}

			}	
			else{
				$this->data['user_id'] = $id;
				$this->render_template('users/delete', $this->data);
			}	
		}
	}
	public function profile(){
		$this->data['user_info']=$this->model_wage_tag->getTagById($this->data['user_id']);
		$this->render_template('users/profile', $this->data);
	}
}