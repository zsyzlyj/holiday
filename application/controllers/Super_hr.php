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
        $this->load->model('model_hr_score_attr');
        $this->load->model('model_hr_score_content');
        $this->load->model('model_hr_confirm_status');
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
                    /*
                    foreach($this->model_hr->getData() as $k => $v){
                        $this->model_hr->delete($v['user_id']);
                    }
                    */
                    $this->hr_excel_put();
                    $this->index();
                }
            }
        }
        else{
            $this->render_super_template('super/hr_import',$this->data);
        }
    }
    public function search(){
        $this->data['wage_data']='';
        $this->data['attr_data']='';
        $this->data['chosen_month']='';
        
        if($_SERVER['REQUEST_METHOD'] == 'POST' and array_key_exists('chosen_month',$_POST)){
            $this->data['chosen_month']=$_POST['chosen_month'];
            $doc_name=substr($_POST['chosen_month'],0,4).substr($_POST['chosen_month'],5,6);
            if(strlen($doc_name)<=7 and $doc_name!=''){
                $this->data['attr_data']=$this->model_wage_attr->getWageAttrDataByDate($doc_name);
                $this->data['wage_notice']=$this->model_wage_notice->getWageNoticeByDate($doc_name)['content'];
            }
            $log=array(
                'user_id' => $this->data['user_id'],
                'username' => $this->data['user_name'],
                'login_ip' => $_SERVER["REMOTE_ADDR"],
                'staff_action' => '查看'.$this->data['chosen_month'].'工资',
                'action_time' => date('Y-m-d H:i:s')
            );
            $this->model_log_action->create($log);
            unset($log);
            $this->render_super_template('super/hr_search',$this->data);
        }
        else{
            $this->render_super_template('super/hr_search',$this->data);
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
        $this->data['dept_options']=$this->model_hr_content->getDept();
        $this->data['gender_options']=$this->model_hr_content->getGender();
        $this->data['section_options']=$this->model_hr_content->getSection();
        $this->data['post_options']=$this->model_hr_content->getPost();
        $this->data['marry_options']=$this->model_hr_content->getMarry();
        $this->data['degree_options']=$this->model_hr_content->getDegree();
        $this->data['equ_degree_options']=$this->model_hr_content->getEquDegree();
        $this->data['party_options']=$this->model_hr_content->getParty();
        $this->data['post_type_options']=$this->model_hr_content->getPostType();

        $this->data['column_name']="";
        $this->data['hr_data']="";
        $this->data['current_dept']="";
        $this->data['current_gender']="";
        $this->data['current_section']="";
        $this->data['current_post']="";
        $this->data['current_marry']="";
        $this->data['current_degree']="";
        $this->data['current_equ_degree']="";
        $this->data['current_party']="";
        $this->data['current_post_type']="";
        $selected_dept="";
        $selected_gender="";
        $selected_section="";
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
            if(array_key_exists('selected_section', $_POST)){
                $selected_section=$_POST['selected_section'];
            }
            elseif(array_key_exists('current_section', $_POST)){
                $selected_section=$_POST['current_section'];
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
            $this->data['current_section']=empty($selected_section)?$selected_section:implode(",", $selected_section);
            $this->data['current_post']=empty($selected_post)?$selected_post:implode(",", $selected_post);
            $this->data['current_marry']=empty($selected_marry)?$selected_marry:implode(",", $selected_marry);
            $this->data['current_degree']=empty($selected_degree)?$selected_degree:implode(",", $selected_degree);
            $this->data['current_equ_degree']=empty($selected_equ_degree)?$selected_equ_degree:implode(",", $selected_equ_degree);
            $this->data['current_party']=empty($selected_party)?$selected_party:implode(",", $selected_party);
            $this->data['current_post_type']=empty($selected_post_type)?$selected_post_type:implode(",", $selected_post_type);

            //$this->data['current_dept']=$select_dept;
            //$this->data['current_dept']=$select_dept;
            $this->data['column_name'] = $this->model_hr_attr->getData();
            $this->data['trueend']=(int)str_replace('attr','',array_search(NULL,$this->data['column_name']))-1;
            $this->data['hr_data'] = $this->model_hr_content->search($_POST['name'],$selected_dept,$selected_gender,$selected_section,$selected_post,$selected_marry,$selected_degree,$selected_equ_degree,$selected_party,$selected_post_type);
            /**/
        }
        $this->render_super_template('super/hr_search',$this->data);
    }
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
        $score_content=$this->model_hr_score_content->getName();
        $score_status=$this->model_hr_confirm_status->getData();
        $score_list=array();
        $found=false;
        foreach($score_content as $a =>$b){
            foreach($score_status as $k => $v){
                if($b['content2']==$v['name']){
                    array_push($score_list,array('user_id' => '1','name'=>$b['content2'],'status' => $v['status']));
                    $found=true;
                }
            }
            if(!$found){
                array_push($score_list,array('user_id' => '1','name'=>$b['content2'],'status' => '未确认'));
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
                    $this->render_super_template('super/hr_score_import',$this->data);
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
}