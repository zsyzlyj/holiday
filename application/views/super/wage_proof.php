


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
          <h3>收入证明</h3>
          <br />
          <a href="<?php echo base_url('super/show_wage_proof') ?>" target="_blank" class="btn btn-warning">收入证明（通用）</a> 
          <a href="<?php echo base_url('super/show_bank_wage_proof') ?>" target="_blank" class="btn btn-warning">收入证明（工商银行）</a> 
          <a href="<?php echo base_url('super/show_fund_proof') ?>" target="_blank" class="btn btn-warning">收入证明（公积金）</a> 
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  
  <script type="text/javascript">
    $(document).ready(function() {
      $("#wageProofMainMenu").addClass('active');  
    });
    
  </script>