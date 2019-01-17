<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Admin_Controller 
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_auth');
		$this->data['user_name'] = $this->session->userdata('user_name');
        $this->data['user_id'] = $this->session->userdata('user_id');
	}
	/*
    ============================================================
    普通员工登录
    包括：
    1、holiday_login(),年假系统登录界面
    2、wage_login(),薪酬系统登录界面
    3、holiday_logout(),返回年假系统登录界面
	4、wage_logout(),返回年假系统登录界面
	5、holiday_setting(),年假系统修改密码页面
    6、wage_setting(),薪酬系统修改密码页面
    7、setting(),修改密码母板
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
	*/
	public function get_code(){
		$img = imagecreatetruecolor(80, 30);
		$black = imagecolorallocate($img, 0x00, 0x00, 0x00);
		$green = imagecolorallocate($img, 0x00, 0xFF, 0x00);
		$white = imagecolorallocate($img, 0xFF, 0xFF, 0xFF);
		imagefill($img, 0, 0, $white);
		//生成随机的验证码
		$words = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$code = substr(str_shuffle($words), 0, 4);
		imagestring($img, 5, 10, 10, $code, $black);
		/*
		//加入噪点干扰
		for ($i = 0; $i < 300; $i++) {
			imagesetpixel($img, rand(0, 100), rand(0, 100), $black);
			imagesetpixel($img, rand(0, 100), rand(0, 100), $green);
		}
		//加入线段干扰
		for ($n = 0; $n <= 1; $n++) {
			imageline($img, 0, rand(0, 40), 100, rand(0, 40), $black);
			imageline($img, 0, rand(0, 40), 100, rand(0, 40), $white);
		}
		*/
		//图片保存的位置
		$new_img = "captcha/".date('YmdHis').'-'.$code.".jpg";
		$created = imagejpeg($img, $new_img);

		//输出验证码
		#header("content-type: image/png");
		#imagepng($img);
		//销毁图片
		imagedestroy($img);
		$result=array(
			'image' => $new_img,
			'code' => $code
		);
		return $result;
	}
	public function holiday_login(){
		$this->holiday_logged_in();
		
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
				$id_exists = $this->model_auth->holiday_check_id($this->input->post('user_id'));
				if($id_exists == TRUE){
					$login = $this->model_auth->holiday_login($this->input->post('user_id'), $this->input->post('password'));
					if($login){
						$log=array(
							'user_id' => $login['user_id'],
							'username' => $login['username'],
							'login_ip' => $_SERVER["REMOTE_ADDR"],
							'staff_action' => 'holiday_log_in',
							'action_time' => date('Y-m-d H:i:s')
						);
						$this->model_log_action->create($log);
						$logged_in_sess = array(
							'user_name' => $login['username'],
							'user_id' => $login['user_id'],
							'permission' => $login['permission'],
							'logged_in_holiday' => TRUE
						);
						$this->session->set_userdata($logged_in_sess);
						switch($login['permission']){
							case 1:
								redirect('holiday/admin', 'refresh');
								break;
							case 2:
								redirect('holiday/manager', 'refresh');
								break;
							default:	
								redirect('holiday/staff', 'refresh');
								break;
						}
					}
					else{
						$image_item=$this->get_code();
						$_SESSION['image']=$image_item['image'];
						$_SESSION['code']=$image_item['code'];
						unset($image_item);
						$this->data['errors'] = '密码错误';
						$this->load->view('holiday_login', $this->data);
					}
				}
				else{
					$image_item=$this->get_code();
					$_SESSION['image']=$image_item['image'];
					$_SESSION['code']=$image_item['code'];
					unset($image_item);
					$this->data['errors'] = '账户不存在';
					$this->load->view('holiday_login', $this->data);
				}
			}
			else{
				$image_item=$this->get_code();
				$_SESSION['image']=$image_item['image'];
				$_SESSION['code']=$image_item['code'];
				unset($image_item);
				$this->data['errors'] = '验证码不正确';
				$this->load->view('holiday_login', $this->data);
			}
        }
        else{
			// false case
			$image_item=$this->get_code();
			$_SESSION['image']=$image_item['image'];
			$_SESSION['code']=$image_item['code'];
			$_SESSION['image']=$image_item['image'];
			unset($image_item);
            $this->load->view('holiday_login',$this->data);
        }	
	}
	public function wage_login(){
		$this->wage_logged_in();	
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
				$id_exists = $this->model_auth->wage_check_id($this->input->post('user_id'));
				if($id_exists == TRUE){
					$login = $this->model_auth->wage_login($this->input->post('user_id'), $this->input->post('password'));
					if($login){
						$log=array(
							'user_id' => $login['user_id'],
							'username' => $login['username'],
							'login_ip' => $_SERVER["REMOTE_ADDR"],
							'staff_action' => 'wage_log_in',
							'action_time' => date('Y-m-d H:i:s')
						);
						$this->model_log_action->create($log);
						$logged_in_sess = array(
							'user_name' => $login['username'],
							'user_id' => $login['user_id'],
							'permission' => $login['permission'],
							'logged_in_wage' => TRUE
						);
						$this->session->set_userdata($logged_in_sess);
						switch($login['permission']){
							case 1:
								redirect('wage/manager', 'refresh');
								break;
							case 2:
								redirect('wage/staff', 'refresh');
								break;
							case 3:	
								redirect('wage/staff', 'refresh');
								break;	
						}
					}
					else{
						$image_item=$this->get_code();
						$_SESSION['image']=$image_item['image'];
						$_SESSION['code']=$image_item['code'];
						unset($image_item);
						$this->data['errors'] = '密码错误';
						$this->load->view('wage_login', $this->data);
					}
				}
				else{
					$image_item=$this->get_code();
					$_SESSION['image']=$image_item['image'];
					$_SESSION['code']=$image_item['code'];
					unset($image_item);
					$this->data['errors'] = '验证码错误';
					$this->load->view('wage_login', $this->data);
				}
           	}
           	else{
				$image_item=$this->get_code();
				$_SESSION['image']=$image_item['image'];
				$_SESSION['code']=$image_item['code'];
				unset($image_item);
           		$this->data['errors'] = '账户不存在';
           		$this->load->view('wage_login', $this->data);
           	}	
        }
        else{
			// false case
			$image_item=$this->get_code();
			$_SESSION['image']=$image_item['image'];
			$_SESSION['code']=$image_item['code'];
			unset($image_item);
            $this->load->view('wage_login');
        }	
	}
	/*
		清除session，退出
		
	*/
	public function holiday_logout(){	
		if(array_key_exists('user_id', $this->data)){
			if($this->data['user_id']==NULL){
				$this->session->sess_destroy();
				redirect('auth/holiday_login', 'refresh');
			}
		}
		else{
			$this->session->sess_destroy();
			redirect('auth/holiday_login', 'refresh');
		}
		$log=array(
			'user_id' => $this->data['user_id'],
			'username' => $this->data['user_name'],
			'login_ip' => $_SERVER["REMOTE_ADDR"],
			'staff_action' => 'holiday_log_out',
			'action_time' => date('Y-m-d H:i:s')
		);
		$this->model_log_action->create($log);
		unset($log);
		$this->session->sess_destroy();
		redirect('auth/holiday_login', 'refresh');
	}
	public function wage_logout(){
		if(array_key_exists('user_id', $this->data)){
			if($this->data['user_id']==NULL){
				$this->session->sess_destroy();
				redirect('auth/wage_login', 'refresh');
			}
		}
		else{
			$this->session->sess_destroy();
			redirect('auth/wage_login', 'refresh');
		}
		$log=array(
			'user_id' => $this->data['user_id'],
			'username' => $this->data['user_name'],
			'login_ip' => $_SERVER["REMOTE_ADDR"],
			'staff_action' => 'wage_log_out',
			'action_time' => date('Y-m-d H:i:s')
		);
		$this->model_log_action->create($log);
		unset($log);
		$this->session->sess_destroy();
		redirect('auth/wage_login', 'refresh');
	}

	public function holiday_setting(){
		$this->setting('holiday');
	}
	public function wage_setting(){
		$this->setting('wage');
	}
	public function setting($type){
		$id = $this->session->userdata('user_id');
		$this->data['user_name'] = $this->session->userdata('user_name');
		if($id){
			$this->form_validation->set_rules('username', 'username', 'trim|max_length[12]');
			if ($this->form_validation->run() == TRUE){
	            // true case
		        if(empty($this->input->post('opassword'))){
					$this->session->set_flashdata('error', '修改失败，原密码不能为空');
					if($type=='holiday')
						redirect('auth/holiday_setting', 'refresh');
					if($type=='wage')
						redirect('auth/wage_setting', 'refresh');
				}
				elseif(empty($this->input->post('npassword')) && empty($this->input->post('cpassword'))){
					$this->session->set_flashdata('error', '修改失败，新密码不能为空');
					if($type=='holiday')
						redirect('auth/holiday_setting', 'refresh');
					if($type=='wage')
						redirect('auth/wage_setting', 'refresh');
				}
		        else{
					$this->form_validation->set_rules('opassword', 'Password', 'trim|required');
					$this->form_validation->set_rules('npassword', 'Password', 'trim|required');
					$this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|matches[npassword]');
					if($this->form_validation->run() == TRUE){
						$compare = $this->model_auth->wage_login($id, $this->input->post('opassword'));
						if($compare){
							$password = md5($this->input->post('npassword'));
							$data = array(
								'username' => $this->input->post('username'),
								'password' => $password,
							);
							if($type=='holiday')
								$update = $this->model_holiday_users->edit($data, $id);
							if($type=='wage')
								$update = $this->model_wage_users->edit($data, $id);	
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
							if($type=='holiday')
								redirect('auth/holiday_setting', 'refresh');
							if($type=='wage')
								redirect('auth/wage_setting', 'refresh');
						}
						
					}
			        else{
						// false case
						redirect('auth/'.$type.'_setting', 'refresh');
						#$this->render_template('users/setting', $this->data);	
			        }
		        }
	        }
	        else{
				// false case
				if($type=='holiday')
	        		$user_data = $this->model_holiday_users->getUserData($id);
				if($type=='wage')
					$user_data = $this->model_wage_users->getUserData($id);
				$this->data['user_data'] = $user_data;
				$this->render_template('users/setting', $this->data);	
	        }
		}
	}
	
}