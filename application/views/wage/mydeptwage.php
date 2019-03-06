

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        部门工资信息
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
            
            <!-- /.box-header -->
            <div class="box-body">
              <div style="overflow:scroll;">
                <form action="<?php echo base_url('wage/search_mydept')?>" class="form-horizontal" method="post" role="form">
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
                        <span class="input-group-addon">
                        <form action='<?php echo base_url('wage/mydeptwage')?>' method="post" id="selected_dept_form">
                          <select id="selected_dept" name="selected_dept" onchange="submitForm();">
                            <?php if($current_dept):?>
                              <option value="<?php echo $current_dept;?>"><?php echo $current_dept;?></option>
                            <?php else: ?>  
                              <option value="请选择部门">请选择部门</option>
                            <?php endif; ?>
                            
                            <?php foreach($dept_options as $k => $v):?>
                            <?php if($current_dept):?>
                              <?php if($current_dept!=$v):?>
                                <option value="<?php echo $v;?>"><?php echo $v;?></option>
                              <?php endif; ?>
                            <?php else:?>
                              <option value="<?php echo $v;?>"><?php echo $v;?></option>
                            <?php endif; ?>
                            <?php endforeach;?>
                          </select>
                        </form> 
                        </span>
                        <button type='submit' class='btn-info form-control'>查询</button>
                      </div>
                      <input type="hidden" id="dtp_input1" value="" /><br/>                    
                    </div>
                  </fieldset>
                </form>
              </div>
              <!--end of container-->
              <hr />
              <div style="overflow:scroll;">
                <fieldset>
                <table id="wageTable"class="table table-striped table-bordered table-responsive" style="white-space:nowrap;text-align: center;">
                  <thead>
                    <?php $counter=0;?>
                    <?php if($attr_data): ?>
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
                    <?php foreach($wage_data as $k => $v): ?>
                    <tr>
                    <?php $counter=0;?>
                    <?php foreach($v as $a => $b): ?>
                      <?php if($counter<$trueend and $counter>0):?>
                      <td style=""><?php echo $b?></td>
                      <?php endif;$counter++;?>
                    <?php endforeach; ?>
                    </tr>
                    <?php endforeach; ?>
                    <?php elseif($chosen_month!=""): ?>
                        <h4>无当月工资记录</h4>
                    <?php endif; ?>
                  </tbody>
                </table>
                </fieldset>
              </div>
              <!-- end of overflow:scroll; -->
            </div>
            <!-- /.box-body -->
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
    $(document).ready(function(){
      $("#myDeptWageMainMenu").addClass('active');
      $(".form_datetime").datetimepicker({
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
    function submitForm(){
        //获取form表单对象
        var form = document.getElementById("selected_dept_form");
        form.submit();//form表单提交
    }
  </script>
 