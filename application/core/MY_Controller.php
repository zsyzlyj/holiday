<?php 

class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
}

class Admin_Controller extends MY_Controller 
{
	var $permission = array();

	public function __construct() 
	{
		parent::__construct();
		if(empty($this->session->userdata('logged_in_super'))){
			$session_data = array('logged_in_super' => FALSE);
			$this->session->set_userdata($session_data);
		}
		else{
			$user_id = $this->session->userdata('user_id');
			$this->load->model('model_super_user');
			$user_data = $this->model_super_user->getUserById($user_id);
			$this->data['permission'] = $user_data['permission'];
		}
		if(empty($this->session->userdata('logged_in'))){
			$session_data = array('logged_in' => FALSE);
			$this->session->set_userdata($session_data);
		}
		else{
			$user_id = $this->session->userdata('user_id');
			$this->load->model('model_users');
			$user_data = $this->model_users->getUserById($user_id);
			$this->data['permission'] = $user_data['permission'];
		}
		$this->load->model('model_log_action');
		$this->session->set_flashdata('success', '');
		$this->session->set_flashdata('error', '');
	}

	
	public function logged_in(){
		$session_data = $this->session->userdata();
		if($session_data['logged_in'] == TRUE){
			redirect('dashboard', 'refresh');
		}
	}

	public function not_logged_in(){
		$session_data = $this->session->userdata();
		if($session_data['logged_in'] == FALSE){
			redirect('auth/login', 'refresh');
		}
	}
	public function holiday_logged_in(){
		$session_data = $this->session->userdata();
		if($session_data['logged_in_holiday'] == TRUE){
			redirect('holiday/staff', 'refresh');
		}
	}

	public function holiday_not_logged_in(){
		$session_data = $this->session->userdata();
		if($session_data['logged_in_holiday'] == FALSE){
			redirect('auth/holiady_login', 'refresh');
		}
	}
	public function wage_logged_in()
	{
		$session_data = $this->session->userdata();
		if($session_data['logged_in_wage'] == TRUE){
			redirect('wage/index', 'refresh');
		}
	}

	public function wage_not_logged_in()
	{
		$session_data = $this->session->userdata();
		if($session_data['logged_in_wage'] == FALSE){
			redirect('auth/wage_login', 'refresh');
		}
	}
	public function logged_in_super()
	{
		$session_data = $this->session->userdata();
		if($session_data['logged_in_super'] == TRUE){
			redirect('super_wage/index', 'refresh');
		}
	}
	public function not_logged_in_super()
	{
		$session_data = $this->session->userdata();
		if($session_data['logged_in_super'] == FALSE){
			redirect('super_auth/login', 'refresh');
		}
	}

