<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Super_wage extends Admin_Controller 
{

	public function __construct()
	{
        parent::__construct();
        $this->data['page_title'] = 'Super';
        $this->load->model('model_plan');
        $this->load->model('model_notice');
        $this->load->model('model_wage_users');
        $this->load->model('model_wage_tag');
        $this->load->model('model_wage_attr');
        $this->load->model('model_wage_record');
        $this->load->model('model_wage');
        $this->load->model('model_wage_doc'); 
        $this->data['permission']=$this->session->userdata('permission');
        $this->data['user_name'] = $this->session->userdata('user_id');
        if($this->data['user_name']==NULL){
            redirect('super_auth/login','refresh');
        }
    }
    /*
    ============================================================
    工资管理
    包括：
    1、主页
    ============================================================
    */ 
    public function index(){
        $this->data['wage_total']=$this->model_wage_attr->getWageTotalData()['total'];
        $this->data['wage_data']=$this->model_wage->getWageData();
        $this->data['attr_data']=$this->model_wage_attr->getWageAttrData();
        $counter=0;
        if($this->data['attr_data']){
            foreach($this->data['attr_data'] as $k => $v){
                
                if($v=='月度绩效工资小计'){
                    $this->data['yuedustart']=$counter;
                }
                if($v=='省核专项奖励小计'){
                    $this->data['yueduend']=$counter-1;
                    $this->data['shengzhuanstart']=$counter;
                }
                if($v=='分公司专项奖励小计'){
                    $this->data['shengzhuanend']=$counter-1;
                    $this->data['fengongsistart']=$counter;
                }
                if($v=='其他小计'){
                    $this->data['fengongsiend']=$counter-1;
                    $this->data['qitastart']=$counter;
                }
                if($v=='教育经费小计'){
                    $this->data['qitaend']=$counter-1;
                    $this->data['jiaoyustart']=$counter;
                }
                if($v=='福利费小计'){
                    $this->data['jiaoyuend']=$counter-1;
                    $this->data['fulistart']=$counter;
                }
                if($v=='当月月应收合计'){
                    $this->data['fuliend']=$counter-1;
                    $this->data['koufeistart']=$counter+1;
                    
                }
                if($v=='扣款小计'){
                    $this->data['koufeiend']=$counter;
                    break;
                }
                $counter++;
            }
        }
        $this->render_super_template('super/wage',$this->data);
    }
    public function this_month(){
        $this->data['wage_total']=$this->model_wage_attr->getWageTotalData()['total'];
        $this->data['wage_data']=$this->model_wage->getWageData();
        $this->data['attr_data']=$this->model_wage_attr->getWageAttrData();
        $counter=0;
        if($this->data['attr_data']){
            foreach($this->data['attr_data'] as $k => $v){
                if($v=='月度绩效工资小计'){
                    $this->data['yuedustart']=$counter;
                }
                if($v=='省核专项奖励小计'){
                    $this->data['yueduend']=$counter-1;
                    $this->data['shengzhuanstart']=$counter;
                }
                if($v=='分公司专项奖励小计'){
                    $this->data['shengzhuanend']=$counter-1;
                    $this->data['fengongsistart']=$counter;
                }
                if($v=='其他小计'){
                    $this->data['fengongsiend']=$counter-1;
                    $this->data['qitastart']=$counter;
                }
                if($v=='教育经费小计'){
                    $this->data['qitaend']=$counter-1;
                    $this->data['jiaoyustart']=$counter;
                }
                if($v=='福利费小计'){
                    $this->data['jiaoyuend']=$counter-1;
                    $this->data['fulistart']=$counter;
                }
                if($v=='当月月应收合计'){
                    $this->data['fuliend']=$counter-1;
                    $this->data['koufeistart']=$counter+1;
                }
                if($v=='扣款小计'){
                    $this->data['koufeiend']=$counter;
                    break;
                }
                $counter++;
            }
        }
        $this->render_super_template('super/wage',$this->data);
    }
    public function search_excel($doc_name){
        $this->load->library("phpexcel");//ci框架中引入excel类
        $this->load->library('PHPExcel/IOFactory');
        
        $dir="uploads/wage";
        $data=array();
        if(is_dir($dir)){
            $files = array();
            $child_dirs = scandir($dir);
            foreach($child_dirs as $child_dir){
                if($child_dir != '.' && $child_dir != '..'){
                    if(is_dir($dir.'/'.$child_dir)){
                        $files[$child_dir] = my_scandir($dir.'/'.$child_dir);
                    }else{
                        if(strstr($child_dir,$doc_name)){
                            if (strstr($child_dir,'xlsx')) {
                                $reader = new PHPExcel_Reader_Excel2007();
                            }
                            else{
                                if (strstr($child_dir, 'xls')) {
                                    $reader = IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)
                                }
                            }
                            $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ','BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ','CA', 'CB', 'CC', 'CD', 'CE', 'CF', 'CG', 'CH', 'CI', 'CJ', 'CK', 'CL', 'CM', 'CN', 'CO', 'CP', 'CQ', 'CR', 'CS', 'CT', 'CU', 'CV', 'CW', 'CX', 'CY', 'CZ','DA', 'DB', 'DC', 'DD', 'DE', 'DF', 'DG', 'DH', 'DI', 'DJ', 'DK', 'DL', 'DM', 'DN', 'DO', 'DP', 'DQ', 'DR', 'DS', 'DT', 'DU', 'DV', 'DW', 'DX', 'DY', 'DZ'); 
                            $PHPExcel = $reader->load($dir.'/'.$child_dir, 'utf-8'); // 载入excel文件
                            $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
                            $highestRow = $sheet->getHighestRow(); // 取得总行数
                            $highestColumm = $sheet->getHighestColumn(); // 取得总列数
                        
                            $columnCnt = array_search($highestColumm, $cellName); 

                            $data = array();
                            for ($rowIndex = 4; $rowIndex <= $highestRow; $rowIndex++) {        //循环读取每个单元格的内容。注意行从1开始，列从A开始
                                for ($colIndex = 0; $colIndex <= $columnCnt; $colIndex++) {
                                    $cellId = $cellName[$colIndex].$rowIndex;  
                                    $cell = $sheet->getCell($cellId)->getValue();
                                    $cell = $sheet->getCell($cellId)->getCalculatedValue();
                                    if ($cell instanceof PHPExcel_RichText) { //富文本转换字符串
                                        $cell = $cell->__toString();
                                    }
                                    if($cell!="" or $cell=="0"){
                                        $data[$rowIndex][$colIndex] = $cell;
                                    }
                                    if($cell=="" and $colIndex==$columnCnt){
                                        $data[$rowIndex][$colIndex] = $cell;
                                    }
                                }
                            }
                        }
                        break;
                    }
                }
            }
        }
        return $data;
    }
    public function search(){
        $this->data['wage_data']="";
        $this->data['attr_data']="";
        $this->data['chosen_month']="";
        if($_SERVER['REQUEST_METHOD'] == 'POST' and array_key_exists('chosen_month',$_POST)){
            $this->data['chosen_month']=$_POST['chosen_month'];
            $doc_name=substr($_POST['chosen_month'],0,4).substr($_POST['chosen_month'],5,6);
            if(strlen($doc_name)<=7 and $doc_name!=""){
                $this->data['wage_data']=$this->search_excel($doc_name);
                $this->data['attr_data']=$this->model_wage_attr->getWageAttrDataByDate($doc_name);
                $counter=0;
                foreach($this->data['attr_data'] as $k => $v){
                    if($v=='月度绩效工资小计'){
                        $this->data['yuedustart']=$counter;
                    }
                    if($v=='省核专项奖励小计'){
                        $this->data['yueduend']=$counter-1;
                        $this->data['shengzhuanstart']=$counter;
                    }
                    if($v=='分公司专项奖励小计'){
                        $this->data['shengzhuanend']=$counter-1;
                        $this->data['fengongsistart']=$counter;
                    }
                    if($v=='其他小计'){
                        $this->data['fengongsiend']=$counter-1;
                        $this->data['qitastart']=$counter;
                    }
                    if($v=='教育经费小计'){
                        $this->data['qitaend']=$counter-1;
                        $this->data['jiaoyustart']=$counter;
                    }
                    if($v=='福利费小计'){
                        $this->data['jiaoyuend']=$counter-1;
                        $this->data['fulistart']=$counter;
                    }
                    if($v=='当月月应收合计'){
                        $this->data['fuliend']=$counter-1;
                        $this->data['koufeistart']=$counter+1;
                    }
                    if($v=='扣款小计'){
                        $this->data['koufeiend']=$counter;
                    }
                    if($v=='本月工资差异说明'){
                        $this->data['trueend']=$counter+1;
                        break;
                    }
                    $counter++;
                }
            }
            $this->render_super_template('super/wage_search',$this->data);
        }
        else{
            $this->render_super_template('super/wage_search',$this->data);
        }
    }
    
    public function proof_Creator($type){
        //图片水印制作
        $ori_img = "assets/images/unicomletterb.jpg";    //原图
        $new_img = "assets/images/new.jpg";    //生成水印后的图片
        
        $original = getimagesize($ori_img);    //得到图片的信息，可以print_r($original)发现它就是一个数组

        switch($original[2]){
            case 1 : $s_original = imagecreatefromgif($ori_img);
                break;
            case 2 : $s_original = imagecreatefromjpeg($ori_img);
                break;
            case 3 : $s_original = imagecreatefrompng($ori_img);
                break;
        }
        
        $font_size = 22;    //字号
        $tilt = 45;    //文字的倾斜度
        $color = imagecolorallocatealpha($s_original,0,0,0,0);// 为一幅图像分配颜色 255,0,0表示红色
        $str = $this->session->userdata('user_id');
        $poxY = 350;    //Y坐标
        for($posX=200;$posX<$original[0];$posX+=600){
            imagettftext($s_original, $font_size, $tilt, $posX, $poxY, $color, 'C:/Windows/Fonts/simfang.ttf', $str);
        }
        $poxY = 650;    //Y坐标
        for($posX=450;$posX<$original[0];$posX+=600){
            imagettftext($s_original, $font_size, $tilt, $posX, $poxY, $color, 'C:/Windows/Fonts/simfang.ttf', $str);
        }
        $poxY = 950;    //Y坐标
        for($posX=200;$posX<$original[0];$posX+=600){
            imagettftext($s_original, $font_size, $tilt, $posX, $poxY, $color, 'C:/Windows/Fonts/simfang.ttf', $str);
        }
        $poxY = 1250;    //Y坐标
        for($posX=500;$posX<$original[0];$posX+=600){
            imagettftext($s_original, $font_size, $tilt, $posX, $poxY, $color, 'C:/Windows/Fonts/simfang.ttf', $str);
        }
        $poxY = 1550;    //Y坐标
        for($posX=200;$posX<$original[0];$posX+=600){
            imagettftext($s_original, $font_size, $tilt, $posX, $poxY, $color, 'C:/Windows/Fonts/simfang.ttf', $str);
        }
        $poxY = 1850;    //Y坐标
        for($posX=500;$posX<$original[0];$posX+=600){
            imagettftext($s_original, $font_size, $tilt, $posX, $poxY, $color, 'C:/Windows/Fonts/simfang.ttf', $str);
        }
        $loop = imagejpeg($s_original, $new_img);    //生成新的图片(jpg格式)，如果用imagepng可以生成png格式
        //证明文件生成
        $this->load->library('tcpdf.php');
        //实例化 
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false); 
        #$pdf = new TCPDF('P', 'mm', 'A4', true, 'GB2312', false); 
        
        // 设置文档信息 
        $pdf->SetCreator('人力资源部'); 
        $pdf->SetAuthor('甘子运'); 
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
        #$pdf->SetDefaultMonospacedFont('courierB'); 
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
        
        $pdf->setCellHeightRatio(3);
        $pdf->AddPage('P', 'A4'); 
        
        //设置背景图片
        #$img_file = 'assets/images/Unicom.jpg';
        $img_file=$new_img;
        $pdf->Image($img_file, 0, 0, 0, 500, '', '', '', false, 300, '', false, false, 0);

        $user_data=$this->model_wage_tag->getTagById($this->session->userdata('user_id'));
        #$holiday_data=$this->model_holiday->getHolidayById($this->session->userdata('user_id'));
        #$holiday_
        #$cage=$holiday_data['Companyage'];
        #$user_id=$user_data['user_id'];
        #$username=$user_data['name'];
        $user_id="";
        $username="";
        #$date=date('Y年m月d日',strtotime($holiday_data['indate']));
        $date="";
        $str="收 入 证 明\r\n";
        $pdf->SetFont('songti','B',24);
        $pdf->Write(0,$str,'', 0, 'C', false, 0, false, false, 0);

        switch($type){
            case 'wage':
                $str="\r\n          兹证明".$username."，身份证号码：".$user_id."为中国联合网络通信有限公司中山市分公司正式员工，自".$date."起为我司工作，现于我单位任职综合部 综合文秘室 综合秘书，其月收入（税前）包括工资、奖金、津贴约XXX元（大写：壹萬贰仟圆整），以上情况属实。此证明仅限于申请贷款之用。\r\n         特此证明！\r\n";
                break;
            case 'bank_wage':
                $str="\r\n中山农村商业银行股份有限公司：\r\n            兹证明".$username."（身份证号码：".$user_id."）为我单位正式员工，自".$date."起为我单位工作，现于我单位任职 网络建设部 无线网建设室 室主任，其月收入（税前）包括工资、奖金、津贴约XXX元（大写：壹萬贰仟伍佰圆整），以上情况属实。此证明仅用于申请贷款之用。\r\n          特此证明！";
                break;
            case 'fund':
                $str="\r\n中山市住房公积金管理中心：\r\n            为申请住房公积金贷款事宜，兹证明 ".$username."，性别：，身份证号 ".$user_id."，是我单位职工，已在我单位工作满".$cage."年，该职工上一年度在我单位总收入约为 XXXX元（大写：拾壹萬伍仟圆整 ）。\r\n\r\n";
                break;
            case 'royal':
                $str="          ".$username."（男，身份证号：".$user_id."） 同志自".$date."进入我单位至今，期间一直拥护中国共产党的领导，坚持四项基本原则和党的各项方针政策，深刻学习三个代表重要思想。没有参加“六四”“法轮功”等活动，未发现有任何违法乱纪行为。\r\n          特此证明!\r\n";
                break;
            case 'on_post_1':
                $str="\r\n          兹有我单位员工".$username."，身份证号：".$user_id."，该员工于".$date."起至今在我公司工作。\r\n            特此证明。\r\n";
                $pdf->SetFont('songti','',14);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n人力资源与企业发展部\r\n".date("Y年m月d日");
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false, 0);
                break;
            case 'on_post_2':
                $str="\r\n          兹有".$username."（女，身份证号：".$user_id."），为中国联合网络通信有限公司中山市分公司中层管理干部，现任中国联合网络通信有限公司中山市分公司综合部部门经理。\r\n            特此证明。\r\n\r\n";
                $pdf->SetFont('songti','',14);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n人力资源与企业发展部\r\n".date("Y年m月d日");
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false, 0);
                break;
            case 'on_post_3':
                $str="\r\n          兹有刘颖（女，身份证号：110108196709174243），为中国联合网络通信有限公司中山市分公司中层管理干部，现任中国联合网络通信有限公司中山市分公司综合部部门经理。\r\n            特此证明。\r\n";
                $pdf->SetFont('songti','',14);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n人力资源与企业发展部\r\n".date("Y年m月d日")."\r\n\r\n\r\n\r\n";
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false, 0);
                $pdf->setCellHeightRatio(1.5); 
                $pdf->SetFont('songti', '', 9);
                $str="单位名称：中国联合网络通信有限公司中山市分公司\r\n联系地址：中山市东区长江北路6号联通大厦\r\n联系人：徐小姐           联系电话：0760-23771356";
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);

                break;
            case 'on_post_4':
                $str="\r\n          兹有我单位".$username."同志，性别：男，身份证号码：".$user_id."，于".$date."至今在我单位从事 南部固网销售公司总经理 （职位）工作。\r\n单位名称：中国联合网络通信有限公司中山市分公司\r\n          联系地址：中山市东区长江北路6号联通大厦\r\n          联系人：徐小姐        联系电话：0760-23771356\r\n          特此证明。\r\n       （此证明仅用于办理流动人员积分制管理使用）\r\n";
                $pdf->SetFont('songti','',14);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n人力资源与企业发展部\r\n".date("Y年m月d日")."\r\n\r\n\r\n\r\n";
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false, 0);
                break;
            case 'on_post_5':
                $str="\r\n          兹有".$username."（女，身份证号：".$user_id."），自".$date."进入我公司工作，现任中国联合网络通信有限公司中山市分公司员工 （职位）。\r\n          特此证明。\r\n       （此证明仅用于办理居住证使用）";
                $pdf->SetFont('songti','',14);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n人力资源与企业发展部\r\n".date("Y年m月d日")."\r\n\r\n\r\n\r\n";
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false, 0);
                $pdf->setCellHeightRatio(1.5); 
                $pdf->SetFont('songti', '', 9);
                $str="单位名称：中国联合网络通信有限公司中山市分公司\r\n联系地址：中山市东区长江北路6号联通大厦\r\n联系人：徐小姐           联系电话：0760-23771356";
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                
                break;
            case 'one_child':
                $str="";
                break;

            default:break;
        }

        if(!(strstr($type,'post'))){
            $pdf->SetFont('songti','',14);
            $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
            $str="\r\n\r\n经办人：\t\t\t\t\t\r\n中国联合网络通信有限公司中山市分公司\r\n人力资源与企业发展部\r\n单位（盖章）\r\n".date("Y年m月d日")."\r\n\r\n\r\n\r\n\r\n";
            $pdf->setCellHeightRatio(1.7); 
            $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false); 
            $pdf->setCellHeightRatio(1.5); 
            $pdf->SetFont('songti', '', 9);
            $str="\r\n\r\n联系地址：中山市长江北路6号联通大厦\r\n联系人：甘先生\r\n联系电话：0760-23692312";
            $pdf->Write(0,$str,'', 0, 'L', false, 0, false, false);
        }

        $pdf->Output('证明.pdf', 'I');
        //输出PDF       
    }
    public function wage_proof(){
        $this->render_super_template('super/wage_proof',$this->data);
    }
    //收入证明
    public function show_wage_proof(){
        $this->proof_Creator("wage");
    }
    //公积金证明
    public function show_fund_proof(){
        $this->proof_Creator("fund");
    }

    //农商银行收入证明
    public function show_bank_wage_proof(){
        $this->proof_Creator("bank_wage");
    }
    
    //收入证明
    public function show_royal_proof(){
        $this->proof_Creator("royal");
    }
    
    public function show_on_post_1_proof(){
        $this->proof_Creator("on_post_1");
    }
    public function show_on_post_2_proof(){
        $this->proof_Creator("on_post_2");
    }
    public function show_on_post_3_proof(){
        $this->proof_Creator("on_post_3");
    }
    public function show_on_post_4_proof(){
        $this->proof_Creator("on_post_4");
    }
    public function show_on_post_5_proof(){
        $this->proof_Creator("on_post_5");
    }
    //收入证明
    public function show_one_child_proof(){
        $this->proof_Creator("one_child");
    }
    public function wage_tag_excel_put(){
        $this->load->library("phpexcel");//ci框架中引入excel类
        $this->load->library('PHPExcel/IOFactory');
        //先做一个文件上传，保存文件
        $path=$_FILES['file'];
        $filePath = "uploads/wage_user/".$path["name"];
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

        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ','BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ','CA', 'CB', 'CC', 'CD', 'CE', 'CF', 'CG', 'CH', 'CI', 'CJ', 'CK', 'CL', 'CM', 'CN', 'CO', 'CP', 'CQ', 'CR', 'CS', 'CT', 'CU', 'CV', 'CW', 'CX', 'CY', 'CZ','DA', 'DB', 'DC', 'DD', 'DE', 'DF', 'DG', 'DH', 'DI', 'DJ', 'DK', 'DL', 'DM', 'DN', 'DO', 'DP', 'DQ', 'DR', 'DS', 'DT', 'DU', 'DV', 'DW', 'DX', 'DY', 'DZ'); 
        $PHPExcel = $reader->load($filePath, 'utf-8'); // 载入excel文件
        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumm = $sheet->getHighestColumn(); // 取得总列数
    
        $columnCnt = array_search($highestColumm, $cellName); 

        $data = array();
        for ($rowIndex = 1; $rowIndex <= $highestRow; $rowIndex++) {        //循环读取每个单元格的内容。注意行从1开始，列从A开始
            for ($colIndex = 0; $colIndex <= $columnCnt; $colIndex++) {
                $cellId = $cellName[$colIndex].$rowIndex;  
                $cell = $sheet->getCell($cellId)->getValue();
                $cell = $sheet->getCell($cellId)->getCalculatedValue();
                if ($cell instanceof PHPExcel_RichText) { //富文本转换字符串
                    $cell = $cell->__toString();
                }
                $data[$rowIndex][$colIndex] = $cell;
            }
        }

        $column=array();
        $column_name=array();
        $attribute_data=array();
        $name='';
        $user_id='';
        $gender='';
        $dept='';
        $position='';
        $indate='';
        $role='';
        $proof_tag='';
        $counter=0;

        $this->model_wage_tag->deleteAll();
        $this->model_wage_users->deleteAll();
        $wage_set=array();
        $user_set=array();
        foreach($data as $k => $v){
            #$row_data=array();
            if($counter>1){
                foreach($v as $a=>$b)
                {
                    switch($data[1][$a]){
                        case '员工姓名':$name=$b;break;
                        case '身份证号':$user_id=$b;break;
                        case '性别':$gender=$b;break;
                        case '所在部门':$dept=$b;break;
                        case '岗位':$position=$b;break;
                        case '加入本企业时间':$indate=$b;break;
                        case '系统角色':$role=$b;break;
                        case '收入证明标识':$proof_tag=$b;break;
                    }
                }
                //新建用户标识
                $row_data=array(
                    'name' => $name,
                    'user_id' => $user_id,
                    'gender' => $gender,
                    'dept' => $dept,
                    'position' => $position,
                    'role' => $role,
                    'proof_tag' => $proof_tag
                );
                array_push($wage_set,$row_data);
                unset($row_data);
                //新建登陆用户
                switch($role){
                    case "部门负责人":$permission=1;break;
                    case "员工":$permission=3;break;
                    case "综管员":$permission=3;break;
                }
                $user_data=array(
                    'username' => $name,
                    'user_id' => $user_id,
                    'password' => md5(substr($user_id,-6)),
                    'permission' => $permission,
                );
                array_push($user_set,$user_data);
                unset($user_data);
            }
            $counter++;
        }
        $this->model_wage_tag->createbatch($wage_set);
        $this->model_wage_users->createbatch($user_set);
        unset($wage_set);
        unset($user_set);
    }
    public function wage_tag_import($filename=NULL)
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
                    $this->wage_tag_excel_put();
                    $this->tag();
                }
            }
        }
        else{
            $this->render_super_template('super/wage_tag_import',$this->data);
        } 
    }
    public function wage_excel_put(){
        $this->load->library("phpexcel");//ci框架中引入excel类
        $this->load->library('PHPExcel/IOFactory');
 
        //先做一个文件上传，保存文件
        $path=$_FILES['file'];
        $filePath = "uploads/wage/".$path["name"];

        move_uploaded_file($path["tmp_name"],$filePath);
        //根据上传类型做不同处理
        $file_name="";
        if (strstr($_FILES['file']['name'],'xlsx')) {
            $reader = new PHPExcel_Reader_Excel2007();
            $file_name = str_replace(".xlsx","",$_FILES['file']['name']);
        }
        else{
            if (strstr($_FILES['file']['name'], 'xls')) {
                $reader = IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)
                $file_name = str_replace(".xls","",$_FILES['file']['name']);
            }
        }
        //薪酬文件记录写入
        //如果有相同时期的文件，直接覆盖记录，如果没有的话，那就创建新文件记录
        if($this->model_wage_record->getRecordByDate($file_name)===null){
            $this->model_wage_record->create(array('upload_date' => $file_name,'path' => $filePath));    
        }
        else{
            $this->model_wage_record->update(array('path' => $filePath),$file_name);
        }
        
        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ','BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ','CA', 'CB', 'CC', 'CD', 'CE', 'CF', 'CG', 'CH', 'CI', 'CJ', 'CK', 'CL', 'CM', 'CN', 'CO', 'CP', 'CQ', 'CR', 'CS', 'CT', 'CU', 'CV', 'CW', 'CX', 'CY', 'CZ','DA', 'DB', 'DC', 'DD', 'DE', 'DF', 'DG', 'DH', 'DI', 'DJ', 'DK', 'DL', 'DM', 'DN', 'DO', 'DP', 'DQ', 'DR', 'DS', 'DT', 'DU', 'DV', 'DW', 'DX', 'DY', 'DZ'); 
        $PHPExcel = $reader->load($filePath, 'utf-8'); // 载入excel文件
        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumm = $sheet->getHighestColumn(); // 取得总列数
        $columnCnt = array_search($highestColumm, $cellName); 

        $data = array();
        for ($rowIndex = 1; $rowIndex <= $highestRow; $rowIndex++) {        //循环读取每个单元格的内容。注意行从1开始，列从A开始
            for ($colIndex = 0; $colIndex <= $columnCnt; $colIndex++) {
                $cellId = $cellName[$colIndex].$rowIndex;  
                $cell = $sheet->getCell($cellId)->getValue();
                $cell = $sheet->getCell($cellId)->getCalculatedValue();
                if ($cell instanceof PHPExcel_RichText) { //富文本转换字符串
                    $cell = $cell->__toString();
                }
                $data[$rowIndex][$colIndex] = $cell;
            }
        }

        $column=array();
        $column_name=array();
        $attribute_data=array();
        $flag=false;
        $counter=0;        
        $attribute=array();
        $content=array();
        $total_col=0;
        $attr=array();
        $attr_str='';
        $attr_counter=1;
        foreach($data[3] as $k => $v){
            if($v!=""){
                $attribute['attr_name'.$attr_counter]=$v;
                $attr_counter++;
            }
        }
        $attribute['date_tag']=$file_name;
        $attr_counter--;
        $this->model_wage_attr->delete_total();
        $this->model_wage_attr->create_total(array('total' => $attr_counter));
        if($this->model_wage_attr->getWageAttrDataByDate($file_name)){
            $this->model_wage_attr->update_attr($attribute);
        }
        else{
            $this->model_wage_attr->create_attr($attribute);
        }
    }
    
    public function wage_import($filename=NULL)
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
                    $this->wage_excel_put();
                    $this->search();
                    #$this->index();
                }
            }
        }
        else{
            $this->render_super_template('super/wage_import',$this->data);
        } 
    }
    public function excel(){
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
 
        $objPHPExcel->setActiveSheetIndex(0);
        
        $result = $this->model_wage_attr->exportAttrData();
        // Field names in the first row
        $fields = $result->list_fields();
        $col = 0;
        foreach ($fields as $field)
        {
            if($field != ""){
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
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
    public function download_page()
    {
        $this->data['user_name'] = $this->session->userdata('user_name');
        $this->data['path'] = "uploads/standard/wage_sample.xlsx";
        $this->render_super_template('super/wage_export',$this->data);
    }
    public function wage_doc_put(){
        //先做一个文件上传，保存文件
        $path=$_FILES['file'];
        $filePath = "uploads/wage_doc/".$path["name"];
        move_uploaded_file($path["tmp_name"],$filePath);
        $doc_data=array(
            'number' => date('Y-m-d H:i:s'),
            'doc_name' => basename($filePath,".pdf"),
            'doc_path' => $filePath,
        );
        $this->model_wage_doc->create($doc_data);
    }
    public function wage_doc_import($filename=NULL)
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
                    $this->wage_doc_put();
                    $this->wage_doc_list();
                }
            }
        }
        else{
            $this->render_super_template('super/wage_doc_import',$this->data);
        } 
    }

    public function wage_doc_list(){
        $wage_doc=$this->model_wage_doc->getWageDocData();
        $this->data['wage_doc']=$wage_doc;
        $this->render_super_template('super/wage_doc_list',$this->data);
    }
    
    
    public function wage_doc_delete(){
        $date = $_POST['time'];
        
        if($date){
			$delete = $this->model_wage_doc->delete($date);
            if($delete == true) {
                $this->session->set_flashdata('success', 'Successfully removed');
                redirect('super_wage/wage_doc_list', 'refresh');
            }
            else {
                $this->session->set_flashdata('error', 'Error occurred!!');
                redirect('super_wage/wage_doc_list', 'refresh');
            }	
		}
    }

    /*
    ============================================================
    查看部门综管员和负责人主页
    ============================================================
    */ 
    public function tag(){
        $manager_data = $this->model_wage_tag->getTagData();
		$result = array();
		
		foreach ($manager_data as $k => $v) {
			$result[$k] = $v;
		}
		$permission_set=array(
			1 => '部门经理',
			3 => '普通员工'
		);

		$this->data['manager_data'] = $result;
		$this->data['permission_set']=$permission_set;
		$this->render_super_template('super/wage_tag', $this->data);
    }
    public function notification(){
        $notice_data = $this->model_notice->getNoticeData();

		$result = array();
		
		foreach ($notice_data as $k => $v) {
            if($v['type']=='wage'){
                $v['type']='薪酬';
                $result[$k] = $v;
            }
		}
		
		$this->data['notice_data'] = $result;
		unset($result);
        $this->render_super_template('super/wage_notification', $this->data);
    }
    public function publish_wage(){
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
				'type' => 'wage'
			);
			$create = $this->model_notice->create($data);
        	if($create == true) {
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('super_wage/notification', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('super_wage/publish_wage', 'refresh');
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
            $this->render_super_template('super/wage_publish_wage', $this->data);
        }	
    }
    public function init_pass(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST[''];
        }
        $tag_data=$this->model_wage_tag->getTagData();
        $result=array();
        foreach($tag_data as $k => $v){
            array_push($result,array('name'=>$v['name'],'user_id'=>$v['']));
        }
        $this->data['user_data'] = $this->model_wage_users->getUserData();
        $this->render_super_template('super/wage_init_pass',$this->data);
    }
    public function tax_counter(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->data['result']=10;
            $this->render_super_template('super/tax_result',$this->data);    
        }
        else{
            $this->render_super_template('super/tax',$this->data);
        }
    }
    public function log_show(){
        $this->data['log']=$this->model_log_action->getLogData();
        #print_r($this->data['log']);
        $this->render_super_template('super/wage_log',$this->data);
    }
}