<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Super_wage extends Admin_Controller 
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
        $this->load->model('model_submit');
        
        $this->load->model('model_feedback');
        $this->load->model('model_wage_users');
        $this->load->model('model_wage_tag');
        $this->load->model('model_wage_attr');
        $this->load->model('model_wage');
        $this->load->model('model_wage_doc');
        $this->data['permission']=$this->session->userdata('permission');
        $this->data['user_name'] = $this->session->userdata('user_id');
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

        $this->render_super_template('super/wage',$this->data);
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
 /*       */
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
                        break;
                }
            }
            $this->model_wage->create($content_data);
            unset($content_data);
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
        $filePath = "uploads/".$path["name"];
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
                    $this->wage_doc_show();
                }
            }
        }
        else{
            $this->render_super_template('super/wage_doc_import',$this->data);
        } 
    }

    public function wage_doc_show(){
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
                redirect('super_wage/wage_doc_show', 'refresh');
            }
            else {
                $this->session->set_flashdata('error', 'Error occurred!!');
                redirect('super_wage/wage_doc_show', 'refresh');
            }	
		}
        $this->render_super_template('super/wage_doc_show',$this->data);
    }
    /*
    ============================================================
    休假管理
    包括：
    1、主页，休假汇总
    2、
    ============================================================
    */ 
    public function holiday(){
        $holiday_data = $this->model_holiday->getHolidayData();

        $result = array();
        foreach ($holiday_data as $k => $v) {
            $result[$k] = $v;
            
            //如果初始化過就不進行初始化 initflag记录是否被初始化过 0未初始化，1初始化完成
            if($result[$k]['initflag']==0){
                $result[$k]['Companyage']=floor((strtotime(date("Y-m-d"))-strtotime($result[$k]['indate']))/86400/365);
                $result[$k]['Totalage']=floor((strtotime(date("Y-m-d"))-strtotime($result[$k]['initdate']))/86400/365);

                if($result[$k]['Companyage']>=1 and $result[$k]['Companyage']<10){
                    $result[$k]['Thisyear']=5;
                }
                else if($result[$k]['Companyage']>=10 and $result[$k]['Companyage']<20){
                    $result[$k]['Thisyear']=10;
                }
                else if($result[$k]['Companyage']>=20){
                    $result[$k]['Thisyear']=15;
                }
                $result[$k]['Totalday']=$result[$k]['Thisyear']+$result[$k]['Lastyear']+$result[$k]['Bonus'];
                $result[$k]['Rest']=$result[$k]['Totalday'];
                $result[$k]['initflag']=1;
                $result[$k]['Used']=$result[$k]['Jan']+$result[$k]['Feb']+$result[$k]['Mar']+$result[$k]['Apr']+$result[$k]['May']+$result[$k]['Jun']+$result[$k]['Jul']+$result[$k]['Aug']+$result[$k]['Sep']+$result[$k]['Oct']+$result[$k]['Nov']+$result[$k]['Dece'];
                //更新数据
                $data = array(
                    'Companyage' => $result[$k]['Companyage'],
                    'Totalage' => $result[$k]['Totalage'],
                    'Thisyear' => $result[$k]['Thisyear'],
                    'Totalday' => $result[$k]['Totalday'],
                    'Rest' => $result[$k]['Rest'],
                    'initflag' => $result[$k]['initflag'],
                    'Used' => $result[$k]['Used'],
                );
    
                $update = $this->model_holiday->update($data, $result[$k]['user_id']);
               
            }
            
        }

        $this->data['holiday_data'] = $result;
        
        $this->data['permission']=$this->session->userdata('permission');
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
                redirect('super/holiday_doc_show', 'refresh');
            }
            else {
                $this->session->set_flashdata('error', '数据库中不存在该记录');
                redirect('super/holiday_doc_show', 'refresh');
            }	
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
        $this->model_feedback->deleteAll();
        $this->model_holiday->deleteAll();
        $this->model_plan->deleteAll();
        $this->model_submit->deleteAll();
        $this->model_users->deleteAll();
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

            //初始化年假计划反馈，每个部门新建一个反馈记录，部门为主键
            
            if($this->model_feedback->getFeedbackByDept($Update_data['department'])==NULL)
            {
                $feedback_data=array(
                    'department' => $Update_data['department'],
                );
                $this->model_feedback->create($feedback_data);
            }
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

            //初始化计划提交
            
            if($this->model_submit->getSubmitByDept($Update_data['department'])==NULL)
            {
                $submit_data=array(
                    'department' => $Update_data['department']
                );
                $this->model_submit->create($submit_data);
            }

            

            //初始化用户信息，每个人新建一条用户记录，用于登陆，密码为身份证后六位
            $Update_user_data=array(
                'user_id' => $User_id,
                'username' => $name,
                'password' => md5(substr($User_id,-6)),
                'permission' => '3'
            );
            $update_user=$this->model_users->create($Update_user_data,$name);   
            /**/

        }
        /*
        if($update == true and $update_user == true) {
            $response['success'] = true;
            $response['messages'] = 'Succesfully updated';
        }
        else {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while updated the brand information';			
        }
        */
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
    public function users(){
        $user_data = $this->model_users->getUserData();

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
    
}