<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Wage extends Admin_Controller{
	public function __construct(){
		parent::__construct();
		$this->not_logged_in();
		$this->data['page_title'] = 'Wage';
        $this->load->model('model_wage');
        $this->load->model('model_holiday');
        $this->load->model('model_users');
        $this->load->model('model_wage_doc');
        $this->load->model('model_wage_apply');
        $this->load->model('model_wage_apply_status');
        $this->load->model('model_wage_tag');
        $this->load->model('model_wage_attr');
        $this->load->model('model_hr_content');
        $this->load->model('model_func');
        $this->load->model('model_wage_notice');
        $this->load->model('model_notice');
        $this->load->model('model_wage_sp');
        $this->load->model('model_wage_sp_attr');
        
        $this->load->model('model_wage_tax');
        $this->load->model('model_wage_tax_attr');
        $this->data['permission'] = $this->session->userdata('permission');
        $this->data['user_name'] = $this->session->userdata('user_name');
        $this->data['user_id'] = $this->session->userdata('user_id');
        $this->data['wage_func']=$this->model_func->getFuncByType('wage');
        $this->data['service_mode']= $this->model_wage_tag->getModeById($this->session->userdata('user_id'))['service_mode'];
        $this->data['notice'] = $this->model_notice->getNoticeLatestWage();
    }
    
	public function index(){
        $this->staff();
    }
    
    public function watermark(){
        require_once(APPPATH.'libraries\FPDI\src\fpdi.php');
        require_once(APPPATH.'libraries\PDF_rotate.php');
        $path=$_POST['doc_path'];
        $name=$this->data['user_id'].'.pdf';
        $pdf =new PDF();
        // get the page count
        $pageCount = $pdf->setSourceFile($path);
        
        $pdf->SetFont('songti','','16');
        $pdf->SetTextColor(250,250,250);
        // iterate through all pages
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++){
            // import a page
            $templateId = $pdf->importPage($pageNo);
            #$pdf->AddGBFont(); 
            // get the size of the imported page
            $size = $pdf->getTemplateSize($templateId);
            // create a page (landscape or portrait depending on the imported page size)
            if ($size['width'] > $size['height']) 
                $pdf->AddPage('L', array($size['width'], $size['height']));
            else $pdf->AddPage('P', array($size['width'], $size['height']));
            for($i=20;$i<$size['width'];$i+=70){
                for($j=50;$j<$size['height'];$j+=90)
                    $pdf->RotatedText($i,$j,$this->data['user_name'],45);
            }

            for($i=50;$i<$size['width'];$i+=70){
                for($j=120;$j<$size['height'];$j+=90)
                    $pdf->RotatedText($i,$j,$this->data['user_name'],45);
            }
            // use the imported page
            $pdf->useTemplate($templateId);
        }
        $pdf->Output(dirname(__FILE__,3).'\\watermark\\'.$name,'F');
        redirect('http://10.210.193.234/hr/watermark/'.$name,'refresh');
    }
    public function wage_doc(){
        $wage_doc = $this->model_wage_doc->getWageDocData();
        
        /*
        foreach($wage_doc as $k => $v){
            $wage_doc[$k]['doc_path']=$this->watermark($v['doc_path']);
        }
        */
        $this->data['wage_doc'] = $wage_doc;
        $this->data['type_array'] = $this->model_wage_doc->getDocType();
        unset($wage_doc);
        $this->render_template('wage/wage_doc', $this->data);
    }
    /*
    ==============================================================================
    部门经理
    ==============================================================================
    */
    public function manager(){        
        $this->staff();
    }
    /*
    ==============================================================================
    普通员工
    ==============================================================================
    */
    public function staff(){
        $this->search();
    }
    
    public function apply_wage_proof(){
        $user_id=$this->session->userdata('user_id');
        if($_SERVER['REQUEST_METHOD'] == 'POST'){            
            $apply_data=array(
                'user_id' => $user_id,
                'name' => $this->session->userdata('user_name'),
                'type' => $_POST['type'],
                'submit_time' => date('Y-m-d H:i:s'),
                'submit_status' => '已提交',
                'feedback_status' => '未审核',
                'url' => $this->proof_creator($_POST['type'],true)
            );
            $apply_status=array(
                'user_id' => $user_id,
                'username' => $this->session->userdata('user_name'),
                'type' => $_POST['type'],
                'submit_status' => '已提交',
                'feedback_status' => '未审核',
            );
            //更新状态这里没有主键，需要匹配user_id和type，更新或生成申请状态
            if($this->model_wage_apply_status->getStatusByIdAndType($user_id,$_POST['type'])){
                $this->model_wage_apply_status->update($apply_status,$user_id,$_POST['type']);
            }
            else $this->model_wage_apply_status->create($apply_status);
            //生成一条申请记录
            $this->model_wage_apply->create($apply_data);
            //2019.03.08这里一整段需要需要重写
            //2019.03.11 12:00 重写完毕，准备测试
        }
        //获取数据库中 已提交 状态的这个人证明开具信息
        #$apply_info=$this->model_wage_apply->getApplyByIdAndStatus($user_id,'已提交');
        #$apply_status=$this->model_wage_apply_status->getApplyById($user_id);
        
        $this->data['name']=array(
            0 => '收入证明',
            1 => '收入证明（农商银行）',
            2 => '收入证明（公积金）',
        ); 
        $url_set=array();
        foreach($this->data['name'] as $k => $v){
            $url=$this->proof_creator($v,false);
            array_push($url_set,$url);
        }
        $status=array();
        $submit_status=array();
        $feedback_status=array();
        //预设全部可以浏览
        for($i=0;$i<count($this->data['name']);$i++){
            $status[$i]=true;
            $submit_status[$i]='';
            $feedback_status[$i]='';
        }
        //查询每个类别的是否存在
        foreach($this->data['name'] as $k => $v){
            $apply_status=$this->model_wage_apply_status->getStatusByIdAndType($user_id,$v);
            if($apply_status){
                $submit_status[$k]=$apply_status['submit_status'];
                $feedback_status[$k]=$apply_status['feedback_status'];
                if(strstr($apply_status['submit_status'],'已')){
                    if(strstr($apply_status['feedback_status'],'已'))
                        $status[$k]=true;
                    else $status[$k]=false;
                }
            }
            else{
                $submit_status[$k]=false;
                $feedback_status[$k]=false;
                $status[$k]=true;
            }
        }
        $this->data['submit_status']=$submit_status;
        $this->data['feedback_status']=$feedback_status;
        $this->data['status']=$status;
        $this->data['url']=$url_set;
        unset($url_set);
        $this->render_template('wage/apply', $this->data);
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
    public function proof_creator($type,$apply_flag){
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
        if(!$apply_flag){
            $img_file = 'assets/images/Unicom.jpg';    
            $pdf->Image($img_file, 0, 0, 0, 500, '', '', '', false, 300, '', false, false, 0);
        }
        $user_id=$this->data['user_id'];
        $user_data=$this->model_wage_tag->getTagById($user_id);
        
        #$user_data=$this->model_hr_content->getById($user_id);
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
            case '收入证明':
                $str="\r\n    兹证明".$username."(身份证号码：".$user_id.")为中国联合网络通信有限公司中山市分公司正式员工，自".$date."起为我司工作，现于我单位任".$dept.$position."，其月收入（税前）包括工资、奖金、津贴约".$avg."元（大写：".$rmb."），以上情况属实。此证明仅限于申请贷款之用。\r\n    特此证明！\r\n";
                $pdf->setCellHeightRatio(2.5); 
                $pdf->SetFont('songti','',15);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n\r\n经办人：\t\t\t\t\t\r\n中国联合网络通信有限公司中山市分公司\r\n人力资源与企业发展部\r\n".date("Y年m月d日")."\r\n\r\n";
                $pdf->setCellHeightRatio(1.7); 
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false); 
                if(!$apply_flag){
                    $pdf->setCellHeightRatio(1.0); 
                    $pdf->SetFont('songti','',11);
                    $str="\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n广东省中山市东区长江北路6号\r\n电话：0760-23666666 传真：0760-23666888\r\n网址：http://www.10010.com/";
                    $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false);
                }
                break;
            case '收入证明（农商银行）':
                $str="\r\n中山农村商业银行股份有限公司：\r\n    兹证明".$username."（身份证号码：".$user_id."）为我单位正式员工，自".$date."起为我单位工作，现于我单位任".$dept.$position."，其月收入（税前）包括工资、奖金、津贴约".$avg."元（大写：".$rmb."），以上情况属实。此证明仅限于申请贷款之用。\r\n    特此证明！";
                $pdf->setCellHeightRatio(2.5); 
                $pdf->SetFont('songti','',15);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n\r\n经办人：\t\t\t\t\t\r\n中国联合网络通信有限公司中山市分公司\r\n人力资源与企业发展部\r\n".date("Y年m月d日")."\r\n\r\n";
                $pdf->setCellHeightRatio(1.7); 
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false); 
                if(!$apply_flag){
                    $pdf->setCellHeightRatio(1.0); 
                    $pdf->SetFont('songti','',11);
                    $str="\r\n\r\n\r\n\r\n\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n广东省中山市东区长江北路6号\r\n电话：0760-23666666 传真：0760-23666888\r\n网址：http://www.10010.com/";
                    $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false);
                }
                break;
            case '收入证明（公积金）':
                $str="\r\n中山市住房公积金管理中心：\r\n    为申请住房公积金贷款事宜，兹证明".$username."，性别：".$gender."，身份证号码：".$user_id."，是我单位职工，已在我单位工作满".$period."年，该职工上一年度在我单位总收入约为".$sum."元（大写：".$rmb_sum."）。\r\n\r\n";
                $pdf->setCellHeightRatio(2.5); 
                $pdf->SetFont('songti','',15);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n经办人：\t\t\t\t\t\r\n中国联合网络通信有限公司中山市分公司\r\n人力资源与企业发展部\r\n".date("Y年m月d日")."\r\n\r\n";
                $pdf->setCellHeightRatio(1.7); 
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false); 
                $str="\r\n    重要提示：本证明所证明情况必须真实，如有虚假，中山市住房公积金管理中心保留依法追究相关责任的权利。";
                $pdf->setCellHeightRatio(1.5); 
                $pdf->SetFont('songti','B',11);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false); 
                if(!$apply_flag){
                    $pdf->setCellHeightRatio(1.0); 
                    $pdf->SetFont('songti','',11);
                    $str="\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n广东省中山市东区长江北路6号\r\n电话：0760-23666666 传真：0760-23666888\r\n网址：http://www.10010.com/";
                    $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false);
                }
                break;
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
        if($apply_flag){
            $path=dirname(__FILE__,3).'/proof/'.$date_name.'-'.$username.'-'.$type.'.pdf';
            $url='proof/'.$date_name.'-'.$username.'-'.$type.'.pdf';
        }
        else{
            $path=dirname(__FILE__,3).'/proof/'.$username.'-'.$type.'-temp.pdf';
            $url='proof/'.$username.'-'.$type.'-temp.pdf';
        }
        $pdf->Output($path, 'F');
        return $url;
        /*
        if(strstr($type,'收入')){
            $pdf->setCellHeightRatio(2.5); 
            $pdf->SetFont('songti','',15);
            $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
            $str="\r\n\r\n\r\n经办人：\t\t\t\t\t\r\n中国联合网络通信有限公司中山市分公司\r\n人力资源与企业发展部\r\n".date("Y年m月d日")."\r\n\r\n";
            $pdf->setCellHeightRatio(1.7); 
            $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false); 
            $pdf->setCellHeightRatio(1.0); 
            $pdf->SetFont('songti','',11);
            $str="\r\n\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n广东省中山市东区长江北路6号\r\n电话：0760-23666666 传真：076023666888\r\n网址：http://www.10010.com/";
            $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false);
        }
        */
        /*
            case '计生证明':
                $str="\r\n          ".$username."（身份证号：".$user_id."），为中国联合网络通信有限公司中山市分公司在编员工，于20xx年xx月与xxx登记结婚，属初婚已育壹孩，没有违反计划生育政策。其在我司工作期间的计划生育工作由我司负责管理。\r\n          特此证明。";
                $pdf->SetFont('songti','',15);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n".date("Y年m月d日");
                $pdf->SetFont('songti','',15);
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false, 0);
                break;
            case '子女户口非在注册证明':
                $str="\r\n          兹有".$username."（".$gender."，身份证号：".$user_id."）为我司在编员工，户籍迁入我司集体户统一管理，于20xx年xx月xx日与xxx登记结婚，20xx年xx月xx日育有一女，其女xxx非我司在册集体户口。\r\n          特此证明。";
                $pdf->SetFont('songti','',15);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n".date("Y年m月d日");
                $pdf->SetFont('songti','',15);
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false, 0);
                break;
                */
    }
    public function search_excel($doc_name,$user_id){
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
                            if (strstr($child_dir,'xlsx')){
                                $reader = new PHPExcel_Reader_Excel2007();
                            }
                            else{
                                if (strstr($child_dir, 'xls')){
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
                            for ($rowIndex = 1; $rowIndex <= $highestRow; $rowIndex++){        //循环读取每个单元格的内容。注意行从1开始，列从A开始
                                $cellId = $cellName[2].$rowIndex;  
                                $cell = $sheet->getCell($cellId)->getCalculatedValue();
                                if ($cell instanceof PHPExcel_RichText){ //富文本转换字符串
                                    $cell = $cell->__toString();
                                }
                                if($cell===$user_id){
                                    for ($colIndex = 0; $colIndex <= $columnCnt; $colIndex++){
                                        $cellId = $cellName[$colIndex].$rowIndex;  
                                        $cell = $sheet->getCell($cellId)->getValue();
                                        $cell = $sheet->getCell($cellId)->getCalculatedValue();
                                        if ($cell instanceof PHPExcel_RichText){ //富文本转换字符串
                                            $cell = $cell->__toString();
                                        }
                                        if($cell!="" or $cell=="0"){
                                            $data[$colIndex] = $cell;
                                        }
                                        
                                    }
                                    break;
                                }
                            }
                            break;
                        }
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
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->data['chosen_month']=$_POST['chosen_month'];
            $doc_name=substr($_POST['chosen_month'],0,4).substr($_POST['chosen_month'],5,6);
            if(strlen($doc_name)<=7 and $doc_name!=""){
                $this->data['attr_data']=$this->model_wage_attr->getWageAttrDataByDate($doc_name);
                $this->data['wage_notice']=$this->model_wage_notice->getWageNoticeByDate($doc_name)['content'];
                if(!empty($this->data['attr_data'])){
                    $this->data['wage_data']=$this->model_wage->getWageByDateAndID($this->data['user_id'],$doc_name);
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
            $this->render_template('wage/search', $this->data);
            
        }
        else{
            $this->render_template('wage/search', $this->data);
        }
    }
    public function searchsp(){
        $this->data['wage_sp']="";
        $this->data['wage_sp_attr']="";
        $this->data['chosen_month']="";
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->data['chosen_month']=$_POST['chosen_month'];
            $doc_name=substr($_POST['chosen_month'],0,4).substr($_POST['chosen_month'],5,6);
            if(strlen($doc_name)<=7 and $doc_name!=""){
                $this->data['wage_sp']=$this->model_wage_sp->getWageSpByDateAndId($doc_name,$this->data['user_id']);
                $this->data['wage_sp_attr']=$this->model_wage_sp_attr->getWageSpByDate($doc_name);
                
            }
            $log=array(
                'user_id' => $this->data['user_id'],
                'username' => $this->data['user_name'],
                'login_ip' => $_SERVER["REMOTE_ADDR"],
                'staff_action' => '查看'.$this->data['chosen_month'].'专项信息',
                'action_time' => date('Y-m-d H:i:s')
            );
            $this->model_log_action->create($log);
            unset($log);
            $this->render_template('wage/searchsp', $this->data);        
        }
        else{
            $this->render_template('wage/searchsp', $this->data);
        }
    }
    public function searchtax(){
        $this->data['wage_tax']="";
        $this->data['wage_tax_attr']="";
        $this->data['chosen_month']="";
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->data['chosen_month']=$_POST['chosen_month'];
            $doc_name=substr($_POST['chosen_month'],0,4).substr($_POST['chosen_month'],5,6);
            if(strlen($doc_name)<=7 and $doc_name!=""){
                $this->data['wage_tax']=$this->model_wage_tax->getTaxByDateAndId($doc_name,$this->data['user_id']);
                $this->data['wage_tax_attr']=$this->model_wage_tax_attr->getTaxByDate($doc_name);   
            }
            $this->data['notice']=$this->model_notice->getNoticeLatestTax();
            $log=array(
                'user_id' => $this->data['user_id'],
                'username' => $this->data['user_name'],
                'login_ip' => $_SERVER["REMOTE_ADDR"],
                'staff_action' => '查看'.$this->data['chosen_month'].'个税信息',
                'action_time' => date('Y-m-d H:i:s')
            );
            $this->model_log_action->create($log);
            unset($log);
            $this->render_template('wage/searchtax', $this->data);        
        }
        else{
            $this->render_template('wage/searchtax', $this->data);
        }
    }

    public function search_mydept_excel($doc_name){
        $this->load->library("phpexcel");//ci框架中引入excel类
        $this->load->library('PHPExcel/IOFactory');
        
        $dir="uploads/wage";
        $user_id=$this->session->userdata('user_id');
        $dept=$this->model_wage_tag->getTagById($user_id)['dept'];
        if(is_dir($dir)){
            $files = array();
            $child_dirs = scandir($dir);
            foreach($child_dirs as $child_dir){
                if($child_dir != '.' && $child_dir != '..'){
                    if(is_dir($dir.'/'.$child_dir)){
                        $files[$child_dir] = my_scandir($dir.'/'.$child_dir);
                    }else{
                        if(strstr($child_dir,$doc_name)){
                            if (strstr($child_dir,'xlsx')){
                                $reader = new PHPExcel_Reader_Excel2007();
                            }
                            else{
                                if (strstr($child_dir, 'xls')){
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
                            for($rowIndex = 2; $rowIndex <= $highestRow; $rowIndex++){        //循环读取每个单元格的内容。注意行从1开始，列从A开始
                                $cellId = $cellName[1].$rowIndex;  
                                $cell = $sheet->getCell($cellId)->getCalculatedValue();
                                if ($cell instanceof PHPExcel_RichText){ //富文本转换字符串
                                    $cell = $cell->__toString();
                                }
                                if($cell===$dept){
                                    $temp=array();
                                    for ($colIndex = 0; $colIndex <= $columnCnt; $colIndex++){
                                        $cellId = $cellName[$colIndex].$rowIndex;  
                                        $cell = $sheet->getCell($cellId)->getValue();
                                        $cell = $sheet->getCell($cellId)->getCalculatedValue();
                                        if ($cell instanceof PHPExcel_RichText){ //富文本转换字符串
                                            $cell = $cell->__toString();
                                        }
                                        if($cell!="" or $cell=="0"){
                                            $temp[$colIndex] = $cell;
                                        }
                                        if($cell=="" and $colIndex==$columnCnt){
                                            $temp[$colIndex] = $cell;
                                        }
                                    }
                                    array_push($data,$temp);
                                    unset($temp);
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
    public function search_mydept(){
        $this->data['current_dept']="";
        $user_id=$this->session->userdata('user_id');
        $admin_data = $this->model_wage_tag->getTagById($user_id);
        $admin_result=array();
        $admin_result=explode('/',$admin_data['dept']);
        $this->data['dept_options']=$admin_result;
        $this->data['wage_data']="";
        $this->data['attr_data']="";
        $this->data['chosen_month']="";
        if($_SERVER['REQUEST_METHOD'] == 'POST' and array_key_exists('chosen_month',$_POST) and array_key_exists('selected_dept',$_POST)){
            if(($_POST['chosen_month']=="单击选择月份" or $_POST['chosen_month']=="1899-12") and $_POST['selected_dept']=="请选择部门"){
                $this->session->set_flashdata('error', '请选择月份和部门！');
                return $this->render_template('wage/mydeptwage',$this->data);
            }
            elseif($_POST['chosen_month']=="单击选择月份"){
                $this->session->set_flashdata('error', '请选择月份！');
                return $this->render_template('wage/mydeptwage',$this->data);
            }
            elseif($_POST['selected_dept']=="请选择部门"){
                $this->session->set_flashdata('error', '请选择部门！');
                return $this->render_template('wage/mydeptwage',$this->data);
            }
            else{
                $this->data['chosen_month']=$_POST['chosen_month'];
                $this->data['current_dept']=$_POST['selected_dept'];
                $doc_name=substr($_POST['chosen_month'],0,4).substr($_POST['chosen_month'],5,6);
                if(strlen($doc_name)<=7 and $doc_name!=""){
                    $this->data['wage_data']=$this->model_wage->getWageByDateAndDept($_POST['selected_dept'],$doc_name);
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
                $this->render_template('wage/mydeptwage',$this->data);
            }
            
        }
        else{
            $this->render_template('wage/mydeptwage',$this->data);
        }
    }
    public function wage_chart(){
        $this->render_template('wage/wage_chart',$this->data);
    }
    public function notice(){
        $this->render_template('wage/wage_notice',$this->data);
    }
}