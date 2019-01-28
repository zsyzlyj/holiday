<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url('dashboard') ?>" class="logo">
      
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="mylogo navbar navbar-static-top">
    
      <ul class="nav navbar-nav navbar-right">

          <li><a href="javascript:void(0);">
          <i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;<?php echo $user_name;?>
          </a></li>
          <li id="changePassword"><a href="<?php echo base_url('auth/setting') ?>"><i class="glyphicon glyphicon-edit"></i> <span>修改密码</span></a></li>
          <li><a href="<?php echo base_url('auth/logout') ?>"><i class="glyphicon glyphicon-log-out"></i>&nbsp;退出登录</a></li>
          <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
      </ul>

    <!-- /.navbar-top-links -->
    </nav>
  </header>