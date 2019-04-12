<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <?php if(strstr($_SERVER['PHP_SELF'],'wage')):?>
          <li id="searchwageMainMenu">
            <a href="<?php echo base_url('wage/search') ?>">
              <i class="fa fa-search"></i> <span>工资明细查询</span>
            </a>
          </li>
          <li class="treeview" id="TaxMainMenu">
            <a href="#">
              <i class="fa fa-star"></i>
              <span>个人所得税信息</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
          
            <ul class="treeview-menu">
              <li id="searchtaxMainMenu">
                <a href="<?php echo base_url('wage/searchtax') ?>">
                  <i class="fa fa-rocket"></i> <span>月度个税信息</span>
                </a>
              </li>
              <li id="searchspMainMenu">
                <a href="<?php echo base_url('wage/searchsp') ?>">
                  <i class="fa fa-file"></i> <span>专项附加扣除信息</span>
                </a>
              </li>
            </ul>
          </li>
          <li id="wagedocMainMenu">
            <a href="<?php echo base_url('wage/wage_doc') ?>">
              <i class="fa fa-file-pdf-o"></i> <span>薪酬文件</span>
            </a>
          </li>
          <?php if($permission == 2 and strstr($wage_func[0]['status'],'开启')): ?>
          <li id="myDeptWageMainMenu">
            <a href="<?php echo base_url('wage/search_mydept') ?>">
              <i class="fa fa-file-archive-o"></i>
              <span>部门工资信息汇总</span>
            </a>
          </li>
          <?php endif; ?>
          
          <?php if($service_mode=='合同制'):?>
          <li id="applyWageProof"><a href="<?php echo base_url('wage/apply_wage_proof') ?>"><i class="fa fa-list"></i><span> 收入证明申请</span></a></li>
          <?php endif;?>
          <!---->
        <?php endif ?>
        <?php if(strstr($_SERVER['PHP_SELF'],'holiday')):?>

        <?php if($permission == 4): ?>
        <li id="myDomainHolidayMainMenu">
          <a href="<?php echo base_url('holiday/mydomainholiday') ?>">
            <i class="fa fa-file-archive-o"></i>
            <span>片区年假信息汇总</span>
          </a>
        </li>
        <li class="treeview" id="myDomainPlanMainMenu">
          <a href="#">
            <i class="fa fa-folder-o"></i>
            <span>片区年假计划汇总</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li id="myDomainPlanNav">
              <a href="<?php echo base_url('holiday/mydomainplan') ?>">
                <i class="fa fa-circle-o"></i>
                <span>年假计划汇总</span>
              </a>
            </li>
            <li id="SubmitStatusNav">
              <a href="<?php echo base_url('holiday/mydomainplan_submit') ?>">
                <i class="fa fa-circle-o"></i>
                <span>汇总提交情况</span>
              </a>
            </li>
          </ul>  
        </li>
        
        <?php endif ?>
        <?php if($permission == 1 or $permission == 2 ): ?>
        <li id="myDeptHolidayMainMenu">
          <a href="<?php echo base_url('holiday/mydeptholiday') ?>">
            <i class="fa fa-file-archive-o"></i>
            <span>部门年假信息汇总</span>
          </a>
        </li>

        <?php endif ?>
        <?php if($permission == 1): ?>
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
            <span>年假计划审核</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <li id="AuditNav">
            <a href="<?php echo base_url('holiday/audit') ?>">
              <i class="fa fa-circle-o"></i>
              年假计划审核
            </a>
          </li>
          <li id="AuditGatherNav">
            <a href="<?php echo base_url('holiday/audit_result') ?>">
            <i class="fa fa-circle-o"></i>
             年假计划审核结果
            </a>
          </li>
          </ul>
        </li>
        <?php endif ?>
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
        <?php endif; ?>
        <?php if(strstr($_SERVER['PHP_SELF'],'setting')):?> 
          <li id="changePassword"><a href="<?php echo base_url('auth/setting') ?>"><i class="glyphicon glyphicon-edit"></i> <span>修改密码</span></a></li>-->
        <?php endif; ?>
        <?php if(strstr($_SERVER['PHP_SELF'],'users')):?>
          <li id="userProfile"><a href="<?php echo base_url('users/profile') ?>"><i class="fa fa-address-book-o"></i> <span>个人信息</span></a></li>
          <?php if ($permission == 2):?>
          <li id="mydept_profiles"><a href="<?php echo base_url('users/mydeptprofiles') ?>"><i class="fa fa-list"></i><span>部门人员信息</span></a></li>
          <?php endif;?>
          <!--<li id="applyOnPostProof"><a href="<?php echo base_url('users/apply_on_post_proof') ?>"><i class="fa fa-list"></i><span>在职证明申请</span></a></li>-->
          
        <?php endif; ?>
        <?php if(strstr($_SERVER['PHP_SELF'],'confirm')):?>
          <li id="checkscore"><a href="<?php echo base_url('hr/confirm') ?>"><i class="fa fa-address-book-o"></i> <span>弹性福利积点确认</span></a></li>
          <li id="checksumscore"><a href="<?php echo base_url('hr/confirm_sum') ?>"><i class="fa fa-address-book-o"></i> <span>年度综合积分确认</span></a></li>
          
        <?php endif; ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  