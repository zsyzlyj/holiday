


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        文件下载
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Holiday</li>
      </ol>
    </section>
    <hr />
    <!-- Main content -->
    <section class="content">
      <div class="col-md-12 col-xs-12">
        <div class="row">
          <h3>年假汇总</h3>
          <br />
          <a href="<?php echo base_url('super/export_holiday') ?>" class="btn btn-info">导出表格</a>
          <hr />
          <h3>年假计划汇总</h3>
          <br />
          <a href="<?php echo base_url('super/export_plan') ?>" class="btn btn-info">导出表格</a>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  
  <script type="text/javascript">
    $(document).ready(function() {
      $("#holidaySyncNav").addClass('active');
      $("#downloadHolidayNav").addClass('active');
      
    });
    
  </script>