

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        部门人员信息
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">
          <div class="box">
            <div class="box-header"> 
            <form action='<?php echo base_url('users/mydeptprofiles' )?>' method="post" id="selected_dept_form">
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
            <?php if($user_data): ?>  
            <form style="margin:0px;display:inline;" action='<?php echo base_url('users/export_mydeptprofiles') ?>' method='post'>
              <input type='hidden' name='current_dept' value="<?php echo $current_dept;?>"/>
              <button class="btn btn-warning">导出</button>
            </form>

            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
              <div style="overflow:scroll;">
              
              <table id="holidayTable" class="table table-bordered table-striped mytdstyle" style="overflow:scroll;white-space: nowrap;">
                <thead>
                <tr>
                  <th>员工姓名</th>
                  <th>身份证号</th>
                  <th>性别</th>
                  <th>所在部门</th>
                  <th>科室</th>
                  <th>岗位</th>
                  <th>合同签订公司</th>
                  <th>婚姻情况</th>
                  <th>生育情况</th>
                  <th>最高学历</th>
                  <th>最高学位</th>
                  <th>全日制最高学历</th>
                  <th>全日制最高学位</th>
                  <th>用工形式</th>
                  <th>加入本企业时间</th>
                  <th>职级薪档</th>
                  <th>职级调整时间</th>
                  <th>薪档调整时间</th>
                </tr>
                </thead>
                <tbody>           
                    <?php foreach ($user_data as $v): ?>
                      <tr>
                        <td><?php echo $v['name']; ?></td>
                        <td><?php echo $v['user_id']; ?></td>
                        <td><?php echo $v['gender']; ?></td>
                        <td><?php echo $v['dept']; ?></td>
                        <td><?php echo $v['office']; ?></td>
                        <td><?php echo $v['position']; ?></td>
                        <td><?php echo $v['company']; ?></td>
                        <td><?php echo $v['marry']; ?></td>
                        <td><?php echo $v['child']; ?></td>
                        <td><?php echo $v['highest_qualification']; ?></td>
                        <td><?php echo $v['highest_degree']; ?></td>
                        <td><?php echo $v['ft_highest_qualification']; ?></td>
                        <td><?php echo $v['ft_highest_degree']; ?></td>
                        <td><?php echo $v['service_mode']; ?></td>
                        <td><?php echo $v['indate']; ?></td>
                        <td><?php echo $v['wage_level']; ?></td>
                        <td><?php echo $v['wage_adjust_stamp']; ?></td>
                        <td><?php echo $v['level_adjust_stamp']; ?></td>
                      </tr>
                    <?php endforeach ?>
                    </tbody>
                  </table>
              </div>
              <?php endif;?>
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
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script type="text/javascript">
    $(document).ready(function(){
      $("#mydept_profiles").addClass('active');
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
 