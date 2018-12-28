<header class="main-header">
    <!-- Logo -->
    <a href="javascript:void(0);" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b></b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>年假管理系统</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
    
    <ul class="nav navbar-nav navbar-right">

        <li><a href="javascript:void(0);">
        <i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;<?php echo $user_name;?>
        </a></li>
        <?php if(strstr($_SERVER['PHP_SELF'],'holiday')):?>
        <li><a href="<?php echo base_url('auth/holiday_setting') ?>"><i class="glyphicon glyphicon-edit "></i>&nbsp;修改密码</a></li>
        <li><a href="<?php echo base_url('auth/holiday_logout') ?>"><i class="glyphicon glyphicon-log-out"></i>&nbsp;退出登录</a></li>
        <?php endif; ?>
        <?php if(strstr($_SERVER['PHP_SELF'],'wage')):?>
        <li><a href="<?php echo base_url('auth/wage_setting') ?>"><i class="glyphicon glyphicon-edit "></i>&nbsp;修改密码</a></li>
        <li><a href="<?php echo base_url('auth/wage_logout') ?>"><i class="glyphicon glyphicon-log-out"></i>&nbsp;退出登录</a></li>
        <?php endif; ?>
        
        <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
    </ul>

    <!-- /.navbar-top-links -->
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
<!--
  <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <?php if($user_name):?>
        <?php echo $user_name;?>
        <?php endif; ?>
        <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-messages">
            <li>
                <a href="#">
                    <div>
                        <strong>John Smith</strong>
                        <span class="pull-right text-muted">
                            <em>Yesterday</em>
                        </span>
                    </div>
                    <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                </a>
            </li>
        </ul> 
        </li>
        <li></li>
    </ul>
-->