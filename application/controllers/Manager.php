<?php 

class Manager extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();
		
		$this->data['page_title'] = 'Managers';
		
		$this->load->model('model_manager');
		$this->load->model('model_users');
	}

	
	public function index()
	{
		$manager_data = $this->model_manager->getManagerData();
		$result = array();
		
		foreach ($manager_data as $k => $v) {
			$result[$k] = $v;
		}
		$permission_set=array(
			0 => '超级管理员',
			1 => '部门经理',
			2 => '综合管理员',
			3 => '普通员工'
		);

		
		$this->data['user_permission']=$this->session->userdata('user_permission');

		$this->data['manager_data'] = $result;
		$this->data['permission_set']=$permission_set;
		$this->render_template('manager/index', $this->data);
	}
	public function excel_put(){
        
        $this->load->library("phpexcel");//ci框架中引入excel类
        $this->load->library('PHPExcel/IOFactory');
        //先做一个文件上传，保存文件
        $path=$_FILES['file'];
        $filePath = "uploads/".$path["name"];

        move_uploaded_file($path["tmp_name"],$filePath);
        //根据上传类型做不同处理
        
        if (strstr($_FILES['file']['name'],'xlsx')) {
            $reader = new PHPExcel_Reader_Excel2007();
        }
        else{
            if (strstr($_FILES['file']['name'], 'xls')) {
                $reader = IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)
            }
        }

        $PHPExcel = $reader->load($filePath, 'utf-8'); // 载入excel文件
        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumm = $sheet->getHighestColumn(); // 取得总列数

        $data = array();
        for ($rowIndex = 1; $rowIndex <= $highestRow; $rowIndex++) {        //循环读取每个单元格的内容。注意行从1开始，列从A开始
            for ($colIndex = 'A'; $colIndex <= $highestColumm; $colIndex++) {
                $addr = $colIndex . $rowIndex;
                $cell = $sheet->getCell($addr)->getValue();
                if ($cell instanceof PHPExcel_RichText) { //富文本转换字符串
                    $cell = $cell->__toString();
                }
                $data[$rowIndex][$colIndex] = $cell;
            }
        }

        $column=array();
        $column_name=array();
        $attribute_data=array();
        $first=true;
        $flag=false;
		$counter=0;
		$user_id="";
        $name="";
        $dept="";
        
        foreach($data as $k => $v){
            if($first){
                $first=false;
                foreach($v as $a =>$b){
                    array_push($column_name,$b);
                }
            }
            else{
                array_push($column,$v);
            }
        }
        $initflag=0;
        foreach($column as $k => $v)
        {
            foreach($v as $a => $b)
            {
                switch($a){
                    case 'A':$name=$b;break;
                    case 'B':$user_id=$b;break;
					case 'C':$dept=$b;break;
					case 'D':$role=$b;break;
                }
            }
            
            $Update_data=array(
				'user_id' => $user_id,
                'name' => $name,
				'dept' => $dept,
				'role' => $role
			);
			$User_default=array(
				'permission' => 3
			);
			$user=$this->model_users->getUserData();
			foreach ($user as $c => $d){

				$this->model_users->update($User_default,$user_id);
			}
			$update_user=false;
            if($this->model_manager->getManagerbyID($user_id))
            {
				$update=$this->model_manager->update($Update_data,$user_id);
				$update_user=true;
            }
            else{
				
				$update=$this->model_manager->create($Update_data);
				if($Update_data['role']=='综管员'){
					$permission=1;
				}
				if($Update_data['role']=='部门负责人'){
					$permission=2;
				}
				$Update_user=array(
					'permission' => $permission
				);
				
				$update_user=$this->model_users->update($Update_user,$user_id);
            }
            
            if($update == true) {
                $response['success'] = true;
                $response['messages'] = 'Succesfully updated';
            }
            else {
                $response['success'] = false;
                $response['messages'] = 'Error in the database while updated the brand information';			
            }
            
        }
    }
	public function import()
	{
		$this->data['user_permission'] = $this->session->userdata('user_permission');
        if($_FILES){
        if($_FILES["file"])
            {
                if ($_FILES["file"]["error"] > 0)
                {
                    echo "Error: " . $_FILES["file"]["error"] . "<br />";
                }
                else
                {
                    $this->excel_put();
                    $this->index();
                }
            }
        }
        else{
            $this->render_template('manager/import',$this->data);
		}        
		$this->data['user_permission']=$this->session->userdata('user_permission');
		$this->render_template('manager/import', $this->data);
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

        	$create = $this->model_users->create($data, $this->input->post('groups'));
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

	public function edit($id = null)
	{

		if ($this->form_validation->run() == TRUE) {
			// true case
			if(empty($this->input->post('password')) && empty($this->input->post('cpassword'))) {
				$data = array(
					'username' => $this->input->post('username'),
					#此处有修改
				);

				$update = $this->model_users->edit($data, $id, $this->input->post('groups'));
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

					$update = $this->model_users->edit($data, $id, $this->input->post('groups'));
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
					$manager_data = $this->model_users->getManagerData($id);

					$this->data['manager_data'] = $manager_data;


					$this->render_template('users/edit', $this->data);	
				}	

			}
		}
		else {
			// false case
			$manager_data = $this->model_users->getUserData($id);

			$this->data['manager_data'] = $manager_data;

			$this->render_template('users/edit', $this->data);	
		}
	}
	public function update()
	{

		$id=$_POST['user_id'];

		$manager_data=array(
			'permission' => $_POST['permit']
		);
		$this->model_users->update($manager_data,$id);
		
		$this->index();

	}
	public function delete($id)
	{

		if($id) {
			if($this->input->post('confirm')) {

					$delete = $this->model_users->delete($id);
					
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
}