<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <?php if($permission=='工资'):?>
        <li id="wageGatherMainMenu">
          <a href="<?php echo base_url('super/wage') ?>">
            <i class="fa fa-money"></i><span>工资汇总</span>
          </a>
        </li>
        <li id="uploadWageFileNav">
          <a href="<?php echo base_url('super/wage_import') ?>">
          <i class="fa fa-circle-o"></i><span>工资导入</span>
          </a>
        </li>
        <?php endif; ?>
        <?php if($permission == '休假'): ?>
        <li id="holidayGatherMainMenu">
          <a href="<?php echo base_url('super/holiday') ?>">
            <i class="fa fa-leaf"></i> <span>年假汇总</span>
          </a>
        </li>
        <li id='planGatherMainMenu'>
          <a href="<?php echo base_url('super/plan') ?>">
            <i class="fa fa-edit"></i> <span>年假计划汇总</span>
          </a>
        </li>
        <li class="treeview" id="mainSyncNav">
          <a href="#">
            <i class="fa fa-cloud"></i>
            <span>数据同步</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li id="uploadFileNav"><a href="<?php echo base_url('super/holiday_import') ?>"><i class="fa fa-circle-o"></i> 上传数据</a></li>
            <li id="downloadFileNav"><a href="<?php echo base_url('super/download_page') ?>"><i class="fa fa-circle-o"></i> 下载数据</a></li>
          </ul>
        </li>
        
        <li class="treeview" id="mainUserNav">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>用户权限管理</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li id="UserNav"><a href="<?php echo base_url('super/users') ?>"><i class="fa fa-circle-o"></i> 用户管理</a></li>
            <li id="manageUserNav"><a href="<?php echo base_url('super/manager') ?>"><i class="fa fa-circle-o"></i> 权限管理</a></li>
          </ul>
        </li>
        <li class="treeview" id="mainNoticeNav">
          <a href="#">
            <i class="fa fa-bullhorn"></i>
            <span>公告</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li id="publish_holiday"><a href="<?php echo base_url('notification/publish_holiday') ?>"><i class="fa fa-circle-o"></i> 发布假期公告</a></li>        
            <li id="publish_plan"><a href="<?php echo base_url('notification/publish_plan') ?>"><i class="fa fa-circle-o"></i> 发布年假计划公告</a></li>        
            <li id="manage_notice"><a href="<?php echo base_url('notification') ?>"><i class="fa fa-circle-o"></i> 公告历史</a></li>
          </ul>
        </li>
        
        <?php endif; ?>
        
        <?php if($permission == '绩效'): ?>
        <li class="treeview" id="mainNoticeNav">
          <a href="#">
            <i class="fa fa-bullhorn"></i>
            <span>绩效</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li id="publish_holiday"><a href="<?php echo base_url('notification/publish_holiday') ?>"><i class="fa fa-circle-o"></i> 发布假期公告</a></li>        
            <li id="publish_plan"><a href="<?php echo base_url('notification/publish_plan') ?>"><i class="fa fa-circle-o"></i> 发布年假计划公告</a></li>        
            <li id="manage_notice"><a href="<?php echo base_url('notification') ?>"><i class="fa fa-circle-o"></i> 公告历史</a></li>
          </ul>
        </li>

        <?php endif; ?>
        
        <!-- user permission info -->
        
        <li><a href="<?php echo base_url('super/setting') ?>"><i class="glyphicon glyphicon-edit"></i> <span>修改密码</span></a></li>
        <li><a href="<?php echo base_url('super_auth/logout') ?>"><i class="glyphicon glyphicon-log-out"></i> <span>登出</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  