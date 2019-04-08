<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class hr extends Admin_Controller{
	public function __construct(){
        parent::__construct();
        $this->not_logged_in();
        $this->data['page_title'] = 'Hr';
        $this->load->model('model_wage_tag');
        $this->load->model('model_notice');
        $this->load->model('model_hr_score_attr');
        $this->load->model('model_hr_score_content');
        $this->load->model('model_hr_score_sum_attr');
        $this->load->model('model_hr_score_sum_content');
        $this->load->model('model_hr_confirm_status');
        $this->load->model('model_hr_confirm_sum_status');
        $this->data['permission'] = $this->session->userdata('permission');
        $this->data['user_name'] = $this->session->userdata('user_name');
        $this->data['user_id'] = $this->session->userdata('user_id');
        $this->data['service_mode']= $this->model_wage_tag->getModeById($this->session->userdata('user_id'))['service_mode'];
        
        $this->data['confirm_status']=$this->model_hr_confirm_status->getByName($this->data['user_name'])['status'];
        $this->data['confirm_sum_status']=$this->model_hr_confirm_sum_status->getById($this->data['user_id'])['status'];
    }
    public function confirm(){
        $this->data['user_name']=$this->session->userdata('user_name');
        $this->data['url']=$this->pdf_creator($this->data['user_name'],'弹性福利积点确认');
        $this->data['attr_data']=$this->model_hr_score_attr->getData();
        $this->data['user_data']=$this->model_hr_score_content->getByName($this->data['user_name']);
        $this->data['status']=$this->model_hr_confirm_status->getByName($this->data['user_name'])['status'];
        $this->render_template('hr/apply',$this->data);
    }
    public function pdf_creator($name,$type){
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
    public function submit_confirm(){
        $user_id=$this->session->userdata('user_id');
        $name=$this->session->userdata('user_name');

        $confirm_status=array(
            'user_id' => $this->model_hr_score_content->getByName($name)['content'],
            'name' => $name,
            'status' => '已确认'
        );

        if($this->model_hr_confirm_status->getByName($name)){
            $this->model_hr_confirm_status->update($confirm_status,$user_id);
        }
        else{
            $this->model_hr_confirm_status->create($confirm_status);
        }
        $this->data['confirm_status']=$this->model_hr_confirm_status->getByName($name)['status'];
        #redirect('hr/confirm','refresh');
    }
    
    public function confirm_sum(){
        $this->data['attr_data']=$this->model_hr_score_sum_attr->getData();
        $this->data['user_data']=$this->model_hr_score_sum_content->getById($this->data['user_id']);
        $this->data['status']=$this->model_hr_confirm_status->getByName($this->data['user_name'])['status'];
        $this->data['notice'] = $this->model_notice->getNoticeLatestHr();
        $this->render_template('hr/apply_sum',$this->data);
    }
    public function submit_confirm_sum(){
        $user_id=$this->session->userdata('user_id');
        $name=$this->session->userdata('user_name');

        $confirm_status=array(
            'user_id' => $user_id,
            'name' => $name,
            'status' => '已确认'
        );

        if($this->model_hr_confirm_sum_status->getById($user_id)){
            $this->model_hr_confirm_sum_status->update($confirm_status,$user_id);
        }
        else{
            $this->model_hr_confirm_sum_status->create($confirm_status);
        }
        $this->data['status']=$this->model_hr_confirm_sum_status->getById($user_id)['status'];
        $this->session->set_flashdata('success', '提交确认成功');
        redirect('hr/confirm_sum','refresh');
    }
}