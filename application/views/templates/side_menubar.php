<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <?php if($permission == 2 ): ?>
        <li id="myDeptHolidayMainMenu">
          <a href="<?php echo base_url('wage/mydeptwage') ?>">
            <i class="fa fa-file-archive-o"></i>
            <span>部门工资信息汇总</span>
          </a>
        </li>
        <?php endif; ?>
        <?php if($permission == 1 or $permission == 2 ): ?>
        <li id="myDeptHolidayMainMenu">
          <a href="<?php echo base_url('holiday/mydeptholiday') ?>">
            <i class="fa fa-file-archive-o"></i>
            <span>部门年假信息汇总</span>
          </a>
        </li>
        <li class="treeview" id="mydeptPlanMainMenu">
          <a href="#">
            <i class="fa fa-folder-o"></i>
            <span>部门年假计划汇总</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li id="myDeptPlanNav">
              <a href="<?php echo base_url('holiday/mydeptplan') ?>">
                <i class="fa fa-circle-o"></i>
                <span>年假计划汇总</span>
              </a>
            </li>
            <li id="SubmitStatusNav">
              <a href="<?php echo base_url('holiday/mydeptplan_submit') ?>">
              <i class="fa fa-circle-o"></i>
              汇总提交情况
              </a>
            </li>
          </ul>  
        </li>
        
        <?php endif ?>
        <?php if($permission == 2): ?>
        <li class="treeview" id="AuditMainMenu">
          <a href="#">
            <i class="fa fa-check-square-o"></i>
            <span>年假审核</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <li id="AuditNav">
            <a href="<?php echo base_url('holiday/audit') ?>">
              <i class="fa fa-circle-o"></i>
              年假审核
            </a>
          </li>
          <li id="AuditGatherNav">
            <a href="<?php echo base_url('holiday/audit_result') ?>">
            <i class="fa fa-circle-o"></i>
             年假审核结果
            </a>
          </li>
          </ul>
            
        </li>

        <?php endif ?>
        
        <li id="holidayMainMenu">
          <a href="<?php echo base_url('wage/staff') ?>">
            <i class="fa fa-money"></i> <span>我的工资信息</span>
          </a>
        </li>
        <li id="holidayMainMenu">
          <a href="<?php echo base_url('holiday/staff') ?>">
            <i class="fa fa-tasks"></i> <span>我的年假信息</span>
          </a>
        </li>
        <li id='planMainMenu'>
          <a href="<?php echo base_url('holiday/staff_plan') ?>">
            <i class="fa fa-edit"></i> <span>我的年假计划</span>
          </a>
        </li> 
        
        <li><a href="<?php echo base_url('users/setting') ?>"><i class="glyphicon glyphicon-edit"></i> <span>修改密码</span></a></li>
        <li><a href="<?php echo base_url('auth/logout') ?>"><i class="glyphicon glyphicon-log-out"></i> <span>登出</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  