

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        工资信息
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><font color="red">薪酬文件：</font></h3>
                </br>              </br>
                <h4>
                  <?php foreach($wage_doc as $k => $v):?>
                    <a href='<?php echo base_url($v['doc_path']);?>' target="_blank"><?php echo $v['doc_name']?></a>
                    <br /><br />
                  <?php endforeach; ?>
                </h4>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
              <div style="overflow:scroll;">
                <table id="wageTable" class="table table-striped table-bordered table-responsive" style="white-space:nowrap;text-align: center;border-color:black;">
                <!--<table id="wageTable" class="table table-striped table-bordered table-hover" style="border-color:black;overflow:scroll;text-align: center;">-->
                  <thead>
                  <?php $counter=0;?>
                  <?php if($attr_data): ?>
                  <tr>
                    <?php foreach($attr_data as $k =>$v):?>
                    <?php if($counter<$trueend):?>
                      <?php if(($counter<5 and $counter!=0) or $counter>$koufeiend ):?>
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
                    <tr>
                    <?php if($wage_data): ?>
                    <?php $counter=0;?>
                    <?php foreach($wage_data as $k => $v): ?>
                      
                      <?php if($counter<$trueend and $counter!=0):?>
                      <td style="border-color:black;"><?php echo $v?></td>
                      <?php endif;$counter++;?>
                    <?php endforeach; ?>
                    <?php endif;?>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- /.box -->
        </div>
        <!-- col-md-12 -->
      </div>
      <!-- /.row -->

      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  
  

  <script type="text/javascript">
    $(document).ready(function() {
      $("#wageMainMenu").addClass('active');
    });
      
    
  </script>
 