	public function render_template($page = null, $data = array())
	{

		$this->load->view('templates/header',$data);
		$this->load->view('templates/header_menu',$data);
		$this->load->view('templates/side_menubar',$data);
		$this->load->view($page, $data);
		$this->load->view('templates/footer',$data);
	}
	public function render_super_template($page = null, $data = array())
	{

		$this->load->view('templates/super_header',$data);
		$this->load->view('templates/super_header_menu',$data);
		$this->load->view('templates/super_side_menubar',$data);
		$this->load->view($page, $data);
		$this->load->view('templates/super_footer',$data);
	}
	public function render_dashboard_template($page = null, $data = array())
	{

		$this->load->view('templates/dashboard_header',$data);
		#$this->load->view('templates/header',$data);
		$this->load->view('templates/dashboard_header_menu',$data);
		#$this->load->view('templates/side_menubar',$data);
		$this->load->view($page, $data);
		$this->load->view('templates/footer',$data);
	}
	public function company_currency()
	{
		$this->load->model('model_company');
		$company_currency = $this->model_company->getCompanyData(1);
		$currencies = $this->currency();
			
		$currency = '';
		foreach ($currencies as $key => $value){
			if($key == $company_currency['currency']){
				$currency = $value;
			}
		}

		return $currency;

	}

	
	public function currency()
	{
		return $currency_symbols = array(
		  'AED' => '&#1583;.&#1573;', // ?
		  'AFN' => '&#65;&#102;',
		  'ALL' => '&#76;&#101;&#107;',
		  'ANG' => '&#402;',
		  'AOA' => '&#75;&#122;', // ?
		  'ARS' => '&#36;',
		  'AUD' => '&#36;',
		  'AWG' => '&#402;',
		  'AZN' => '&#1084;&#1072;&#1085;',
		  'BAM' => '&#75;&#77;',
		  'BBD' => '&#36;',
		  'BDT' => '&#2547;', // ?
		  'BGN' => '&#1083;&#1074;',
		  'BHD' => '.&#1583;.&#1576;', // ?
		  'BIF' => '&#70;&#66;&#117;', // ?
		  'BMD' => '&#36;',
		  'BND' => '&#36;',
		  'BOB' => '&#36;&#98;',
		  'BRL' => '&#82;&#36;',
		  'BSD' => '&#36;',
		  'BTN' => '&#78;&#117;&#46;', // ?
		  'BWP' => '&#80;',
		  'BYR' => '&#112;&#46;',
		  'BZD' => '&#66;&#90;&#36;',
		  'CAD' => '&#36;',
		  'CDF' => '&#70;&#67;',
		  'CHF' => '&#67;&#72;&#70;',
		  'CLP' => '&#36;',
		  'CNY' => '&#165;',
		  'COP' => '&#36;',
		  'CRC' => '&#8353;',
		  'CUP' => '&#8396;',
		  'CVE' => '&#36;', // ?
		  'CZK' => '&#75;&#269;',
		  'DJF' => '&#70;&#100;&#106;', // ?
		  'DKK' => '&#107;&#114;',
		  'DOP' => '&#82;&#68;&#36;',
		  'DZD' => '&#1583;&#1580;', // ?
		  'EGP' => '&#163;',
		  'ETB' => '&#66;&#114;',
		  'EUR' => '&#8364;',
		  'FJD' => '&#36;',
		  'FKP' => '&#163;',
		  'GBP' => '&#163;',
		  'GEL' => '&#4314;', // ?
		  'GHS' => '&#162;',
		  'GIP' => '&#163;',
		  'GMD' => '&#68;', // ?
		  'GNF' => '&#70;&#71;', // ?
		  'GTQ' => '&#81;',
		  'GYD' => '&#36;',
		  'HKD' => '&#36;',
		  'HNL' => '&#76;',
		  'HRK' => '&#107;&#110;',
		  'HTG' => '&#71;', // ?
		  'HUF' => '&#70;&#116;',
		  'IDR' => '&#82;&#112;',
		  'ILS' => '&#8362;',
		  'INR' => '&#8377;',
		  'IQD' => '&#1593;.&#1583;', // ?
		  'IRR' => '&#65020;',
		  'ISK' => '&#107;&#114;',
		  'JEP' => '&#163;',
		  'JMD' => '&#74;&#36;',
		  'JOD' => '&#74;&#68;', // ?
		  'JPY' => '&#165;',
		  'KES' => '&#75;&#83;&#104;', // ?
		  'KGS' => '&#1083;&#1074;',
		  'KHR' => '&#6107;',
		  'KMF' => '&#67;&#70;', // ?
		  'KPW' => '&#8361;',
		  'KRW' => '&#8361;',
		  'KWD' => '&#1583;.&#1603;', // ?
		  'KYD' => '&#36;',
		  'KZT' => '&#1083;&#1074;',
		  'LAK' => '&#8365;',
		  'LBP' => '&#163;',
		  'LKR' => '&#8360;',
		  'LRD' => '&#36;',
		  'LSL' => '&#76;', // ?
		  'LTL' => '&#76;&#116;',
		  'LVL' => '&#76;&#115;',
		  'LYD' => '&#1604;.&#1583;', // ?
		  'MAD' => '&#1583;.&#1605;.', //?
		  'MDL' => '&#76;',
		  'MGA' => '&#65;&#114;', // ?
		  'MKD' => '&#1076;&#1077;&#1085;',
		  'MMK' => '&#75;',
		  'MNT' => '&#8366;',
		  'MOP' => '&#77;&#79;&#80;&#36;', // ?
		  'MRO' => '&#85;&#77;', // ?
		  'MUR' => '&#8360;', // ?
		  'MVR' => '.&#1923;', // ?
		  'MWK' => '&#77;&#75;',
		  'MXN' => '&#36;',
		  'MYR' => '&#82;&#77;',
		  'MZN' => '&#77;&#84;',
		  'NAD' => '&#36;',
		  'NGN' => '&#8358;',
		  'NIO' => '&#67;&#36;',
		  'NOK' => '&#107;&#114;',
		  'NPR' => '&#8360;',
		  'NZD' => '&#36;',
		  'OMR' => '&#65020;',
		  'PAB' => '&#66;&#47;&#46;',
		  'PEN' => '&#83;&#47;&#46;',
		  'PGK' => '&#75;', // ?
		  'PHP' => '&#8369;',
		  'PKR' => '&#8360;',
		  'PLN' => '&#122;&#322;',
		  'PYG' => '&#71;&#115;',
		  'QAR' => '&#65020;',
		  'RON' => '&#108;&#101;&#105;',
		  'RSD' => '&#1044;&#1080;&#1085;&#46;',
		  'RUB' => '&#1088;&#1091;&#1073;',
		  'RWF' => '&#1585;.&#1587;',
		  'SAR' => '&#65020;',
		  'SBD' => '&#36;',
		  'SCR' => '&#8360;',
		  'SDG' => '&#163;', // ?
		  'SEK' => '&#107;&#114;',
		  'SGD' => '&#36;',
		  'SHP' => '&#163;',
		  'SLL' => '&#76;&#101;', // ?
		  'SOS' => '&#83;',
		  'SRD' => '&#36;',
		  'STD' => '&#68;&#98;', // ?
		  'SVC' => '&#36;',
		  'SYP' => '&#163;',
		  'SZL' => '&#76;', // ?
		  'THB' => '&#3647;',
		  'TJS' => '&#84;&#74;&#83;', // ? TJS (guess)
		  'TMT' => '&#109;',
		  'TND' => '&#1583;.&#1578;',
		  'TOP' => '&#84;&#36;',
		  'TRY' => '&#8356;', // New Turkey Lira (old symbol used)
		  'TTD' => '&#36;',
		  'TWD' => '&#78;&#84;&#36;',
		  'UAH' => '&#8372;',
		  'UGX' => '&#85;&#83;&#104;',
		  'USD' => '&#36;',
		  'UYU' => '&#36;&#85;',
		  'UZS' => '&#1083;&#1074;',
		  'VEF' => '&#66;&#115;',
		  'VND' => '&#8363;',
		  'VUV' => '&#86;&#84;',
		  'WST' => '&#87;&#83;&#36;',
		  'XAF' => '&#70;&#67;&#70;&#65;',
		  'XCD' => '&#36;',
		  'XPF' => '&#70;',
		  'YER' => '&#65020;',
		  'ZAR' => '&#82;',
		  'ZMK' => '&#90;&#75;', // ?
		  'ZWL' => '&#90;&#36;',
		);
	}
	/*
	public function generate_captcha()
    {
        $this->load->library('captcha');
        // 英文
        // $config = [
        //     'seKey'     =>  'Zell Dincht',          // 验证码加密密钥
        //     'codeSet'   =>  '2345678abcdefhijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXY',             // 验证码字符集合
        //     'expire'    =>  1800,                   // 验证码过期时间（s）
        //     'useZh'     =>  FALSE,                  // 使用中文验证码 
        //     'useImgBg'  =>  FALSE,                  // 使用背景图片 
        //     'fontSize'  =>  16,                     // 验证码字体大小(px)
        //     'useCurve'  =>  TRUE,                   // 是否画混淆曲线
        //     'useNoise'  =>  FALSE,                  // 是否添加杂点  
        //     'imageW'    =>  0,                      // 验证码图片宽度
        //     'imageH'    =>  40,                     // 验证码图片高度
        //     'length'    =>  3,                      // 验证码位数
        //     'fontttf'   =>  '7.ttf',                // 验证码字体，不设置随机获取
        //     'bg'        =>  array(243, 251, 254),   // 背景颜色
        //     'reset'     =>  TRUE,                   // 验证成功后是否重置
        // ];
        // 中文
        $config = [
            'seKey'     =>  'Zell Dincht',          // 验证码加密密钥
            'codeSet'   =>  '2345678abcdefhijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXY',             // 验证码字符集合
            'expire'    =>  1800,                   // 验证码过期时间（s）
            'useZh'     =>  TRUE,                   // 使用中文验证码 
            'useImgBg'  =>  FALSE,                  // 使用背景图片 
            'fontSize'  =>  16,                     // 验证码字体大小(px)
            'useCurve'  =>  TRUE,                   // 是否画混淆曲线
            'useNoise'  =>  FALSE,                  // 是否添加杂点  
            'imageW'    =>  0,                      // 验证码图片宽度
            'imageH'    =>  40,                     // 验证码图片高度
            'length'    =>  3,                      // 验证码位数
            'fontttf'   =>  'zhttfs/fzstk.ttf',     // 验证码字体，不设置随机获取
            'bg'        =>  array(243, 251, 254),   // 背景颜色
            'reset'     =>  TRUE,                   // 验证成功后是否重置
        ];
        $captcha = new Captcha($config);
        $captcha->generate();

	}
	*/
}