<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>
        工资明细查询
      </h1>
    </section>
  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div class="box">
          <div class="box-header">
          <h3 class="box-title"><font color="red">公告：</font></h3>
            </br>              </br>
          <h4>
          <p>
          <?php echo str_replace('class="ql-align-justify"','class="ql-align-justify" style="line-height:150%"',$notice['content']);?>
          </p>
          </h4>
          </br>
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
            <hr />
            <?php if($chosen_month): ?>
            <h4>中山联通<?php echo date_format(date_create($chosen_month),"Y年m月");?>员工工资单</h4>
            <hr />
            <h5 style="word-wrap:break-word;line-height:200%"><?php echo $wage_notice;?></p></h5>
            <hr />
            <?php endif;?>
            <div style="overflow:scroll;">
              <fieldset>
              <table id="wageTable"class="table table-striped table-bordered table-responsive" style="white-space:nowrap;text-align: center;">
                <thead>
                  <?php $counter=0;?>
                  <?php if($attr_data and $wage_data): ?>
                  <tr>
                    <?php foreach($attr_data as $k =>$v):?>
                    <?php if($counter<$trueend):?>
                      <?php if(($counter<5 and $counter>0) or $counter>$koufeiend):?>
                        <th style="text-align:center;vertical-align:middle;" rowspan="3"><?php echo $v?></th>
                      <?php elseif($counter==5):?>
                        <th style="text-align:center;" colspan="<?php echo $jiaoyuend-4;?>">应发</th>
                      <?php elseif($counter==$fulistart): ?>
                        <th style="text-align:center;" colspan="<?php echo $fuliend-$fulistart+1;?>">福利费</th>
                      <?php elseif($counter==$koufeistart-1): ?>
                      <th style="text-align:center;vertical-align:middle;" rowspan="3">当月月应收合计</th>
                      <?php elseif($counter==$koufeistart): ?>
                      <th style="text-align:center;" colspan="<?php echo $koufeiend-$koufeistart+1;?>">各项扣款</th>
                      <?php endif;?>
                    <?php endif;$counter++;?>
                    <?php endforeach; ?>
                  </tr>
                  <tr style="">
                  <?php $counter=0;?>
                  <?php foreach($attr_data as $k => $v): ?>
                  <?php if($counter<$trueend):?>
                    <?php if($counter>=5 and $counter<$yuedustart):?>
                      <th rowspan="2" style="text-align:center;vertical-align:middle;"><?php echo $v?></th>
                    <?php elseif($counter==$yuedustart):?>
                      <th style="text-align:center;" colspan="<?php echo $yueduend-$yuedustart+1;?>">月度绩效</th>
                    <?php elseif($counter==$shengzhuanstart): ?>
                      <th style="text-align:center;" colspan="<?php echo $shengzhuanend-$shengzhuanstart+1;?>">省核专项奖励</th>
                    <?php elseif($counter==$fengongsistart): ?>
                      <th style="text-align:center;" colspan="<?php echo $fengongsiend-$fengongsistart+1;?>">分公司专项奖励</th>
                    <?php elseif($counter==$qitastart): ?>
                      <th style="text-align:center;" colspan="<?php echo $qitaend-$qitastart+1;?>">其他</th>
                    <?php elseif($counter==$jiaoyustart): ?>
                      <th style="text-align:center;" colspan="<?php echo $jiaoyuend-$jiaoyustart+1;?>">教育经费</th>
                    <?php elseif($counter>=$fulistart and $counter<=$fuliend): ?>
                      <th style="text-align:center;vertical-align:middle;" rowspan="2"><?php echo $v?></th>
                    <?php elseif($counter>=$koufeistart and $counter<=$koufeiend): ?>
                      <th style="text-align:center;vertical-align:middle;" rowspan="2"><?php echo $v?></th>
                    <?php endif;?>    

                  <?php endif;$counter++;?>
                  <?php endforeach; ?>
                  </tr>
                  <tr style="">
                  <?php $counter=0;?>
                  <?php foreach($attr_data as $k => $v): ?>
                  <?php if($counter<$trueend):?>
                    <?php if($counter>=$yuedustart and $counter<=$jiaoyuend):?>
                    <th style="text-align:center;"><?php echo $v;?></th>
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
                      <?php if($counter<=$trueend and $counter>0):?>
                      <td style=""><?php echo $v?></td>
                      <?php endif;$counter++;?>
                    <?php endforeach; ?>
                    </tr>
                  <?php elseif($chosen_month!=""): ?>
                      <h4>无当月工资记录</h4>
                  <?php endif; ?>
                </tbody>
              </table>
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
      $("#searchwageMainMenu").addClass('active');
      $(".form_datetime").datetimepicker({
        bootcssVer:3,
        format: 'yyyy-mm',
        startView:3,
        minView:3,
        startDate:(new Date().getFullYear()-2).toString()+'-'+new Date().getMonth().toString(),
        autoclose:true,
        pickerPosition: "-left"
      });
    
    });
    
    
  </script>
