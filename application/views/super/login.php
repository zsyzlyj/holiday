<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
<meta http-equiv="Pragma" content="no-cache"> 
<meta http-equiv="Cache-Control" content="no-cache"> 
<meta http-equiv="Expires" content="0"> 
<title>后台管理</title>

<link rel="stylesheet" href="<?php echo base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
  
<link rel="stylesheet" href="<?php echo base_url('assets/dist/css/login.css') ?>">
<link href="<?php echo base_url('assets/images/logo-icob.ico');?>" type="image/x-icon" rel="shortcut icon">

</head>

<body>
<div class="login_box">
    <div class="login_l_img"><img src="<?php echo base_url('assets/dist/img/login-img.png') ?>" /></div>
        <div class="login">
            <div class="login_logo"><a href="<?php echo base_url('super_auth/login'); ?>"><img src="<?php echo base_url('assets/dist/img/login_logo.png') ?>" /></a></div>
            <div class="login_name">
                <p>超级管理员登录</p>
            </div>
            <font color="red">
            <?php echo validation_errors(); ?>  
            <?php if(!empty($errors)) {
            echo $errors;
            } ?>
            </font>
            <form action="<?php echo base_url('super_auth/login') ?>" method="post">
                <div class="form-group has-feedback">
                    <input class="form-control" type="text" name="user_id" id="user_id" required="required" placeholder="用户名" autocomplete="off">
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="password" id="password" required="required" placeholder="密码" autocomplete="off">
                </div>
                <div class="row">
                    <div class="col-md-7">
                    <input class="form-control" type="text" name="verify_code" id="password" required="required" placeholder="验证码" autocomplete="off">
                    </div>
                    <div class="col-md-4">
                        <a href="javascript:void(0);" id="reload-captcha"><p id="captcha-image"></p></a>
                    </div>
                </div>
                <input value="登录" style="width:100%;" type="submit">
            </form>
            <br />
            <div><a href="<?php echo base_url('auth/login');?>" class="login_link">返回员工登录首页</a></div>
        </div>
    </div>
    
</div>
<script src="<?php echo base_url('assets/bower_components/jquery/dist/jquery.min.js') ?>"></script>
<script type="text/javascript">
    function get_captcha() {
        $.get("<?php echo base_url('super_auth/get_captcha');?>", function(data){
            $('#captcha-image').html(data);
        });
    };
    $(document).ready(function() {
        get_captcha();
        $('#reload-captcha').click(get_captcha);
    });

</script>
</body>
</html>
