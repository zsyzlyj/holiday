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
        
        <li id="uploadHolidayNav"><a href="<?php echo base_url('super_holiday/holiday_import') ?>"><i class="fa fa-cloud-upload"></i> 上传年假信息</a></li>
        <!--<li id="downloadHolidayNav"><a href="<?php echo base_url('super_holiday/download_page') ?>"><i class="fa fa-cloud-download"></i> 下载年假计划汇总表</a></li>-->
        <li id="progressHolidayNav"><a href="<?php echo base_url('super_holiday/progress') ?>"><i class="fa fa-list"></i> 进度</a></li>
        
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
            <li id="uploadTagFileNav"><a href="<?php echo base_url('super_wage/wage_tag_import') ?>"><i class="fa fa-circle-o"></i><span>人员角色导入（大表）</span></a></li>
            <li id="resetWageUserNav"><a href="<?php echo base_url('super_wage/reset_pass') ?>"><i class="fa fa-circle-o"></i><span>人员密码初始化</span></a></li>
            <li id="manageHolidayUserNav"><a href="<?php echo base_url('super_holiday/manager') ?>"><i class="fa fa-circle-o"></i> 综管、部门负责人管理</a></li>
            <li id="createUserNav"><a href="<?php echo base_url('super_wage/create') ?>"><i class="fa fa-circle-o"></i><span> 创建用户</span></a></li>
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
        <li id="switchMainMenu">
          <a href="<?php echo base_url('super_holiday/switch_function') ?>">
            <i class="fa fa-tasks"></i>
            <span> 权限开关</span>
          </a>
        </li>
        <?php elseif($permission=='工资'):?>
        <!--
        <li id="wageGatherMainMenu">
          <a href="<?php echo base_url('super_wage/this_month') ?>">
            <i class="fa fa-money"></i><span>本月工资明细汇总</span>
          </a>
        </li>
        -->
        <li id="searchwageGetherMainMenu">
          <a href="<?php echo base_url('super_wage/search') ?>">
            <i class="fa fa-file"></i><span>工资明细信息</span>
          </a>
        </li>
        <!--
        <li id="uploadWageFileNav">
          <a href="<?php echo base_url('super_wage/wage_import') ?>">
            <i class="fa fa-cloud-upload"></i><span>工资明细导入</span>
          </a>
        </li>
        <li id="showWageImportNav">
          <a href="<?php echo base_url('super_wage/show_import_list') ?>">
            <i class="fa fa-list"></i><span>工资明细记录汇总</span>
          </a>
        </li>
-->
        <li class="treeview" id="taxInfo">
          <a href="#">
            <i class="fa fa-star"></i>
            <span>个税信息</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li id="searchtaxMainMenu">
              <a href="<?php echo base_url('super_wage/searchtax') ?>">
                <i class="fa fa-rocket"></i>月度个税信息</a>
            </li>
            <li id="searchwagespMainMenu">
              <a href="<?php echo base_url('super_wage/searchsp') ?>">
                <i class="fa fa-file"></i><span>专项附加扣除信息</span>
              </a>
            </li>
            
          </ul>
        </li>
        <!--
        <li id="searchwagespMainMenu">
          <a href="<?php echo base_url('super_wage/searchsp') ?>">
            <i class="fa fa-file"></i><span>专项附加扣除信息</span>
          </a>
        </li>
        -->
        <!--
        <li id="uploadWageSpFileNav">
          <a href="<?php echo base_url('super_wage/wage_sp_import') ?>">
            <i class="fa fa-cloud-upload"></i><span>专项附件导入</span>
          </a>
        </li>
        <li id="showWageSpImportNav">
          <a href="<?php echo base_url('super_wage/show_sp_import_list') ?>">
            <i class="fa fa-list"></i><span>专项附件汇总</span>
          </a>
        </li>
