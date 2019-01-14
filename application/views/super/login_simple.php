<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<title>登录</title>
	<link rel="stylesheet" href="<?php echo base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">

    <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/simple/login.css')?>">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo base_url('assets/bower_components/font-awesome/css/font-awesome.min.css') ?>">
	<!-- Ionicons -->
	<link rel="stylesheet" href="<?php echo base_url('assets/bower_components/Ionicons/css/ionicons.min.css') ?>">
	
</head>
<body>
<div class="login">
    <div class="login_title">
        <p>系统</p>
    </div>
    <div class="login_main">
        <div class="main_left"></div>
        <div class="main_right">
            <div class="right_title">用户登录</div>
            <form action="">
				<div class="form-group has-feedback">
					<input class="form-control" name="user_id" id="user_id" placeholder="用户名" autocomplete="off">
				</div>
				<div class="form-group has-feedback">
					<input type="password" class="form-control" name="password" id="password" placeholder="密码" autocomplete="off">
				</div>
				<div class="row">
					<div class="col-xs-8">
					<input class="form-control" name="verify_code" id="password" placeholder="验证码" autocomplete="off">
					</div>
					<div class="col-xs-4">
					<a href="<?php echo base_url('super_auth/login');?>"><img src="<?php echo base_url($_SESSION['image']);?>" style="border:1px solid black" value="验证" name="captcha"/></a>
					</div>
				</div>
                <div class="yes_login"><a href="">登&nbsp;&nbsp;&nbsp;&nbsp;录</a></div>
            </form>
        </div>
    </div>
</div>

</body>
</html>