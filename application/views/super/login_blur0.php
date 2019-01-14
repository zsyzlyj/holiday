<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>超管登录</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  
  
  <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/font-awesome/css/font-awesome.min.css') ?>">

  <!-- Login Background -->
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/reset.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/supersized.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/style.css') ?>">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>
<body class="hold-transition login-page">
  <div class="page-container">
  <?php echo validation_errors(); ?>  

  <?php if(!empty($errors)) {
    echo $errors;
  } ?>
    <a href="<?php echo base_url('super_auth/login'); ?>" style="color:#FFFFFF"><h1>管理</h1></a>
    <form action="" method="post">
      
        <input name="user_id" id="user_id" placeholder="用户名" autocomplete="off">
        <input type="password" name="password" id="password" placeholder="密码" autocomplete="off">
        <input class="col-md-6 col-md-offset-1" name="verify_code" id="password" placeholder="验证码" autocomplete="off"><a class="col-md-4" href="<?php echo base_url('super_auth/login');?>"><img src="<?php echo base_url($_SESSION['image']);?>" style="border:1px solid black" value="验证" name="captcha"/></a></input>
        <button type="submit">登录</button>
        <div class="error"><span>+</span></div>
    
      </div>      
    </form>
  </div>
</div>
<!-- /.login-box -->
<script src="<?php echo base_url('assets/dist/js/jquery-1.8.2.min.js'); ?>"></script>
<!-- Bootstrap 3.3.7 
<script src="<?php echo base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
-->
<!-- iCheck -->
<script src="<?php echo base_url('assets/plugins/iCheck/icheck.min.js') ?>"></script>

<script src="<?php echo base_url('assets/dist/js/supersized.3.2.7.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/dist/js/supersized-init.js'); ?>"></script>
<script src="<?php echo base_url('assets/dist/js/scripts.js'); ?>"></script>
<script>

</script>
</body>
</html>
