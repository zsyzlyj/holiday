<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Super_Auth extends Admin_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('model_super_auth');
		$this->load->model('model_super_user');
		$this->data['permission']=$this->session->userdata('permission');
		$this->data['user_id'] = $this->session->userdata('user_id');
		$this->data['user_name'] = $this->session->userdata('user_id');
	}

	/*
    ============================================================
    超管登录
    包括：
    1、index(),登录界面
    2、login(),登录界面
    3、logout(),返回登录界面
    4、holiday_setting(),假期超管修改密码页面
    5、wage_setting(),薪酬超管修改密码页面
    6、setting(),修改密码母板
    ============================================================
	*/ 
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
			$words = 'abcdefghijkmnpqrstuvwxyABCDEFGHJKLMNPQRSTUVWXYZ3456789';
			$code = substr(str_shuffle($words), 0, 4);
			imagestring($img, 5, 10, 10, $code, $black);
			$new_img = "captcha/".date('YmdHis').'-'.$code.".jpg";
			$created = imagejpeg($img, $new_img);
			$_SESSION['code']=$code;
			$_SESSION['image']=$new_img;
			echo '<a href="javascript:void(0);"  _onclick="get_captcha();"><img src="http://'.$_SERVER['HTTP_HOST'].'/human_resources/'.$new_img.'" style="border:1px solid black"/></a>';
			//销毁图片
			imagedestroy($img);
        } else {
            show_404();
        }
    }
	
	public function index(){
		$this->login();
	}
	public function login(){
		$this->logged_in_super();
		$this->form_validation->set_rules('user_id', 'user_id', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('verify_code', 'verify_code', 'required');
		if(array_key_exists('image', $_SESSION)){
			if(file_exists($_SESSION['image'])){
				unlink($_SESSION['image']);
			}
		}
        if ($this->form_validation->run() == TRUE){
			if(strtolower($this->input->post('verify_code'))===strtolower($_SESSION['code'])){
				// true case
				$id_exists = $this->model_super_auth->check_id($this->input->post('user_id'));
				if($id_exists == TRUE){
					$login = $this->model_super_auth->login($this->input->post('user_id'), $this->input->post('password'));
					if($login){
						$log=array(
							'user_id' => $login['user_id'],
							'username' => $login['user_id'],
							'login_ip' => $_SERVER["REMOTE_ADDR"],
							'staff_action' => 'super_log_in',
							'action_time' => date('Y-m-d H:i:s')
						);
						$this->model_log_action->create($log);
							$logged_in_sess = array(
							'user_id' => $login['user_id'],
							'permission' => $login['permission'],
							'logged_in_super' => TRUE
						);
						$this->session->set_userdata($logged_in_sess);
						switch($login['permission']){
							case '工资':
								redirect('super_wage/search', 'refresh');
								break;
							case '休假':
								redirect('super_holiday/index', 'refresh');
								break;
							default:
								break;
						}
					}
					else{
						$this->data['errors'] = '密码错误';
						$this->load->view('super/login', $this->data);
					}
				}
				else{
					$this->data['errors'] = '账户不存在';
					$this->load->view('super/login', $this->data);
				}
			}
			else{
				$this->data['errors'] = '验证码错误';
				$this->load->view('super/login', $this->data);
			}
            
        }
        else{
			// false case
			$this->load->view('super/login',$this->data);
        }	
	}
	/*
		清除session，退出
		
	*/
	public function logout()
	{
		if(array_key_exists('user_id', $this->data)){
			if($this->data['user_id']==NULL){
				$this->session->sess_destroy();
				redirect('super_auth/login', 'refresh');
			}
		}
		else{
			$this->session->sess_destroy();
			redirect('super_auth/login', 'refresh');
		}
		$log=array(
			'user_id' => $this->data['user_id'],
			'username' => $this->data['user_id'],
			'login_ip' => $_SERVER["REMOTE_ADDR"],
			'staff_action' => 'super_log_out',
			'action_time' => date('Y-m-d H:i:s')
		);
		$this->model_log_action->create($log);
		$this->session->sess_destroy();
		redirect('super_auth/login', 'refresh');
	}
	public function holiday_setting(){
		$this->setting('holiday');
	}
	public function wage_setting(){
		$this->setting('wage');
	}
	/*
    ============================================================
    用户密码修改
    ============================================================
    */ 
    public function setting($type=NULL){	
		$id = $this->session->userdata('user_id');
		if($id){
			$this->form_validation->set_rules('username', 'username', 'trim|max_length[12]');
			if ($this->form_validation->run() == TRUE){
	            // true case
		        if(empty($this->input->post('opassword'))){
					$this->session->set_flashdata('error', '修改失败，原密码不能为空');
					if($type=='holiday')
						redirect('super_auth/holiday_setting', 'refresh');
					if($type=='wage')
						redirect('super_auth/wage_setting', 'refresh');
				}
				elseif(empty($this->input->post('npassword')) && empty($this->input->post('cpassword'))){
					$this->session->set_flashdata('error', '修改失败，新密码不能为空');
					if($type=='holiday')
						redirect('super_auth/holiday_setting', 'refresh');
					if($type=='wage')
						redirect('super_auth/wage_setting', 'refresh');
				}
		        else{
					$this->form_validation->set_rules('opassword', 'Password', 'trim|required');
					$this->form_validation->set_rules('npassword', 'Password', 'trim|required');
					$this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|matches[npassword]');
					if($this->form_validation->run() == TRUE){
						$compare = $this->model_super_auth->login($id, $this->input->post('opassword'));
						if($compare){
							$password = md5($this->input->post('npassword'));
							$data = array(
								'user_id' => $id,
								'password' => $password,
							);
							$update = $this->model_super_user->edit($data, $id);
	
							if($update == true){
								$this->session->set_flashdata('success', '修改成功！');
								$this->render_super_template('super/setting', $this->data);
							}
							else{
								$this->session->set_flashdata('error', '遇到未知错误!!');
								$this->render_super_template('super/setting', $this->data);
								
							}
						}
						else{
							$this->session->set_flashdata('error', '原密码错误');
							if($type=='holiday')
								redirect('super_auth/holiday_setting', 'refresh');
							if($type=='wage')
								redirect('super_auth/wage_setting', 'refresh');
						}
						
					}
			        else{
						// false case
						redirect('super_auth/'.$type.'_setting', 'refresh');
			        }
		        }
	        }
	        else{
				// false case
				$user_data=$this->model_super_user->getUserData($id);
				$this->data['user_data'] = $user_data;
				$this->render_super_template('super/setting', $this->data);	
	        }
		}
    }	
}