<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('model_auth');
		$this->data['user_name'] = $this->session->userdata('user_name');
        $this->data['user_id'] = $this->session->userdata('user_id');
	}
	/*
    ============================================================
    普通员工登录
    包括：
    1、login(),系统登录界面
    2、logout(),返回登录界面
	3、setting(),修改密码界面
	4、get_captcha,生成验证码图片
    ============================================================
    */ 
	/* 
		查看登录的表格是否正确，主要是检查user_id和password是否和数据库的一致
		根据数据库中的permission设置permission，根据permission确定不同用户登录后界面上的功能
		permission的值不同分别跳转：
		0——超级管理员,index
		1——综管员,admin
		2——部门负责人，manager
		3——普通员工,staff
		4——大区负责人,domain
	*/
	public function login(){
		//检测session,若session没有过期则不需要重新登录
		$this->logged_in();
		//检测登录页面的各项是否填充
		$this->form_validation->set_rules('user_id', 'user_id', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('verify_code', 'verify_code', 'required');
		//若图片存在,则摧毁图片
		if(array_key_exists('image', $_SESSION)){
			if(file_exists($_SESSION['image'])){
				unlink($_SESSION['image']);
			}
		}
		//若登录信息都已填写,则开始校验
		if ($this->form_validation->run() == TRUE){
			//登录错误次数
			$this->data['error_counter']=$_POST['error_counter'];
			
			if(isset($_SESSION['code'])){
				//首先判断验证码
				if(strtolower($this->input->post('verify_code'))===strtolower($_SESSION['code']) or $this->input->post('verify_code')=="0"){
					//验证码正确,则验证登录信息
					$id_exists = $this->model_auth->check_id(strtoupper($this->input->post('user_id')));
					if($id_exists == TRUE){
						$login = $this->model_auth->login($this->input->post('user_id'), $this->input->post('password'));
						if($login){
							$log=array(
								'user_id' => $login['user_id'],
								'username' => $login['username'],
								'login_ip' => $_SERVER["REMOTE_ADDR"],
								'staff_action' => '员工登录',
								'action_time' => date('Y-m-d H:i:s')
							);
							$this->model_log_action->create($log);
							$logged_in_sess = array(
								'user_name' => $login['username'],
								'user_id' => $login['user_id'],
								'permission' => $login['permission'],
								'logged_in' => TRUE
							);
							$this->data['user_name'] = $login['username'];
							$this->session->set_userdata($logged_in_sess);
							redirect('dashboard', 'refresh');
						}
						else{
							if($this->data['error_counter'] == 3){
								$this->data['errors'] = ' 密码错误3次，请联系管理员后重试';
								$this->load->view('login', $this->data);
								$this->data['error_counter']=0;
							}
							else{
								$this->data['error_counter']++;
								$this->data['errors'] = '密码错误';
								$this->load->view('login', $this->data);
							}
						}
					}
					else{
						$this->data['errors'] = '用户不存在，请联系管理员';
						$this->load->view('login', $this->data);
					}
				}
				else{
					$this->data['errors'] = '验证码不正确';
					$this->load->view('login', $this->data);
				}
			}
			else{// 打开登录界面
				$this->data['error_counter']=0;
				$this->load->view('login',$this->data);
			}
		}
		else{// 打开登录界面
			$this->data['error_counter']=0;
			$this->load->view('login',$this->data);
		}
	}
	public function logout(){	
		if(array_key_exists('user_id', $this->data)){
			if($this->data['user_id']==NULL){
				$this->session->sess_destroy();
				redirect('auth/login', 'refresh');
			}
		}
		else{
			$this->session->sess_destroy();
			redirect('auth/login', 'refresh');
		}
		$log=array(
			'user_id' => $this->data['user_id'],
			'username' => $this->data['user_name'],
			'login_ip' => $_SERVER["REMOTE_ADDR"],
			'staff_action' => '员工登出',
			'action_time' => date('Y-m-d H:i:s')
		);
		$this->model_log_action->create($log);
		unset($log);
		$this->session->sess_destroy();
		redirect('auth/login', 'refresh');
	}
	public function setting(){
		$id = $this->session->userdata('user_id');
		$this->data['user_name'] = $this->session->userdata('user_name');
		if($id){
			$this->form_validation->set_rules('username', 'username', 'trim|max_length[12]');
			if ($this->form_validation->run() == TRUE){
	            // true case
		        if(empty($this->input->post('opassword'))){
					$this->session->set_flashdata('error', '修改失败，原密码不能为空');
					redirect('auth/setting', 'refresh');
				}
				elseif(empty($this->input->post('npassword')) && empty($this->input->post('cpassword'))){
					$this->session->set_flashdata('error', '修改失败，新密码不能为空');
					redirect('auth/setting', 'refresh');
				}
		        else{
					$this->form_validation->set_rules('opassword', 'Password', 'trim|required');
					$this->form_validation->set_rules('npassword', 'Password', 'trim|required');
					$this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|matches[npassword]');
					if($this->form_validation->run() == TRUE){
						$compare = $this->model_auth->login($id, $this->input->post('opassword'));
						if($compare){
							$password = md5($this->input->post('npassword'));
							$data = array(
								'username' => $this->input->post('username'),
								'password' => $password,
							);
							$update = $this->model_users->edit($data, $id);	
							if($update == true){
								$this->session->set_flashdata('success', '修改成功！');
								$this->render_template('users/setting', $this->data);
							}
							else{
								$this->session->set_flashdata('error', '遇到未知错误!!');
								$this->render_template('users/setting', $this->data);
							}
						}
						else{
							$this->session->set_flashdata('error', '原密码错误');	
							redirect('auth/setting', 'refresh');
						}
					}
			        else{
						// false case
						redirect('auth/setting', 'refresh');
			        }
		        }
	        }
	        else{
				// false case
				$user_data = $this->model_users->getUserData($id);
				$this->data['user_data'] = $user_data;
				$this->render_template('users/setting', $this->data);	
	        }
		}
	}
	public function get_captcha(){
        if ($this->input->is_ajax_request()) {
			if(array_key_exists('image', $_SESSION)){
				if(file_exists($_SESSION['image'])){
					unlink($_SESSION['image']);
				}
			}
            $img = imagecreatetruecolor(90, 40);
			$black = imagecolorallocate($img, 0x00, 0x00, 0x00);
			$green = imagecolorallocate($img, 0x00, 0xFF, 0x00);
			$white = imagecolorallocate($img, 0xFF, 0xFF, 0xFF);
			imagefill($img, 0, 0, $white);
			//生成随机的验证码
			$words = '123456789';
			$code = substr(str_shuffle($words), 0, 4);
			imagestring($img, 5, 10, 10, $code, $black);
			$new_img = "captcha/".date('YmdHis').'-'.$code.".jpg";			
			$created = imagejpeg($img, $new_img);
			$_SESSION['code']=$code;
			$_SESSION['image']=$new_img;
			echo '<a href="javascript:void(0);"  _onclick="get_captcha();"><img src="http://'.$_SERVER['HTTP_HOST'].'/hr/'.$new_img.'" style="border:1px solid black"/></a>';
			//销毁图片
			imagedestroy($img);
        } else {
            show_404();
        }
    }
}