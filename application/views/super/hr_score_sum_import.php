

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
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <form action="<?php echo base_url('super_hr/hr_score_sum_import') ?>" method="post"
            name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <div>
                <label>选择上传文件</label> 
                <br />
                <br />
                <h5><input type="file" name="file" id="file" accept=".xls,.xlsx"/></h5>
                <br />
                <button type="submit" id="submit" name="import" class="btn btn-warning" >导入</button>
                <a class="btn btn-info" href="<?php echo base_url($path) ?>">角色表模板下载</a>
            </div>
        </form>
      </div>
    </div>  

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
    $(document).ready(function() {
      $("#scoreSumMainMenu").addClass('active');
    });
    
  </script>