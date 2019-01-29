

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      日志汇总
    </h1>
  </section>
  <br />
  <br />

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">
      <div id="messages"></div>
      <div class="box">
        <div class="box-header">
        </div>
        <div class="box-body">
          <div style="overflow:scroll;">
            <table id="wageLogTable" class="table table-bordered table-striped" >
              <thead>
                <tr>
                  <th>操作时间</th>
                  <th>身份证</th>
                  <th>用户名</th>
                  <th>动作</th>
                  <th>IP</th>
                </tr>
              </thead>
              <tbody>
                
                <?php foreach($log as $k => $v):?>
                <tr>
                  <td><?php echo $v['action_time'];?></td>
                  <td><?php echo $v['user_id'];?></td>
                  <td><?php echo $v['username'];?></td>
                  <td><?php echo $v['staff_action'];?></td>
                  <td><?php echo $v['login_ip'];?></td>
                </tr>
                <?php endforeach;?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      </div>
    </div>  

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
    $(document).ready(function(){ 
      $("#logTableMainMenu").addClass('active');
      $('#wageLogTable').DataTable({
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
        "order":[[0,"desc"]],
      });
    });
    
  </script>