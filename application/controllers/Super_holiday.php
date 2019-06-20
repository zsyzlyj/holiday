<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Super_holiday extends Admin_Controller{
	public function __construct(){
        parent::__construct();
        $this->data['page_title'] = 'Super';
        $this->load->model('model_holiday');
        $this->load->model('model_holiday_doc');
        $this->load->model('model_plan_seven');
        $this->load->model('model_notice');
        $this->load->model('model_manager');
        $this->load->model('model_users');
        $this->load->model('model_feedback');
        $this->load->model('model_func');
        $this->data['permission']=$this->session->userdata('permission');
        $this->data['user_name'] = $this->session->userdata('user_id');
        if($this->data['user_name']==NULL){
            redirect('super_auth/login','refresh');
        }
    }
    /*
    ============================================================
    休假管理
    包括：
    1、index(),休假汇总
    2、holiday(),休假汇总
    3、holiday_doc_put(),上传假期文件
    4、holiday_doc_import(),跳转上传假期文件页面
    5、holiday_doc_list(),显示所有的假期文件（使用datatable）
    6、holiday_doc_delete(),删除一个假期文件,后跳转doc_list
    7、holiday_excel_put(),处理上传文件,把年假信息导入数据库
    8、holiday_import(),跳转上传假期信息页面
    9、download_page(),跳转下载页面,下载页面包含年假上传模板和年假计划
    10、excel(),构建假期模板文档
    11、export_holiday(),下载假期模板文档的接口
    12、excel_plan(),构建假期计划文档
    13、export_plan(),下载假期计划的接口
    14、plan(),年假计划汇总
    15、plan_change_submit(),年假修改权限赋予和撤销,综管员和超管都能用
    16、users(),查看所有用户的权限，同时可以修改用户的权限
    17、user_delete(),删除单个用户
    18、user_update(),更新某个用户的权限
    19、manager_excel_put(),处理上传文件,把综管员、部门经理信息导入数据库
    20、manager_import(),跳转上传管理人员名单页面
    21、manager(),管理人员名单汇总
    22、notification(),公告历史汇总(年假和计划)
    23、publish_holiday(),发布年假相关公告
    24、publish_plan(),发布年假计划相关公告
    ============================================================
    */ 
    public function index(){
        $this->holiday();
    }
    public function holiday(){
        $this->data['holiday_data'] = $this->model_holiday->getHolidayData();
        $this->render_super_template('super/holiday',$this->data);
    }
    public function holiday_doc_put(){
        //先做一个文件上传，保存文件
        $path=$_FILES['file'];
        $filePath = "uploads/holiday_doc/".$path["name"];
        move_uploaded_file($path["tmp_name"],$filePath);
        $doc_data=array(
            'number' => date('Y-m-d H:i:s'),
            'doc_name' => basename($filePath,".pdf"),
            'doc_path' => $filePath,
        );
        $this->model_holiday_doc->create($doc_data);
    }
    public function holiday_doc_import($filename=NULL){
        if($_FILES){
            if($_FILES["file"]){
                if($_FILES["file"]["error"] > 0){
                    $this->session->set_flashdata('error', '请选择要上传的文件！');
                    $this->render_super_template('super/holiday_doc_import',$this->data);
                }
                else{
                    $this->holiday_doc_put();
                    $this->data['holiday_doc']=$this->model_holiday_doc->getHolidayDocData();
                    $this->render_super_template('super/holiday_doc_list',$this->data);
                }
            }
        }
        else{
            $this->render_super_template('super/holiday_doc_import',$this->data);
        } 
    }
    public function holiday_doc_list(){
        $this->data['holiday_doc']=$this->model_holiday_doc->getHolidayDocData();
        $this->render_super_template('super/holiday_doc_list',$this->data);
    }
    public function holiday_doc_delete(){
        $time = $_POST['time'];
        if($time){
			$delete = $this->model_holiday_doc->deleteByTime($time);
            if($delete == true){
                $this->session->set_flashdata('success', '删除成功');
            }
            else{
                $this->session->set_flashdata('error', '数据库中不存在该记录');
            }
            redirect('super_holiday/holiday_doc_list', 'refresh');
		}
        $this->render_super_template('super/holiday_doc_list',$this->data);
    }
    public function holiday_excel_put(){
        $this->load->library("phpexcel");//ci框架中引入excel类
        $this->load->library('PHPExcel/IOFactory');
        //先做一个文件上传，保存文件
        $path=$_FILES['file'];
        $filePath = "uploads/holiday/".$path["name"];
        move_uploaded_file($path["tmp_name"],$filePath);
        //根据上传类型做不同处理
        if(strstr($_FILES['file']['name'],'xlsx')){
            $reader = new PHPExcel_Reader_Excel2007();
        }
        else{
            if(strstr($_FILES['file']['name'], 'xls')){
                $reader = IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)
            }
        }
        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ','BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ','CA', 'CB', 'CC', 'CD', 'CE', 'CF', 'CG', 'CH', 'CI', 'CJ', 'CK', 'CL', 'CM', 'CN', 'CO', 'CP', 'CQ', 'CR', 'CS', 'CT', 'CU', 'CV', 'CW', 'CX', 'CY', 'CZ','DA', 'DB', 'DC', 'DD', 'DE', 'DF', 'DG', 'DH', 'DI', 'DJ', 'DK', 'DL', 'DM', 'DN', 'DO', 'DP', 'DQ', 'DR', 'DS', 'DT', 'DU', 'DV', 'DW', 'DX', 'DY', 'DZ'); 
        $PHPExcel = $reader->load($filePath, 'utf-8'); // 载入excel文件
        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumm = $sheet->getHighestColumn(); // 取得总列数
        $columnCnt = array_search($highestColumm, $cellName); 
        //删除所有假期信息，计划，用户   
        $this->model_holiday->deleteAll();
        $this->model_plan_seven->deleteAll();
        $holiday_set=array();
        $plan_set=array();
        $dept="";
        $Initdate=0;
        $Indate=0;
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
        for ($rowIndex = 1; $rowIndex <= $highestRow; $rowIndex++){
            if($rowIndex>1){
                for ($colIndex = 0; $colIndex <= $columnCnt; $colIndex++){
                    $cellId = $cellName[$colIndex].$rowIndex;  
                    $cell = $sheet->getCell($cellId)->getValue();
                    $cell = $sheet->getCell($cellId)->getCalculatedValue();
                    if($cell instanceof PHPExcel_RichText){ //富文本转换字符串
                        $cell = $cell->__toString();
                    }
                    $b=$cell;
                    if($b==NULL){
                        $b=0;
                    }
                    switch($colIndex){
                        case 0:$name=$b;break;
                        case 1:$dept=$b;break;
                        case 2:$Initdate=gmdate('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP($b));break;
                        case 3:$Indate=gmdate('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP($b));break;
                        case 4:$Totalage=$b;break;
                        case 5:$Comage=$b;break;
                        case 6:$Totalday=$b;break;
                        case 7:$Lastyear=$b;break;
                        case 8:$Thisyear=$b;break;
                        case 9:$Bonus=$b;break;
                        case 10:$Used=$b;break;
                        case 11:$Rest=$b;break;
                        case 12:$Jan=$b;break;
                        case 13:$Feb=$b;break;
                        case 14:$Mar=$b;break;
                        case 15:$Apr=$b;break;
                        case 16:$May=$b;break;
                        case 17:$Jun=$b;break;
                        case 18:$Jul=$b;break;
                        case 19:$Aug=$b;break;
                        case 20:$Sep=$b;break;
                        case 21:$Oct=$b;break;
                        case 22:$Nov=$b;break;
                        case 23:$Dece=$b;break;
                        case 24:$User_id=$b;break;
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
                    'User_id' => $User_id
                );
                //如果假期表中没有这个人，那么就假期信息初始化，计划初始化，用户初始化，
                //holiday,plan
                //初始化假期信息，每个人新建一条假期的记录
                $Update_data['Companyage']=round((strtotime(date("Y-m-d"))-strtotime($Update_data['indate']))/86400/365);
                $Update_data['Totalage']=round((strtotime(date("Y-m-d"))-strtotime($Update_data['initdate']))/86400/365);
                /*
                if($Update_data['Companyage']>=1 and $Update_data['Companyage']<10){
                    $Update_data['Thisyear']=5;
                }
                else if($Update_data['Companyage']>=10 and $Update_data['Companyage']<20){
                    $Update_data['Thisyear']=10;
                }
                else if($Update_data['Companyage']>=20){
                    $Update_data['Thisyear']=15;
                }
                */
                $Update_data['Totalday']=$Update_data['Thisyear']+$Update_data['Lastyear']+$Update_data['Bonus'];
                
                $Update_data['Used']=$Update_data['Jan']+$Update_data['Feb']+$Update_data['Mar']+$Update_data['Apr']+$Update_data['May']+$Update_data['Jun']+$Update_data['Jul']+$Update_data['Aug']+$Update_data['Sep']+$Update_data['Oct']+$Update_data['Nov']+$Update_data['Dece'];
                array_push($holiday_set,$Update_data);
                if($Update_data['Used']>$Update_data['Thisyear']){
                    $lastyear=0;
                    $thisyear=$Update_data['Totalday']-$Update_data['Used'];
                }
                else{
                    $thisyear=$Update_data['Thisyear'];
                    $lastyear=$Update_data['Lastyear']-$Update_data['Used'];    
                }
                $bonus=$Update_data['Bonus'];
                $totalday=$Update_data['Totalday'];
                $Update_data['Rest']=$Update_data['Totalday']-$Update_data['Used'];
                unset($Update_data);
                //初始化假期计划信息，每个人新建一条假期的记录
                $plan_data=array(
                    'user_id' => $User_id,
                    'name' => $name,
                    'department' => $dept,
                    'Thisyear' => $thisyear,
                    'Lastyear' => $lastyear,
                    'Bonus' => $bonus,
                    'Totalday' => $Rest,
                    'Jun' => 0,
                    'Jul' => 0,
                    'Aug' => 0,
                    'Sep' => 0,
                    'Oct' => 0,
                    'Nov' => 0,
                    'Dece' => 0,
                    /*
                    'firstquater' => 0,
                    'secondquater' => 0,
                    'thirdquater' => 0,
                    'fourthquater' => 0,
                    */
                    'submit_tag' => 0
                );
                array_push($plan_set,$plan_data);
                unset($plan_data);
            }
        }
        $this->model_holiday->createbatch($holiday_set);
        $this->model_plan_seven->createbatch($plan_set);
        unset($holiday_set);
        unset($plan_set);
    }
    public function holiday_import($filename=NULL){
        $this->data['url']="uploads/standard/年假导入模板.xlsx";
        if($_FILES){
            if($_FILES["file"]){
                if($_FILES["file"]["error"] > 0){
                    $this->session->set_flashdata('error', '请选择要上传的文件！');
                    $this->render_super_template('super/holiday_import',$this->data);
                }
                else{
                    $this->holiday_excel_put();
                    $this->data['holiday_data'] = $this->model_holiday->getHolidayData();
                    $this->render_super_template('super/holiday',$this->data);
                }
            }
        }
        else{
            $this->render_super_template('super/holiday_import',$this->data);
        }
    }
    public function download_page(){
        $this->render_super_template('super/holiday_export',$this->data);
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
        foreach ($fields as $field){
            $v="";
            switch($field){
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
                case 'user_id':$v="身份证号\t";break; 	
                default:break;
            }
            if($v != ""){
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $v);
                $col++;
            }
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
        $result = $this->model_plan_seven->exportPlanData();
        // Field names in the first row
        $fields = $result->list_fields();
        $col = 0;
        foreach ($fields as $field){
            $v="";
            switch($field){
                case 'name':$v="姓名\t";break;
                case 'department':$v="部门\t";break;
                case 'Totalday':$v="可休假总数\t";break;
                case 'Lastyear':$v="去年休假数\t";break;
                case 'Thisyear':$v="今年休假数\t";break;
                case 'Bonus':$v="荣誉休假数\t";break;
                case 'Jun':$v="六月\t";break;
                case 'Jul':$v="七月\t";break;
                case 'Aug':$v="八月\t";break;
                case 'Sep':$v="九月\t";break;
                case 'Oct':$v="十月\t";break;
                case 'Nov':$v="十一月\t";break;
                case 'Dece':$v="十二月\t";break;    
                /*
                case 'firstquater':$v="第一季度\t";break;
                case 'secondquater':$v="第二季度\t";break;
                case 'thirdquater':$v="第三季度\t";break;
                case 'fourthquater':$v="第四季度\t";break;
                */
                default:break;
            }
            if($v!=""){
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $v);
                $col++;
            }
        }
        // Fetching the table data
        $row = 2;
        foreach($result->result() as $data){
            $col = 0;
            foreach ($fields as $field){
                if($field != 'user_id' and $field != 'submit_tag'){
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
                    $col++;
                }
            }
            $row++;
        }
        
        $filename = date('YmdHis').".xlsx";
        // Sending headers to force the user to download the file
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename);
        header('Cache-Control: max-age=0');
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
    public function export_plan(){
        $this->excel_plan();
    }
    public function plan(){
        $plan_data = $this->model_plan_seven->getPlanData();
        $result = array();        
        if($plan_data){
            foreach($plan_data as $k => $v){
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
        $this->render_super_template('super/holiday_plan', $this->data);
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
            $update = $this->model_plan_seven->update($data,$_POST['user_id']);            
            if($update == true){
                $this->session->set_flashdata('success', '授权完成');
                $plan_data = $this->model_plan_seven->getPlanData();
                $result = array();        
                if($plan_data){
                    foreach($plan_data as $k => $v){
                        if($v['submit_tag']==1){
                            $v['submit_tag']='已提交';
                        }
                        elseif($v['submit_tag']==0){
                            $v['submit_tag']='未提交';
                        }
                        $result[$k]=$v;
                    }
                }
                $this->data['plan_data'] = $result;
                $this->render_super_template('super/holiday_plan', $this->data);
            }
        }
        else{
            $plan_data = $this->model_plan_seven->getPlanData();
            $result = array();        
            if($plan_data){
                foreach($plan_data as $k => $v){
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
            $this->render_super_template('super/holiday_plan', $this->data);
        }
    }
    public function users(){
        $user_data = $this->model_users->getUserData();
		$holiday = $this->model_holiday->getHolidayData();
		$result = array();
		foreach ($user_data as $k => $v){
			$result[$k] = $v;
			foreach($holiday as $a => $b){
				if($b['name'] == $v['username']){
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
			if($_POST['user_id2']!=NULL){
                $id=$_POST['user_id2'];
			}
		}
		if($id){
			if($this->input->post('confirm')){
                $delete = $this->model_users->delete($id);
                if($delete == true){
                    $this->session->set_flashdata('success', '删除成功');
                }
                else{
                    $this->session->set_flashdata('error', '删除失败');
                }
                redirect('super_holiday/users', 'refresh');
			}	
			else{
				$this->data['user_id'] = $id;
				$this->render_super_template('super/user_delete', $this->data);
			}	
		}
	}        
    public function user_update(){
		$id=$_POST['user_id'];
		$user_data=array(
			'permission' => $_POST['permit']
		);
		$this->model_users->update($user_data,$id);
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
			$this->model_manager->delete($id);
		}
		else{
			$manager_data=array(
				'user_id' => $id,
				'name' => $user['name'],
				'dept' => $user['department'],
				'role' => $role
			);
			//更新管理层角色，如果角色存在，那么直接update，如果不存在，那么新建新的角色
			if($this->model_manager->getManagerById($id)){
			    $this->model_manager->update($manager_data,$id);
			}
			else{
				$this->model_manager->create($manager_data,$id);
			}
		}
		$this->users();
	}
    public function manager_excel_put(){
        $this->load->library("phpexcel");//ci框架中引入excel类
        $this->load->library('PHPExcel/IOFactory');
        //先做一个文件上传，保存文件
        $path=$_FILES['file'];
        $filePath = "uploads/holiday_user/".$path["name"];
        move_uploaded_file($path["tmp_name"],$filePath);
        //根据上传类型做不同处理
        if(strstr($_FILES['file']['name'],'xlsx')){
            $reader = new PHPExcel_Reader_Excel2007();
        }
        else if(strstr($_FILES['file']['name'], 'xls')){
            $reader = IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)
        }
        $PHPExcel = $reader->load($filePath, 'utf-8'); // 载入excel文件
        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumm = $sheet->getHighestColumn(); // 取得总列数
        $data = array();
        $manager_set=array();
        $feedback_set=array();
        $all_dept=array();
        $user_set=array();
        //删除所有的管理人员
        $this->model_manager->deleteAll();
        //删除所有的反馈信息
        $this->model_feedback->deleteAll();
        for ($rowIndex = 1; $rowIndex <= $highestRow; $rowIndex++){        //循环读取每个单元格的内容。注意行从1开始，列从A开始
            if($rowIndex>1){
                for ($colIndex = 'A'; $colIndex <= $highestColumm; $colIndex++){
                    $addr = $colIndex . $rowIndex;
                    $cell = $sheet->getCell($addr)->getValue();
                    if($cell instanceof PHPExcel_RichText){ //富文本转换字符串
                        $cell = $cell->__toString();
                    }
                    $b = $cell;
                    $a=$colIndex;
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
                array_push($manager_set,$Update_data);
                //创建管理人员			
                if($Update_data['role']=='综管员'){
                    $permission=1;
                }
                if($Update_data['role']=='部门负责人'){
                    $permission=2;
                }
                if(strstr($Update_data['dept'],'片区')){
                    $permission=4;
                }
                $Update_user=array(
                    'user_id' => $user_id,
                    'permission' => $permission
                );
                #$update_user=$this->model_users->update($Update_user,$user_id);        
                array_push($user_set,$Update_user);
                unset($Update_data);
                //初始化年假计划反馈，每个部门新建一个反馈记录，部门为主键         
                if(!in_array($dept,$all_dept)){
                    array_push($all_dept,$dept);
                }
            }
        }
        foreach($all_dept as $k => $v){
            $feedback_data=array(
                'department' => $v,
            );
            array_push($feedback_set,$feedback_data);
            unset($feedback_data);
        }
        $this->model_users->updatebatch($user_set);
        $this->model_manager->createbatch($manager_set);
        $this->model_feedback->createbatch($feedback_set);
    }

    public function manager_import(){
        $this->data['path'] = "uploads/standard/负责人和綜管員角色表模板.xlsx";
        if($_FILES){
            if($_FILES["file"]){
                if($_FILES["file"]["error"] > 0){
                    $this->session->set_flashdata('error', '请选择要上传的文件！');
                    $this->render_super_template('super/manager_import',$this->data);
                }
                else{
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
    }
    /*
    ============================================================
    查看部门综管员和负责人主页
    ============================================================
    */ 
    public function manager(){
		$permission_set=array(
			1 => '部门经理',
			2 => '综合管理员',
			3 => '普通员工'
		);
		$this->data['manager_data'] = $this->model_manager->getManagerData();;
		$this->data['permission_set']=$permission_set;
		$this->render_super_template('super/manager', $this->data);
    }
    public function notification(){
        $notice_data = $this->model_notice->getHolidayNoticeData();
		$result = array();		
		foreach ($notice_data as $k => $v){
            if($v['type']=='holiday'){
                $v['type']='假期';
                $result[$k] = $v;
            }
            if($v['type']=='plan'){
                $v['type']='计划';
                $result[$k] = $v;
            }
		}
		$this->data['notice_data'] = $result;
		unset($result);
        $this->render_super_template('super/holiday_notification', $this->data);
    }
    public function publish_holiday(){
		$this->form_validation->set_rules('title', 'title', 'required');
		$this->form_validation->set_rules('content', 'content', 'required');	
        if($this->form_validation->run() == TRUE){
        #if($this->input->post('title')!=null){
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
        	if($create == true){
        		$this->session->set_flashdata('success', '公告发布成功');
        		redirect('super_holiday/notification', 'refresh');
        	}
        	else{
        		$this->session->set_flashdata('error', '发生未知错误!!');
        		redirect('super_holiday/publish_holiday', 'refresh');
        	}
        }
        else{
            // false case
            $this->render_super_template('super/holiday_publish_holiday', $this->data);
        }
	}
	public function publish_plan(){
        
		$this->form_validation->set_rules('title', 'title', 'required');
		$this->form_validation->set_rules('content', 'content', 'required');
		
        if($this->form_validation->run() == TRUE){
        #if($this->input->post('title')!=null){
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
        	if($create == true){
        		$this->session->set_flashdata('success', '公告发布成功！');
        		redirect('super_holiday/notification', 'refresh');
        	}
        	else{
        		$this->session->set_flashdata('error', '发生未知错误!!');
        		redirect('super_holiday/publish_plan', 'refresh');
        	}
        }
        else{
            // false case
            $this->render_super_template('super/holiday_publish_plan', $this->data);
        }
        
    }
    public function notification_delete(){
        $pubtime=$_POST['time'];
        $this->model_notice->delete($pubtime);
        $this->session->set_flashdata('success', '公告删除成功！');
        redirect('super_holiday/notification', 'refresh');
    }
    
    public function progress(){
        $this->data['progress']=$this->model_feedback->getFeedbackStatus();
        $this->render_super_template('super/holiday_progress', $this->data);
    }
    public function switch_function(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(array_key_exists('func_name_off', $_POST)){
                $name=$_POST['func_name_off'];
                $status='已关闭';
            }
            if(array_key_exists('func_name_on', $_POST)){
                $name=$_POST['func_name_on'];
                $status='已开启';
            }
            $this->model_func->edit(array('name' => $name,'status' => $status),$name);
        }
        $this->data['holiday_func']=$this->model_func->getFuncByType('holiday');
        $this->render_super_template('super/holiday_switch_function',$this->data);
    }
}