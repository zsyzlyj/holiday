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
        $this->load->model('model_wage_tag');
        $this->load->model('model_wage_attr');
        $this->load->model('model_func');
        $this->load->model('model_wage_notice');
        $this->load->model('model_notice');
        $this->data['permission'] = $this->session->userdata('permission');
        $this->data['user_name'] = $this->session->userdata('user_name');
        $this->data['user_id'] = $this->session->userdata('user_id');
        $this->data['wage_func']=$this->model_func->getFuncByType('wage');
        $this->data['service_mode']= $this->model_wage_tag->getModeById($this->session->userdata('user_id'))['service_mode'];
        $this->data['notice_data'] = $this->model_notice->getNoticeLatestWage();
    }
    
	public function index(){
        $this->staff();
    }
    
    public function watermark($path){
        $name=str_replace('.pdf',$this->data['user_id'].'.pdf',$path);
        if(!file_exists($name)){
            require_once(APPPATH.'libraries\FPDI\src\fpdi.php');
            require_once(APPPATH.'libraries\PDF_rotate.php');
            #$pdf = new \setasign\Fpdi\Fpdi();
            $pdf =new PDF();
            // get the page count
            $pageCount = $pdf->setSourceFile($path);
            // iterate through all pages
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++)
            {
                // import a page
                $templateId = $pdf->importPage($pageNo);
                #$pdf->AddGBFont(); 
                // get the size of the imported page
                $size = $pdf->getTemplateSize($templateId);
                // create a page (landscape or portrait depending on the imported page size)
                if ($size['width'] > $size['height']) $pdf->AddPage('L', array($size['width'], $size['height']));
                else $pdf->AddPage('P', array($size['width'], $size['height']));
                $pdf->SetFont('','B','12');
                $pdf->SetFont('songti','',22);
                $pdf->SetTextColor(255,192,203);
                #$pdf->RotatedText(100,100,'Rina_lyj',45);
                for($i=20;$i<$size['width'];$i+=70){
                    for($j=50;$j<$size['height'];$j+=140)
                        $pdf->RotatedText($i,$j,$this->data['user_name'],45);
                }
    
                for($i=50;$i<$size['width'];$i+=70){
                    for($j=120;$j<$size['height'];$j+=140)
                        $pdf->RotatedText($i,$j,$this->data['user_name'],45);
                }
                // use the imported page
                $pdf->useTemplate($templateId);
            }
            $pdf->Output(dirname(__FILE__,3).'\\'.$name,'F');
        }
        
        return $name;
    }
    public function wage_doc(){
        $wage_doc = $this->model_wage_doc->getWageDocData();
        foreach($wage_doc as $k => $v){
            $wage_doc[$k]['doc_path']=$this->watermark($v['doc_path']);
        }
        $this->data['wage_doc'] = $wage_doc;
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
        #$this->search();
        $this->notice();
    }
    
    public function export_wage_proof(){
        
    }
    public function apply_on_post_proof(){
        $user_id=$this->session->userdata('user_id');
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $apply_data=array(
                'user_id' => $user_id,
                'name' => $this->session->userdata('user_name'),
                'type' => $_POST['type'],
                'submit_time' => date('Y-m-d H:i:s'),
                'submit_status' => '已提交',
                'feedback_status' => '未审核'
            );
            if($this->model_wage_apply->getApplyByIdAndStatus($user_id,$_POST['type'])){
                $this->model_wage_apply->update($apply_data,$user_id);
            }
            else $this->model_wage_apply->create($apply_data);
        }
        //获取数据库中 已提交 状态的这个人证明开具信息
        #$apply_info=$this->model_wage_apply->getApplyByIdAndStatus($user_id,'已提交');
        $apply_info=$this->model_wage_apply->getApplyById($user_id);
        $this->data['name']=array(
            0 => '现实表现证明',
            1 => '在职证明1',
            2 => '在职证明2',
            3 => '在职证明（积分入户1）',
            4 => '在职证明（积分入户2）',
            5 => '在职证明（居住证）',
            6 => '在职证明（住房补贴）',
            /*
            7 => '计生证明',
            8 => '子女户口非在注册证明'
            */
        );
        $status=array();
        $submit_status=array();
        $feedback_status=array();
        //预设全部可以浏览
        for($i=0;$i<count($this->data['name']);$i++){
            $status[$i]=true;
            $submit_status[$i]='';
            $feedback_status[$i]='';
        }
        //如果已提交则为false，不能浏览
        foreach($apply_info as $k =>$v){
            switch($v['type']){
                case '现实表现证明':
                    $submit_status[0]=$v['submit_status'];
                    $feedback_status[0]=$v['feedback_status'];
                    if(strstr($v['submit_status'],'已')){
                        if(strstr($v['feedback_status'],'已'))
                            $status[0]=true;
                        else $status[0]=false;
                    }
                    break;
                case '在职证明1':
                    $submit_status[1]=$v['submit_status'];
                    $feedback_status[1]=$v['feedback_status'];
                    if(strstr($v['submit_status'],'已')){
                        if(strstr($v['feedback_status'],'已'))
                            $status[1]=true;
                        else $status[1]=false;
                    }
                    break;
                case '在职证明2':
                    $submit_status[2]=$v['submit_status'];
                    $feedback_status[2]=$v['feedback_status'];
                    if(strstr($v['submit_status'],'已')){
                        if(strstr($v['feedback_status'],'已'))
                            $status[2]=true;
                        else $status[2]=false;
                    }
                    break;
                case '在职证明（积分入户1）':
                    $submit_status[3]=$v['submit_status'];
                    $feedback_status[3]=$v['feedback_status'];
                    if(strstr($v['submit_status'],'已')){
                        if(strstr($v['feedback_status'],'已'))
                            $status[3]=true;
                        else $status[3]=false;
                    }
                    break;
                case '在职证明（积分入户2）':
                    $submit_status[4]=$v['submit_status'];
                    $feedback_status[4]=$v['feedback_status'];
                    if(strstr($v['submit_status'],'已')){
                        if(strstr($v['feedback_status'],'已'))
                            $status[4]=true;
                        else $status[4]=false;
                    }
                    break;
                case '在职证明（居住证）':
                    $submit_status[5]=$v['submit_status'];
                    $feedback_status[5]=$v['feedback_status'];
                    if(strstr($v['submit_status'],'已')){
                        if(strstr($v['feedback_status'],'已'))
                            $status[5]=true;
                        else $status[5]=false;
                    }
                    break;
                case '在职证明（住房补贴）':
                    $submit_status[6]=$v['submit_status'];
                    $feedback_status[6]=$v['feedback_status'];
                    if(strstr($v['submit_status'],'已')){
                        if(strstr($v['feedback_status'],'已'))
                            $status[6]=true;
                        else $status[6]=false;
                    }
                    break;
                /*
                case '计生证明':
                    $submit_status[7]=$v['submit_status'];
                    $feedback_status[7]=$v['feedback_status'];
                    if(strstr($v['submit_status'],'已')){
                        if(strstr($v['feedback_status'],'已'))
                            $status[7]=true;
                        else $status[7]=false;
                    }
                    break;
                case '子女户口非在注册证明':
                    $submit_status[8]=$v['submit_status'];
                    $feedback_status[8]=$v['feedback_status'];
                    if(strstr($v['submit_status'],'已')){
                        if(strstr($v['feedback_status'],'已'))
                            $status[8]=true;
                        else $status[8]=false;
                    }
                    break;
                */
                default:break;
            }
        }
        $this->data['submit_status']=$submit_status;
        $this->data['feedback_status']=$feedback_status;
        $this->data['status']=$status;

        $this->data['url']=array(
            0 => 'wage/show_royal_proof',
            1 => 'wage/show_on_post_1_proof',
            2 => 'wage/show_on_post_2_proof',
            3 => 'wage/show_on_post_3_proof',
            4 => 'wage/show_on_post_4_proof',
            5 => 'wage/show_on_post_5_proof',
            6 => 'wage/show_on_post_6_proof',
            /*
            7 => 'wage/show_child_1_proof',
            8 => 'wage/show_child_2_proof',
            */
        );
        $this->render_template('wage/apply_on_post', $this->data);
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
                'feedback_status' => '未审核'
            );
            if($this->model_wage_apply->getApplyByIdAndStatus($user_id,$_POST['type'])){
                $this->model_wage_apply->update($apply_data,$user_id);
            }
            else $this->model_wage_apply->create($apply_data);
        }
        //获取数据库中 已提交 状态的这个人证明开具信息
        #$apply_info=$this->model_wage_apply->getApplyByIdAndStatus($user_id,'已提交');
        $apply_info=$this->model_wage_apply->getApplyById($user_id);
        $this->data['name']=array(
            0 => '收入证明',
            1 => '收入证明（农商银行）',
            2 => '收入证明（公积金）',
        );
        $status=array();
        $submit_status=array();
        $feedback_status=array();
        //预设全部可以浏览
        for($i=0;$i<count($this->data['name']);$i++){
            $status[$i]=true;
            $submit_status[$i]='';
            $feedback_status[$i]='';
        }
        //如果已提交则为false，不能浏览
        foreach($apply_info as $k =>$v){
            switch($v['type']){
                case '收入证明':
                    $submit_status[0]=$v['submit_status'];
                    $feedback_status[0]=$v['feedback_status'];
                    if(strstr($v['submit_status'],'已')){
                        if(strstr($v['feedback_status'],'已'))
                            $status[0]=true;
                        else $status[0]=false;
                    }
                    break;
                case '收入证明（农商银行）':
                    $submit_status[1]=$v['submit_status'];
                    $feedback_status[1]=$v['feedback_status'];
                    if(strstr($v['submit_status'],'已')){
                        if(strstr($v['feedback_status'],'已'))
                            $status[1]=true;
                        else $status[1]=false;
                    }
                    break;
                case '收入证明（公积金）':
                    $submit_status[2]=$v['submit_status'];
                    $feedback_status[2]=$v['feedback_status'];
                    if(strstr($v['submit_status'],'已')){
                        if(strstr($v['feedback_status'],'已'))
                            $status[2]=true;
                        else $status[2]=false;
                    }
                    break;
            }
        }
        $this->data['submit_status']=$submit_status;
        $this->data['feedback_status']=$feedback_status;
        $this->data['status']=$status;

        $this->data['url']=array(
            0 => 'wage/show_wage_proof',
            1 => 'wage/show_bank_wage_proof',
            2 => 'wage/show_fund_wage_proof'
        );
        $this->render_template('wage/apply', $this->data);
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
        
        if(strstr($type,'wage')){
            $str="收 入 证 明\r\n";
        }
        elseif(strstr($type,'post') or strstr($type,'child_2')){
            $str="证         明\r\n";
        }elseif(strstr($type,'royal')){
            $str="现 实 表 现 证 明\r\n";
        }
        /*
        elseif(strstr($type,'child_1')){
            $str="计 生 证 明\r\n";
        }
        */
        $pdf->SetFont('songti','B',24);
        $pdf->Write(0,$str,'', 0, 'C', false, 0, false, false, 0);

        switch($type){
            case 'wage':
                $str="\r\n          兹证明（姓名），身份证号码：111111111111111111为中国联合网络通信有限公司中山市分公司正式员工，自1971年1月1日起为我司工作，现于我单位任职综合部 综合文秘室 综合秘书，其月收入（税前）包括工资、奖金、津贴约XXX元（大写：壹萬贰仟圆整），以上情况属实。此证明仅限于申请贷款之用。\r\n         特此证明！\r\n";
                break;
            case 'bank_wage':
                $str="\r\n中山农村商业银行股份有限公司：\r\n          兹证明（姓名）（身份证号码： 111111111111111111）为我单位正式员工，自1971年1月1日起为我单位工作，现于我单位任职 网络建设部 无线网建设室 室主任，其月收入（税前）包括工资、奖金、津贴约XXX元（大写：壹萬贰仟伍佰圆整），以上情况属实。此证明仅用于申请贷款之用。\r\n          特此证明！";
                break;
            case 'fund_wage':
                $str="\r\n中山市住房公积金管理中心：\r\n            为申请住房公积金贷款事宜，兹证明（姓名），（性别）：，身份证号：111111111111111111，是我单位职工，已在我单位工作满50年，该职工上一年度在我单位总收入约为XXXX元（大写：拾壹萬伍仟圆整 ）。\r\n\r\n";
                break;
            case 'royal':
                $str="\r\n          （姓名）（性别，身份证号：111111111111111111）同志自 1971年1月1日 进入我单位至今，期间一直拥护中国共产党的领导，坚持四项基本原则和党的各项方针政策，深刻学习三个代表重要思想。没有参加“六四”“法轮功”等活动，未发现有任何违法乱纪行为。\r\n          特此证明!\r\n";
                $pdf->SetFont('songti','',14);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n".date("Y年m月d日");
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false, 0);
                break;
            case 'on_post_1':
                $str="\r\n            兹有我单位员工（姓名），身份证号：111111111111111111，该员工于 1971年1月1日 起至今在我公司工作。\r\n            特此证明。\r\n";
                $pdf->SetFont('songti','',14);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n".date("Y年m月d日");
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false, 0);
                break;
            case 'on_post_2':
                $str="\r\n          兹有（姓名）（性别，身份证号：111111111111111111），为中国联合网络通信有限公司中山市分公司（岗位），现任中国联合网络通信有限公司中山市分公司（岗位）。\r\n            特此证明。\r\n\r\n";
                $pdf->SetFont('songti','',14);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n".date("Y年m月d日");
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false, 0);
                break;
            case 'on_post_3':
                $str="\r\n          兹有 （姓名）（性别，身份证号：111111111111111111），为中国联合网络通信有限公司中山市分公司（岗位），现任中国联合网络通信有限公司中山市分公司（岗位）。\r\n            特此证明。\r\n";
                $pdf->SetFont('songti','',14);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n".date("Y年m月d日")."\r\n\r\n\r\n\r\n";
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false, 0);
                $pdf->setCellHeightRatio(1.5); 
                $pdf->SetFont('songti', '', 9);
                $str="单位名称：中国联合网络通信有限公司中山市分公司\r\n联系地址：中山市东区长江北路6号联通大厦\r\n联系人：徐小姐           联系电话：0760-23771356";
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                break;
            case 'on_post_4':
                $str="\r\n          兹有我单位（姓名）同志，性别：性别，身份证号码：111111111111111111，于 1971年1月1日 至今在我单位从事（职位）工作。\r\n单位名称：中国联合网络通信有限公司中山市分公司\r\n          联系地址：中山市东区长江北路6号联通大厦\r\n          联系人：徐小姐        联系电话：0760-23771356\r\n          特此证明。\r\n       （此证明仅用于办理流动人员积分制管理使用）\r\n";
                $pdf->SetFont('songti','',14);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n".date("Y年m月d日")."\r\n\r\n\r\n\r\n";
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false, 0);
                break;
            case 'on_post_5':
                $str="\r\n          兹有姓名（性别，身份证号：111111111111111111），自 1971年1月1日进入我公司工作，现任中国联合网络通信有限公司中山市分公司员工 （职位）。\r\n          特此证明。\r\n       （此证明仅用于办理居住证使用）";
                $pdf->SetFont('songti','',14);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n".date("Y年m月d日")."\r\n\r\n\r\n\r\n";
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false, 0);
                $pdf->setCellHeightRatio(1.5); 
                $pdf->SetFont('songti', '', 9);
                $str="单位名称：中国联合网络通信有限公司中山市分公司\r\n联系地址：中山市东区长江北路6号联通大厦\r\n联系人：徐小姐           联系电话：0760-23771356";
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                break;
            case 'on_post_6':
                $str="\r\n          （姓名）同志（性别，身份证号码：111111111111111111），2008年7月1日起在我司工作，在职期间未享受过实物分房及建、购房相关补贴，该证明用于申请住房补贴使用。\r\n          特此证明。";
                $pdf->SetFont('songti','',14);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n人力资源部\r\n".date("Y年m月d日");
                $pdf->SetFont('songti','',14);
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false, 0);
                break;
            /*
            case 'child_1':
                $str="\r\n          （姓名）（身份证号：111111111111111111），为中国联合网络通信有限公司中山市分公司在编员工，于20xx年xx月与xxx登记结婚，属初婚已育壹孩，没有违反计划生育政策。其在我司工作期间的计划生育工作由我司负责管理。\r\n          特此证明。";
                $pdf->SetFont('songti','',14);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n".date("Y年m月d日");
                $pdf->SetFont('songti','',14);
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false, 0);
                break;
            case 'child_2':
                $str="\r\n          兹有（姓名）（性别，身份证号：111111111111111111）为我司在编员工，户籍迁入我司集体户统一管理，于20xx年xx月xx日与xxx登记结婚，20xx年xx月xx日育有一女，其女xxx非我司在册集体户口。\r\n          特此证明。";
                $pdf->SetFont('songti','',14);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n".date("Y年m月d日");
                $pdf->SetFont('songti','',14);
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false, 0);
                break;
            */
            default:break;
        }

        if(strstr($type,'wage')){
            $pdf->SetFont('songti','',14);
            $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
            $str="\r\n\r\n经办人：\t\t\t\t\t\r\n中国联合网络通信有限公司中山市分公司\r\n人力资源与企业发展部\r\n单位（盖章）\r\n".date("Y年m月d日")."\r\n\r\n\r\n\r\n";
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
    //收入证明
    public function show_wage_proof(){
        $this->proof_Creator("wage");
    }
    //公积金证明
    public function show_fund_wage_proof(){
        $this->proof_Creator("fund_wage");
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
    public function show_on_post_6_proof(){
        $this->proof_Creator("on_post_6");
    }
    public function show_child_1_proof(){
        $this->proof_Creator("child_1");
    }
    public function show_child_2_proof(){
        $this->proof_Creator("child_2");
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
            $this->render_template('wage/search', $this->data);
            
        }
        else{
            $this->render_template('wage/search', $this->data);
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
                    #$this->data['wage_data']=$this->search_mydept_excel($doc_name,$_POST['selected_dept']);
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