

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        部门工资信息
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Wage</li>
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
            
            
            <form action='<?php echo base_url('wage/mydeptwage' )?>' method="post" id="selected_dept_form">
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
            <?php if($wage_data): ?>  
            <form style="margin:0px;display:inline;" action='<?php echo base_url('holiday/export_mydeptholiday') ?>' method='post'>
              <input type='hidden' name='current_dept' value="<?php echo $current_dept;?>"/>
              <button class="btn btn-warning">导出</button>
            </form>

            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
              <div style="overflow:scroll;">
              
              <table id="wageTable" class="table table-bordered table-striped" style="white-space: nowrap;word-break:  keep-all;text-align: center;">
                <thead>
                <?php foreach ($wage_data as $v): ?>
                <tr>
                  <?php foreach($v as $a =>$b):?>
                    <?php if(!strstr($a,'num')):?>
                    <th><?php echo $b; ?></th>
                    <?php endif; ?>
                  <?php endforeach;break; ?>
                  <?php endforeach;?>
                </tr>
                </thead>
                <tbody>      
                    <?php foreach ($wage_data as $v): ?>
                    <tr>
                      <?php foreach($v as $a =>$b):?>
                        <?php if(!strstr($a,'num')):?>
                        <td><?php echo $b; ?></td>
                        <?php endif; ?>
                      <?php endforeach;?>
                    <?php endforeach;?>
                    </tr>
                    </tbody>
                  </table>
              </div>
              <!-- /.overflow:scroll -->
            </div>
            <?php endif; ?>
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


      $("#myDeptWageMainMenu").addClass('active');
    
      
    });
    function submitForm(){
    //获取form表单对象
        var form = document.getElementById("selected_dept_form");
        form.submit();//form表单提交
    }
    
  </script>
 