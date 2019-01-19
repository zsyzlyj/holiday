

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
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
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer"></a>
          </div>
        </div>
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
            <a href="<?php echo base_url('products/') ?>" class="small-box-footer"></a>
          </div>
         
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow" style="cursor:pointer" onclick="window.open('<?php echo base_url('wage/staff');?>','_self')">
            <div class="inner">
              <h3>年假查询</h3>

              <p>Total Products</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-people"></i>
            </div>
            <a href="<?php echo base_url('products/') ?>" class="small-box-footer"></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
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
        <!-- ./col -->
      </div>
      <!-- /.row -->
      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script type="text/javascript">
    $(document).ready(function() {
    }); 
  </script>
