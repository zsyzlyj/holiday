<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <?php if($user_permission == 3 ): ?>
        <li id="dashboardMainMenu">
          <a href="<?php echo base_url('holiday/staff') ?>">
            <i class="fa fa-bar-chart"></i> <span>年假信息</span>
          </a>
        </li>
        <li id='planMainMenu'>
          <a href="<?php echo base_url('holiday/staff_plan') ?>">
            <i class="fa fa-edit"></i> <span>年假计划</span>
          </a>
        </li>
        
        <?php endif ?>
        <?php if($user_permission == 1 ): ?>
        <li id="dashboardMainMenu">
          <a href="<?php echo base_url('holiday/admin') ?>">
            <i class="fa fa-bar-chart"></i> <span>年假信息</span>
          </a>
        </li>
        <li id='planMainMenu'>
          <a href="<?php echo base_url('holiday/staff_plan') ?>">
            <i class="fa fa-edit"></i> <span>年假计划</span>
          </a>
        </li>
        <li id="myDeptPlanNav">
          <a href="<?php echo base_url('holiday/mydeptplan') ?>">
            <i class="fa fa-folder-o"></i>
            <span>本部门年假提交汇总</span>
          </a>
        </li>
        
        <?php endif ?>
        <?php if($user_permission == 2 ): ?>
        <li id="dashboardMainMenu">
          <a href="<?php echo base_url('holiday/manager') ?>">
            <i class="fa fa-bar-chart"></i> <span>年假信息</span>
          </a>
        </li>
        <li id='planMainMenu'>
          <a href="<?php echo base_url('holiday/staff_plan') ?>">
            <i class="fa fa-edit"></i> <span>年假计划</span>
          </a>
        </li>
        
        <?php endif ?>
        <?php if($user_permission == 0): ?>
        <li id="dashboardGatherMainMenu">
          <a href="<?php echo base_url('holiday') ?>">
            <i class="fa fa-bar-chart"></i> <span>年假汇总</span>
          </a>
        </li>
        <li id='planGatherMainMenu'>
          <a href="<?php echo base_url('holiday/plan_set') ?>">
            <i class="fa fa-edit"></i> <span>年假计划汇总</span>
          </a>
        </li>
        <li id="myDeptHolidayNav">
          <a href="<?php echo base_url('holiday/mydeptholiday') ?>">
            <i class="fa fa-file-archive-o"></i>
            <span>本部门年假信息汇总</span>
          </a>
        </li>
        <li id="myDeptPlanNav">
          <a href="<?php echo base_url('holiday/mydeptplan') ?>">
            <i class="fa fa-folder-o"></i>
            <span>本部门年假计划汇总</span>
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
            <li id="uploadFileNav"><a href="<?php echo base_url('holiday/import') ?>"><i class="fa fa-circle-o"></i> 上传数据</a></li>
            <li id="downloadFileNav"><a href="<?php echo base_url('holiday/download_page') ?>"><i class="fa fa-circle-o"></i> 下载数据</a></li>
          </ul>
            
        </li>
  
          <li class="treeview" id="mainUserNav">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>用户管理</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li id="createUserNav"><a href="<?php echo base_url('users/create') ?>"><i class="fa fa-circle-o"></i> 添加用户</a></li>

        
            <li id="manageUserNav"><a href="<?php echo base_url('users') ?>"><i class="fa fa-circle-o"></i> 用户权限管理</a></li>
          
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
            <li id="publish_notice"><a href="<?php echo base_url('notification/publish') ?>"><i class="fa fa-circle-o"></i> 发布公告</a></li>        

            
            <li id="manage_notice"><a href="<?php echo base_url('notification') ?>"><i class="fa fa-circle-o"></i> 公告历史</a></li>
          </ul>
            <li id="dashboardMainMenu">
            <a href="<?php echo base_url('holiday/staff') ?>">
              <i class="fa fa-bar-chart"></i> <span>年假信息</span>
            </a>
          </li>
          <li id='planMainMenu'>
            <a href="<?php echo base_url('holiday/staff_plan') ?>">
              <i class="fa fa-edit"></i> <span>年假计划</span>
            </a>
          </li>
          <?php endif; ?>

          <!--

            <li class="treeview" id="mainGroupNav">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Groups</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                
                  <li id="addGroupNav"><a href="<?php echo base_url('groups/create') ?>"><i class="fa fa-circle-o"></i> Add Group</a></li>
                
                
                <li id="manageGroupNav"><a href="<?php echo base_url('groups') ?>"><i class="fa fa-circle-o"></i> Manage Groups</a></li>
                
              </ul>
            </li>

            <li id="brandNav">
              <a href="<?php echo base_url('brands/') ?>">
                <i class="glyphicon glyphicon-tags"></i> <span>Brands</span>
              </a>
            </li>


            <li id="categoryNav">
              <a href="<?php echo base_url('category/') ?>">
                <i class="fa fa-files-o"></i> <span>Category</span>
              </a>
            </li>



            <li id="storeNav">
              <a href="<?php echo base_url('stores/') ?>">
                <i class="fa fa-files-o"></i> <span>Stores</span>
              </a>
            </li>

          
          <li id="attributeNav">
            <a href="<?php echo base_url('attributes/') ?>">
              <i class="fa fa-files-o"></i> <span>Attributes</span>
            </a>
          </li>

            <li class="treeview" id="mainOrdersNav">
              <a href="#">
                <i class="fa fa-dollar"></i>
                <span>Orders</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">            
                  <li id="addOrderNav"><a href="<?php echo base_url('orders/create') ?>"><i class="fa fa-circle-o"></i> Add Order</a></li>

                <li id="manageOrdersNav"><a href="<?php echo base_url('orders') ?>"><i class="fa fa-circle-o"></i> Manage Orders</a></li>
              </ul>
            </li>



            <li id="reportNav">
              <a href="<?php echo base_url('reports/') ?>">
                <i class="glyphicon glyphicon-stats"></i> <span>Reports</span>
              </a>
            </li>



            <li id="companyNav"><a href="<?php echo base_url('company/') ?>"><i class="fa fa-files-o"></i> <span>Company</span></a></li>

-->

            <li class="treeview" id="mainProductNav">
              <a href="#">
                <i class="fa fa-envelope"></i>
                <span>信箱</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                  <li id="addProductNav"><a href="<?php echo base_url('products/create') ?>"><i class="fa fa-circle-o"></i> Add Product</a></li>
              
                <li id="manageProductNav"><a href="<?php echo base_url('products') ?>"><i class="fa fa-circle-o"></i> Manage Products</a></li>
              </ul>
            </li>




        

        <!-- <li class="header">Settings</li> -->

          <li><a href="<?php echo base_url('users/profile/') ?>"><i class="fa fa-user-o"></i> <span>个人信息</span></a></li>

          <li><a href="<?php echo base_url('users/setting/') ?>"><i class="fa fa-wrench"></i> <span>设置</span></a></li>
        

        
        <!-- user permission info -->
        
        
        <li><a href="<?php echo base_url('auth/logout') ?>"><i class="glyphicon glyphicon-log-out"></i> <span>登出</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  