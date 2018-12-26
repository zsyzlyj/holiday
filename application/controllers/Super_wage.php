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
        $this->load->model('model_manager');
        $this->load->model('model_wage_users');
        $this->load->model('model_wage_tag');
        $this->load->model('model_wage_attr');
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
    public function search(){

        
        $this->render_super_template('super/wage_search',$this->data);
    }
    
    public function proof_Creator($type){
        $this->load->library('tcpdf.php');
        //实例化 
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false); 
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
        #$pdf->setHeaderFont(Array('kozminproregular', '', '10')); 
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
        
        $pdf->setCellHeightRatio(3);
        $pdf->AddPage('P', 'A4'); 
        
        //设置背景图片
        $img_file = 'assets/images/Unicom.jpg';
        $pdf->Image($img_file, 0, 0, 0, 500, '', '', '', false, 300, '', false, false, 0);

        $user_data=$this->model_wage->getWageById($this->session->userdata('user_id'));
        $holiday_data=$this->model_holiday->getHolidayById($this->session->userdata('user_id'));

        $cage=$holiday_data['Companyage'];
        $user_id=$user_data['user_id'];
        $username=$user_data['name'];
        $date=date('Y年m月d日',strtotime($holiday_data['indate']));
        
        $str="收 入 证 明\r\n";
        $pdf->SetFont('kozminproregular','B',24);
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
                $pdf->SetFont('kozminproregular','',14);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n".date("Y年m月d日");
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false, 0);
                break;
            case 'on_post_2':
                $str="\r\n          兹有".$username."（女，身份证号：".$user_id."），为中国联合网络通信有限公司中山市分公司中层管理干部，现任中国联合网络通信有限公司中山市分公司综合部部门经理。\r\n            特此证明。\r\n\r\n";
                $pdf->SetFont('kozminproregular','',14);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n".date("Y年m月d日");
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false, 0);
                break;
            case 'on_post_3':
                $str="\r\n          兹有刘颖（女，身份证号：110108196709174243），为中国联合网络通信有限公司中山市分公司中层管理干部，现任中国联合网络通信有限公司中山市分公司综合部部门经理。\r\n            特此证明。\r\n";
                $pdf->SetFont('kozminproregular','',14);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n".date("Y年m月d日")."\r\n\r\n\r\n\r\n";
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false, 0);
                $pdf->setCellHeightRatio(1.5); 
                $pdf->SetFont('kozminproregular', '', 9);
                $str="单位名称：中国联合网络通信有限公司中山市分公司\r\n联系地址：中山市东区长江北路6号联通大厦\r\n联系人：徐小姐           联系电话：0760-23771356";
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);

                break;
            case 'on_post_4':
                $str="\r\n          兹有我单位".$username."同志，性别：男，身份证号码：".$user_id."，于".$date."至今在我单位从事 南部固网销售公司总经理 （职位）工作。\r\n单位名称：中国联合网络通信有限公司中山市分公司\r\n          联系地址：中山市东区长江北路6号联通大厦\r\n          联系人：徐小姐        联系电话：0760-23771356\r\n          特此证明。\r\n       （此证明仅用于办理流动人员积分制管理使用）\r\n";
                $pdf->SetFont('kozminproregular','',14);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n".date("Y年m月d日")."\r\n\r\n\r\n\r\n";
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false, 0);
                break;
            case 'on_post_5':
                $str="\r\n          兹有".$username."（女，身份证号：".$user_id."），自".$date."进入我公司工作，现任中国联合网络通信有限公司中山市分公司员工 （职位）。\r\n          特此证明。\r\n       （此证明仅用于办理居住证使用）";
                $pdf->SetFont('kozminproregular','',14);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n".date("Y年m月d日")."\r\n\r\n\r\n\r\n";
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false, 0);
                $pdf->setCellHeightRatio(1.5); 
                $pdf->SetFont('kozminproregular', '', 9);
                $str="单位名称：中国联合网络通信有限公司中山市分公司\r\n联系地址：中山市东区长江北路6号联通大厦\r\n联系人：徐小姐           联系电话：0760-23771356";
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                
                break;
            case 'one_child':
                $str="";
                break;

            default:break;
        }

        if(!(strstr($type,'post'))){
            $pdf->SetFont('kozminproregular','',14);
            $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
            $str="\r\n\r\n经办人：\t\t\t\t\t\r\n中国联合网络通信有限公司中山市分公司\r\n单位（盖章）\r\n".date("Y年m月d日")."\r\n\r\n\r\n\r\n\r\n";
            $pdf->setCellHeightRatio(1.7); 
            $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false); 
            $pdf->setCellHeightRatio(1.5); 
            $pdf->SetFont('kozminproregular', '', 9);
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
                #$row_data();
                #unset($row_data);
                
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
                if($this->model_wage_tag->getTagById($user_id)==NULL){
                    $this->model_wage_tag->create($row_data);
                }
                else{
                    $this->model_wage_tag->update($row_data,$user_id);
                }
                
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
                if($this->model_wage_users->getUserById($user_id)==NULL){
                    $this->model_wage_users->create($user_data);
                }
                else{
                    $this->model_wage_users->update($user_data,$user_id);
                }
                unset($user_data);
            }
            
            $counter++;   
        }
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
                    $this->index();
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
        $flag=false;
        $counter=0;        
        $attribute=array();
        $content=array();
        $total_col=0;
        $attr=array();
        $attr_str='';
        $attr_counter=1;
        foreach($data as $k => $v){
            $row_data=array();
            if($counter==2){
                foreach($v as $a=>$b)
                {
                    if($b!=""){
                        $attribute['attr_name'.$attr_counter]=$b;
                        $attr_counter++;
                    }
                }
            }
            if($counter>2){
                foreach($v as $a=>$b)
                {
                    if($b!="" or $b=="0"){
                       array_push($row_data,$b);
                       
                    }
                }
                array_push($content,$row_data);
            }
            
            unset($row_data);
            $counter++;
        }
        $attr_counter--;
        $this->model_wage_attr->delete_total();
        $this->model_wage_attr->create_total(array('total' => $attr_counter));
        $this->model_wage_attr->delete_attr();
        $this->model_wage_attr->create_attr($attribute);

        //把数据打包，写入数据库
        $this->model_wage->deleteAll();
        $wage_set=array();
        foreach($content as $k => $v){
            $content_data=array();    
            foreach($v as $a => $b){
                switch($a){
                    case 0:$content_data['number']=$b;break;
                    case 1:$content_data['department']=$b;break;
                    case 2:$content_data['user_id']=$b;break;
                    case 3:$content_data['name']=$b;break;
                    default:
                        $content_data['content'.($a-3)]=$b;
                        #echo ($a-3).'<br />';
                        break;
                }
            }
            if($a!=$attr_counter-1){
                #echo ($attr_counter-4).'<br />';
                $content_data['content'.($attr_counter-4)]="";
            }

            array_push($wage_set,$content_data);
            unset($content_data);
        }
        $this->model_wage->createbatch($wage_set);
        unset($wage_set);
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
                    $this->index();
                }
            }
        }
        else{
            $this->render_super_template('super/wage_import',$this->data);
        } 
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
        $this->render_super_template('super/wage_doc_list',$this->data);
    }

    public function tax_counter(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->data['result']=10;
            $this->render_super_template('super/tax_result',$this->data);    
        }
        $this->render_super_template('super/tax',$this->data);
    }
}