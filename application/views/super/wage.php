

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        工资信息汇总
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">

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
          <div class="box">
            <div class="box-header">
            </div>
            <div class="box-body">
              <div>
                <table id="wageTable" class="table table-striped table-bordered table-hover mytable" style="border-color:black;overflow:scroll;white-space: nowrap;word-break:  keep-all;text-align: center;">
                  <thead>
                  <?php if($attr_data):?>
                  <tr style="border-color:gray">
                  <?php $counter=0;?>
                  <?php foreach($attr_data as $k => $v): ?>
                  <?php if($counter<$trueend):?>
                    <?php if($counter<5 or $counter>$koufeiend):?>
                      <th style="text-align:center;border-color:black;" rowspan="3"><?php echo $v?></th>
                    <?php elseif($counter==5):?>
                      <th style="text-align:center;border-color:black;" colspan="<?php echo $jiaoyuend-4;?>">应发</th>
                    <?php elseif($counter==$fulistart): ?>
                      <th style="text-align:center;border-color:black;" colspan="<?php echo $fuliend-$fulistart+1;?>">福利费</th>
                    <?php elseif($counter==$koufeistart-1): ?>
                    <th rowspan="3" style="text-align:center;border-color:black;">当月月应收合计</th>
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
                  <?php if($wage_data): ?>
                  <?php foreach($wage_data as $k => $v): ?>
                    <tr>
                      <?php $counter=0;?>
                      <?php foreach($v as $a => $b):?>
                      <?php if($counter<$trueend):?>
                      <td style="border-color:black;">
                        <?php echo $b;?>
                      </td>
                      <?php endif;$counter++;?>
                      <?php endforeach; ?>
                    </tr>
                  <?php endforeach; ?>
                  <?php endif;?>
                  </tbody>
                </table>

              </div>
              <!-- /.overflow:scroll -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- col-md-12 -->
      </div>
      <!-- /.row -->
      </section>
  </div>
  <!-- /.content-wrapper -->
  
  
  

  <script type="text/javascript">
    $(document).ready(function(){
      $('#wageGatherMainMenu').addClass('active');
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
 