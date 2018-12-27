<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Wage extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->wage_not_logged_in();

		$this->data['page_title'] = 'Wage';

        $this->load->model('model_wage');
        $this->load->model('model_holiday');
        $this->load->model('model_wage_doc');
        $this->load->model('model_wage_users');
        $this->load->model('model_wage_tag');
        $this->load->model('model_wage_attr');
        $this->data['permission'] = $this->session->userdata('permission');
        $this->data['user_name'] = $this->session->userdata('user_name');
        $this->data['user_id'] = $this->session->userdata('user_id');
        $this->data['wage_doc'] = $this->model_wage_doc->getWageDocData();
	}
    
	public function index()
	{        
		$this->staff();
    }
    /*
    * It Fetches the products data from the product table 
    * this function is called from the datatable ajax function
    */
	public function fetchWageData()
	{
		$result = array('data' => array());

        $data = $this->model_wage->getWageData();
        echo $data;
        
		foreach ($data as $key => $value) {
			$result['data'][$key] = array(
				$value['name'],
				$value['indate'],
                $value['companyage'],
                $value['sumage'],
                $value['sumday'],
                $value['lastyear'],
                $value['thisyear'],
                $value['bonus'],
                $value['used'],
                $value['rest'],
            );
            console($result['data']['name']);
		} // /foreach

        echo json_encode($result);
       /* */
    }
    /*
    ==============================================================================
    部门经理
    ==============================================================================
    */
    public function manager()
	{
        $user_id=$this->session->userdata('user_id');

        $this->data['holiday_data'] = $this->model_wage->getHolidayById($user_id);
        
		$this->render_template('holiday/staff', $this->data);
    }
    /*
    ==============================================================================
    普通员工
    ==============================================================================
    */

    public function staff()
	{
        $user_id=$this->session->userdata('user_id');
        if($user_id==NULL){
            redirect('auth/wage_logout');
        }
        $log=array(
            'user_id' => $this->data['user_id'],
            'username' => $this->data['user_name'],
            'login_ip' => $_SERVER["REMOTE_ADDR"],
            'staff_action' => 'wage_staff_get',
            'action_time' => date('Y-m-d H:i:s')
        );
        $this->model_log_action->create($log);
        $user_id=$this->session->userdata('user_id');
        $this->data['wage_data'] = $this->model_wage->getWageById($user_id);
        $this->data['attr_data']=$this->model_wage_attr->getWageAttrData();
        $counter=0;
        foreach($this->data['attr_data'] as $k => $v){
            #echo $v;
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

        /*
        $fold_attr=array();
        $fold_data=array();
        $unfold_attr=array();
        $unfold_data=array();
        $wage_attr=array();
        $wage_data=array();
        $fold_total=0;
        $unfold_total=0;
        
        $attr=$this->model_wage_attr->getWageAttrData();
        $wage=$this->model_wage->getWageById($user_id);

        //先把工资信息加上折叠标签，折叠标签为true就折叠，false就是不折叠
        foreach($attr as $k => $v){
            if($v!=""){
                array_push($wage_attr,array('fold_tag' => false,'content' => $v,'type' => '','fold_start' => false));
            }
        }
        $total=count($wage_attr);
        unset($attr);
        
        foreach($wage as $a => $b){
            if($b!=""){
                array_push($wage_data,$b);
            }
        }
        
        if(count($wage_data)<$total){
            array_push($wage_data,'无');
        };
        #foreach($wage as $k => $v){
        #    echo $v;
        #}

        unset($wage);
        
        foreach($wage_attr as $k => $v){
            if(strstr($v['content'],'月度绩效工资小计')){
                $wage_attr[$k]['fold_start']=true;
                $wage_attr[$k]['type']='月度绩效工资小计';
                for($i=$k;$i<$total;$i++){
                    if(strstr($wage_attr[$i]['content'],'省核专项奖励小计')){
                        for($j=$k+1;$j<$i;$j++){
                            array_push($fold_attr,array('type' => '月度绩效工资小计','content' => $wage_attr[$j]['content']));
                            $wage_attr[$j]['type']='月度绩效工资小计';
                            $wage_attr[$j]['fold_tag']=true;
                        }
                        break;
                    }
                } 
            }
            else if(strstr($v['content'],'省核专项奖励小计')){
                $wage_attr[$k]['fold_start']=true;
                $wage_attr[$k]['type']='省核专项奖励小计';
                for($i=$k;$i<$total;$i++){
                    if(strstr($wage_attr[$i]['content'],'分公司专项奖励小计')){
                        for($j=$k+1;$j<$i;$j++){
                            array_push($fold_attr,array('type' => '省核专项奖励小计','content' => $wage_attr[$j]['content']));
                            $wage_attr[$j]['type']='省核专项奖励小计';
                            $wage_attr[$j]['fold_tag']=true;
                        }
                        break;
                    }
                    
                }
                
            }
            else if(strstr($v['content'],'分公司专项奖励小计')){
                $wage_attr[$k]['fold_start']=true;
                $wage_attr[$k]['type']='分公司专项奖励小计';
                for($i=$k;$i<$total;$i++){
                    if(strstr($wage_attr[$i]['content'],'其他小计')){
                        for($j=$k+1;$j<$i;$j++){
                            array_push($fold_attr,array('type' => '分公司专项奖励小计','content' => $wage_attr[$j]['content']));
                            $wage_attr[$j]['type']='分公司专项奖励小计';
                            $wage_attr[$j]['fold_tag']=true;
                        }
                        break;
                    }
                    
                }
            }
            else if(strstr($v['content'],'其他小计')){
                $wage_attr[$k]['fold_start']=true;
                $wage_attr[$k]['type']='其他小计';
                for($i=$k;$i<$total;$i++){
                    if(strstr($wage_attr[$i]['content'],'教育经费小计')){
                        for($j=$k+1;$j<$i;$j++){
                            array_push($fold_attr,array('type' => '其他小计','content' => $wage_attr[$j]['content']));
                            $wage_attr[$j]['type']='其他小计';
                            $wage_attr[$j]['fold_tag']=true;
                        }
                        break;
                    }
                    
                }
            }
            else if(strstr($v['content'],'教育经费小计')){
                $wage_attr[$k]['fold_start']=true;
                $wage_attr[$k]['type']='教育经费小计';
                for($i=$k;$i<$total;$i++){
                    if(strstr($wage_attr[$i]['content'],'福利费小计')){
                        for($j=$k+1;$j<$i;$j++){
                            array_push($fold_attr,array('type' => '教育经费小计','content' => $wage_attr[$j]['content']));
                            $wage_attr[$j]['type']='教育经费小计';
                            $wage_attr[$j]['fold_tag']=true;
                            
                        }
                        break;
                    }
                    
                }
            }
            else if(strstr($v['content'],'福利费小计')){
                $wage_attr[$k]['fold_start']=true;
                $wage_attr[$k]['type']='福利费小计';
                for($i=$k;$i<$total;$i++){
                    if(strstr($wage_attr[$i]['content'],'当月月应收合计')){
                        for($j=$k+1;$j<$i;$j++){
                            array_push($fold_attr,array('type' => '福利费小计','content' => $wage_attr[$j]['content']));
                            $wage_attr[$j]['type']='福利费小计';
                            $wage_attr[$j]['fold_tag']=true;
                            
                        }
                        break;
                    }
                    
                }
            }
            else if(strstr($v['content'],'当月月应收合计')){
                for($i=$k;$i<$total;$i++){
                    if(strstr($wage_attr[$i]['content'],'扣款小计')){
                        $wage_attr[$i]['fold_start']=true;
                        $wage_attr[$i]['type']='扣款小计';
                        for($j=$k+1;$j<$i;$j++){
                            array_push($fold_attr,array('type' => '扣款小计','content' => $wage_attr[$j]['content']));
                            $wage_attr[$j]['type']='扣款小计';
                            $wage_attr[$j]['fold_tag']=true;
                        }
                        break;
                    }
                }
            }
            
            if(!$wage_attr[$k]['fold_tag']){
                array_push($unfold_attr,$wage_attr[$k]['content']);
            }
        }
        
        foreach($wage_data as $k => $v){

            if($wage_attr[$k]['fold_tag']){
                array_push($fold_data,array('type' => $wage_attr[$k]['type'],'content' => $v,'fold_tag' => $wage_attr[$k]['fold_tag'],'fold_start' => $wage_attr[$k]['fold_start']));    
            }
            else{
                array_push($unfold_data,array('type' => $wage_attr[$k]['type'],'content' => $v,'fold_tag' => $wage_attr[$k]['fold_tag'],'fold_start' => $wage_attr[$k]['fold_start']));    
            }
        }
        
        unset($wage_attr);
        unset($wage_data);
        foreach($unfold_data as $k=>$v){
            
        }

        $this->data['wage_data']=$unfold_data;
        $this->data['wage_attr']=$unfold_attr;
        $this->data['fold_data']=$fold_data;
        $this->data['fold_attr']=$fold_attr;
        */

		$this->render_template('wage/staff', $this->data);
    }

    public function mydeptwage()
    {
        $result=array();
        $user_id=$this->session->userdata('user_id');
        $this->data['current_dept']="";
        if($_POST){
            $select_dept=$_POST['selected_dept'];
            $wage_data = $this->model_wage->getWageByDept($select_dept);
            $result = array();
            foreach ($wage_data as $k => $v)
            {
                $result[$k] = $v;
            }

            $this->data['wage_data'] = $result;
            $this->data['current_dept']=$select_dept;

        }
        
        $admin_data = $this->model_wage_tag->getTagById($user_id);

        $admin_result=array();
        $admin_result=explode('/',$admin_data['dept']);

        $this->data['dept_options']=$admin_result;

        $this->data['wage_data'] = $result;
        
        
		$this->render_template('wage/mydeptwage', $this->data);
    }
    
    public function export_wage_proof(){
        
    }
    public function apply_wage_proof(){
        $this->data['submitted']=0;
        $this->data['']=array(
            0 => '工资证明',
            1 => '工资证明（工商银行）',
            2 => '',
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
                $str="\r\n          兹证明 姓名 ，身份证号码：111111111111111111为中国联合网络通信有限公司中山市分公司正式员工，自1971年1月1日起为我司工作，现于我单位任职综合部 综合文秘室 综合秘书，其月收入（税前）包括工资、奖金、津贴约XXX元（大写：壹萬贰仟圆整），以上情况属实。此证明仅限于申请贷款之用。\r\n         特此证明！\r\n";
                break;
            case 'bank_wage':
                $str="\r\n中山农村商业银行股份有限公司：\r\n            兹证明 姓名 （身份证号码： 111111111111111111）为我单位正式员工，自1971年1月1日起为我单位工作，现于我单位任职 网络建设部 无线网建设室 室主任，其月收入（税前）包括工资、奖金、津贴约XXX元（大写：壹萬贰仟伍佰圆整），以上情况属实。此证明仅用于申请贷款之用。\r\n          特此证明！";
                break;
            case 'fund':
                $str="\r\n中山市住房公积金管理中心：\r\n            为申请住房公积金贷款事宜，兹证明 姓名，性别：，身份证号：111111111111111111，是我单位职工，已在我单位工作满50年，该职工上一年度在我单位总收入约为XXXX元（大写：拾壹萬伍仟圆整 ）。\r\n\r\n";
                break;
            case 'royal':
                $str="           姓名 （男，身份证号：111111111111111111） 同志自 1971年1月1日 进入我单位至今，期间一直拥护中国共产党的领导，坚持四项基本原则和党的各项方针政策，深刻学习三个代表重要思想。没有参加“六四”“法轮功”等活动，未发现有任何违法乱纪行为。\r\n          特此证明!\r\n";
                break;
            case 'on_post_1':
                $str="\r\n          兹有我单位员工 姓名 ，身份证号：111111111111111111，该员工于 1971年1月1日 起至今在我公司工作。\r\n            特此证明。\r\n";
                $pdf->SetFont('kozminproregular','',14);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n".date("Y年m月d日");
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false, 0);
                break;
            case 'on_post_2':
                $str="\r\n          兹有 姓名 （女，身份证号：111111111111111111），为中国联合网络通信有限公司中山市分公司中层管理干部，现任中国联合网络通信有限公司中山市分公司综合部部门经理。\r\n            特此证明。\r\n\r\n";
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
                $str="\r\n          兹有我单位 姓名 同志，性别：男，身份证号码：111111111111111111，于 1971年1月1日 至今在我单位从事 南部固网销售公司总经理 （职位）工作。\r\n单位名称：中国联合网络通信有限公司中山市分公司\r\n          联系地址：中山市东区长江北路6号联通大厦\r\n          联系人：徐小姐        联系电话：0760-23771356\r\n          特此证明。\r\n       （此证明仅用于办理流动人员积分制管理使用）\r\n";
                $pdf->SetFont('kozminproregular','',14);
                $pdf->Write(0,$str,'', 0, 'L', true, 0, false, false, 0);
                $str="\r\n\r\n中国联合网络通信有限公司中山市分公司\r\n".date("Y年m月d日")."\r\n\r\n\r\n\r\n";
                $pdf->Write(0,$str,'', 0, 'R', true, 0, false, false, 0);
                break;
            case 'on_post_5':
                $str="\r\n          兹有 姓名 （女，身份证号：111111111111111111），自 1971年1月1日 进入我公司工作，现任中国联合网络通信有限公司中山市分公司员工 （职位）。\r\n          特此证明。\r\n       （此证明仅用于办理居住证使用）";
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

}