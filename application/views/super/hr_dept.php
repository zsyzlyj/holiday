  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        部门人员信息表
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">
          <br />
          <div class="box">
            <div class="box-header"></div>
            <!-- /.box-header -->
            <div class="box-body">
              <form action='<?php echo base_url('super_hr/hr_dept' )?>' method="post" id="selected_dept_form">
                <select id="selected_dept" name="selected_dept[]" class="selectpicker show-tick" multiple data-live-search="true" data-actions-box="true">
                  <?php if($current_dept!=""):?>
                  <option value="<?php $current_dept;?>"><?php echo $current_dept;?></option>
                  <?php endif;?>
                  <?php foreach($dept_options as $k => $v):?>
                  <?php if($current_dept!=$v):?>
                    <option value="<?php echo $v['content13'];?>"><?php echo $v['content13'];?></option>
                  <?php endif;?>
                  <?php endforeach;?>
                </select>
                <button class="btn btn-primary" style="margin:10px">查询</button>
              </form>
              <hr />
              <?php if($current_dept!=""):?>
              <h3><?php echo $current_dept;?>信息汇总表</h3>
              
              <hr />
              <div class="col-md-12 col-xs-12">
                <div style="overflow:scroll;">
                <table id="deptTable" class="table table-bordered table-striped" style="overflow:scroll;word-break:  keep-all;border-color:silver;">
                <thead>
                  <tr style="border-color:silver;">
                    <?php $counter=0;?>
                    <?php if($column_name): ?>
                      <?php foreach ($column_name as $k => $v): ?>
                      <?php if($counter<$trueend):?>
                        <th style="border-color:silver;"><?php echo $v;$counter++;?></th>
                      <?php endif; ?>
                      <?php endforeach ?>
                    <?php endif;?>
                  </tr>
                  </thead>
                  <tbody>
                    <?php if($hr_data): ?>                  
                      <?php foreach ($hr_data as $k => $v): ?>
                        <tr style="border-color:silver;">
                        <?php $counter=0;?>
                        <?php foreach($v as $a => $b):?>
                        <?php if($counter<$trueend):?>
                        <td style="border-color:silver;"><?php echo $b;$counter++;?></td>
                        <?php endif; ?>
                        <?php endforeach ?>
                        </tr>
                      <?php endforeach ?>
                    <?php endif; ?>
                  <!---->
                  </tbody>
                </table>
                </div>
                <!-- /.overflow:scroll -->
              </div>
              <?php endif;?>
              <hr />
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
      $("#deptMainMenu").addClass('active');
      $('.selectpicker').selectpicker();
      $('#deptTable').DataTable({
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
        },
        "order":[[12,"desc"]]
      });
    });
    function submitForm(){
      //获取form表单对象
      var form = document.getElementById("selected_dept_form");
      form.submit();//form表单提交
    }
  </script>
 