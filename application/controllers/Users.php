<?php 

class Users extends Admin_Controller{
	public function __construct(){
		parent::__construct();
		$this->logged_in_super();
		$this->data['page_title'] = 'Users';
        $this->load->model('model_wage_tag');
		$this->load->model('model_hr_content');
		$this->load->model('model_manager');
		$this->load->model('model_holiday');
		$this->load->model('model_wage');
		$this->load->model('model_func');
		$this->load->model('model_users');
		$this->data['permission']=$this->session->userdata('permission');
		$this->data['user_name'] = $this->session->userdata('user_name');
		$this->data['func']=$this->model_func->getFuncByType('holiday');
		$this->data['user_id'] = $this->session->userdata('user_id');
	}
	
	public function index(){
		$user_data = $this->model_users->getUserData();
		$holiday = $this->model_holiday->getHolidayData();
		$result = array();
		foreach ($user_data as $k => $v){
			$result[$k] = $v;
			foreach($holiday as $a => $b){
				if($b['name'] == $v['username'] ){
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
		$this->render_template('users/index', $this->data);
	}

	public function password_hash($pass = ''){
		if($pass){
			$password = password_hash($pass, PASSWORD_DEFAULT);
			return $password;
		}
	}
	
	public function delete($id){
		if($id){
			if($this->input->post('confirm')){

					$delete = $this->model_users->delete($id);
					
					if($delete == true){
		        		$this->session->set_flashdata('success', '用户删除成功');
		        		redirect('users/', 'refresh');
		        	}
		        	else{
		        		$this->session->set_flashdata('error', '系统发生未知错误!!');
		        		redirect('users/delete/'.$id, 'refresh');
		        	}

			}	
			else{
				$this->data['user_id'] = $id;
				$this->render_template('users/delete', $this->data);
			}	
		}
	}
	public function profile(){
		$this->data['user_info']=$this->model_wage_tag->getTagById($this->data['user_id']);
        #$this->data['user_info']=$this->model_hr_content->getById($this->data['user_id']);
        $this->render_template('users/profile', $this->data);
    }
    public function mydeptprofiles(){
		$user_info=$this->model_wage_tag->getTagById($this->data['user_id']);
        #$this->data['user_info']=$this->model_wage_tag->getByDept($user_info['dept']);
        $this->data['user_data'] = "";
        $this->data['current_dept']="";
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->data['user_data'] = $this->model_wage_tag->getByDept($user_info['dept']);
            $this->data['current_dept'] = $_POST['selected_dept'];
        }
        $admin_data = $this->model_wage_tag->getTagById($this->data['user_id']);
        $admin_result=array();
        $admin_result=explode('/',$admin_data['dept']);
        $this->data['dept_options']=$admin_result;

        $this->render_template('users/mydeptprofiles', $this->data);
    }
    public function excel_mydeptinfo($dept){
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
        $objPHPExcel->setActiveSheetIndex(0);
        $result = $this->model_wage_tag->exportData($dept);
        // Field names in the first row
        $fields = $result->list_fields();
        $col = 0;
        foreach ($fields as $field){
            $v="";
            switch($field){
                case 'name':$v="姓名\t";break;
                case 'dept':$v="部门\t";break;
                case 'office':$v="科室\t";break;
                case 'position':$v="岗位\t";break;
                case 'company':$v="合同签订公司\t";break;
                case 'marry':$v="婚姻情况\t";break;
                case 'child':$v="生育情况\t";break;
                case 'highest_qualification':$v="最高学历\t";break;
                case 'highest_degree':$v="最高学位\t";break;
                case 'ft_highest_qualification':$v="全日制最高学历\t";break;
                case 'ft_highest_degree':$v="全日制最高学位\t";break;
                case 'service_mode':$v="用工形式\t";break;
                case 'indate':$v="加入本企业时间\t";break;
                case 'wage_level':$v="职级薪档\t";break;
                case 'wage_adjust_stamp':$v="职级调整时间\t";break;
                case 'level_adjust_stamp':$v="薪档调整时间\t";break;
                
                case 'qian3':$v=(date("Y")-3)."年\t";break;
                case 'qian2':$v=(date("Y")-2)."年\t";break;
                case 'qian1':$v=(date("Y")-1)."年\t";break;
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
                if($field != 'user_id' and $field != 'gender' and $field != 'proof_tag' and $field != 'accumulation'){
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
         /**/
    }
    public function export_mydeptprofiles(){
        $user_id=$this->session->userdata('user_id');
        $my_data = $this->model_wage_tag->getTagById($user_id);
        $this->excel_mydeptinfo($_POST['current_dept']);
    }
	public function proof_Creator($type,$apply_flag){
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
            $str="证         明";
        }elseif(strstr($type,'现实表现')){
            $str="现 实 表 现 证 明";
        }elseif(strstr($type,'计生')){
            $str="计 生 证 明";
        }
        
        $pdf->SetFont('songti','B',30);
        #$pdf->Write(0,$str,'', 0, 'C', false, 0, false, false, 0);
        $pdf->writeHTML($str, true, false, true, false, 'C');
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
                $str="中国联合网络通信有限公司中山市分公司\r\n".date("Y年m月d日");
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
	public function apply_on_post_proof(){
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
        }
        //获取数据库中 已提交 状态的这个人证明开具信息
        #$apply_info=$this->model_wage_apply->getApplyByIdAndStatus($user_id,'已提交');
        #$apply_info=$this->model_wage_apply->getApplyById($user_id);
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
        /*
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
                
                default:break;
            }
        }
        */
        $this->data['submit_status']=$submit_status;
        $this->data['feedback_status']=$feedback_status;
        $this->data['status']=$status;

        $this->data['url']=$url_set;
        $this->render_template('users/apply_on_post', $this->data);
    }
}