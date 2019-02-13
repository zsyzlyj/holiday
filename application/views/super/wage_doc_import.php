

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
        <div class="box">
          <div class="box-body">
            <form action="<?php echo base_url('super_wage/wage_doc_import') ?>" method="post"
                name="frmPDFImport" id="frmPDFImport" enctype="multipart/form-data">
                <div>
                    <label><h4>选择上传文件</h4></label> 
                    <hr />
                    <select id="groups" name="selected_type" onclick="t(this)">
                      <option value="">选择类别</option>
                      <?php foreach ($type_option as $k => $v): ?>
                        <option value="<?php echo $v['doc_type'] ?>"><?php echo $v['doc_type'] ?></option> 
                      <?php endforeach ?>
                      <option value="-1">自定义</option>
                    </select>
                    <input name="selected_type_input" id="select_custom" style="display:none"/>
                    <hr />
                    <h5><input type="file" name="file" id="file" accept=".pdf"/></h5>
                    <br />
                    <button type="submit" id="submit" name="import" class="btn btn-warning" >导入</button>
                </div>
            </form>
          </div>
        </div>
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
    function t(obj){
      if(obj.options[obj.selectedIndex].value == "-1")
        document.getElementById("select_custom").style.display="";
      else 
        document.getElementById("select_custom").style.display="none";
    }
  </script>