<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <?php if($permission == '休假'): ?>
        <li id="holidayGatherMainMenu">
          <a href="<?php echo base_url('super_holiday/holiday') ?>">
            <i class="fa fa-leaf"></i> <span>年假汇总</span>
          </a>
        </li>
        <li id='planGatherMainMenu'>
          <a href="<?php echo base_url('super_holiday/plan') ?>">
            <i class="fa fa-edit"></i> <span>年假计划汇总</span>
          </a>
        </li>
        <li class="treeview" id="uploadHolidayDoc">
          <a href="#">
            <i class="fa fa-cloud"></i>
            <span>年假文件导入</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li id="uploadHolidayDocNav"><a href="<?php echo base_url('super_holiday/holiday_doc_import') ?>"><i class="fa fa-circle-o"></i> 年假文件导入</a></li>
            <li id="showHolidayDocNav"><a href="<?php echo base_url('super_holiday/holiday_doc_list') ?>"><i class="fa fa-circle-o"></i> 年假文件汇总</a></li>
          </ul>
        </li>
        <li class="treeview" id="holidaySyncNav">
          <a href="#">
            <i class="fa fa-cloud"></i>
            <span>年假信息更新</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li id="uploadHolidayNav"><a href="<?php echo base_url('super_holiday/holiday_import') ?>"><i class="fa fa-circle-o"></i> 上传年假信息</a></li>
            <li id="downloadHolidayNav"><a href="<?php echo base_url('super_holiday/download_page') ?>"><i class="fa fa-circle-o"></i> 下载年假模板</a></li>
          </ul>
        </li>
        
        <li class="treeview" id="holidayUserNav">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>用户角色管理</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <!--<li id="UserNav"><a href="<?php echo base_url('super_holiday/users') ?>"><i class="fa fa-circle-o"></i> 用户管理</a></li>-->
            <li id="manageHolidayUserNav"><a href="<?php echo base_url('super_holiday/manager') ?>"><i class="fa fa-circle-o"></i> 综管、部门负责人管理</a></li>
          </ul>
        </li>
        
        <li class="treeview" id="holidayNoticeNav">
          <a href="#">
            <i class="fa fa-bullhorn"></i>
            <span>发布公告</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li id="publish_holiday"><a href="<?php echo base_url('super_holiday/publish_holiday') ?>"><i class="fa fa-circle-o"></i> 发布假期公告</a></li>        
            <li id="publish_plan"><a href="<?php echo base_url('super_holiday/publish_plan') ?>"><i class="fa fa-circle-o"></i> 发布年假计划公告</a></li>        
            <li id="manage_holiday_notice"><a href="<?php echo base_url('super_holiday/notification') ?>"><i class="fa fa-circle-o"></i> 公告历史</a></li>
          </ul>
        </li>
        
        <?php endif; ?>
        <?php if($permission=='工资'):?>
        <li id="wageGatherMainMenu">
          <a href="<?php echo base_url('super_wage/this_month') ?>">
            <i class="fa fa-money"></i><span>本月薪酬汇总</span>
          </a>
        </li>
        <li id="searchwageGetherMainMenu">
          <a href="<?php echo base_url('super_wage/search') ?>">
            <i class="fa fa-file"></i><span>往月薪酬汇总</span>
          </a>
        </li>
        <li class="treeview" id="wageSyncNav">
          <a href="#">
            <i class="fa fa-cloud"></i>
            <span>本月薪酬信息更新</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li id="uploadWageFileNav"><a href="<?php echo base_url('super_wage/wage_import') ?>"><i class="fa fa-circle-o"></i><span>薪酬信息导入</span></a></li>
            <li id="downloadWageNav"><a href="<?php echo base_url('super_wage/download_page') ?>"><i class="fa fa-circle-o"></i>下载薪酬模板</a></li>
          </ul>
        </li>
        
        <li class="treeview" id="wageUserNav">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>用户角色管理</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li id="uploadTagFileNav"><a href="<?php echo base_url('super_wage/wage_tag_import') ?>"><i class="fa fa-circle-o"></i><span>人员角色导入</span></a></li>
            <li id="manageWageUserNav"><a href="<?php echo base_url('super_wage/tag') ?>"><i class="fa fa-circle-o"></i> 综管、部门负责人管理</a></li>
          </ul>
        </li>
        <li class="treeview" id="wageNoticeNav">
          <a href="#">
            <i class="fa fa-bullhorn"></i>
            <span>发布公告</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li id="wage_publish_wage"><a href="<?php echo base_url('super_wage/publish_wage') ?>"><i class="fa fa-circle-o"></i> 发布薪酬公告</a></li>        
            <li id="manage_wage_notice"><a href="<?php echo base_url('super_wage/notification') ?>"><i class="fa fa-circle-o"></i> 公告历史</a></li>
          </ul>
        </li>
        <li class="treeview" id="uploadWageDoc">
          <a href="#">
            <i class="fa fa-cloud"></i>
            <span>薪酬文件导入</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li id="uploadWageDocNav"><a href="<?php echo base_url('super_wage/wage_doc_import') ?>"><i class="fa fa-circle-o"></i> 薪酬文件导入</a></li>
            <li id="showWageDocNav"><a href="<?php echo base_url('super_wage/wage_doc_list') ?>"><i class="fa fa-circle-o"></i> 薪酬文件汇总</a></li>
          </ul>
        </li>
        <li id="wageProofMainMenu">
          <a href="<?php echo base_url('super_wage/wage_proof') ?>">
            <i class="fa fa-money"></i><span>收入证明</span>
          </a>
        </li>
        <li class="treeview" id="taxCounterMenu">
          <a href="#">
            <i class="fa fa-cloud"></i>
            <span>个税计算</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li id="taxCounterNav"><a href="<?php echo base_url('super_wage/tax_counter') ?>"><i class="fa fa-circle-o"></i> 个税计算器</a></li>
            <li id="showWageDocNav"><a href="#"><i class="fa fa-circle-o"></i> 人员名单导入</a></li>
          </ul>
        </li>
        <?php endif; ?>
        
        <!-- user permission info -->
        
        <?php if(strstr($_SERVER['PHP_SELF'],'holiday')):?>
        <li id="settingMenu"><a href="<?php echo base_url('super_auth/holiday_setting') ?>"><i class="glyphicon glyphicon-edit"></i> <span>修改密码</span></a></li>
        <?php endif; ?>
        <?php if(strstr($_SERVER['PHP_SELF'],'wage')):?>
        <li id="settingMenu"><a href="<?php echo base_url('super_auth/wage_setting') ?>"><i class="glyphicon glyphicon-edit"></i> <span>修改密码</span></a></li>
        <?php endif; ?>
        
        <li><a href="<?php echo base_url('super_auth/logout') ?>"><i class="glyphicon glyphicon-log-out"></i> <span>退出登录</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  