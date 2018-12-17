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
		permission=$this->session->userdata('permission');
		$this->data['user_name'] = $this->session->userdata('user_name');
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
		$reset=false;
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
			if(!$reset){
				$User_default=array(
					'permission' => 3
				);
				$user=$this->model_users->getUserData();
				foreach ($user as $c => $d){
					$this->model_users->update($User_default,$user_id);
				}
				$reset=true;
			}
			$update_user=false;
            if($this->model_manager->getManagerbyID($user_id))
            {
				$update=$this->model_manager->update($Update_data,$user_id);
            }
            else{
				$update=$this->model_manager->create($Update_data);
            }
            if($Update_data['role']=='超级管理员'){
				$permission=0;
			}
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
            if($update == true and $update_user== true) {
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
		
		$this->render_template('manager/import', $this->data);
	}

}