<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>
        专项附加扣除信息
      </h1>
    </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div class="box">
          <div class="box-header">
          </br>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="container">
              <form action="<?php echo base_url('wage/searchsp')?>" class="form-horizontal" method="post" role="form">
                <fieldset>
                  <legend></legend>
                  <div class="form-group">
                    <label for="dtp_input1" class="col-md-1 control-label">月份选择</label>
                    <div class="input-group date form_datetime col-md-5" data-date-format="yyyy-mm" data-link-field="dtp_input1">
                      <?php if($chosen_month):?>
                      <input class="form-control" name="chosen_month" size="16" type="text" value="<?php echo $chosen_month;?>" readonly>
                      <?php else:?>
                      <input class="form-control" name="chosen_month" size="16" type="text" value="单击选择月份" readonly>
                      <?php endif;?>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                      <button type='submit' class='btn-info form-control'>查询</button>
                    </div>
                    <input type="hidden" id="dtp_input1" value="" /><br/>                    
                  </div>
                </fieldset>
              </form>
            </div>
            <?php if($chosen_month): ?>
            <h4>中山联通<?php echo date_format(date_create($chosen_month),"Y年m月");?>专项扣除明细</h4>
            <hr />
            <?php endif;?>
            <div style="overflow:scroll;">
              <fieldset>
              <?php if($wage_sp): ?>
              <table id="wageTable"class="table table-striped table-bordered table-responsive" style="white-space:nowrap;text-align: center;">
                <thead>             
                  <tr>
                    <?php foreach($wage_sp_attr as $k => $v):?>
                    <?php if($v!="" and $k!="date_tag"):?>
                      <th><?php echo $v;?></th>
                    <?php endif;?>
                    <?php endforeach;?>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                  <?php foreach($wage_sp as $k => $v): ?>
                    <?php if($k!='date_tag'):?>
                    <td><?php echo $v;?></td>
                    <?php endif;?>
                  <?php endforeach; ?>
                  </tr>
                </tbody>
              </table>
              <?php elseif($chosen_month!=""): ?>
                无当月专项附加扣除记录
              <?php endif; ?>
              </fieldset>
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
      $("#searchspMainMenu").addClass('active');
      $(".form_datetime").datetimepicker({
        bootcssVer:3,
        format: 'yyyy-mm',
        startView:3,
        minView:3,
        startDate:"2017-01",
        autoclose:true,
        pickerPosition: "-left"
      });
    
    });
    
    
  </script>
