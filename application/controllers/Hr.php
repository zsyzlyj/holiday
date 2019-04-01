<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class hr extends Admin_Controller{
	public function __construct(){
        parent::__construct();
        $this->not_logged_in();
        $this->data['page_title'] = 'Hr';
        $this->load->model('model_wage_tag');
        $this->data['permission'] = $this->session->userdata('permission');
        $this->data['user_name'] = $this->session->userdata('user_name');
        $this->data['user_id'] = $this->session->userdata('user_id');
        $this->data['service_mode']= $this->model_wage_tag->getModeById($this->session->userdata('user_id'))['service_mode'];
	}
    public function index(){
        $this->data['user_name']=$this->session->userdata('user_name');
        $this->render_super_template('hr/apply',$this->data);
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
        $this->render_template('wage/apply_on_post', $this->data);
    }
}