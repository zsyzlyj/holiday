<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Super extends Admin_Controller 
{

	public function __construct()
	{
        parent::__construct();
        $this->data['page_title'] = 'Super';
        $this->load->model('model_holiday');
        $this->load->model('model_plan');
        $this->load->model('model_notice');
        $this->load->model('model_manager');
        $this->load->model('model_submit');
        $this->load->model('model_users');
        $this->load->model('model_feedback');
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
    public function wage(){
        $this->data['wage_data']=$this->model_wage->getWageData();
        $this->data['total_column']=$this->model_wage_attr->getWageTotalData()['total'];
        $this->data['wage_attr']=$this->model_wage_attr->getWageAttrData()['attr'];
        $this->render_super_template('super/wage',$this->data);
    }
    
    public function wage_template($pdf){
        
        $user_data=$this->model_wage->getWageById($this->session->userdata('user_id'));
        $holiday_data=$this->model_holiday->getHolidayById($this->session->userdata('user_id'));
        $date=$holiday_data['indate'];

        $user_id=$user_data['user_id'];
        $username=$user_data['name'];
        $pdf->SetFont('kozminproregular', 'B', 24);
        $str="收 入 证 明";
        $pdf->Write(0,$str,'', 0, 'C', true, 0, false, false, 0);  
        $str="\r\n            兹证明 ".$username."（身份证号码： ".$user_id."）为中国联合网络通信有限公司中山市分公司正式员工，自".date('Y年m月d日',strtotime($date))."起为我司工作，现于我单位任职综合部、综合文秘室综合秘书，其月收入（税前）包括工资、奖金、津贴约xxx元（大写：壹萬贰仟圆整），以上情况属实。此证明仅限于申请贷款之用。\r\n            特此证明！\r\n\r\n\r\n";
        $pdf->SetFont('kozminproregular', '', 14);
        $pdf->Write(0,$str,'', 0, 'L', false, 0, false, false, 0);  
    
        $str="\r\n经办人：\t\t\t\t\t\r\n中山联通人力资源与企业发展部\r\n单位（盖章）\r\n".date("Y年m月d日")."\r\n\r\n\r\n";
        $pdf->setCellHeightRatio(1.7); 
        $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false); 
        $pdf->setCellHeightRatio(1.5); 
        $pdf->SetFont('kozminproregular', '', 9);
        $str="\r\n\r\n联系地址：中山市长江北路6号联通大厦\r\n联系人：甘先生\r\n联系电话：0760-23692312";
        $pdf->Write(0,$str,'', 0, 'L', false, 0, false, false);
        $pdf->Output('t.pdf', 'I');
    }
    
    public function fund_template($pdf){
        $user_data=$this->model_wage->getWageById($this->session->userdata('user_id'));
        $holiday_data=$this->model_holiday->getHolidayById($this->session->userdata('user_id'));

        $cage=$holiday_data['Companyage'];
        $user_id=$user_data['user_id'];
        $username=$user_data['name'];
        $pdf->SetFont('kozminproregular');
        $html='<p align="center"><font size="24">收 入 证 明</font></p><br />
        <div style="line-height:40px;">
        <font size="13">中山市住房公积金管理中心:</font>
        <br />
        <font size="13">为申请住房公积金贷款事宜，兹证明 '.$username.'，性别：无 ，身份证号：'.$user_id.'是我单位职工，已在我单位工作满'.$cage.'年，该职工上一年度在我单位总收入约为元（大写：拾壹萬伍仟圆整）。
        </font>
        </div>';
        
        $pdf->WriteHTML($html);

        /*
        $pdf->SetFont('kozminproregular', 'B', 24);
        $str="收 入 证 明\r\n";
        $pdf->Write(0,$str,'', 0, 'C', true, 0, false, false, 0);  
        $pdf->SetFont('kozminproregular', '', 14);
        $str="\r\n中山市住房公积金管理中心：\r\n";
        $pdf->Write(0,$str,'', 0, 'L', false, 0, false, false, 0);  
        $str="为申请住房公积金贷款事宜，兹证明";#.$username."，性别：无，身份证号码：";
        $pdf->Write(0,$str,'', 0, 'L', false, 0, false, false, 0);  
        $str=$username;
        $pdf->SetFont('', 'U');
        $pdf->Write(0,$str,'', 0, 'L', false, 0, false, false, 0);  
        $str="，性别：无，身份证号码：".$user_id;
        $pdf->SetFont('kozminproregular', '', 14);
        $pdf->Write(0,$str,'', 0, 'L', false, 0, false, false, 0);  
        $str="，是我单位 干部□、职工□，（请在□内打√），已在我单位工作满";
        $pdf->SetFont('kozminproregular', '', 14);
        $pdf->Write(0,$str,'', 0, 'L', false, 0, false, false, 0);  
        $pdf->SetFont('kozminproregular', 'U', 14);
        $pdf->Write(0,$cage,'', 0, 'L', false, 0, false, false, 0);  
        $str="年，该职工上一年度在我单位总收入约为 ";
        $pdf->SetFont('kozminproregular', '', 14);
        $pdf->Write(0,$str,'', 0, 'L', false, 0, false, false, 0);  
        $str="xxxx元（大写：拾壹萬伍仟圆整）。";
        $pdf->SetFont('kozminproregular', 'U', 14);
        $pdf->Write(0,$str,'', 0, '', false, 0, false, false, 0);  
        
        $pdf->SetFont('kozminproregular', '', 14);
        $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false); 
        $str="\r\n经办人：\t\t\t\t\t\r\n中山联通人力资源与企业发展部\r\n单位（盖章）\r\n".date("Y年m月d日")."\r\n\r\n\r\n";
        $pdf->setCellHeightRatio(1.7); 
        $pdf->SetFont('kozminproregular', '', 14);
        $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false); 
        $pdf->setCellHeightRatio(1.5); 
        $pdf->SetFont('kozminproregular', '', 9);
        $str="\r\n\r\n联系地址：中山市长江北路6号联通大厦\r\n联系人：甘先生\r\n联系电话：0760-23692312";
        $pdf->Write(0,$str,'', 0, 'L', false, 0, false, false);  
        //输出PDF 
        
        */
        $pdf->Output('收入证明（住房公积金）.pdf', 'I');
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
        switch($type){
            case 'wage':$this->wage_template($pdf);break;
            case 'bank_wage':$this->bank_wage_template($pdf);break;
            case 'fund':$this->fund_template($pdf);break;
            #case 'wage':$this->wage_template();break;
            default:break;
        }
        
        //输出PDF 
        
    }
    public function wage_proof(){
        $this->render_template('super/wage_proof',$this->data);
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
        $this->PDF_Creator("bank_wage");
    }
    /*
    //收入证明
    public function show_fund_proof(){
        $this->PDF_Creator();
    }
    //收入证明
    public function show_fund_proof(){
        $this->PDF_Creator();
    }
    //收入证明
    public function show_fund_proof(){
        $this->PDF_Creator();
    }
    //收入证明
    public function show_fund_proof(){
        $this->PDF_Creator();
    }
    //收入证明
    public function show_fund_proof(){
        $this->PDF_Creator();
    }
    //收入证明
    public function show_fund_proof(){
        $this->PDF_Creator();
    }
    //收入证明
    public function show_fund_proof(){
        $this->PDF_Creator();
    }
    //收入证明
    public function show_fund_proof(){
        $this->PDF_Creator();
    }
    */

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
        $first=array();
        $second=array();
        $third=array();
        $fourth=array();
        $flag=false;
        $counter=0;        
        $attribute=array();
        $content=array();
        $total_col=0;
        $attr=array();
        foreach($data as $k => $v){
            $row_data=array();
            
            if($counter>=2 and $counter<=5){
                foreach($v as $a=>$b)
                {
                    if($b=='')
                        array_push($row_data,'space');
                    else array_push($row_data,$b);
                    
                }
                if($total_col==0){
                    $total_col=count($row_data);
                }                
                array_push($attr,$row_data);
                unset($row_data);
            }
            if($counter>5)
            {
                foreach($v as $a=>$b)
                {
                    array_push($row_data,$b);
                }
                array_push($content,$row_data);
                unset($row_data);
            }
            $counter++;
        }
        //清除所有全空的行
        for($i=0;$i<$total_col;$i++){
            if($attr[0][$i]=='space' and $attr[1][$i]=='space' and $attr[2][$i]=='space' and $attr[3][$i]=='space'){
                for($j=0;$j<4;$j++){
                    unset($attr[$j][$i]);
                }
            }
        }
        
        $total_col=count($attr[0]);
        echo $total_col;
        
        $attr_str='';
        foreach($attr as $k => $v){
            $attr_str=$attr_str.'<tr>';
            foreach($v as $a => $b){
                if($b=='space')
                    $attr_str=$attr_str.'<th></th>';
                else $attr_str=$attr_str.'<th>'.$b.'</th>';
            }
            $attr_str=$attr_str.'</tr>';
        } 
        $attr_data=array(
            'attr' => $attr_str
        );
        $this->model_wage_attr->delete_attr();
        $this->model_wage_attr->create_attr($attr_data);
        $total_data=array(
            'total' => $total_col
        );
        $this->model_wage_attr->delete_total($total_data);
        $this->model_wage_attr->create_total($total_data);

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
                    $this->wage();
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
            'number' => date('Y-m-d h:i:s'),
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
                redirect('super/wage_doc_show', 'refresh');
            }
            else {
                $this->session->set_flashdata('error', 'Error occurred!!');
                redirect('super/wage_doc_show', 'refresh');
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
        /* excel导入时间的方法！ */
        $initflag=0;
        foreach($column as $k => $v)
        {
            foreach($v as $a => $b)
            {
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
            if($this->model_holiday->getHolidaybyID($User_id))
            {
                if(!(serialize($Update_data) == serialize($this->model_holiday->getHolidaybyID($User_id)))){
                   $update=$this->model_holiday->update($Update_data,$User_id);
                }
            }
            else{
                $update=$this->model_holiday->create($Update_data);
                if($this->model_users->getUserById($User_id)==1){
                    $Update_user_data=array(
                        'user_id' => $User_id,
                        'username' => $name,
                        'password' => md5('hr'),
                        'permission' => '3'
                    );
            
                    $update_user=$this->model_users->create($Update_user_data,$name);
                }
                $submit_data=array(
                    'department' => $Update_data['department']
                );
                $this->model_submit->create($submit_data);
                $feedback_data=array(
                    'department' => $Update_data['department'],
                );
                $this->model_feedback->create($feedback_data);
            }
            
            if($update == true and $update_user == true) {
                $response['success'] = true;
                $response['messages'] = 'Succesfully updated';
            }
            else {
                $response['success'] = false;
                $response['messages'] = 'Error in the database while updated the brand information';			
            }  
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
                $feedback_data=array(
                    'department' => $dept,
                    'content' => '',
                    'confirm' => 0,
                    'status' => '未审核'
                );
                if($this->model_feedback->getFeedbackByDept()==NULL){
                    $this->model_feedback->create($feedback_data);
                }
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
    /*
    ============================================================
    绩效管理
    包括：
    1、
    2、
    ============================================================
    */ 
    public function achievement (){
        $this->render_super_template('super/achievement',$this->data);
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

		        	$update = $this->model_users->edit($data, $id);
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

						$update = $this->model_users->edit($data, $id);
						
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
			        	$user_data = $this->model_users->getUserData($id);

			        	$this->data['user_data'] = $user_data;

						$this->render_super_template('super/setting', $this->data);	
			        }	

		        }
	        }
	        else {
	            // false case
	        	$user_data = $this->model_users->getUserData($id);

	        	$this->data['user_data'] = $user_data;

				$this->render_super_template('super/setting', $this->data);	
	        }	
		}
	}
}