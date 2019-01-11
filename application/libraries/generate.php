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

    $this->load->library('captcha');

    if(!empty($code = $this->input->post('captcha'))) // 用户输入的验证码，根据逻辑，自行处理吧，大概就是这么个意思。
    {
        $captcha = new Captcha();
        $result = $captcha->validate($code);// 验证
        if($result) {
            $data['success_info'] = '验证成功';
        }
    }