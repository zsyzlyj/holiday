<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php if(strstr($_SERVER['PHP_SELF'],'wage')):?>
  <title>工资查询</title>
  <?php endif; ?>
  <?php if(strstr($_SERVER['PHP_SELF'],'holiday')):?>
  <title>年假查询</title>
  <?php endif; ?>
  <?php if(strstr($_SERVER['PHP_SELF'],'profile')):?>
  <title>个人信息</title>
  <?php endif; ?>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->  
  <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/bootstrap/dist/css/bootstrap.css') ?>">
  <!-- Font Awesome -->  
  <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/font-awesome/css/font-awesome.min.css') ?>">
  
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/Ionicons/css/ionicons.min.css') ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/AdminLTE.min.css') ?>">
 
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/skins/_all-skins.min.css') ?>">

  <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') ?>">
  <!-- 2019.04.11 删除-->
  <!-- Select2
  <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/select2/dist/css/select2.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/fileinput/fileinput.min.css') ?>">
 -->
  <!-- icheck -->
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/iCheck/all.css') ?>">

  <!-- bootstrap datetimepicker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/showmonth.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/showapply.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/bootstrap.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/bootstrap-datetimepicker.min.css')?>">

  <!-- Page level plugin CSS-->
  <!--2019.03.15 删除
    <link href="<?php echo base_url('assets/dist/vendor/datatables/dataTables.bootstrap4.css') ?>" rel="stylesheet">
  -->
  <link href="<?php echo base_url('assets/images/logo-icob.ico');?>" type="image/x-icon" rel="shortcut icon">
 
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <!-- 2019.03.15 删除
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  -->
  <!--2019.02.21 删除-->
  <!--
  <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') ?>">
   Morris chart
  <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/morris.js/morris.css') ?>">  
    bootstrap wysihtml5 - text editor
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') ?>">
    
  <!-- jvectormap 
  <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/jvectormap/jquery-jvectormap.css') ?>">
  <!-- Date Picker 
  <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') ?>">
  <!-- Daterange picker   
  <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css') ?>">

  -->
  
  <style type="text/css">
    #loginBox{
      display:none;
    }
  </style>
  
  <!-- jQuery 3 -->
  <script src="<?php echo base_url('assets/bower_components/jquery/dist/jquery.min.js') ?>"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?php echo base_url('assets/bower_components/jquery-ui/jquery-ui.min.js') ?>"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button);
  </script>
  <!-- Bootstrap 3.3.7 -->
  <script src="<?php echo base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>

  <!-- Slimscroll -->
  <script src="<?php echo base_url('assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') ?>"></script>
  <!-- FastClick -->
  <script src="<?php echo base_url('assets/bower_components/fastclick/lib/fastclick.js') ?>"></script>
  <!-- Select2 -->
  <!-- 2019.04.11 删除-->
  <!--
  <script src="<?php echo base_url('assets/bower_components/select2/dist/js/select2.full.min.js') ?>"></script>
  -->
  <!-- AdminLTE App -->  
  <script src="<?php echo base_url('assets/dist/js/adminlte.min.js') ?>"></script>
  
  <!-- icheck -->
  <script src="<?php echo base_url('assets/plugins/iCheck/icheck.min.js') ?>"></script>

  <!-- DataTables -->
  <script src="<?php echo base_url('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') ?>"></script>


  <!-- Datetimepicker -->
  
  <script src="<?php echo base_url('assets/dist/js/bootstrap-datetimepicker.js') ?>"></script>
  <script src="<?php echo base_url('assets/bower_components/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js'); ?>"></script>

  <!-- AdminLTE dashboard demo (This is only for demo purposes) 
  <script src="<?php echo base_url('assets/dist/js/pages/dashboard.js') ?>"></script>
  -->
  <!-- 
    <!-- Morris.js charts 
  <script src="<?php echo base_url('assets/bower_components/raphael/raphael.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/bower_components/morris.js/morris.min.js') ?>"></script>
  <!-- Sparkline 
  <script src="<?php echo base_url('assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') ?>"></script>
  <!-- jvectormap 
  <script src="<?php echo base_url('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') ?>"></script>

  <!-- jQuery Knob Chart 
    <script src="<?php echo base_url('assets/bower_components/jquery-knob/dist/jquery.knob.min.js') ?>"></script>
  <!-- daterangepicker 
  <script src="<?php echo base_url('assets/bower_components/moment/min/moment.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.js') ?>"></script>
  <!-- datepicker 
  <script src="<?php echo base_url('assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') ?>"></script>
  Bootstrap WYSIHTML5
     
  <script src="<?php echo base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') ?>"></script>
  AdminLTE for demo purposes 
  <script src="<?php echo base_url('assets/dist/js/demo.js') ?>"></script>
  <script src="<?php echo base_url('assets/plugins/fileinput/fileinput.min.js') ?>"></script>
  -->

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  