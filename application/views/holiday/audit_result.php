

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        审核
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Holiday</li>
      </ol>
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
            <form style="margin:0px;display:inline;" action='<?php echo base_url('holiday/export_mydeptholiday') ?>' method='post'>
              <input type='hidden' name='current_dept' value="<?php echo $current_dept;?>"/>
              <button class="btn btn-warning">导出</button>
            </form>

            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
              <div style="overflow:scroll;">
              
              <table id="holidayTable" class="table table-bordered table-striped" style="overflow:scroll;" width="100%">
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
                  <?php if($plan_data): ?>                  
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
              <div>
              <form action='<?php echo base_url('holiday/audit_feedback' )?>' method="post">
                <div class="form-group">
                    <label for="content"><h4 class="box-title">审核意见</h4></label>
                    <textarea class="form-control" rows="10" name="content"></textarea>
                    
                </div>
                <button name='agree' class="btn btn-success">同&nbsp;&nbsp;意</button>
                <button name='reject' class="btn btn-danger">不同意</button>
              </form>
              </div>
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
    $(document).ready(function() {
      $('#holidayTable').DataTable({
  
      language: {
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
          "oPaginate": {
              "sFirst": "首页",
              "sPrevious": "上页",
              "sNext": "下页",
              "sLast": "末页"
          },
          "oAria": {
              "sSortAscending": ": 以升序排列此列",
              "sSortDescending": ": 以降序排列此列"
          }
      }
    });


      $("#AuditMainMenu").addClass('active');
    
      
    });
    function submitForm(){
    //获取form表单对象
        var form = document.getElementById("selected_dept_form");
        form.submit();//form表单提交
    }
    
  </script>
 