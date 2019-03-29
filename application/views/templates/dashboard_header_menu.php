<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url('dashboard') ?>" class="logo">
    <span style="float:left"></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="mylogo navbar navbar-static-top">
    
      <ul class="nav navbar-nav navbar-right">

          <li><a href="javascript:void(0);">
          <font size="4px"><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;<?php echo $user_name;?></font>
          </a></li>
          <li id="changePassword"><a href="<?php echo base_url('auth/setting') ?>"><font size="4px"><i class="glyphicon glyphicon-edit"></i>修改密码</font></a></li>
          <li><a href="<?php echo base_url('auth/logout') ?>"><font size="4px"><i class="glyphicon glyphicon-log-out"></i>&nbsp;退出系统</a></font></li>
          <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
      </ul>

    <!-- /.navbar-top-links -->
    </nav>
  </header>