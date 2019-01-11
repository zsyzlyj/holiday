



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
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="container">
              <form action="<?php echo base_url('super_wage/search')?>" class="form-horizontal" method="post" role="form">
                <fieldset>
                  <legend></legend>
                  <div class="form-group">
                    <label for="dtp_input1" class="col-md-2 control-label">月份选择</label>
                    <div class="input-group date form_datetime col-md-5" data-date="1979-09-16T05:25:07Z" data-date-format="yyyy-mm" data-link-field="dtp_input1">
                      <?php if($chosen_month):?>
                      <input class="form-control" name="chosen_month" size="16" type="text" value="<?php echo $chosen_month;?>" readonly>
                      <?php else:?>
                      <input class="form-control" name="chosen_month" size="16" type="text" value="单击选择月份" readonly>
                      <?php endif;?>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                      <button type='submit' class='btn-info form-control'>查询</button>
                    </div>
                    <!-- /.input-group -->               
                  </div>
                  <!-- /.form-group -->
                </fieldset>
              </form>
              <hr />
              <?php if($attr_data and $wage_data): ?>
              <div style="overflow:scroll;">
                <fieldset>
                <table id="wageTable"class="table table-striped table-bordered table-responsive" style="white-space:nowrap;text-align: center;">
                  <thead>
                    <?php $counter=0;?>
                    <tr>
                      <?php foreach($attr_data as $k =>$v):?>
                      <?php if($counter<$trueend):?>
                        <?php if($counter<5 or $counter>$koufeiend):?>
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
                  </thead>
                  <tbody>
                    <?php foreach($wage_data as $k => $v): ?>
                      <tr>
                      <?php $counter=0;?>
                      <?php foreach($v as $a => $b): ?>
                        <?php if($counter<$trueend):?>
                        <td style=""><?php echo $b?></td>
                        <?php endif;$counter++;?>
                      <?php endforeach; ?>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
                </fieldset>
                <?php elseif($chosen_month!=""):?>
                无当月工资记录
              </div>
              <?php endif; ?>
            </div>
            <!-- /.container -->
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>  
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
    $(document).ready(function(){ 
      $("#searchwageGetherMainMenu").addClass('active');
      $(".form_datetime").datetimepicker({
        bootcssVer:3,
        format: "yyyy-mm",
        startView:3,
        minView:3,
        startDate:"2017-01",
        autoclose:true  
      });
      $('#wageTable').DataTable({
        language:{
            "sProcessing": "处理中...",
            "sLengthMenu": "显示 _MENU_ 项",
            "sZeroRecords": "没有匹配结果",
            "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
            "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
            "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
            "sInfoPostFix": "",
            "sSearch": "搜索:",
            "sUrl": "",
            "sEmptyTable": "表中数据为空",
            "sLoadingRecords": "载入中...",
            "sInfoThousands": ",",
            "oPaginate":{
                "sFirst": "首页",
                "sPrevious": "上页",
                "sNext": "下页",
                "sLast": "末页"
            },
            "oAria":{
                "sSortAscending": ": 以升序排列此列",
                "sSortDescending": ": 以降序排列此列"
            }
        }      
      });
    
    }); 
  </script>
