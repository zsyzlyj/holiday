



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>
        薪酬文件
      </h1>
      
        
        
      
    </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div class="box">
          <div class="box-header">
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            
            <div class="container">
              <form action="<?php echo base_url('wage/search')?>" class="form-horizontal" method="post" role="form">
                <fieldset>
                  <legend></legend>
                  <div class="form-group">
                </fieldset>
              </form>
            </div>
            <div style="overflow:scroll;col-md-6">
              <h3></h3>
              <table id="wageTable" class="table table-striped table-bordered table-responsive" style="white-space:nowrap;text-align: center;">
              <thead>
                <th style="text-align: center;">序号</th>
                <th style="text-align: center;">文件名</th>
              </thead>
              <tbody>
              <?php foreach($wage_doc as $k => $v):?>
                <tr>
                  <td style="text-align: center;"><?php echo $k+1;?></td>
                  <td style="text-align: center;"><a href='<?php echo base_url($v['doc_path']);?>' target="_blank"><?php echo $v['doc_name']?></a></td>
                </tr>
              <?php endforeach;?>
              </tbody>
              </table>
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
      $("#wagedocMainMenu").addClass('active');
      $(".form_datetime").datetimepicker({
        //language: 'cn',
        format: 'yyyy-mm',
        startView:3,
        minView:3,
        startDate:"2017-12",
        autoclose:true
      });
    
    });
    
    
  </script>
