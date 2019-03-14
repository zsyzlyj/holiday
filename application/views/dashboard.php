  <!-- Content Wrapper. Contains page content -->
  <!--<div class="content-wrapper" style="background:url('<?php echo base_url('assets/images/dashboardbg.jpg')?>');background-attachment:fix;background-repeat:norepeat;background-size:cover;);">-->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <!--主功能面板-->
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua" style="cursor:pointer"  onclick="window.open('<?php echo base_url('holiday/staff');?>','_self')">
            <div class="inner">
              <h3>年假查询</h3>
              <p>Total Holiday</p>
            </div>
            <div class="icon">
              <i class="ion ion-home"></i>
              <!--<i class="ion ion-bag"></i>-->
            </div>
          </div>
        </div>

      </div>
      <div class="row">
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green" style="cursor:pointer" onclick="window.open('<?php echo base_url('wage/staff');?>','_self')">
            <div class="inner">
              <h3>工资查询</h3>
              <p>Total Wage</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow" style="cursor:pointer" onclick="window.open('<?php echo base_url('users/profile');?>','_self')">
            <div class="inner">
              <h3>个人信息</h3>
              <p>Personal Information</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-people"></i>
            </div>
          </div>
        </div>
      </div>
<!--    
        <div class="col-lg-3 col-xs-6">

          <div class="small-box bg-red" style="cursor:pointer" onclick="window.open('<?php echo base_url('wage/staff');?>','_self')">
            <div class="inner">
              <h3>年假查询</h3>

              <p>Total Products</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-home"></i>
            </div>
            <a href="<?php echo base_url('products/') ?>" class="small-box-footer"></a>
          </div>
        </div>

      </div>
-->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script type="text/javascript">
    $(document).ready(function() {
    }); 
  </script>
