
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
   
  </section>

  <!-- Main content -->
  <section class="content">
    <?php if($this->session->flashdata('success')): ?>
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo $this->session->flashdata('success'); ?>
      </div>
    <?php elseif($this->session->flashdata('error')): ?>
      <div class="alert alert-error alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo $this->session->flashdata('error'); ?>
      </div>
    <?php endif; ?>
    <!-- Small boxes (Stat box) -->
    <div class="box">
      <div class="box-header">
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div>
          <form action="<?php echo base_url('super_hr/hr_transfer_all_import') ?>" method="post"
              name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
              <fieldset>
              <legend></legend>
                <div class="form-group">
                  <div class="input-group date form_datetime col-md-2" data-date="1979-09-16T05:25:07Z" data-date-format="yyyy-mm" data-link-field="dtp_input1">
                    <input class="form-control" name="chosen_month" size="14" type="text" value="<?php echo date('Y-m',strtotime('-1 months',strtotime(date('Y-m'))));?>" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                  </div>
                </div>
                <hr />
                <div class="control-group">
                  <label class="control-label">选择上传文件</label>
                  <!-- File Upload -->
                  <div class="controls">
                    <input type="file" name="file" id="file" accept=".xls,.xlsx"/>
                  </div>
                </div>
                <br />
                <div class="control-group">
                  <!-- Button -->
                  <div class="controls">
                    <button type="submit" id="submit" name="import" class="btn btn-warning" >上传</button>
                    <a class="btn btn-info" href="#">下载模板</a>
                    <a class="btn btn-primary" href="<?php echo base_url('super_wage/search') ?>">返回</a>
                  </div>
                </div>
              </fieldset>
          </form>
        </div>
      </div>
    </div>

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
    $(document).ready(function() {
      $("#hrTransferMenu").addClass('active');
      $(".form_datetime").datetimepicker({
        bootcssVer:3,
        format: "yyyy-mm",
        startView:3,
        minView:3,
        startDate:"2010-01",
        autoclose:true  
      });
    });
    
  </script>