

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        年假计划审核
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
            <form action='<?php echo base_url('holiday/audit' )?>' method="post" id="selected_dept_form">
            <select id="selected_dept" name="selected_dept" onchange="submitForm();">
              <option value="">
                <?php if($current_dept):?>
                  <?php echo $current_dept;?>
                <?php else: ?>  
                  选择部门
                <?php endif; ?>
              </option>
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
            <br />
            <br />
            </form>
            <?php if($feedback_status=='已审核'):?>
            <div class="box-header">
              本部门已审核
            </div>
            <?php else:?>
            <?php if($submit_status=='未提交'):?>
            <div class="box-header">
              <h4>本部门未提交</h4>
            </div>
            <?php else:?>
            <?php if($plan_data): ?>   
            <form style="margin:0px;display:inline;" action='<?php echo base_url('super_holiday/export_mydeptholiday') ?>' method='post'>
              <input type='hidden' name='current_dept' value="<?php echo $current_dept;?>"/>
              <button class="btn btn-warning">导出</button>
            </form>

            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
              <div style="overflow:scroll;">
              
              <table id="holidayTable" class="table table-bordered table-striped" style="overflow:scroll;table-layout:fixed" width="100%">
                <thead>
                <tr>
                  <th>姓名</th>
                  <th>可休假总数</th>
                  <th>上年可休数</th>
                  <th>今年可休数</th>
                  <th>荣誉假期数</th>
                  <th>第一季度</th>
                  <th>第二季度</th>
                  <th>第三季度</th>
                  <th>第四季度</th>
                </tr>
                </thead>
                <tbody>
                                 
                    <?php foreach ($plan_data as $v): ?>
                      <tr>
                        <td><?php echo $v['name']; ?></td>
                        <td><?php echo $v['Totalday']; ?></td>
                        <td><?php echo $v['Lastyear']; ?></td>
                        <td><?php echo $v['Thisyear']; ?></td>
                        <td><?php echo $v['Bonus']; ?></td>
                        <td><?php echo $v['firstquater']; ?></td>
                        <td><?php echo $v['secondquater']; ?></td>
                        <td><?php echo $v['thirdquater']; ?></td>
                        <td><?php echo $v['fourthquater']; ?></td>
                      </tr>
                    <?php endforeach ?>
                    </tbody>
                  <?php endif; ?>
                  </table>
                
              </div>
              <!-- /.overflow:scroll -->
              <?php if($feedback_status=='未审核' and $submit_status=='已提交'):?>
              <div>
              <form action='<?php echo base_url('holiday/audit')?>' method="post">
                <?php if($current_dept):?>
                  <input type='hidden' name="selected_dept" value="<?php echo $current_dept;?>"/>
                <?php endif; ?> 
                <div class="form-group">
                    <label for="content"><h4 class="box-title">审核意见</h4></label>
                    <textarea class="form-control" rows="10" name="feedback_content"></textarea>
                </div>
                <label><input name="confirm" type="radio" value="1" />&nbsp;同意 </label>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <label><input name="confirm" type="radio" value="0" />&nbsp;不同意 </label>
                <br />
                <br />
                <a href="javascript:void(0)" class="btn btn-success" data-toggle="modal" data-target="#myModal">提交</a>
                <div class="modal-month fade" tabindex="-1" data-backdrop="false" role="dialog" id="myModal">
                  <div class="modal-content-month">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><font color="black">×</font></button>
                      <h4 class="modal-title">审    核</h4>
                      </div>
                    <div class="modal-body">
                      <h4 style="text-align:left">确认提交吗？</h4>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                      <button type="submit" class="btn btn-success btn-ok">确认提交</a>
                    </div>
                  </div><!-- /.modal-content -->
                </div><!-- /.modal -->

              </form>
              </div>
              <?php endif; ?>
            </div>
            
            <!-- /.box-body -->
          <?php endif; ?>
          <?php endif; ?>
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
      $("#AuditMainMenu").addClass('active');
      $("#AuditNav").addClass('active');
      $('#holidayTable').DataTable({
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
 