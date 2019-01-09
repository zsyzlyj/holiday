<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Holiday extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->holiday_not_logged_in();

        $this->data['page_title'] = 'Holiday';
        $this->data['permission'] = $this->session->userdata('permission');
        $this->data['user_name'] = $this->session->userdata('user_name');
        
        $this->load->model('model_holiday');
        $this->load->model('model_holiday_doc');
        $this->load->model('model_plan');
        $this->load->model('model_notice');
        $this->load->model('model_holiday_manager');
        $this->load->model('model_feedback');
        $this->data['notice_data'] = $this->model_notice->getNoticeLatestHoliday();
        $this->data['holiday_doc'] = $this->model_holiday_doc->getHolidayDocData();
        if($this->data['user_name']==NULL){
            redirect('super_auth/login','refresh');
        }
	}
    /*
    ============================================================
    休假管理
    包括：
    1、index(),员工个人年假信息展示
    2、staff(),休假汇总
    3、excel_mydeptholiday(),上传假期文件
    4、export_holiday(),跳转上传假期文件页面
    5、excel_plan(),显示所有的假期文件（使用datatable）
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
        $this->staff();
    }

    /*
    ==============================================================================
    普通员工
    ==============================================================================
    */

    public function staff(){
        $user_id=$this->session->userdata('user_id');
        if($user_id==NULL){
            redirect('auth/holiday_logout');
        }
        $this->data['holiday_data'] = $this->model_holiday->getHolidayById($user_id);
        if($this->data['holiday_data']==NULL){
            redirect('auth/holiday_logout');
        }
        $log=array(
            'user_id' => $this->data['holiday_data']['user_id'],
            'username' => $this->data['holiday_data']['name'],
            'login_ip' => $_SERVER["REMOTE_ADDR"],
            'staff_action' => 'holiday_staff_get',
            'action_time' => date('Y-m-d H:i:s')
        );
        $this->model_log_action->create($log);
		$this->render_template('holiday/staff', $this->data);
    }

    public function excel_mydeptholiday($dept){
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
        $objPHPExcel->setActiveSheetIndex(0);
        $result = $this->model_holiday->exportmydeptHolidayData($dept);
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
                default:break;
            }
            if($v != ""){
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $v);
                $col++;
            }
        }
        // Fetching the table data
        $row = 2;
        foreach($result->result() as $data){
            $col = 0;
            foreach ($fields as $field){
                if($field != 'user_id'){
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
                    $col++;
                }
            }
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
    public function export_holiday(){
        $this->excel();
        redirect('holiday/index', 'refresh');
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
        foreach ($fields as $field){
            $v="";
            switch($field){
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
    public function excel_mydeptplan($dept){
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
 
        $objPHPExcel->setActiveSheetIndex(0);
        $result=array();
        $result = $this->model_plan->exportmydeptPlanData($dept);
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
                case 'Thisyear':$v="今年休假数\t";break;
                case 'Lastyear':$v="去年休假数\t";break;
                case 'Bonus':$v="荣誉休假数\t";break;
                case 'Totalday':$v="可休假总数\t";break;                
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
    
    public function export_mydeptplan()
  {
        $user_id=$this->session->userdata('user_id');
        $my_data = $this->model_plan->getPlanById($user_id);

        $this->excel_mydeptplan($_POST['current_dept']);
    }

    public function export_mydeptholiday()
  {
        $user_id=$this->session->userdata('user_id');
        $my_data = $this->model_plan->getPlanById($user_id);

        $this->excel_mydeptholiday($_POST['current_dept']);
    }

    /*
    ==============================================================================
    综合管理员
    ==============================================================================
    */
    public function admin()
	{
        $this->staff();
    }

    public function mydeptholiday(){
        $result=array();
        $user_id=$this->session->userdata('user_id');
        $this->data['current_dept']="";
        if($_POST){
            $select_dept=$_POST['selected_dept'];
            $holiday_data = $this->model_holiday->getHolidayByDept($select_dept);
            $result = array();
            foreach ($holiday_data as $k => $v)
          {
                $result[$k] = $v;
            }

            $this->data['holiday_data'] = $result;
            $this->data['current_dept']=$select_dept;

        }
        
        $admin_data = $this->model_holiday_manager->getManagerById($user_id);

        $admin_result=array();
        $admin_result=explode('/',$admin_data['dept']);

        $this->data['dept_options']=$admin_result;

        $this->data['holiday_data'] = $result; 
		$this->render_template('holiday/mydeptholiday', $this->data);
    }
    public function mydeptplan(){
        $user_id=$this->session->userdata('user_id');
        $result = array();
        $submitted=0;
        $this->data['current_dept']="";
        $this->data['submit_status'] ="";
        $selected_dept="";
        $domain=array();
        if($_POST){
            if(array_key_exists('selected_dept', $_POST)){
                $selected_dept=$_POST['selected_dept'];
            }
            if(array_key_exists('current_dept', $_POST)){
                $selected_dept=$_POST['current_dept'];
            }
            if($selected_dept=='营业中心'){
                $manager_data = $this->model_holiday_manager->getManagerByDept($selected_dept);
                
                foreach($manager_data as $k => $v){
                    if($v['dept']!='营业中心'){
                        $temp=array();
                        $tempsubmitted=0;
                        $plan_data = $this->model_plan->getPlanByDept($v['dept']);
                        foreach ($plan_data as $a => $b){
                            if($b['submit_tag']==1){
                                $tempsubmitted++;
                            }
                        }
                        $temp=array(
                            'dept' => $v['dept'],
                            'manager' => $v['name'],
                            'total' => count($plan_data),
                            'submitted' => $tempsubmitted,
                            'submit_status' => $this->model_feedback->getFeedbackByDept($v['dept'])['submit_status']
                        );
                        if(count($plan_data)==$tempsubmitted){
                            $submitted++;
                        }
                        array_push($domain,$temp);
                        unset($temp);
                    }
                }
                $this->data['domain']=$domain;
            }
            else{
                $plan_data = $this->model_plan->getPlanByDept($selected_dept);
                foreach ($plan_data as $k => $v){
                    $result[$k]=$v;
                    if($v['submit_tag']==1){
                        $result[$k]['submit_tag'] = '已提交';
                        $submitted++;
                    }
                    else{
                        $result[$k]['submit_tag'] = '未提交';
                    }
                }
            }
            $this->data['current_dept']=$selected_dept;
            $this->data['submit_status'] = $this->model_feedback->getFeedbackByDept($selected_dept)['submit_status'];
        }
        $admin_data = $this->model_holiday_manager->getManagerById($user_id);

        $admin_result=array();
        $admin_result=explode('/',$admin_data['dept']);

        $this->data['dept_options']=$admin_result;
        $this->data['submitted'] = $submitted;        
        #$this->data['submitted'] = 6;
        $this->data['plan_data'] = $result;
        $this->data['feedback'] = $this->model_feedback->getFeedbackByDept($selected_dept);
        $this->render_template('holiday/mydeptplan', $this->data);
    }
    public function mydeptplan_submit(){
        $user_id = $this->session->userdata('user_id');
        $my_data = $this->model_holiday_manager->getManagerById($user_id);
        $dept_set=array();
        $data=array();
        $feedback=array();
        if(strstr($my_data['dept'],'/')){
            $dept_set=explode('/',$my_data['dept']);
            foreach($dept_set as $a => $b){
                if($this->model_feedback->getFeedbackByDept($b)){
                    $feedback[$b]=$this->model_feedback->getFeedbackByDept($b);
                }
            }
        }
        else{
            $feedback[$my_data['dept']]=$this->model_feedback->getFeedbackByDept($my_data['dept']);
        }
        $this->data['feedback'] = $feedback;
        $this->render_template('holiday/submit_result', $this->data);
    }

    /*
    ==============================================================================
    部门经理
    ==============================================================================
    */
    public function manager()
	{
        $this->staff();
    }

    /*
    ==============================================================================
    单个人的年假计划显示
    ==============================================================================
    */

    public function staff_plan()
  {
        $user_id=$this->session->userdata('user_id');
        $plan_data = $this->model_plan->getplanById($user_id);
        $this->data['notice_data'] = $this->model_notice->getNoticeLatestPlan();
        $this->data['plan_data'] = $plan_data;
		$this->render_template('holiday/staff_plan', $this->data);
    }
    /*
    ==============================================================================
    年假计划提交
    ==============================================================================
    */
    public function update_plan()
  {
        /*============================================================*/
        /*
            首页必须要的信息，包括身份证，通知信息
        */
        /*============================================================*/
        $user_id=$this->session->userdata('user_id');
        $plan_data = $this->model_plan->getPlanById($user_id);
        $result = array();


        foreach ($plan_data as $k => $v){
            $result[$k] = $v;
        }
        
        $this->data['plan_data'] = $result;
        /**/
        /*============================================================*/

        /*============================================================*/
        $this->form_validation->set_rules('firstquater', 'firstquater','is_natural|greater_than[-1]');
        $this->form_validation->set_rules('secondquater', 'secondquater','is_natural|greater_than[-1]');
        $this->form_validation->set_rules('thirdquater', 'thirdquater','is_natural|greater_than[-1]');
        $this->form_validation->set_rules('fourthquater', 'fourthquater','is_natural|greater_than[-1]');

        if ($this->form_validation->run() == TRUE){
            if($_POST['firstquater']+$_POST['secondquater']+$_POST['thirdquater']+$_POST['fourthquater']==$_POST['total'])
          {
                $data = array(
                    'firstquater' => $_POST['firstquater'],
                    'secondquater' => $_POST['secondquater'],
                    'thirdquater' => $_POST['thirdquater'],
                    'fourthquater' => $_POST['fourthquater'],
                    'submit_tag' => 1
                );

                $create = $this->model_plan->update($data,$user_id);
                
                if($create == true){
                    $this->session->set_flashdata('success', '提交成功');
                    $this->staff_plan();
                }
                else{
                    $this->session->set_flashdata('error', '提交失败');
                    $this->staff_plan();
                }
            }
            else
          {
                $this->session->set_flashdata('error', '提交失败，计划总数必须等于可休假总数');
                $this->staff_plan();
            }
            /**/
        }
        else{
            $this->staff_plan();
        }
    }
    /*
    ==============================================================================
    片区负责人，综合管理员修改年假计划编辑权限
    ==============================================================================
    */
    public function mydomainholiday(){
        $holiday_data=array();
        $user_id=$this->session->userdata('user_id');
        $selected_dept="";
        $this->data['current_dept']="";
        if($_POST){
            $selected_dept=$_POST['selected_dept'];
            $holiday_data = $this->model_holiday->getHolidayByDept($selected_dept);
            $this->data['current_dept']=$selected_dept;
        }
        
        $admin_data = $this->model_holiday_manager->getManagerById($user_id);
        $admin_result=array();
        array_push($admin_result,$admin_data['dept']);
        $this->data['dept_options']=$admin_result;
        $this->data['holiday_data'] = $holiday_data;
        unset($admin_result);
        $this->render_template('holiday/mydomainholiday', $this->data);
    }
    public function mydomainplan(){
        $user_id=$this->session->userdata('user_id');
        $result = array();
        $submitted=0;
        $this->data['current_dept']="";
        $this->data['submit_status'] ="";
        $selected_dept="";
        $domain=array();
        if($_POST){
            if(array_key_exists('selected_dept', $_POST)){
                $selected_dept=$_POST['selected_dept'];
            }
            if(array_key_exists('current_dept', $_POST)){
                $selected_dept=$_POST['current_dept'];
            }
            $plan_data = $this->model_plan->getPlanByDept($selected_dept);
            foreach ($plan_data as $k => $v){
                $result[$k]=$v;
                if($v['submit_tag']==1){
                    $result[$k]['submit_tag'] = '已提交';
                    $submitted++;
                }
                else{
                    $result[$k]['submit_tag'] = '未提交';
                }
            }
            $this->data['current_dept']=$selected_dept;
            $this->data['submit_status'] = $this->model_feedback->getFeedbackByDept($selected_dept)['submit_status'];
        }
        $admin_data = $this->model_holiday_manager->getManagerById($user_id);

        $admin_result=array();

        array_push($admin_result,$admin_data['dept']);
        $this->data['dept_options']=$admin_result;
        $this->data['submitted'] = $submitted;        
        #$this->data['submitted'] = 42;
        $this->data['plan_data'] = $result;
        $this->data['feedback'] = $this->model_feedback->getFeedbackByDept($selected_dept);
        $this->render_template('holiday/mydomainplan', $this->data);
    }
    public function mydomainplan_submit(){
        $user_id = $this->session->userdata('user_id');
        $my_data = $this->model_holiday_manager->getManagerById($user_id);
        $feedback=array();
        $feedback[$my_data['dept']]=$this->model_feedback->getFeedbackByDept($my_data['dept']);
        $this->data['feedback'] = $feedback;
        $this->render_template('holiday/submit_domain_result', $this->data);
    }
    public function submit_domain(){
        if($_POST['current_dept']){
            $dept=$_POST['current_dept'];
            $data=array(
                'department' => $dept,
                'content' => '',
                'submit_status' => '已提交'
            );
            $this->model_feedback->update($data,$dept);
            
        }
        $this->mydomainplan();
    }
    /*
    ==============================================================================
    超级管理员，综合管理员修改年假计划编辑权限
    ==============================================================================
    */
    public function change_submit(){
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
            if($update == true){
                $this->session->set_flashdata('success', '授权完成');
                $this->plan_set();
            }
        }
        else{
            $this->plan_set();
        }

    }
    public function change_submit_mydeptplan(){
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
            if($update == true){
                $this->session->set_flashdata('success', '授权完成');
                $this->mydeptplan();
            }
        }
        else{
            $this->mydeptplan();
        }

    }

    public function submit_to_audit(){
        if($_POST['current_dept']){
            $dept=$_POST['current_dept'];
            $data=array(
                'department' => $dept,
                'content' => '',
                'feedback_status' => '未审核',
                'submit_status' => '已提交'
            );
            //如果部门存在，那就更新反馈状态，未审核
            //如果部门不存在，那就创建新的部门状态
            if($this->model_feedback->getFeedbackByDept($dept)){
                $this->model_feedback->update($data,$dept);
            }
            else{
                $this->model_feedback->create($data);
            }
        }
        $this->mydeptplan();
    }
    public function audit(){
        $user_id=$this->session->userdata('user_id');
        $result = array();
        $this->data['current_dept']="";
        $this->data['submit_status'] = "";
            $this->data['feedback_status'] = "";
        if($_POST){
            $select_dept=$_POST['selected_dept'];
            //如果有反馈内容的话，那么就检验是否选了同意和不同意
            //如果没有反馈内容，那就是普通的查看，直接去显示提交过来的计划表
            if(array_key_exists('feedback_content', $_POST)){
                $this->form_validation->set_rules('confirm', 'confirm', 'trim|required');
                if($this->form_validation->run() == TRUE){
                    //如果反馈的结果是不同意，那么就把该部门的综管员的编辑和提交权限打开。
                    //如果反馈同意就不用做任何事情
                    if($_POST['confirm']==0){
                        $data=array(
                            'content' => $_POST['feedback_content'],
                            'submit_status' => '未提交',
                            'feedback_status' => '已审核',
                            'confirm_status' => '不同意'
                        );
                        $this->model_feedback->update($submit_data,$select_dept);
                    }
                    else{
                        $data=array(
                            'content' => $_POST['feedback_content'],
                            'submit_status' => '已提交',
                            'feedback_status' => '已审核',
                            'confirm_status' => '同意'
                        );
                        $this->model_feedback->update($data,$select_dept);
                    }
                }
                $plan_data = $this->model_plan->getPlanByDept($select_dept);
                foreach ($plan_data as $k => $v){
                    $result[$k]=$v;
                }
            }
            else{
                $plan_data = $this->model_plan->getPlanByDept($select_dept);
                foreach ($plan_data as $k => $v){
                    $result[$k]=$v;
                }
            }
            $feedback=$this->model_feedback->getFeedbackByDept($select_dept);
            $this->data['current_dept']=$select_dept;
            $this->data['submit_status'] =$feedback['submit_status'];
            $this->data['feedback_status'] =$feedback['feedback_status'];
        }

        $admin_data = $this->model_holiday_manager->getManagerById($user_id);

        $admin_result=array();
        $admin_result=explode('/',$admin_data['dept']);

        $this->data['dept_options']=$admin_result;
        $this->data['plan_data'] = $result;
        
        $this->render_template('holiday/audit', $this->data);

    }

    public function audit_result(){
        $user_id=$this->session->userdata('user_id');
        
        $my_data = $this->model_holiday_manager->getManagerById($user_id);

        $dept_set=array();
        $data=array();
        $dept='';
        if(strstr($my_data['dept'],'/')){
            $dept_set=explode('/',$my_data['dept']);
            foreach($dept_set as $a => $b){
                if($this->model_feedback->getFeedbackByDept($b)){
                    array_push($data,$this->model_feedback->getFeedbackByDept($b));
                }
            }
        }
        else{
            array_push($data,$this->model_feedback->getFeedbackByDept($my_data['dept']));
        }
        $this->data['dept']=$my_data;
        $this->data['feedback_data']=$data;
        $this->render_template('holiday/audit_result', $this->data);
    }

}