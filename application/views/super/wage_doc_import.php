

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Import</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <form action="<?php echo base_url('super_wage/wage_doc_import') ?>" method="post"
            name="frmPDFImport" id="frmPDFImport" enctype="multipart/form-data">
            <div>
                <label><h4>选择上传文件</h4></label> 
                <br />
                <br />
                <h5><input type="file" name="file" id="file" accept=".pdf"/></h5>
                <br />
                <button type="submit" id="submit" name="import" class="btn btn-warning" >Import</button>
        
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
        $("#uploadWageDoc").addClass('active');
        $("#uploadWageDocNav").addClass('active');
    });
    
  </script>