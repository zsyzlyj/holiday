

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        片区年假信息
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
            <form action='<?php echo base_url('holiday/mydomainholiday' )?>' method="post" id="selected_dept_form">
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
            <?php if($holiday_data): ?>  
            <form style="margin:0px;display:inline;" action='<?php echo base_url('super_holiday/export_mydeptholiday') ?>' method='post'>
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
                  <th>姓名</th>
                  <th>部门</th>                
                  <th>社会工龄</th>
                  <th>公司工龄</th>
                  <th>可休假总数</th>
                  <th>荣誉假期</th>
                  <th>上年可休数</th>
                  <th>今年可休数</th>
                  <th>一月</th>
                  <th>二月</th>
                  <th>三月</th>
                  <th>四月</th>
                  <th>五月</th>
                  <th>六月</th>
                  <th>七月</th>
                  <th>八月</th>
                  <th>九月</th>
                  <th>十月</th>
                  <th>十一月</th>
                  <th>十二月</th>
                  
                  <th>已休假数</th>
                  <th>剩下休假数</th>
                </tr>
                </thead>
                <tbody>
                                  
                    <?php foreach ($holiday_data as $v): ?>
                      <tr>
                        <td><?php echo $v['name']; ?></td>
                        <td><?php echo $v['department']; ?></td>
                        <td><?php echo $v['Totalage']; ?></td>
                        <td><?php echo $v['Companyage']; ?></td>
                        
                        <td><?php echo $v['Totalday']; ?></td>
                        <td><?php echo $v['Lastyear']; ?></td>
                        <td><?php echo $v['Thisyear']; ?></td>
                        <td><?php echo $v['Bonus']; ?></td>
                        <td><?php echo $v['Jan']; ?></td>
                        <td><?php echo $v['Feb']; ?></td>
                        <td><?php echo $v['Mar']; ?></td>
                        <td><?php echo $v['Apr']; ?></td>
                        <td><?php echo $v['May']; ?></td>
                        <td><?php echo $v['Jun']; ?></td>
                        <td><?php echo $v['Jul']; ?></td>
                        <td><?php echo $v['Aug']; ?></td>
                        <td><?php echo $v['Sep']; ?></td>
                        <td><?php echo $v['Oct']; ?></td>
                        <td><?php echo $v['Nov']; ?></td>
                        <td><?php echo $v['Dece']; ?></td>
                        <td><?php echo $v['Used']; ?></td>
                        <td><?php echo $v['Rest']; ?></td>
                      </tr>
                    <?php endforeach ?>
                    </tbody>
                  <?php endif; ?>
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
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script type="text/javascript">
    $(document).ready(function(){
      $("#myDomainHolidayMainMenu").addClass('active');
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
 