-->
        <li id="downloadWageNav">
          <a href="<?php echo base_url('super_wage/wage_export') ?>">
            <i class="fa fa-cloud-download"></i><span>工资明细导出</span>
          </a>
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
            <li id="createUserNav"><a href="<?php echo base_url('super_wage/create') ?>"><i class="fa fa-circle-o"></i><span> 创建用户</span></a></li>
            <li id="resetWageUserNav"><a href="<?php echo base_url('super_wage/reset_pass') ?>"><i class="fa fa-circle-o"></i><span>人员密码初始化</span></a></li>
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
            <li id="wage_publish_tax"><a href="<?php echo base_url('super_wage/publish_tax') ?>"><i class="fa fa-circle-o"></i> 发布个税说明</a></li>
            <li id="manage_wage_notice"><a href="<?php echo base_url('super_wage/notification') ?>"><i class="fa fa-circle-o"></i> 公告历史</a></li>

          </ul>
        </li>
        <li id="uploadWageDocNav"><a href="<?php echo base_url('super_wage/wage_doc_import') ?>"><i class="fa fa-cloud"></i> 薪酬文件导入和汇总</a></li>
        <!--
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
        -->
        <li id="wageProofMainMenu">
          <a href="<?php echo base_url('super_wage/wage_proof') ?>">
            <i class="fa fa-money"></i>
            <span> 开具收入证明</span>
          </a>
        </li>
        <li id="wageProofAuditMainMenu">
          <a href="<?php echo base_url('super_wage/wage_proof_audit') ?>">
            <i class="fa fa-money"></i>
             <span class="pull-right-container label label-danger">
            <?php if($unread):?>
              <?php echo $unread;?>
            <?php endif; ?>
            </span>
            <span> 证明审核</span>
          </a>
        </li>

        <!--
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
        -->
        <li id="logTableMainMenu">
          <a href="<?php echo base_url('super_wage/log_show') ?>">
            <i class="fa fa-database"></i>
            <span> 日志查看</span>
          </a>
        </li>
        <li id="switchMainMenu">
          <a href="<?php echo base_url('super_wage/switch_function') ?>">
            <i class="fa fa-tasks"></i>
            <span> 权限开关</span>
          </a>
        </li>
        <?php elseif($permission == '人员'): ?>
        <!--
        <li id="infoMainMenu">
          <a href="<?php echo base_url('super_hr/index') ?>">
            <i class="fa fa-tasks"></i>
            <span> 人员信息</span>
          </a>
        </li>
        <li id="deptMainMenu">
          <a href="<?php echo base_url('super_hr/hr_dept') ?>">
            <i class="fa fa-tasks"></i>
            <span> 部门信息</span>
          </a>
        </li>
        <li id="hrMainMenu">
          <a href="<?php echo base_url('super_hr/index') ?>">
            <i class="fa fa-tasks"></i>
            <span> 人员信息汇总</span>
          </a>
        </li>
        -->
        <li id="hrsearchMainMenu">
          <a href="<?php echo base_url('super_hr/hr_search') ?>">
            <i class="fa fa-tasks"></i>
            <span> 条件搜索</span>
          </a>
        </li>
        <li id="hrTransferMenu">
          <a href="<?php echo base_url('super_hr/hr_transfer_search') ?>">
            <i class="fa fa-tasks"></i>
            <span> 岗位调动信息</span>
          </a>
        </li>
        <li id="scoreMainMenu">
          <a href="<?php echo base_url('super_hr/hr_score') ?>">
            <i class="fa fa-tasks"></i>
            <span> 积点确认</span>
          </a>
        </li>
        <li id="scoreSumMainMenu">
          <a href="<?php echo base_url('super_hr/hr_score_sum') ?>">
            <i class="fa fa-tasks"></i>
            <span> 年度综合积分</span>
          </a>
        </li>
        <li class="treeview" id="hrNoticeNav">
          <a href="#">
            <i class="fa fa-bullhorn"></i>
            <span>年度综合积分确认公告</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li id="publish_hr_score_sum"><a href="<?php echo base_url('super_hr/hr_publish_score_sum') ?>"><i class="fa fa-circle-o"></i> 发布综合积分公告</a></li>        
            <li id="manage_score_sum_notice"><a href="<?php echo base_url('super_hr/notification') ?>"><i class="fa fa-circle-o"></i> 公告历史</a></li>
          </ul>
        </li>
        <li id="hrProofMainMenu">
          <a href="<?php echo base_url('super_hr/hr_proof') ?>">
            <i class="fa fa-money"></i>
            <span> 开具证明</span>
          </a>
        </li>
        <?php endif; ?>
        <!-- user permission info -->
        <li id="settingMenu"><a href="<?php echo base_url('super_auth/setting') ?>"><i class="glyphicon glyphicon-edit"></i> <span>修改密码</span></a></li>
        <!--
        <li><a href="<?php echo base_url('super_auth/logout') ?>"><i class="glyphicon glyphicon-log-out"></i> <span>退出系统</span></a></li>
        -->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  