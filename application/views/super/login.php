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
</head>

<body>
<div class="login_box">

    <div class="login_l_img"><img src="<?php echo base_url('assets/dist/img/login-img.png') ?>" /></div>
        <div class="login">
            <div class="login_logo"><a href="<?php echo base_url('super_auth/login'); ?>"><img src="<?php echo base_url('assets/dist/img/login_logo.png') ?>" /></a></div>
            <div class="login_name">
                <p>超级管理员登录</p>
            </div>
            <?php echo validation_errors(); ?>  
            <?php if(!empty($errors)) {
            echo $errors;
            } ?>
            <form action="<?php echo base_url('super_auth/login') ?>" method="post">
                <div class="form-group has-feedback">
                    <input class="form-control" type="text" name="user_id" id="user_id" placeholder="用户名" autocomplete="off">
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="password" id="password" placeholder="密码" autocomplete="off">
                </div>
                <div class="row">
                    <div class="col-md-7">
                    <input class="form-control" type="text" name="verify_code" id="password" placeholder="验证码" autocomplete="off">
                    </div>
                    <div class="col-md-4">
                    <a href="<?php echo base_url('super_auth/login');?>"><img src="<?php echo base_url($_SESSION['image']);?>" style="border:1px solid black" value="验证" name="captcha"/></a>
                    </div>
                </div>
                <input value="登录" style="width:100%;" type="submit">
            </form>
        </div>
    </div>
</div>

</body>
</html>
