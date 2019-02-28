



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
                </fieldset>
              </form>
            </div>
            <div style="col-md-12">
              <?php foreach($type_array as $a => $b):?>
                <h3><?php echo $b['doc_type'];?></h3><br />
                <table id="wageTable" class="table table-striped table-bordered table-responsive" style="white-space:nowrap;">
                <thead>
                  <th class="col-md-1">序号</th>
                  <th class="col-md-11">文件名</th>
                </thead>
                <tbody>
                <?php $counter=0;?>
                <?php foreach($wage_doc as $k => $v):?>
                  <tr>
                    <?php if($b['doc_type']==$v['doc_type']):?>
                      <td style="text-align: center;"><?php echo ++$counter;?></td>
                      <td><a href='<?php echo base_url($v['doc_path']);?>' target="_blank"><?php echo $v['doc_name']?></a></td>
                    <?php endif;?>
                  </tr>
                <?php endforeach;?>
                </tbody>
                </table>
                <hr />
              <?php endforeach;?>
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
