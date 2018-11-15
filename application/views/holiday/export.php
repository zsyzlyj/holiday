


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
        <h3>年假汇总</h3>
        <a href="<?php echo base_url('holiday/export_holiday') ?>" class="btn btn-info">导出表格</a>
        <hr />
        <h3>年假计划汇总</h3>
        <a href="<?php echo base_url('holiday/export_plan') ?>" class="btn btn-info">导出表格</a>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  
  <script type="text/javascript">
    $(document).ready(function() {
      $("#mainSyncNav").addClass('active');
      $("#downloadFileNav").addClass('active');
      
    });
    
  </script>