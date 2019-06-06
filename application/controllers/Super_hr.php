<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class super_hr extends Admin_Controller {
	public function __construct(){
        parent::__construct();
        $this->data['page_title'] = 'Super';
        $this->load->model('model_hr_attr');
        $this->load->model('model_hr_content');
        $this->load->model('model_wage_tag');
        $this->load->model('model_wage');
        $this->load->model('model_users');
        $this->load->model('model_notice');
        $this->load->model('model_hr_score_attr');
        $this->load->model('model_hr_score_content');
        $this->load->model('model_hr_transfer_attr');
        $this->load->model('model_hr_transfer_content');
        $this->load->model('model_hr_score_sum_attr');
        $this->load->model('model_hr_score_sum_content');
        $this->load->model('model_hr_confirm_status');
        $this->load->model('model_hr_confirm_sum_status');
        $this->data['user_name'] = $this->session->userdata('user_id');
        $this->data['user_id'] = $this->session->userdata('user_id');
        if($this->data['user_name']==NULL){
            redirect('super_auth/login','refresh');
        }
        $this->data['permission']=$this->session->userdata('permission');
    }
    public function index(){
        $this->data['column_name']=$this->model_hr_attr->getData();
        $this->data['hr_data']=$this->model_hr_content->getData();
        $this->data['trueend']=(int)str_replace('attr','',array_search(NULL,$this->data['column_name']))-1;
        $this->render_super_template('super/hr',$this->data);
    }

    public function hr_excel_put(){
        $this->load->library('phpexcel');//ci框架中引入excel类
        $this->load->library('PHPExcel/IOFactory');
        //先做一个文件上传，保存文件
        $path=$_FILES['file'];
        $filename=date("Ym");
        //根据上传类型做不同处理
        if(strstr($_FILES['file']['name'],'xlsx')){
            $reader = new PHPExcel_Reader_Excel2007();
            $filePath = 'uploads/hr/'.$filename.'.xlsx';
            move_uploaded_file($path['tmp_name'],$filePath);
        }
        elseif(strstr($_FILES['file']['name'], 'xls')){
            $reader = IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)
            $filePath = 'uploads/hr/'.$filename.'.xls';
            move_uploaded_file($path['tmp_name'],$filePath);
            
        }
        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ','BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ','CA', 'CB', 'CC', 'CD', 'CE', 'CF', 'CG', 'CH', 'CI', 'CJ', 'CK', 'CL', 'CM', 'CN', 'CO', 'CP', 'CQ', 'CR', 'CS', 'CT', 'CU', 'CV', 'CW', 'CX', 'CY', 'CZ','DA', 'DB', 'DC', 'DD', 'DE', 'DF', 'DG', 'DH', 'DI', 'DJ', 'DK', 'DL', 'DM', 'DN', 'DO', 'DP', 'DQ', 'DR', 'DS', 'DT', 'DU', 'DV', 'DW', 'DX', 'DY', 'DZ'); 
        $PHPExcel = $reader->load($filePath, 'utf-8'); // 载入excel文件
        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
        
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumm = $sheet->getHighestColumn(); // 取得总列数
        $columnCnt = array_search($highestColumm, $cellName); 

        $data = array();
        $attr = array();
        $id='';
        $name='';
        $user_id='';
        $gender='';
        $native='';
        $minzu='';
        $age='';
        $birth='';
        $marry='';
        $type='';
        $dept='';
        $office='';
        $post_inner='';
        $post_outer='';
        $post_major='';
        $position='';
        $party_post='';
        $position_series='';
        $position_name='';
        $salary_level='';
        $position_adjust_stamp='';
        $salary_adjust_stamp='';
        $indate='';
        $companydate='';
        $totalage='';
        $companyage='';
        $probation_end='';
        $service_mode='';
        $sign_company='';
        $sign_start='';
        $sign_end='';
        $political_orientation='';
        $in_party_date='';
        $pro_name='';
        $pro_level='';
        $qualification_name='';
        $qualification_level='';
        $qualification_date='';
        $company_level='';
        $employment_term='';
        $highest_qualification='';
        $highest_degree='';
        $ft_qualification='';
        $ft_school='';
        $ft_major='';
        $ft_date='';
        $ft_degree='';
        $nft_qualification='';
        $nft_school='';
        $nft_major='';
        $nft_date='';
        $nft_degree='';
        $elite='';
        $company_elite='';
        $professor='';
        
        $access2006='';
        $access2007='';
        $access2008='';
        $access2009='';
        $access2010='';
        $access2011='';
        $access2012='';
        $access2013='';
        $access2014='';
        $access2015='';
        $access2016='';
        $access2017='';
        $access2018='';
        $access2019='';
        $access2020='';
        $access2021='';
        $access2022='';
        $access2023='';
        $access2024='';
        $access2025='';
        for($rowIndex = 1; $rowIndex <= $highestRow; $rowIndex++){        //循环读取每个单元格的内容。注意行从1开始，列从A开始
            $tmp=array();
            for($colIndex = 0; $colIndex <= $columnCnt; $colIndex++){
                $cellId = $cellName[$colIndex].$rowIndex;  
                $cell = $sheet->getCell($cellId)->getValue();
                $cell = $sheet->getCell($cellId)->getCalculatedValue();
                if($cell instanceof PHPExcel_RichText){ //富文本转换字符串
                    $cell = $cell->__toString();
                }
                $b=$cell;
                if($rowIndex==1){
                    $attr['attr'.($colIndex+1)] = $cell;
                }
                else{
                    switch($attr['attr'.($colIndex+1)]){
                        case '序号':$id=$b;break;
                        case '员工姓名':$name=$b;break;
                        case '身份证号码':$user_id=$b;break;
                        case '性别':$gender=$b;break;
                        case '籍贯':$native=$b;break;
                        case '民族':$minzu=$b;break;
                        case '年龄':$age=$b;break;
                        case '出生日期':$birth=$b;break;
                        case '婚姻状况':$marry=$b;break;
                        case '分类':$type=$b;break;
                        case '所在部门':$dept=$b;break;
                        case '科室':$office=$b;break;
                        case '岗位（内）':$post_inner=$b;break;
                        case '岗位（外）':$post_outer=$b;break;
                        case '职务（主）':$post_major=$b;break;
                        case '岗位分类':$position=$b;break;
                        case '党内职务':$party_post=$b;break;
                        case '职位序列':$position_series=$b;break;
                        case '职衔称谓':$position_name=$b;break;
                        case '职级薪档':$wage_level=$b;break;
                        case '职级调整时间':$position_adjust_stamp=$b==''?'':(string)gmdate('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP(intval($b)));break;
                        case '薪档调整时间':$salary_adjust_stamp=$b=='' ?'':(string)gmdate('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP(intval($b)));break;
                        case '参加工作时间':$b=='' ?'':$indate=(string)gmdate('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP(intval($b)));break;
                        case '加入本企业时间':$b=='' ?'':$companydate=(string)gmdate('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP(intval($b)));break;
                        case '工龄':$totalage=intval($b);break;
                        case '司龄':$companyage=intval($b);break;
                        case '试任期截止时间':$probation_end=$b=='' ?'':(string)gmdate('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP(intval($b)));break;
                        case '用工形式':$service_mode=$b;break;
                        case '合同签订公司':$sign_company=$b;break;
                        case '合同起始时间':$sign_start=$b=='' ?'':(string)gmdate('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP(intval($b)));break;
                        case '合同终止时间':$sign_end=$b=='' ?'':(string)gmdate('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP(intval($b)));break;
                        case '政治面貌':$political_orientation=$b;break;
                        case '入党/团时间':$in_party_date= $b=='' ?'':(string)gmdate('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP(intval($b)));break;
                        case '专业技术职务资格名称':$pro_name=$b;break;
                        case '专业技术职务资格等级':$pro_level=$b;break;
                        case '国家职业资格名称':$qualification_name=$b;break;
                        case '国家职业资格等级':$qualification_level=$b;break;
                        case '国家职业资格等级取得日期':$qualification_date=$b=='' ?'':(string)gmdate('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP(intval($b)));break;
                        case '公司聘任':$company_level=$b;break;
                        case '聘期':$employment_term=$b;break;
                        case '最高学历':$highest_qualification=$b;break;
                        case '最高学位':$highest_degree=$b;break;
                        case '全日制教育':$ft_qualification=$b;break;
                        case '毕业院校（全日制）':$ft_school=$b;break;
                        case '所学专业（全日制）':$ft_major=$b;break;
                        case '毕业时间（全日制）':$ft_date=$b=='' ?'':(string)gmdate('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP(intval($b)));break;
                        case '学位（全日制）':$ft_degree=$b;break;
                        case '在职教育':$nft_qualification=$b;break;
                        case '毕业院校（在职教育）':$nft_school=$b;break;
                        case '所学专业（在职教育）':$nft_major=$b;break;
                        case '毕业时间（在职教育）':$nft_date=$b=='' ?'':(string)gmdate('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP(intval($b)));break;
                        case '学位（在职教育）':$nft_degree=$b;break;
                        case '骨干人才信息':$elite=$b;break;
                        case '集团级战略人才信息':$company_elite=$b;break;
                        case '技术专家':$professor=$b;break;
                        case '2006年考核结果':$access2006=$b;break;
                        case '2007年考核结果':$access2007=$b;break;
                        case '2008年考核结果':$access2008=$b;break;
                        case '2009年考核结果':$access2009=$b;break;
                        case '2010年考核结果':$access2010=$b;break;
                        case '2011年考核结果':$access2011=$b;break;
                        case '2012年考核结果':$access2012=$b;break;
                        case '2013年考核结果':$access2013=$b;break;
                        case '2014年考核结果':$access2014=$b;break;
                        case '2015年考核结果':$access2015=$b;break;
                        case '2016年考核结果':$access2016=$b;break;
                        case '2017年考核结果':$access2017=$b;break;
                        case '2018年考核结果':$access2018=$b;break;
                        case '2019年考核结果':$access2019=$b;break;
                        case '2020年考核结果':$access2020=$b;break;
                        case '2021年考核结果':$access2021=$b;break;
                        case '2022年考核结果':$access2022=$b;break;
                        case '2023年考核结果':$access2023=$b;break;
                        case '2024年考核结果':$access2024=$b;break;
                        case '2025年考核结果':$access2025=$b;break;
                        default:break;
                    } 
                }
            }
            $tmp=array(
                'id' => $id,
                'name' => $name,
                'user_id' => $user_id,
                'gender' => $gender,
                'native' => $native,
                'minzu' => $minzu,
                'age' => (string)intval((strtotime(date("Y-m-d"))-strtotime($birth))/86400/365),
                'birth' => $birth,
                'marry' => $marry,
                'type' => $type,
                'dept' => $dept,
                'office' => $office,
                'post_inner' => $post_inner,
                'post_outer' => $post_outer,
                'post_major' => $post_major,
                'position' => $position,
                'party_post' => $party_post,
                'position_series' => $position_series,
                'position_name' => $position_name,
                'salary_level' => $salary_level,
                'position_adjust_stamp' => $position_adjust_stamp,
                'salary_adjust_stamp' => $salary_adjust_stamp,
                'indate' => $indate,
                'companydate' => $companydate,
                'totalage' => $totalage,
                'companyage' => $companyage,
                'probation_end' => $probation_end,
                'service_mode' => $service_mode,
                'sign_company' => $sign_company,
                'sign_start' => $sign_start,
                'sign_end' => $sign_end,
                'political_orientation' => $political_orientation,
                'in_party_date' => $in_party_date,
                'pro_name' => $pro_name,
                'pro_level' => $pro_level,
                'qualification_name' => $qualification_name,
                'qualification_level' => $qualification_level,
                'qualification_date' => $qualification_date,
                'company_level' => $company_level,
                'employment_term' => $employment_term,
                'highest_qualification' => $highest_qualification,
                'highest_degree' => $highest_degree, 
                'ft_qualification' => $ft_qualification,
                'ft_school' => $ft_school,
                'ft_major' => $ft_major,
                'ft_date' => $ft_date,
                'ft_degree' => $ft_degree,
                'nft_qualification' => $nft_qualification,
                'nft_school' => $nft_school,
                'nft_major' => $nft_major,
                'nft_date' => $nft_date,
                'nft_degree' => $nft_degree,
                'elite' => $elite,
                'company_elite' => $company_elite,
                'professor' => $professor,
                'access2006' => $access2006,
                'access2007' => $access2007,
                'access2008' => $access2008,
                'access2009' => $access2009,
                'access2010' => $access2010,
                'access2011' => $access2011,
                'access2012' => $access2012,
                'access2013' => $access2013,
                'access2014' => $access2014,
                'access2015' => $access2015,
                'access2016' => $access2016,
                'access2017' => $access2017,
                'access2018' => $access2018,
                'access2019' => $access2019,
                'access2020' => $access2020,
                'access2021' => $access2021,
                'access2022' => $access2022,
                'access2023' => $access2023,
                'access2024' => $access2024,
                'access2025' => $access2025
            );   
            if($rowIndex!=1){
                array_push($data,$tmp);
            }
            unset($tmp);
        }
        #echo var_dump($attr);
        $this->model_hr_attr->delete();
        $this->model_hr_content->delete();
        $this->model_hr_attr->create($attr);
        $this->model_hr_content->createbatch($data);
    }

    public function hr_import(){
        $this->data['path'] = "uploads/standard/负责人和綜管員角色表模板.xlsx";
        if($_FILES){
            if($_FILES["file"]){
                if($_FILES["file"]["error"] > 0){
                    $this->session->set_flashdata('error', '请选择要上传的文件！');
                    $this->render_super_template('super/hr_import',$this->data);
                }
                else{
                    $this->hr_excel_put();
                    $this->index();
                }
            }
        }
        else{
            $this->render_super_template('super/hr_import',$this->data);
        }
    }
    
    public function hr_dept(){
        #$this->model_hr_content->getDataByDept();
        $this->data['dept_options']=$this->model_hr_content->getDept();
        $this->data['column_name']="";
        $this->data['hr_data']="";
        $this->data['current_dept']="";
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(array_key_exists('selected_dept', $_POST)){
                $selected_dept=$_POST['selected_dept'];
            }
            elseif(array_key_exists('current_dept', $_POST)){
                $selected_dept=$_POST['current_dept'];
            }
            $str="";
            foreach($selected_dept as $k => $v){
                $str.=$v.', ';
            }
            $str=substr($str,0,strlen($str)-2);
            #$this->data['current_dept']=$selected_dept;
            $this->data['current_dept']=$str;
            $this->data['column_name'] = $this->model_hr_attr->getData();
            $this->data['trueend']=(int)str_replace('attr','',array_search(NULL,$this->data['column_name']))-1;
            $this->data['hr_data'] = $this->model_hr_content->getDataByDept($selected_dept);
            /**/
        }
        $this->render_super_template('super/hr_dept',$this->data);
    }
    public function hr_search(){
        $this->data['hr_data']='';
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->data['hr_data'] = $this->model_hr_content->search($_POST['name']);
        }
        
        $this->data['column_name'] = $this->model_hr_attr->getData();
        $this->data['trueend']=(int)str_replace('attr','',array_search(NULL,$this->data['column_name']))-1;
        $this->render_super_template('super/hr_search',$this->data);
    }
    /*
    public function hr_search(){
        $this->data['dept_options']=$this->model_hr_content->getDept();
        $this->data['gender_options']=$this->model_hr_content->getGender();
        $this->data['office_options']=$this->model_hr_content->getoffice();
        $this->data['post_options']=$this->model_hr_content->getPost();
        $this->data['marry_options']=$this->model_hr_content->getMarry();
        $this->data['degree_options']=$this->model_hr_content->getDegree();

        $this->data['column_name']="";
        $this->data['hr_data']="";
        $this->data['current_dept']="";
        $this->data['current_gender']="";
        $this->data['current_office']="";
        $this->data['current_post']="";
        $this->data['current_marry']="";
        $this->data['current_degree']="";
        $this->data['current_equ_degree']="";
        $this->data['current_party']="";
        $this->data['current_post_type']="";
        $selected_dept="";
        $selected_gender="";
        $selected_office="";
        $selected_post="";
        $selected_marry="";
        $selected_degree="";
        $selected_equ_degree="";
        $selected_party="";
        $selected_post_type="";
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(array_key_exists('selected_dept', $_POST)){
                $selected_dept=$_POST['selected_dept'];
            }
            elseif(array_key_exists('current_dept', $_POST)){
                $selected_dept=$_POST['current_dept'];
            }
            if(array_key_exists('selected_gender', $_POST)){
                $selected_gender=$_POST['selected_gender'];
            }
            elseif(array_key_exists('current_gender', $_POST)){
                $selected_gender=$_POST['current_gender'];
            }
            if(array_key_exists('selected_office', $_POST)){
                $selected_office=$_POST['selected_office'];
            }
            elseif(array_key_exists('current_office', $_POST)){
                $selected_office=$_POST['current_office'];
            }
            if(array_key_exists('selected_post', $_POST)){
                $selected_post=$_POST['selected_post'];
            }
            elseif(array_key_exists('current_post', $_POST)){
                $selected_post=$_POST['current_post'];
            }
            if(array_key_exists('selected_marry', $_POST)){
                $selected_marry=$_POST['selected_marry'];
            }
            elseif(array_key_exists('current_marry', $_POST)){
                $selected_marry=$_POST['current_marry'];
            }
            if(array_key_exists('selected_degree', $_POST)){
                $selected_degree=$_POST['selected_degree'];
            }
            elseif(array_key_exists('current_degree', $_POST)){
                $selected_degree=$_POST['current_degree'];
            }
            if(array_key_exists('selected_equ_degree', $_POST)){
                $selected_equ_degree=$_POST['selected_equ_degree'];
            }
            elseif(array_key_exists('current_equ_degree', $_POST)){
                $selected_equ_degree=$_POST['current_equ_degree'];
            }
            if(array_key_exists('selected_party', $_POST)){
                $selected_party=$_POST['selected_party'];
            }
            elseif(array_key_exists('current_party', $_POST)){
                $selected_party=$_POST['current_party'];
            }
            if(array_key_exists('selected_post_type', $_POST)){
                $selected_post_type=$_POST['selected_post_type'];
            }
            elseif(array_key_exists('current_post_type', $_POST)){
                $selected_post_type=$_POST['current_post_type'];
            }
            $this->data['current_dept']=empty($selected_dept)?$selected_dept:implode(",", $selected_dept);
            $this->data['current_gender']=empty($selected_gender)?$selected_gender:implode(",", $selected_gender);
            $this->data['current_office']=empty($selected_office)?$selected_office:implode(",", $selected_office);
            $this->data['current_post']=empty($selected_post)?$selected_post:implode(",", $selected_post);
            $this->data['current_marry']=empty($selected_marry)?$selected_marry:implode(",", $selected_marry);
            $this->data['current_degree']=empty($selected_degree)?$selected_degree:implode(",", $selected_degree);
            $this->data['current_equ_degree']=empty($selected_equ_degree)?$selected_equ_degree:implode(",", $selected_equ_degree);
            $this->data['current_party']=empty($selected_party)?$selected_party:implode(",", $selected_party);
            $this->data['current_post_type']=empty($selected_post_type)?$selected_post_type:implode(",", $selected_post_type);

            //$this->data['current_dept']=$select_dept;
            //$this->data['current_dept']=$select_dept;
            $this->data['hr_data'] = $this->model_hr_content->search($_POST['name'],$selected_dept,$selected_gender,$selected_office,$selected_post,$selected_marry,$selected_degree,$selected_equ_degree,$selected_party,$selected_post_type);
        }
        
        $this->data['column_name'] = $this->model_hr_attr->getData();
        $this->data['trueend']=(int)str_replace('attr','',array_search(NULL,$this->data['column_name']))-1;
        $this->render_super_template('super/hr_search',$this->data);
    }
    */
    /**
    *数字金额转换成中文大写金额的函数
    *String Int $num 要转换的小写数字或小写字符串
    *return 大写字母
    *小数位为两位
    **/
    private function num_to_rmb($num){
        $c1 = "零壹贰叁肆伍陆柒捌玖";
        $c2 = "分角圓拾佰仟萬拾佰仟億";
        //精确到分后面就不要了，所以只留两个小数位
        #$num = round($num, 2);
        $num = round($num, 0);
         
        //将数字转化为整数
        $num = $num * 100;
        if (strlen($num) > 10) {
            return "金额太大，请检查";
        } 
        $i = 0;
        $c = "";
        while (1) {
            if ($i == 0) {
                //获取最后一位数字
                $n = substr($num, strlen($num)-1, 1);
            } else {
                $n = $num % 10;
            }
            //每次将最后一位数字转化为中文
            $p1 = substr($c1, 3 * $n, 3);
            $p2 = substr($c2, 3 * $i, 3);
            if ($n != '0' || ($n == '0' && ($p2 == '亿' || $p2 == '萬' || $p2 == '圓'))) {
                $c = $p1 . $p2 . $c;
            } else {
                $c = $p1 . $c;
            }
            $i = $i + 1;
            //去掉数字最后一位了
            $num = $num / 10;
            $num = (int)$num;
            //结束循环
            if ($num == 0) {
                break;
            } 
        }
        $j = 0;
        $slen = strlen($c);
        while ($j < $slen) {
            //utf8一个汉字相当3个字符
            $m = substr($c, $j, 6);
            //处理数字中很多0的情况,每次循环去掉一个汉字“零”
            if ($m == '零圓' || $m == '零萬' || $m == '零亿' || $m == '零零') {
                $left = substr($c, 0, $j);
                $right = substr($c, $j + 3);
                $c = $left . $right;
                $j = $j-3;
                $slen = $slen-3;
            } 
            $j = $j + 3;
        } 
        //这个是为了去掉类似23.0中最后一个“零”字
        if (substr($c, strlen($c)-3, 3) == '零') {
            $c = substr($c, 0, strlen($c)-3);
        }
        //将处理的汉字加上“整”
        if (empty($c)) {
            return "零圓整";
        }else{
            return $c . "整";
        }
    }
    public function pdf_creator($user_id,$type){
        $this->load->library('tcpdf.php');
        //实例化 
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false); 
        // 设置文档信息 
        $pdf->SetCreator('人力资源部'); 
        $pdf->SetAuthor('徐华'); 
        $pdf->SetTitle('收入证明'); 
        $pdf->SetKeywords('TCPDF, PDF, PHP'); 
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        // 设置页眉和页脚信息 
        $pdf->SetHeaderData('logo.png', 30, '页眉', '页眉', array(0,64,255), array(0,64,128)); 
        $pdf->setFooterData(array(0,64,0), array(0,64,128));         
        // 设置页眉和页脚字体 
        #$pdf->setHeaderFont(Array('songti', '', '10')); 
        #$pdf->setFooterFont(Array('helvetica', '', '8')); 
        // 设置默认等宽字体 
        $pdf->SetDefaultMonospacedFont('courierB'); 
        // 设置间距 
        #$pdf->SetMargins(27.5,40,27);
        
        $pdf->SetMargins(27.5,20,27);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // 设置分页 
        $pdf->SetAutoPageBreak(false,0); 
        // set image scale factor 
        $pdf->setImageScale(1.5); 
        // set default font subsetting mode 
        $pdf->setFontSubsetting(true); 
        $pdf->setFontStretching(100);
        $pdf->setFontSpacing(0);
        //设置字体 
        #$pdf->setCellHeightRatio(3);
        $pdf->setCellHeightRatio(3.0);
        $pdf->AddPage('P', 'A4'); 
        //设置背景图片
        /*
        if(!$apply_flag){
            $img_file = 'assets/images/Unicom.jpg';    
            $pdf->Image($img_file, 0, 0, 0, 500, '', '', '', false, 300, '', false, false, 0);
        }
        */
        #$user_id=$this->data['user_id'];
        $name='蔡蔼霞';
        $user_data=$this->model_hr_score_content->getByName($name);
        $str="弹性福利积点确认\r\n";
        $pdf->SetFont('songti','B',24);
        #$pdf->Write(0,$str,'', 0, 'C', false, 0, false, false, 0);
        $pdf->writeHTML($str, true, false, true, false, 'C');
        $html="";
        $str="";
        switch($type){
            case '弹性福利积点确认':
                $str=$name."：\r\n    为充分发挥企业福利的激励作用，提高福利激励的灵活性，公司增设2018年可选福利。现以福利激励积点的形式授予您2018年可选福利，首次应用为兑现2017年度福利激励积点，考勤、业绩、荣誉挂钩2017年度情况，工龄为截止到2017年12月31日数据，核心人才以2017年12月31日为时点进行核算。";
                $str.="\r\n    您的积点总计".$user_data['content10']."，其中基础积点".$user_data['content5']."、工龄积点".$user_data['content6']."、业绩积点".$user_data['content7']."、个人荣誉积点".$user_data['content8']."、核心人才积点".$user_data['content9']."。";
                $str.="\r\n    员工获得积点的当月需将积点货币化计入当月工资薪金中合并缴纳个人所得税。积点年度间不结转、不累积，在年底时进行清算，积点使用余额超过100积点的部分清零，未超过100积点的部分在员工税后工资中货币化折算发放。\r\n\r\n";
                $pdf->setCellHeightRatio(2); 
                $pdf->SetFont('songti','',15);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="中国联合网络通信有限公司中山市分公司\r\n人力资源与企业发展部\r\n".date("Y年m月d日")."\r\n";
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false); 
                $str="……………………………………………………………………………\r\n弹性福利通知回执单\r\n";
                $pdf->SetFont('songti','B',15);
                $pdf->Write(0,$str,'', 0, 'C', true, 0, false, false); 
                $str="    本人对以上福利积点情况已收悉，并确认个人积点数无误。";
                
                $pdf->SetFont('songti','',15);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false); 
                $str="签名：\r\n".date("Y年m月d日");
                #$pdf->setCellHeightRatio(1.7); 
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false); 
                break;
            default:break;
        }
        
        #$pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
        
        //输出PDF
        $date_name=date('YmdHis');
        
        $path=dirname(__FILE__,3).'/proof/'.$name.'-'.$type.'.pdf';
        $url='proof/'.$name.'-'.$type.'.pdf';
        $pdf->Output($path, 'F');
        return $url;
    }
    public function hr_score(){
        $score_content=$this->model_hr_score_content->getData();
        $score_status=$this->model_hr_confirm_status->getData();
        $score_list=array();
        $found=false;
        foreach($score_content as $a =>$b){
            foreach($score_status as $k => $v){
                if($b['content2']==$v['name']){
                    array_push($score_list,array('user_id' => $b['content1'],'name'=>$b['content2'],'status' => $v['status']));
                    $found=true;
                    break;
                }
            }
            if(!$found){
                array_push($score_list,array('user_id' => $b['content1'],'name'=>$b['content2'],'status' => '未确认'));
                $found=false;
            }
            $found=false;             
        }
        $this->data['score_list']=$score_list;
        unset($score_content);
        unset($score_status);
        unset($score_list);
        $this->render_super_template('super/hr_score',$this->data);
    }
    public function hr_score_excel_put(){
        $this->load->library('phpexcel');//ci框架中引入excel类
        $this->load->library('PHPExcel/IOFactory');
        //先做一个文件上传，保存文件
        $path=$_FILES['file'];
        $filename=date("Ym");
        //根据上传类型做不同处理
        if(strstr($_FILES['file']['name'],'xlsx')){
            $reader = new PHPExcel_Reader_Excel2007();
            $filePath = 'uploads/hr/'.$filename.'.xlsx';
            move_uploaded_file($path['tmp_name'],$filePath);
        }
        elseif(strstr($_FILES['file']['name'], 'xls')){
            $reader = IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)
            $filePath = 'uploads/hr/'.$filename.'.xls';
            move_uploaded_file($path['tmp_name'],$filePath);
            
        }
        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ','BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ','CA', 'CB', 'CC', 'CD', 'CE', 'CF', 'CG', 'CH', 'CI', 'CJ', 'CK', 'CL', 'CM', 'CN', 'CO', 'CP', 'CQ', 'CR', 'CS', 'CT', 'CU', 'CV', 'CW', 'CX', 'CY', 'CZ','DA', 'DB', 'DC', 'DD', 'DE', 'DF', 'DG', 'DH', 'DI', 'DJ', 'DK', 'DL', 'DM', 'DN', 'DO', 'DP', 'DQ', 'DR', 'DS', 'DT', 'DU', 'DV', 'DW', 'DX', 'DY', 'DZ'); 
        $PHPExcel = $reader->load($filePath, 'utf-8'); // 载入excel文件
        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
        
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumm = $sheet->getHighestColumn(); // 取得总列数
        $columnCnt = array_search($highestColumm, $cellName); 

        $data = array();
        $attr = array();
        for($rowIndex = 1; $rowIndex <= $highestRow; $rowIndex++){        //循环读取每个单元格的内容。注意行从1开始，列从A开始
            $tmp=array();
            for($colIndex = 0; $colIndex <= $columnCnt; $colIndex++){
                $cellId = $cellName[$colIndex].$rowIndex;  
                $cell = $sheet->getCell($cellId)->getValue();
                $cell = $sheet->getCell($cellId)->getCalculatedValue();
                if($cell instanceof PHPExcel_RichText){ //富文本转换字符串
                    $cell = $cell->__toString();
                }
                if($rowIndex==1){
                    $attr['attr'.($colIndex+1)] = $cell;
                }
                else{
                    $tmp['content'.($colIndex+1)] = $cell;
                }
                //$temp[$colIndex] = $cell;
            }
            #$this->model_hr_content->create($tmp);
            if($rowIndex!=1){
                array_push($data,$tmp);
            }
            unset($tmp);
        }
        $this->model_hr_score_attr->delete();
        $this->model_hr_score_content->delete();
        $this->model_hr_score_attr->create($attr);
        $this->model_hr_score_content->createbatch($data); 
    }

    public function hr_score_import(){
        $this->data['path'] = "uploads/standard/负责人和綜管員角色表模板.xlsx";
        if($_FILES){
            if($_FILES["file"]){
                if($_FILES["file"]["error"] > 0){
                    $this->session->set_flashdata('error', '请选择要上传的文件！');
                    $this->render_super_template('super/hr_score_import',$this->data);
                }
                else{
                    $this->hr_score_excel_put();
                    $this->hr_score();
                }
            }
        }
        else{
            $this->render_super_template('super/hr_score_import',$this->data);
        }
    }
    public function reset_confirm(){
        $this->model_hr_confirm_status->reset();
        $this->hr_score();
    }
    public function hr_score_sum(){
        $score_content=$this->model_hr_score_sum_content->getName();
        $score_status=$this->model_hr_confirm_sum_status->getData();
        $score_list=array();
        $found=false;
        foreach($score_content as $a =>$b){
            foreach($score_status as $k => $v){
                if($b['content2']==$v['user_id']){
                    array_push($score_list,array('user_id' => $b['content2'],'name'=>$b['content1'],'status' => $v['status']));
                    $found=true;
                    break;
                }
            }
            if(!$found){
                array_push($score_list,array('user_id' => $b['content2'],'name'=>$b['content1'],'status' => '未确认'));
                $found=false;
            }
            $found=false;             
        }
        $this->data['score_list']=$score_list;
        unset($score_content);
        unset($score_status);
        unset($score_list);
        $this->render_super_template('super/hr_score_sum',$this->data);
    }
    public function hr_score_sum_excel_put(){
        $this->load->library('phpexcel');//ci框架中引入excel类
        $this->load->library('PHPExcel/IOFactory');
        //先做一个文件上传，保存文件
        $path=$_FILES['file'];
        $filename=date("Ym");
        //根据上传类型做不同处理
        if(strstr($_FILES['file']['name'],'xlsx')){
            $reader = new PHPExcel_Reader_Excel2007();
            $filePath = 'uploads/hr/'.$filename.'.xlsx';
            move_uploaded_file($path['tmp_name'],$filePath);
        }
        elseif(strstr($_FILES['file']['name'], 'xls')){
            $reader = IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)
            $filePath = 'uploads/hr/'.$filename.'.xls';
            move_uploaded_file($path['tmp_name'],$filePath);
            
        }
        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ','BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ','CA', 'CB', 'CC', 'CD', 'CE', 'CF', 'CG', 'CH', 'CI', 'CJ', 'CK', 'CL', 'CM', 'CN', 'CO', 'CP', 'CQ', 'CR', 'CS', 'CT', 'CU', 'CV', 'CW', 'CX', 'CY', 'CZ','DA', 'DB', 'DC', 'DD', 'DE', 'DF', 'DG', 'DH', 'DI', 'DJ', 'DK', 'DL', 'DM', 'DN', 'DO', 'DP', 'DQ', 'DR', 'DS', 'DT', 'DU', 'DV', 'DW', 'DX', 'DY', 'DZ'); 
        $PHPExcel = $reader->load($filePath, 'utf-8'); // 载入excel文件
        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
        
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumm = $sheet->getHighestColumn(); // 取得总列数
        $columnCnt = array_search($highestColumm, $cellName); 

        $data = array();
        $attr = array();
        for($rowIndex = 1; $rowIndex <= $highestRow; $rowIndex++){        //循环读取每个单元格的内容。注意行从1开始，列从A开始
            $tmp=array();
            for($colIndex = 0; $colIndex <= $columnCnt; $colIndex++){
                $cellId = $cellName[$colIndex].$rowIndex;  
                $cell = $sheet->getCell($cellId)->getValue();
                $cell = $sheet->getCell($cellId)->getCalculatedValue();
                if($cell instanceof PHPExcel_RichText){ //富文本转换字符串
                    $cell = $cell->__toString();
                }
                if($rowIndex==1){
                    $attr['attr'.($colIndex+1)] = $cell;
                }
                else{
                    $tmp['content'.($colIndex+1)] = $cell;
                }
                //$temp[$colIndex] = $cell;
            }
            #$this->model_hr_content->create($tmp);
            if($rowIndex!=1){
                array_push($data,$tmp);
            }
            unset($tmp);
        }
        $this->model_hr_score_sum_attr->delete();
        $this->model_hr_score_sum_content->delete();
        $this->model_hr_score_sum_attr->create($attr);
        $this->model_hr_score_sum_content->createbatch($data); 
    }

    public function hr_score_sum_import(){
        $this->data['path'] = "uploads/standard/负责人和綜管員角色表模板.xlsx";
        if($_FILES){
            if($_FILES["file"]){
                if($_FILES["file"]["error"] > 0){
                    $this->session->set_flashdata('error', '请选择要上传的文件！');
                    $this->render_super_template('super/hr_score_sum_import',$this->data);
                }
                else{
                    $this->hr_score_sum_excel_put();
                    $this->render_super_template('super/hr_score_sum_import',$this->data);
                }
            }
        }
        else{
            $this->render_super_template('super/hr_score_sum_import',$this->data);
        }
    }
    public function reset_confirm_sum(){
        $this->model_hr_confirm_sum_status->reset();
        $this->hr_score_sum();
    }
    public function hr_publish_score_sum(){
        $this->form_validation->set_rules('title', 'title', 'required');
		$this->form_validation->set_rules('content', 'content', 'required');
		
        if($this->form_validation->run() == TRUE){
            // true case
			$title=$this->input->post('title');
			$content=$this->input->post('content');
        	$data = array(
				'pubtime' => date('Y-m-d H:i:s'),
				'username' => $this->session->userdata('user_id'),
        		'title' => $this->input->post('title'),
				'content' => $this->input->post('content'),
				'type' => 'hr'
			);
			$create = $this->model_notice->create($data);
        	if($create == true){
        		$this->session->set_flashdata('success', '公告发布成功');
        		redirect('super_hr/notification', 'refresh');
        	}
        	else{
        		$this->session->set_flashdata('error', '系统发生未知错误!!');
        		redirect('super_hr/hr_publish_score_sum', 'refresh');
        	}

        }
        else{
            // false case
			$notice_data = $this->model_notice->getNoticeData();
			$result = array();
			foreach($notice_data as $k => $v){
				$result[$k] = $v;
			}
			$this->data['notice_data'] = $result;
            $this->render_super_template('super/hr_publish_score_sum', $this->data);
        }
    }
    public function notification(){
        $notice_data = $this->model_notice->getHrNoticeData();
		$result = array();		
		foreach ($notice_data as $k => $v){
            if($v['type']=='hr'){
                $v['type']='积分';
                $result[$k] = $v;
            }
		}
		$this->data['notice_data'] = $result;
		unset($result);
        $this->render_super_template('super/hr_notification', $this->data);
    }
    public function notification_delete(){
        $pubtime=$_POST['time'];
        $this->model_notice->delete($pubtime);
        $this->session->set_flashdata('success', '公告删除成功！');
        redirect('super_hr/notification', 'refresh');
    }
    public function user_details(){
        $this->data['column_name']=$this->model_hr_attr->getData();
        $this->data['data']=$this->model_hr_content->getById($_POST['user_id']);
        $this->data['trueend']=(int)str_replace('attr','',array_search(NULL,$this->data['column_name']))-1;
        $this->render_super_template('super/hr_user_details', $this->data);
    }
    public function proof_creator(){
        $this->load->library('tcpdf.php');
        //实例化 
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false); 
        // 设置文档信息 
        $pdf->SetCreator('人力资源部'); 
        $pdf->SetTitle('证明'); 
        $pdf->SetKeywords('TCPDF, PDF, PHP'); 
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        // 设置页眉和页脚信息 
        $pdf->SetHeaderData('logo.png', 30, '页眉', '页眉', array(0,64,255), array(0,64,128)); 
        $pdf->setFooterData(array(0,64,0), array(0,64,128));         
        // 设置页眉和页脚字体 
        #$pdf->setHeaderFont(Array('songti', '', '10')); 
        #$pdf->setFooterFont(Array('helvetica', '', '8')); 
        // 设置默认等宽字体 
        $pdf->SetDefaultMonospacedFont('courierB'); 
        // 设置间距 
        $pdf->SetMargins(27.5,40,27);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // 设置分页 
        $pdf->SetAutoPageBreak(false,0); 
        // set image scale factor 
        $pdf->setImageScale(1.5); 
        // set default font subsetting mode 
        $pdf->setFontSubsetting(true); 
        $pdf->setFontStretching(100);
        $pdf->setFontSpacing(0);
        //设置字体 
        #$pdf->setCellHeightRatio(3);
        $pdf->setCellHeightRatio(3.0);
        $pdf->AddPage('P', 'A4'); 
        //设置背景图片
        $img_file = 'assets/images/Unicom.jpg';    
        $pdf->Image($img_file, 0, 0, 0, 500, '', '', '', false, 300, '', false, false, 0);

        #$user_id=$this->data['user_id'];
        $user_id=$_POST['user_id'];
        $user_data=$this->model_hr_content->getById($user_id);
        #$cage=$holiday_data['Companyage'];
        #$user_id=$user_data['user_id'];
        $username=$user_data['name'];
        $date_set=array();
        $date=date('Y年m月d日',strtotime($user_data['indate']));
        $ToEndMonth=strtotime('-1 Month',strtotime(date('Y-m'))); //转换一下
        $ToStartMonth=strtotime('-12 Month', strtotime(date('Y-m')));
        
        $i=false; //开始标示
        while( $ToStartMonth < $ToEndMonth ) {
            $NewMonth = !$i ? date('Y-m', strtotime('+0 Month', $ToStartMonth)) : date('Y-m', strtotime('+1 Month', $ToStartMonth));
            $ToStartMonth = strtotime( $NewMonth );
            $i = true;
            array_push($date_set,substr($NewMonth,0,4).substr($NewMonth,5,6));
        }
        
        $avg=$this->model_wage->countAvg($date_set,$user_id)['total'];
        $sum=$this->model_wage->countSum($date_set,$user_id)['total'];
        
        if($avg===NULL){
            $avg=0;
        }
        if($sum===NULL){
            $sum=0;
        }
        $dept=$user_data['dept'];
        $gender=$user_data['gender'];
        $position=$user_data['position'];
        $period=floor((strtotime(date('Y/m/d'))-strtotime($user_data['indate'])) / 60 / 60 / 24 / 365);
        $type=$_POST['type'];
        if(strstr($type,'收入')){
            $str="收 入 证 明";
        }
        elseif(strstr($type,'在职')){
            $str="证          明";
        }elseif(strstr($type,'现实表现')){
            $str="现 实 表 现 证 明";
        }elseif(strstr($type,'计生')){
            $str="计 生 证 明";
        }
        
        $pdf->SetFont('songti','B',30);
        #$pdf->Write(0,$str,'', 0, 'C', false, 0, false, false, 0);
        $pdf->writeHTML($str, true, false, true, false, 'C');
        $rmb=$this->num_to_rmb($avg);
        $rmb_sum=$this->num_to_rmb($sum);
        $avg=number_format($avg,0,"","");
        $sum=number_format($sum,0,"","");
        $html="";
        $pdf->SetFont('songti','',15);
        switch($type){
            case '现实表现证明':
                $str="\r\n    ".$username."(男，身份证号:".$user_id.")同志自".$date."进入我单位至今，期间一直拥护中国共产党的领导，坚持四项基本原则和党的各项方针政策，深刻学习三个代表重要思想。没有参加“六四”“法轮功”等活动，未发现有任何违法乱纪行为。\r\n    特此证明!\r\n";
                $pdf->SetFont('songti','',15);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n".date("Y年m月d日");
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false, 0);
                break;
            case '在职证明1':
                $str="\r\n    兹有我单位员工".$username."，身份证号：".$user_id."，该员工于".$date."起至今在我公司工作。\r\n    特此证明。\r\n";
                $pdf->SetFont('songti','',15);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n".date("Y年m月d日");
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false, 0);
                break;
            case '在职证明2':
                $str="\r\n    兹有".$username."（".$gender."，身份证号：".$user_id."），为我公司在编员工，现任中国联合网络通信有限公司中山市分公司".$dept.$position."。\r\n    特此证明。\r\n\r\n";
                $pdf->SetFont('songti','',15);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n".date("Y年m月d日");
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false, 0);
                break;
            case '在职证明（积分入户1）':
                $str="\r\n    兹有".$username."（性别：".$gender."，身份证号：".$user_id."），为中国联合网络通信有限公司中山市分公司".$dept.$position."，现任中国联合网络通信有限公司中山市分公司".$dept.$position."。\r\n    特此证明。\r\n";
                $pdf->SetFont('songti','',15);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n".date("Y年m月d日")."\r\n\r\n\r\n\r\n";
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false, 0);
                $pdf->setCellHeightRatio(1.5); 
                $pdf->SetFont('songti', '', 9);
                $str="单位名称：中国联合网络通信有限公司中山市分公司\r\n联系地址：中山市东区长江北路6号联通大厦\r\n联系人：徐小姐           联系电话：0760-23771356";
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                break;
            case '在职证明（积分入户2）':
                $str="\r\n    兹有我单位".$username."同志，性别：".$gender."，身份证号码：".$user_id."，于".$date."至今在我单位从事".$dept.$position."工作。\r\n单位名称：中国联合网络通信有限公司中山市分公司\r\n    联系地址：中山市东区长江北路6号联通大厦\r\n    联系人：徐小姐        联系电话：0760-23771356\r\n    特此证明。\r\n    （此证明仅限于流动人员积分制管理使用）\r\n";
                $pdf->SetFont('songti','',15);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n".date("Y年m月d日")."\r\n\r\n\r\n\r\n";
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false, 0);
                break;
            case '在职证明（居住证）':
                $str="\r\n    兹有".$username."（".$gender."，身份证号：".$user_id."），自".$date."进入我公司工作，现任中国联合网络通信有限公司中山市分公司员工".$dept.$position."。\r\n    特此证明。\r\n    （此证明仅限于办理居住证使用）";
                $pdf->SetFont('songti','',15);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n".date("Y年m月d日")."\r\n\r\n\r\n\r\n";
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false, 0);
                $pdf->setCellHeightRatio(1.5); 
                $pdf->SetFont('songti', '', 9);
                $str="单位名称：中国联合网络通信有限公司中山市分公司\r\n联系地址：中山市东区长江北路6号联通大厦\r\n联系人：徐小姐           联系电话：0760-23771356";
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                break;
            case '在职证明（住房补贴）':
                $str="\r\n    ".$username."同志（".$gender."，身份证号码：".$user_id."），".$date."起在我司工作，在职期间未享受过实物分房及建、购房相关补贴，该证明用于申请住房补贴使用。\r\n    特此证明。";
                $pdf->SetFont('songti','',15);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n人力资源部\r\n".date("Y年m月d日");
                $pdf->SetFont('songti','',15);
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false, 0);
                break;
            
            default:break;
        }
        
        #$pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
        
        //输出PDF
        $date_name=date('YmdHis');
        //如果是查看，则生成临时文件，如果是申请，则生成正式文件，后面打印这一份
        $path=dirname(__FILE__,3).'/proof/'.$date_name.'-'.$user_id.'.pdf';
        $url='proof/'.$date_name.'-'.$user_id.'.pdf';

        $pdf->Output($path,'F');
        redirect('http://10.210.193.234/hr/'.$url,'refresh');
    }
    public function hr_proof(){
        $this->data['keyword']="";
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->data['user_info']=$this->model_users->getIdByName($_POST['user_name']);
            $this->data['keyword']=$_POST['user_name'];
        }
        $this->render_super_template('super/hr_proof_search',$this->data);
    }
    public function user_edit(){
        $this->data['column_name']=$this->model_hr_attr->getData();
        $this->data['data']=$this->model_hr_content->getById($_POST['user_id']);
        $this->data['trueend']=(int)str_replace('attr','',array_search(NULL,$this->data['column_name']))-1;
        $this->render_super_template('super/hr_user_details', $this->data);
    }
    #用于上传过去的总表
    
    public function hr_transfer_all_excel_put(){
        $this->load->library('phpexcel');//ci框架中引入excel类
        $this->load->library('PHPExcel/IOFactory');
        //先做一个文件上传，保存文件
        $path=$_FILES['file'];
        #$filename=date("Ym");
        $filename='201001-201902人员调动汇总表';
        //根据上传类型做不同处理
        if(strstr($_FILES['file']['name'],'xlsx')){
            $reader = new PHPExcel_Reader_Excel2007();
            $filePath = 'uploads/hr/'.$filename.'.xlsx';
            move_uploaded_file($path['tmp_name'],$filePath);
        }
        elseif(strstr($_FILES['file']['name'], 'xls')){
            $reader = IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)
            $filePath = 'uploads/hr/'.$filename.'.xls';
            move_uploaded_file($path['tmp_name'],$filePath);
            
        }
        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ','BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ','CA', 'CB', 'CC', 'CD', 'CE', 'CF', 'CG', 'CH', 'CI', 'CJ', 'CK', 'CL', 'CM', 'CN', 'CO', 'CP', 'CQ', 'CR', 'CS', 'CT', 'CU', 'CV', 'CW', 'CX', 'CY', 'CZ','DA', 'DB', 'DC', 'DD', 'DE', 'DF', 'DG', 'DH', 'DI', 'DJ', 'DK', 'DL', 'DM', 'DN', 'DO', 'DP', 'DQ', 'DR', 'DS', 'DT', 'DU', 'DV', 'DW', 'DX', 'DY', 'DZ'); 
        $PHPExcel = $reader->load($filePath, 'utf-8'); // 载入excel文件
        $sheetCount = $PHPExcel->getSheetCount();
        #$sheetCount = 1;
        for($i=0;$i<$sheetCount;$i++){
            $sheet = $PHPExcel->getSheet($i); // 读取第一個工作表
            $del_date=substr($PHPExcel->getSheetNames()[$i],0,4);
            $highestRow = $sheet->getHighestRow(); // 取得总行数
            $highestColumm = $sheet->getHighestColumn(); // 取得总列数
            $columnCnt = array_search($highestColumm, $cellName); 
    
            $data = array();
            $attr = array();
            $id='';
            $name='';
            $user_id='';
            $transfer_date='';
            $dept_before='';
            $office_before='';
            $dept_after='';
            $office_after='';
            $position_before='';
            $position_after='';
            $date_tag='';
            
            for($rowIndex = 1; $rowIndex <= $highestRow; $rowIndex++){        //循环读取每个单元格的内容。注意行从1开始，列从A开始
                $tmp=array();
                for($colIndex = 0; $colIndex <= $columnCnt; $colIndex++){
                    $cellId = $cellName[$colIndex].$rowIndex;  
                    $cell = $sheet->getCell($cellId)->getValue();
                    $cell = $sheet->getCell($cellId)->getCalculatedValue();
                    if($cell instanceof PHPExcel_RichText){ //富文本转换字符串
                        $cell = $cell->__toString();
                    }
                    $b=$cell;
                    if($rowIndex==1){
                        $attr['attr'.($colIndex+1)] = $cell;
                    }
                    else{
                        switch($attr['attr'.($colIndex+1)]){
                            case '姓名':$name=$b;break;
                            case '身份证号码':$user_id=$b;break;
                            case '调整前部门':$dept_before=$b;break;
                            case '调整前室\部\厅':$office_before=$b;break;
                            case '调整前职务、岗位':$position_before=$b;break;
                            case '调整后部门':$dept_after=$b;break;
                            case '调整后室\部\厅':$office_after=$b;break;
                            case '调整后职务、岗位':$position_after=$b;break;
                            case '调整后职务、岗位':$position_after=$b;break;
                            case '调整时间':$date_tag=$b==''?$b:(string)gmdate('Y-m',PHPExcel_Shared_Date::ExcelToPHP(intval($b)));break;
                            default:break;
                        } 
                    }
                }
                $tmp=array(
                    'name' => $name,
                    'dept_before' => $dept_before,
                    'office_before' => $office_before,
                    'position_before' => $position_before,
                    'dept_after' => $dept_after,
                    'office_after' => $office_after,
                    'position_after' => $position_after,
                    'date_tag' => $date_tag
                );   
                if($rowIndex!=1 and $name!=''){
                    array_push($data,$tmp);
                }
                unset($tmp);
            }
            #echo var_dump($attr);
            #$this->model_hr_transfer_attr->deleteByDate($del_date);
            $this->model_hr_transfer_content->deleteByDate($del_date);
            $this->model_hr_transfer_attr->delete();
            #$this->model_hr_transfer_content->delete();
            $this->model_hr_transfer_attr->create($attr);
            $this->model_hr_transfer_content->createbatch($data);
        }
    }
    
    /**/
    public function hr_transfer_all_import(){
        if($_FILES){
            if($_FILES["file"]){
                if($_FILES["file"]["error"] > 0){
                    $this->session->set_flashdata('error', '请选择要上传的文件！');
                    $this->render_super_template('super/hr_transfer_import',$this->data);
                }
                else{
                    $this->hr_transfer_all_excel_put();
                    redirect('super_hr/hr_transfer_search','refresh');
                }
            }
        }
        else{
            $this->session->set_flashdata('error', '请选择文件!!');
            $this->render_super_template('super/hr_transfer_import',$this->data);
        }
    }
    
    public function hr_transfer_excel_put($doc_name){
        $this->load->library('phpexcel');//ci框架中引入excel类
        $this->load->library('PHPExcel/IOFactory');
        //先做一个文件上传，保存文件
        $path=$_FILES['file'];
        $filename=date("Ym").'人员调动汇总表';
        #$filename='201001-201902人员调动汇总表';
        //根据上传类型做不同处理
        if(strstr($_FILES['file']['name'],'xlsx')){
            $reader = new PHPExcel_Reader_Excel2007();
            $filePath = 'uploads/hr/'.$filename.'.xlsx';
            move_uploaded_file($path['tmp_name'],$filePath);
        }
        elseif(strstr($_FILES['file']['name'], 'xls')){
            $reader = IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)
            $filePath = 'uploads/hr/'.$filename.'.xls';
            move_uploaded_file($path['tmp_name'],$filePath);
        }
        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ','BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ','CA', 'CB', 'CC', 'CD', 'CE', 'CF', 'CG', 'CH', 'CI', 'CJ', 'CK', 'CL', 'CM', 'CN', 'CO', 'CP', 'CQ', 'CR', 'CS', 'CT', 'CU', 'CV', 'CW', 'CX', 'CY', 'CZ','DA', 'DB', 'DC', 'DD', 'DE', 'DF', 'DG', 'DH', 'DI', 'DJ', 'DK', 'DL', 'DM', 'DN', 'DO', 'DP', 'DQ', 'DR', 'DS', 'DT', 'DU', 'DV', 'DW', 'DX', 'DY', 'DZ'); 
        $PHPExcel = $reader->load($filePath, 'utf-8'); // 载入excel文件
        $sheetCount = $PHPExcel->getSheetCount();
        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
        $del_date=$doc_name;
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumm = $sheet->getHighestColumn(); // 取得总列数
        $columnCnt = array_search($highestColumm, $cellName); 

        $data = array();
        $attr = array();
        $id='';
        $name='';
        $user_id='';
        $transfer_date='';
        $dept_before='';
        $office_before='';
        $dept_after='';
        $office_after='';
        $position_before='';
        $position_after='';
        $date_tag='';
        
        for($rowIndex = 1; $rowIndex <= $highestRow; $rowIndex++){        //循环读取每个单元格的内容。注意行从1开始，列从A开始
            $tmp=array();
            for($colIndex = 0; $colIndex <= $columnCnt; $colIndex++){
                $cellId = $cellName[$colIndex].$rowIndex;  
                $cell = $sheet->getCell($cellId)->getValue();
                $cell = $sheet->getCell($cellId)->getCalculatedValue();
                if($cell instanceof PHPExcel_RichText){ //富文本转换字符串
                    $cell = $cell->__toString();
                }
                $b=$cell;
                if($rowIndex==1){
                    $attr['attr'.($colIndex+1)] = $cell;
                }
                else{
                    switch($attr['attr'.($colIndex+1)]){
                        case '姓名':$name=$b;break;
                        case '身份证号码':$user_id=$b;break;
                        case '调整前部门':$dept_before=$b;break;
                        case '调整前室\部\厅':$office_before=$b;break;
                        case '调整前职务、岗位':$position_before=$b;break;
                        case '调整后部门':$dept_after=$b;break;
                        case '调整后室\部\厅':$office_after=$b;break;
                        case '调整后职务、岗位':$position_after=$b;break;
                        case '调整后职务、岗位':$position_after=$b;break;
                        case '调整时间':$date_tag=(string)gmdate('Y-m',PHPExcel_Shared_Date::ExcelToPHP(intval($b)));break;
                        default:break;
                    } 
                }
            }
            $tmp=array(
                'name' => $name,
                'dept_before' => $dept_before,
                'office_before' => $office_before,
                'position_before' => $position_before,
                'dept_after' => $dept_after,
                'office_after' => $office_after,
                'position_after' => $position_after,
                'date_tag' => $date_tag
            );   
            if($rowIndex!=1){
                array_push($data,$tmp);
            }
            unset($tmp);
        }
        $this->model_hr_transfer_content->deleteByDate($del_date);
       
        $this->model_hr_transfer_content->createbatch($data);
    }
    public function hr_transfer_import(){
        if($_SERVER['REQUEST_METHOD'] == 'POST' and array_key_exists('chosen_month',$_POST)){
            $doc_name=$_POST['chosen_month'];
            if(strstr($doc_name,'1899')){
                $this->session->set_flashdata('error', '请选择月份!!');
                $this->render_super_template('super/wage_import',$this->data);
            }
            else{
                if(strlen($doc_name)<=7 and $doc_name!=''){
                    if($_FILES){
                        if($_FILES["file"]){
                            if($_FILES["file"]["error"] > 0){
                                $this->session->set_flashdata('error', '请选择要上传的文件！');
                                $this->render_super_template('super/hr_transfer_import',$this->data);
                            }
                            else{
                                echo 'normal '.$doc_name;
                                $this->hr_transfer_excel_put($doc_name);
                                redirect('super_hr/hr_transfer_search','refresh');
                            }
                        }
                    }
                    else{
                        $this->session->set_flashdata('error', '请选择文件!!');
                        $this->render_super_template('super/hr_transfer_import',$this->data);
                    }
                }
            }
        }
        else{
            $this->render_super_template('super/hr_transfer_import',$this->data);
        }
    }

    public function hr_transfer_search(){
        $this->data['hr_data']='';
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->data['hr_data'] = $this->model_hr_transfer_content->search($_POST['name']);
            /**/
        }
        
        $this->data['column_name'] = $this->model_hr_transfer_attr->getData();
        if($this->data['column_name']){
            $this->data['trueend']=(int)str_replace('attr','',array_search(NULL,$this->data['column_name']))-1;
        }
        $this->render_super_template('super/hr_transfer',$this->data);
    }
}