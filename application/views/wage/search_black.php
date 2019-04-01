



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>
        往月工资信息
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
            <div>
              <form action="<?php echo base_url('wage/search')?>" class="form-horizontal" method="post" role="form">
                <fieldset>
                  <legend></legend>
                  <div class="form-group">
                    <label for="dtp_input1" class="col-md-1 control-label">月份选择</label>
                    <div class="input-group date form_datetime col-md-5" data-date-format="yyyy-mm" data-link-field="dtp_input1">
                      <?php if($chosen_month):?>
                      <input class="form-control" name="chosen_month" size="16" type="text" value="<?php echo $chosen_month;?>" readonly>
                      <?php else:?>
                      <input class="form-control" name="chosen_month" size="16" type="text" value="<?php echo date('Y-m');?>" readonly>
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
            <div style="overflow:scroll;">
              <table id="wageTable"class="table table-striped table-bordered table-responsive" style="white-space:nowrap;text-align: center;border-color:black;">
                <thead>
                  <?php $counter=0;?>
                  <?php if($attr_data): ?>
                  <tr>
                    <?php foreach($attr_data as $k =>$v):?>
                    <?php if($counter<$trueend):?>
                      <?php if(($counter<5 and $counter>0) or $counter>$koufeiend):?>
                        <th style="text-align:center;border-color:black;" rowspan="3"><?php echo $v?></th>
                      <?php elseif($counter==5):?>
                        <th style="text-align:center;border-color:black;" colspan="<?php echo $jiaoyuend-4;?>">应发</th>
                      <?php elseif($counter==$fulistart): ?>
                        <th style="text-align:center;border-color:black;" colspan="<?php echo $fuliend-$fulistart+1;?>">福利费</th>
                      <?php elseif($counter==$koufeistart-1): ?>
                      <th style="text-align:center;border-color:black;" rowspan="3">当月月应收合计</th>
                      <?php elseif($counter==$koufeistart): ?>
                      <th style="text-align:center;border-color:black;" colspan="<?php echo $koufeiend-$koufeistart+1;?>">各项扣款</th>
                      <?php endif;?>
                    <?php endif;$counter++;?>
                    <?php endforeach; ?>
                  </tr>
                  <tr style="border-color:black;">
                  <?php $counter=0;?>
                  <?php foreach($attr_data as $k => $v): ?>
                  <?php if($counter<$trueend):?>
                    <?php if($counter>=5 and $counter<$yuedustart):?>
                      <th rowspan="2" style="text-align:center;border-color:black;"><?php echo $v?></th>
                    <?php elseif($counter==$yuedustart):?>
                      <th style="text-align:center;border-color:black;" colspan="<?php echo $yueduend-$yuedustart+1;?>">月度绩效</th>
                    <?php elseif($counter==$shengzhuanstart): ?>
                      <th style="text-align:center;border-color:black;" colspan="<?php echo $shengzhuanend-$shengzhuanstart+1;?>">省核专项奖励</th>
                    <?php elseif($counter==$fengongsistart): ?>
                      <th style="text-align:center;border-color:black;" colspan="<?php echo $fengongsiend-$fengongsistart+1;?>">分公司专项奖励</th>
                    <?php elseif($counter==$qitastart): ?>
                      <th style="text-align:center;border-color:black;" colspan="<?php echo $qitaend-$qitastart+1;?>">其他</th>
                    <?php elseif($counter==$jiaoyustart): ?>
                      <th style="text-align:center;border-color:black;" colspan="<?php echo $jiaoyuend-$jiaoyustart+1;?>">教育经费</th>
                    <?php elseif($counter>=$fulistart and $counter<=$fuliend): ?>
                      <th style="text-align:center;border-color:black;" rowspan="2"><?php echo $v?></th>
                    <?php elseif($counter>=$koufeistart and $counter<=$koufeiend): ?>
                      <th style="text-align:center;border-color:black;" rowspan="2"><?php echo $v?></th>
                    <?php endif;?>    

                  <?php endif;$counter++;?>
                  <?php endforeach; ?>
                  </tr>
                  <tr style="border-color:black;">
                  <?php $counter=0;?>
                  <?php foreach($attr_data as $k => $v): ?>
                  <?php if($counter<$trueend):?>
                    <?php if($counter>=$yuedustart and $counter<=$jiaoyuend):?>
                    <th style="text-align:center;border-color:black;"><?php echo $v;?></th>
                    <?php endif; ?>
                  <?php endif;$counter++;?>
                  <?php endforeach; ?>
                  </tr>
                  
                    
                  <?php endif; ?>
                </thead>
                <tbody>
                  
                  <?php if($wage_data):?>
                    <tr>
                    <?php $counter=0;?>
                    <?php foreach($wage_data as $k => $v): ?>
                      <?php if($counter<$trueend and $counter>0):?>
                      <td style="border-color:black;"><?php echo $v?></td>
                      <?php endif;$counter++;?>
                    <?php endforeach; ?>
                    </tr>
                  <?php else: ?>
                    <h4>无当月工资记录</h4>
                  <?php endif; ?>
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
      $("#searchwageMainMenu").addClass('active');
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
