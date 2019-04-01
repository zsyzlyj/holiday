<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>
        月度个税信息
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
            <div>
              <form action="<?php echo base_url('wage/searchtax')?>" class="form-horizontal" method="post" role="form">
                <fieldset>
                  <legend></legend>
                  <div class="form-group">
                    <label for="dtp_input1" class="col-md-1 control-label">月份选择</label>
                    <div class="input-group date form_datetime col-md-5" data-date-format="yyyy-mm" data-link-field="dtp_input1">
                      <?php if($chosen_month):?>
                      <input id="chosen_month" class="form-control" name="chosen_month" size="16" type="text" value="<?php echo $chosen_month;?>" readonly>
                      <?php else:?>
                      <input id="chosen_month" class="form-control" name="chosen_month" size="16" type="text" value="<?php echo date('Y-m');?>" readonly>
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
            <h4>中山联通<?php echo date_format(date_create($chosen_month),"Y年m月");?>个税明细</h4>
            <hr />
            <?php endif;?>
            <div style="overflow:scroll;">
              <fieldset>
              <?php if($wage_tax): ?>
              <?php $counter=0;?>
              <table id="wageTable"class="table table-striped table-bordered table-responsive" style="white-space:nowrap;text-align: center;">
                <thead>
                  <tr>
                    <?php foreach($wage_tax_attr as $k => $v):?>
                    <?php if($v!="" and $k!="date_tag"):?>
                      <th style="text-align: center;"><?php echo $v;$counter++;?></th>
                    <?php endif;?>
                    <?php endforeach;?>
                  </tr>
                </thead>
                <tbody>
                  <?php $counterdata=0;?>
                  <tr>
                  <?php foreach($wage_tax as $k => $v): ?>
                    <?php if($k!='date_tag' and $counterdata<$counter):?>
                      <td><?php echo $v;$counterdata++;?></td>
                      <?php endif;?>
                  <?php endforeach; ?>
                  </tr>
                </tbody>
              </table>
              <hr />
              <div>
              <h3><?php echo $notice['title'];?></h3>
              <br />
              <div style="font-size:15px"><?php echo str_replace('class="ql-align-justify"','class="ql-align-justify" style="line-height:150%"',$notice['content']);?></div>
              </div>
              <?php elseif($chosen_month!=""): ?>
                无当月个税记录
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
      $("#TaxMainMenu").addClass('active');
      $("#searchtaxMainMenu").addClass('active');
      $(".form_datetime").datetimepicker({
        bootcssVer:3,
        format: 'yyyy-mm',
        startView:3,
        minView:3,
        startDate: "2019-01",
        autoclose:true,
        pickerPosition: "-left",
        showCurrentAtPos:1
      });
      if(new Date().getFullYear()-2>2019)
        $('#datetimepicker').datetimepicker('setStartDate', (new Date().getFullYear()-2).toString()+'-'+new Date().getMonth().toString());
    });

  </script>
