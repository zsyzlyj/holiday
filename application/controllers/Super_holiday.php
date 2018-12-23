<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Super_holiday extends Admin_Controller 
{

	public function __construct()
	{
        parent::__construct();
        $this->data['page_title'] = 'Super';
        $this->load->model('model_holiday');
        $this->load->model('model_holiday_doc');
        $this->load->model('model_plan');
        $this->load->model('model_notice');
        $this->load->model('model_manager');
        $this->load->model('model_holiday_users');
        $this->load->model('model_feedback'); 
        $this->data['permission']=$this->session->userdata('permission');
        $this->data['user_name'] = $this->session->userdata('user_id');
    }
    /*
    ============================================================
    休假管理
    包括：
    1、主页，休假汇总
    2、
    ============================================================
    */ 
    public function index(){
        $this->holiday();
    }
    public function holiday(){
        $this->data['holiday_data'] = $this->model_holiday->getHolidayData();
        $this->data['permission'] = $this->session->userdata('permission');
        $this->data['user_name'] = $this->session->userdata('user_id');
        $this->render_super_template('super/holiday',$this->data);
    }
    public function holiday_doc_put(){
        //先做一个文件上传，保存文件
        $path=$_FILES['file'];
        $filePath = "uploads/".$path["name"];
        move_uploaded_file($path["tmp_name"],$filePath);
        $doc_data=array(
            'number' => date('Y-m-d H:i:s'),
            'doc_name' => basename($filePath,".pdf"),
            'doc_path' => $filePath,
        );
        $this->model_holiday_doc->create($doc_data);
        
    }
    public function holiday_doc_import($filename=NULL)
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
                    $this->holiday_doc_put();
                    $this->holiday_doc_show();
                }
            }
        }
        else{
            $this->render_super_template('super/holiday_doc_import',$this->data);
        } 
    }

    public function holiday_doc_show(){
        $holiday_doc=$this->model_holiday_doc->getHolidayDocData();
        $this->data['holiday_doc']=$holiday_doc;
        $this->render_super_template('super/holiday_doc_list',$this->data);
        
    }
    
    
    public function holiday_doc_delete(){
        $doc_name = $_POST['doc_name'];
        if($doc_name){
			$delete = $this->model_holiday_doc->delete($doc_name);
            if($delete == true) {
                $this->session->set_flashdata('success', '删除成功');
            }
            else{
                $this->session->set_flashdata('error', '数据库中不存在该记录');
            }
            redirect('super_holiday/holiday_doc_show', 'refresh');
		}
        $this->render_super_template('super/holiday_doc_show',$this->data);
    }
    public function excel(){
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
 
        $objPHPExcel->setActiveSheetIndex(0);
        
        $result = $this->model_holiday->exportHolidayData();
        // Field names in the first row
        $fields = $result->list_fields();
        $col = 0;
        foreach ($fields as $field)
        {
            $v="";
            switch($field)
            {
                case 'name':$v="姓名\t";break;
                case 'department':$v="部门\t";break;
                case 'initdate':$v="开始工作时间\t";break;
                case 'indate':$v="入职时间\t";break;
                case 'Companyage':$v="社会工龄\t";break;
                case 'Totalage':$v="公司工龄\t";break;
                case 'Totalday':$v="可休假总数\t";break;
                case 'Lastyear':$v="去年休假数\t";break;
                case 'Thisyear':$v="今年休假数\t";break;
                case 'Bonus':$v="荣誉休假数\t";break;
                case 'Used':$v="已休假数\t";break;
                case 'Rest':$v="未休假数\t";break;
                case 'Jan':$v="一月\t";break;
                case 'Feb':$v="二月\t";break;
                case 'Mar':$v="三月\t";break;
                case 'Apr':$v="四月\t";break;
                case 'May':$v="五月\t";break;
                case 'Jun':$v="六月\t";break;
                case 'Jul':$v="七月\t";break;
                case 'Aug':$v="八月\t";break;
                case 'Sep':$v="九月\t";break;
                case 'Oct':$v="十月\t";break;
                case 'Nov':$v="十一月\t";break;
                case 'Dece':$v="十二月\t";break;    	
                default:break;
            }
            if($v != ""){
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $v);
                $col++;
            }
        }
 
        // Fetching the table data
        $row = 2;
        
        foreach($result->result() as $data)
        {
            $col = 0;
            foreach ($fields as $field)
            {
                if($field != 'initflag' and $field != 'user_id')
                {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
                    $col++;
                }
                else{}
            }
            /*
            if($field != 'initflag' and $field != 'user_id')
            {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
            }
 
            */
            $row++;
        }
 
        $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
 
        $filename = date('YmdHis').".xlsx";

        // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename);
        header("Content-Disposition:filename=".$filename);
        header('Cache-Control: max-age=0');
 
        $objWriter->save('php://output');

    }
    public function excel_plan(){
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
 
        $objPHPExcel->setActiveSheetIndex(0);
        
        $result = $this->model_plan->exportPlanData();
        // Field names in the first row
        $fields = $result->list_fields();
        $col = 0;
        foreach ($fields as $field)
        {
            $v="";
            switch($field)
            {
                case 'name':$v="姓名\t";break;
                case 'department':$v="部门\t";break;
                case 'Totalday':$v="可休假总数\t";break;
                case 'Lastyear':$v="去年休假数\t";break;
                case 'Thisyear':$v="今年休假数\t";break;
                case 'Bonus':$v="荣誉休假数\t";break;
                case 'firstquater':$v="第一季度\t";break;
                case 'secondquater':$v="第二季度\t";break;
                case 'thirdquater':$v="第三季度\t";break;
                case 'fourthquater':$v="第四季度\t";break;
                default:break;
            }
            if($v!="")
            {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $v);
                $col++;
            }
        }
 
        // Fetching the table data
        $row = 2;
        
        foreach($result->result() as $data)
        {
            $col = 0;
            
            foreach ($fields as $field)
            {
                if($field != 'user_id' and $field != 'submit_tag')
                {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
                    $col++;
                }
            }
            /*
            if($field != 'user_id' and $field != 'submit_tag')
            {
               $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
            }
            */
            $row++;
        }
 
        $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
 
        $filename = date('YmdHis').".xlsx";
        
        // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename);
        header("Content-Disposition:filename=".$filename);
        header('Cache-Control: max-age=0');
 
        $objWriter->save('php://output');

    }
    
    public function export_plan()
    {
        $this->excel_plan();
    }
    public function export_holiday()
    {
        $this->excel();
        redirect('super/holiday', 'refresh');
    }
    public function download_page()
    {
        $this->data['user_name'] = $this->session->userdata('user_name');
        $this->render_super_template('super/export',$this->data);
    }
    
    public function holiday_excel_put(){
        
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
        $name="";
        $dept="";
        $Initdate=gmdate("Y-m-d") ;
        $Indate=gmdate("Y-m-d");
        $Totalage=0;
        $Comage=0;
        $Totalday=0;
        $Lastyear=0;
        $Thisyear=0;
        $Bonus=0;
        $Used=0;
        $Rest=0;
        $Jan=0;
        $Feb=0;
        $Mar=0;
        $Apr=0;
        $May=0;
        $Jun=0;
        $Jul=0;
        $Aug=0;
        $Sep=0;
        $Oct=0;
        $Nov=0;
        $Dece=0;
        $User_id="";
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
        //删除所有人的年假计划反馈、假期信息，计划，计划提交，用户
        //删除综管员和部门经理
        
        $this->model_holiday->deleteAll();
        $this->model_plan->deleteAll();
        $this->model_holiday_users->deleteAll();        
        $this->model_manager->deleteAll();
        /* excel导入时间的方法！ */
        $initflag=0;
        foreach($column as $k => $v)
        {
            foreach($v as $a => $b)
            {
                if($b==NULL){
                    $b=0;
                }
                switch($a){
                    case 'A':$name=$b;break;
                    case 'B':$dept=$b;break;
                    case 'C':$Initdate=gmdate('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP($b));break;
                    case 'D':$Indate=gmdate('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP($b));break;
                    case 'E':$Totalage=$b;break;
                    case 'F':$Comage=$b;break;
                    case 'G':$Totalday=$b;break;
                    case 'H':$Lastyear=$b;break;
                    case 'I':$Thisyear=$b;break;
                    case 'J':$Bonus=$b;break;
                    case 'K':$Used=$b;break;
                    case 'L':$Rest=$b;break;
                    case 'M':$Jan=$b;break;
                    case 'N':$Feb=$b;break;
                    case 'O':$Mar=$b;break;
                    case 'P':$Apr=$b;break;
                    case 'Q':$May=$b;break;
                    case 'R':$Jun=$b;break;
                    case 'S':$Jul=$b;break;
                    case 'T':$Aug=$b;break;
                    case 'U':$Sep=$b;break;
                    case 'V':$Oct=$b;break;
                    case 'W':$Nov=$b;break;
                    case 'X':$Dece=$b;break;
                    case 'Y':$User_id=$b;break;
                }
            }
            
            $Update_data=array(
                'name' => $name,
                'department' => $dept,
                'initdate' => $Initdate,
                'indate' => $Indate,
                'Companyage' => $Comage,
                'Totalage' => $Totalage,
                'Totalday' => $Totalday,
                'Lastyear' => $Lastyear,
                'Thisyear' => $Thisyear,
                'Bonus' => $Bonus,
                'Used' => $Used,
                'Rest' => $Rest,
                'Jan' => $Jan,
                'Feb' => $Feb,
                'Mar' => $Mar,
                'Apr' => $Apr,
                'May' => $May,
                'Jun' => $Jun,
                'Jul' => $Jul,
                'Aug' => $Aug,
                'Sep' => $Sep,
                'Oct' => $Oct,
                'Nov' => $Nov,
                'Dece' => $Dece,
                'initflag' => $initflag,
                'User_id' => $User_id
            );
            
            $update_user=true;
            

            //如果假期表中没有这个人，那么就年假计划反馈初始化，假期信息初始化，计划初始化，计划提交初始化，用户初始化，
            //feedback,holiday,plan,submit,user

            //初始化假期信息，每个人新建一条假期的记录
            //如果初始化過就不進行初始化 initflag记录是否被初始化过 0未初始化，1初始化完成
        
            $Update_data['Companyage']=floor((strtotime(date("Y-m-d"))-strtotime($Update_data['indate']))/86400/365);
            $Update_data['Totalage']=floor((strtotime(date("Y-m-d"))-strtotime($Update_data['initdate']))/86400/365);

            if($Update_data['Companyage']>=1 and $Update_data['Companyage']<10){
                $Update_data['Thisyear']=5;
            }
            else if($Update_data['Companyage']>=10 and $Update_data['Companyage']<20){
                $Update_data['Thisyear']=10;
            }
            else if($Update_data['Companyage']>=20){
                $Update_data['Thisyear']=15;
            }
            $Update_data['Totalday']=$Update_data['Thisyear']+$Update_data['Lastyear']+$Update_data['Bonus'];
            $Update_data['Rest']=$Update_data['Totalday'];
            $Update_data['initflag']=1;
            $Update_data['Used']=$Update_data['Jan']+$Update_data['Feb']+$Update_data['Mar']+$Update_data['Apr']+$Update_data['May']+$Update_data['Jun']+$Update_data['Jul']+$Update_data['Aug']+$Update_data['Sep']+$Update_data['Oct']+$Update_data['Nov']+$Update_data['Dece'];
    
            $update=$this->model_holiday->create($Update_data);

            //初始化假期计划信息，每个人新建一条假期的记录
            
            $plan_data=array(
                'user_id' => $Update_data['User_id'],
                'name' => $Update_data['name'],
                'department' => $Update_data['department'],
                'Thisyear' => $Update_data['Thisyear'],
                'Lastyear' => $Update_data['Lastyear'],
                'Bonus' => $Update_data['Bonus'],
                'Totalday' => $Update_data['Totalday'],
                'firstquater' => 0,
                'secondquater' => 0,
                'thirdquater' => 0,
                'fourthquater' => 0,
                'submit_tag' => 0
            );
            $update=$this->model_plan->create($plan_data);

            

            //初始化用户信息，每个人新建一条用户记录，用于登陆，密码为身份证后六位
            $Update_user_data=array(
                'user_id' => $User_id,
                'username' => $name,
                'password' => md5(substr($User_id,-6)),
                'permission' => '3'
            );
            $update_user=$this->model_holiday_users->create($Update_user_data,$name);   
        }
    }
    public function holiday_import($filename=NULL)
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
                    $this->holiday_excel_put();
                    $this->holiday();
                }
            }
        }
        else{
            $this->render_super_template('super/holiday_import',$this->data);
        } 
    }

    public function plan()
    {
        $user_id=$this->session->userdata('user_id');

        $user_data=$this->model_super_user->getUserById($user_id);
        $plan_data = $this->model_plan->getPlanData();
        
        $result = array();
        
        if($plan_data)
        {
            foreach($plan_data as $k => $v)
            {
                if($v['submit_tag']==1){
                    $v['submit_tag']='已提交';
                }
                else if($v['submit_tag']==0){
                    $v['submit_tag']='未提交';
                }
                $result[$k]=$v;
            }  
        }
        else
        {
            $holiday_data=$this->model_holiday->getHolidayData();
            foreach($holiday_data as $k =>$v)
            {
                $plan_data=array(
                    'user_id' => $v['user_id'],
                    'name' => $v['name'],
                    'department' => $v['department'],
                    'Thisyear' => $v['Thisyear'],
                    'Lastyear' => $v['Lastyear'],
                    'Bonus' => $v['Bonus'],
                    'Totalday' => $v['Totalday'],
                    'firstquater' => 0,
                    'secondquater' => 0,
                    'thirdquater' => 0,
                    'fourthquater' => 0,
                    'submit_tag' => 0
                );
                $this->model_plan->create($plan_data);
            }
            $plan_data = $this->model_plan->getPlanData();
            foreach($plan_data as $k => $v)
            {
                if($v['submit_tag']==1){
                    $v['submit_tag']='已提交';
                }
                else if($v['submit_tag']==0){
                    $v['submit_tag']='未提交';
                }
                $result[$k]=$v;
            }
            
        }

        $this->data['plan_data'] = $result;
        $this->render_super_template('super/plan', $this->data);
    }

    /*
    ==============================================================================
    超级管理员，综合管理员修改年假计划编辑权限
    ==============================================================================
    */
    public function plan_change_submit(){
        if($_POST){
            if($_POST['submit_auth']==1){
                $data = array(
                    'submit_tag' => 0
                );
                
            }
            if($_POST['submit_revolt']==1){
                $data = array(
                    'submit_tag' => 1
                );
            }

            $update = $this->model_plan->update($data,$_POST['user_id']);
            
            if($update == true) {
                $this->session->set_flashdata('success', 'Successfully created');
                $this->plan();
            }
        }
        else{
            $this->plan();
        }

    }
    public function users(){
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
		
        $this->render_super_template('super/users',$this->data);
    }
    public function user_delete(){
        if(array_key_exists('user_id1', $_POST)){
			if($_POST['user_id1']!=NULL){
                $id=$_POST['user_id1'];

			}
        }
        if(array_key_exists('user_id2', $_POST)){
            echo array_key_exists('user_id2', $_POST);
			if($_POST['user_id2']!=NULL){
                $id=$_POST['user_id2'];
			}
		}

		if($id) {
			if($this->input->post('confirm')) {
					$delete = $this->model_holiday_users->delete($id);
					if($delete == true) {
		        		$this->session->set_flashdata('success', 'Successfully removed');
		        	}
		        	else {
		        		$this->session->set_flashdata('error', '删除失败');
                    }
                    redirect('super_holiday/users', 'refresh');

			}	
			else {
				$this->data['user_id'] = $id;
				$this->render_super_template('super/user_delete', $this->data);
			}	
		}
	}        


    public function manager_excel_put(){
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
        $manager_data=$this->model_manager->getManagerData();
        $this->model_feedback->deleteAll();
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
            //重制所有用户的权限
			if(!$reset){
				$User_default=array(
					'permission' => 3
				);
				$user=$this->model_holiday_users->getUserData();
				foreach ($user as $c => $d){
					$this->model_holiday_users->update($User_default,$user_id);
				}
				$reset=true;
			}
            
            //创建管理人员
            $update_user=false;
            
            if($this->model_manager->getManagerbyID($user_id))
            {
				$update=$this->model_manager->update($Update_data,$user_id);
            }
            else{
				$update=$this->model_manager->create($Update_data);
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
            $update_user=$this->model_holiday_users->update($Update_user,$user_id);
            
            //初始化年假计划反馈，每个部门新建一个反馈记录，部门为主键
            
            if($this->model_feedback->getFeedbackByDept($dept)==NULL)
            {
                echo $dept;
                $feedback_data=array(
                    'department' => $dept,
                );
                $this->model_feedback->create($feedback_data);
            }

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

    public function manager_import()
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
                    foreach($this->model_manager->getManagerData() as $k => $v){
                        $this->model_manager->delete($v['user_id']);
                    }

                    $this->manager_excel_put();
                    $this->manager();
                }
            }
        }
        else{
            $this->render_super_template('super/manager_import',$this->data);
		}        
		
		$this->render_super_template('super/manager_import', $this->data);
    }
    /*
    ============================================================
    查看部门综管员和负责人主页
    ============================================================
    */ 
    public function manager(){
        $manager_data = $this->model_manager->getManagerData();
		$result = array();
		
		foreach ($manager_data as $k => $v) {
			$result[$k] = $v;
		}
		$permission_set=array(
			1 => '部门经理',
			2 => '综合管理员',
			3 => '普通员工'
		);

		$this->data['manager_data'] = $result;
		$this->data['permission_set']=$permission_set;
		$this->render_super_template('super/manager', $this->data);
    }
    /*
    ============================================================
    用户密码修改
    ============================================================
    */ 
    public function setting()
	{
		$id = $this->session->userdata('user_id');
		if($id) {
			$this->form_validation->set_rules('username', 'username', 'trim|max_length[12]');

			if ($this->form_validation->run() == TRUE) {
	            // true case
		        if(empty($this->input->post('password')) && empty($this->input->post('cpassword'))) {
		        	$data = array(
		        		'username' => $this->input->post('username'),
		        	);

		        	$update = $this->model_holiday_users->edit($data, $id);
		        	if($update == true) {
		        		$this->session->set_flashdata('success', 'Successfully updated');
		        		redirect('super/setting/', 'refresh');
		        	}
		        	else {
		        		$this->session->set_flashdata('errors', 'Error occurred!!');
		        		redirect('super/setting/', 'refresh');
		        	}
		        }
		        else {
		        	#$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
					#$this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|matches[password]');
					$this->form_validation->set_rules('password', 'Password', 'trim|required');
					$this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|matches[password]');

					if($this->form_validation->run() == TRUE) {

						$password = md5($this->input->post('password'));

						$data = array(
			        		'username' => $this->input->post('username'),
			        		'password' => $password,
			        	);

						$update = $this->model_holiday_users->edit($data, $id);
						
			        	if($update == true) {
			        		$this->session->set_flashdata('success', 'Successfully updated');
			        		redirect('super/setting/', 'refresh');
			        	}
			        	else {
			        		$this->session->set_flashdata('errors', 'Error occurred!!');
			        		redirect('super/setting/', 'refresh');
			        	}
					}
			        else {
			            // false case
			        	$user_data = $this->model_holiday_users->getUserData($id);

			        	$this->data['user_data'] = $user_data;

						$this->render_super_template('super/setting', $this->data);	
			        }	

		        }
	        }
	        else {
	            // false case
	        	$user_data = $this->model_holiday_users->getUserData($id);

	        	$this->data['user_data'] = $user_data;

				$this->render_super_template('super/setting', $this->data);	
	        }	
		}
    }
    public function notification()
    {
        $notice_data = $this->model_notice->getNoticeData();

		$result = array();
		
		foreach ($notice_data as $k => $v) {
            if($v['type']=='holiday')
                $v['type']='假期';
            if($v['type']=='plan')
                $v['type']='计划';
            $result[$k] = $v;
            
		}
		
		$this->data['notice_data'] = $result;
		
        $this->render_super_template('super/notification', $this->data);
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
				'type' => 'holiday'
			);
			$create = $this->model_notice->create($data);
        	if($create == true) {
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('super_holiday/notification', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('super_holiday/publish_holiday', 'refresh');
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
            $this->render_super_template('super/publish_holiday', $this->data);
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
				'type' => 'plan'
			);
			$create = $this->model_notice->create($data);
        	if($create == true) {
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('super_holiday/notification', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('super_holiday/publish_plan', 'refresh');
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
            $this->render_super_template('super/publish_plan', $this->data);
        }
	}
    
}