<header class="main-header">
    <!-- Logo -->
    <a href="javascript:void(0);" class="logo" style="cursor:default;text-decoration:none">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b></b></span>
      <!-- logo for regular state and mobile devices -->
      <?php if(strstr($_SERVER['PHP_SELF'],'holiday')):?>
        <span class="logo-lg"><b>年假查询系统</b></span>
      <?php endif; ?>
      <?php if(strstr($_SERVER['PHP_SELF'],'wage')):?>
        <span class="logo-lg"><b>工资查询系统</b></span>
      <?php endif; ?>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
    
    <ul class="nav navbar-nav navbar-right">
        <li><a href="javascript:void(0);" style="cursor:default">
        <i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;<?php echo $user_name;?>
        </a></li>
        <li><a href="<?php echo base_url('dashboard') ?>"><i class="glyphicon glyphicon-th"></i>&nbsp;返回主页</a></li>
        <li><a href="<?php echo base_url('auth/logout') ?>"><i class="glyphicon glyphicon-log-out"></i>&nbsp;退出系统</a></li>
    </ul>

    <!-- /.navbar-top-links -->
    </nav>
  </header>