<?php 

class Users extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->holiday_not_logged_in();
		
		$this->data['page_title'] = 'Users';
		
		$this->load->model('model_holiday_users');
		$this->load->model('model_wage_users');
		$this->load->model('model_holiday_manager');
		$this->load->model('model_holiday');
		$this->data['permission']=$this->session->userdata('permission');
		$this->data['user_name'] = $this->session->userdata('user_name');
	}
	
	public function index()
	{
		$user_data = $this->model_holiday_users->getUserData();

		$holiday = $this->model_holiday->getHolidayData();

		$result = array();
		
		foreach ($user_data as $k => $v) {
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

	public function create()
	{

		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]|is_unique[users.username]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
		$this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|matches[password]');


        if ($this->form_validation->run() == TRUE) {
            // true case
            $password = $this->password_hash($this->input->post('password'));
        	$data = array(
        		'username' => $this->input->post('username'),
        		'password' => $password,
        	);

        	$create = $this->model_holiday_users->create($data, $this->input->post('groups'));
        	if($create == true) {
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('users/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('users/create', 'refresh');
        	}
        }
        else {
            // false case

            $this->render_template('users/create', $this->data);
        }	

		
	}

	public function password_hash($pass = '')
	{
		if($pass) {
			$password = password_hash($pass, PASSWORD_DEFAULT);
			return $password;
		}
	}

	public function edit($id = null)
	{
		if ($this->form_validation->run() == TRUE) {
			// true case
			if(empty($this->input->post('password')) && empty($this->input->post('cpassword'))) {
				$data = array(
					'username' => $this->input->post('username'),
					#此处有修改
				);

				$update = $this->model_holiday_users->edit($data, $id, $this->input->post('groups'));
				if($update == true) {
					$this->session->set_flashdata('success', 'Successfully created');
					redirect('users/', 'refresh');
				}
				else {
					$this->session->set_flashdata('errors', 'Error occurred!!');
					redirect('users/edit/'.$id, 'refresh');
				}
			}
			else {
				$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
				$this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|matches[password]');

				if($this->form_validation->run() == TRUE) {

					$password = $this->password_hash($this->input->post('password'));

					$data = array(
						'username' => $this->input->post('username'),
						'password' => $password,
						'email' => $this->input->post('email'),
						'firstname' => $this->input->post('fname'),
						'lastname' => $this->input->post('lname'),
						'phone' => $this->input->post('phone'),
						'gender' => $this->input->post('gender'),
					);

					$update = $this->model_holiday_users->edit($data, $id, $this->input->post('groups'));
					if($update == true) {
						$this->session->set_flashdata('success', 'Successfully updated');
						redirect('users/', 'refresh');
					}
					else {
						$this->session->set_flashdata('errors', 'Error occurred!!');
						redirect('users/edit/'.$id, 'refresh');
					}
				}
				else {
					// false case
					$user_data = $this->model_holiday_users->getUserData($id);
					$groups = $this->model_holiday_users->getUserGroup($id);

					$this->data['user_data'] = $user_data;
					$this->data['user_group'] = $groups;

					$group_data = $this->model_groups->getGroupData();
					$this->data['group_data'] = $group_data;

					$this->render_template('users/edit', $this->data);	
				}	

			}
		}
		else {
			// false case
			$user_data = $this->model_holiday_users->getUserData($id);

			$this->data['user_data'] = $user_data;

			$this->render_template('users/edit', $this->data);	
		}
	}
	public function update()
	{
		$id=$_POST['user_id'];

		$user_data=array(
			'permission' => $_POST['permit']
		);
		$this->model_holiday_users->update($user_data,$id);
		$user=$this->model_holiday->getHolidayById($id);
		$role='普通员工';
		if($_POST['permit']==1){
			$role='综管员';
		}
		if($_POST['permit']==2){
			$role='部门负责人';
		}
		if($_POST['permit']==3){
			//如果这个角色被降级，那么就删除管理层角色表中的这个人
			$this->model_holiday_manager->delete($id);
		}
		else{
			$manager_data=array(
				'user_id' => $id,
				'name' => $user['name'],
				'dept' => $user['department'],
				'role' => $role
			);
			//更新管理层角色，如果角色存在，那么直接update，如果不存在，那么新建新的角色
			if($this->model_holiday_manager->getManagerById($id))
			{
				$this->model_holiday_manager->update($manager_data,$id);
			}
			else{
				$this->model_holiday_manager->create($manager_data,$id);
			}
		}
		$this->index();

	}
	public function delete($id)
	{

		if($id) {
			if($this->input->post('confirm')) {

					$delete = $this->model_holiday_users->delete($id);
					
					if($delete == true) {
		        		$this->session->set_flashdata('success', 'Successfully removed');
		        		redirect('users/', 'refresh');
		        	}
		        	else {
		        		$this->session->set_flashdata('error', 'Error occurred!!');
		        		redirect('users/delete/'.$id, 'refresh');
		        	}

			}	
			else {
				$this->data['user_id'] = $id;
				$this->render_template('users/delete', $this->data);
			}	
		}
	}

	public function profile()
	{
		$user_id = $this->session->userdata('user_id');
		
		$user_data = $this->model_holiday_users->getUserData($user_id);
		$this->data['user_data'] = $user_data;
        $this->render_template('users/profile', $this->data);
	}

	public function holiday_setting(){
		$this->setting('holiday');
	}
	public function wage_setting(){
		$this->setting('wage');
	}
	public function setting($type)
	{
		$id = $this->session->userdata('user_id');
		$this->data['user_name'] = $this->session->userdata('user_name');
		if($id) {
			$this->form_validation->set_rules('username', 'username', 'trim|max_length[12]');

			if ($this->form_validation->run() == TRUE) {
	            // true case
		        if(empty($this->input->post('password')) && empty($this->input->post('cpassword'))) {
					$this->session->set_flashdata('errors', '修改失败，新密码不能为空');
					if($type=='holiday')
						redirect('users/holiday_setting', 'refresh');
					if($type=='wage')
						redirect('users/wage_setting', 'refresh');
		        }
		        else {
					$this->form_validation->set_rules('password', 'Password', 'trim|required');
					$this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|matches[password]');

					if($this->form_validation->run() == TRUE) {

						$password = md5($this->input->post('password'));

						$data = array(
			        		'username' => $this->input->post('username'),
			        		'password' => $password,
			        	);
						if($type=='holiday')
							$update = $this->model_holiday_users->edit($data, $id);
						if($type=='wage')
							$update = $this->model_wage_users->edit($data, $id);
						
			        	if($update == true) {
			        		$this->session->set_flashdata('success', 'Successfully updated');
			        		redirect('users/'.$type.'_setting/', 'refresh');
			        	}
			        	else {
			        		$this->session->set_flashdata('errors', 'Error occurred!!');
			        		redirect('users/'.$type.'_setting/', 'refresh');
			        	}
					}
			        else {
						// false case
						redirect('users/'.$type.'_setting', 'refresh');
			        }

		        }
	        }
	        else {
				// false case
				if($type=='holiday')
	        		$user_data = $this->model_holiday_users->getUserData($id);
				if($type=='wage')
					$user_data = $this->model_wage_users->getUserData($id);
				$this->data['user_data'] = $user_data;
	        	

				$this->render_template('users/setting', $this->data);	
	        }	
		}
	}


}