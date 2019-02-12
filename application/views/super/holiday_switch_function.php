  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        权限开关
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">          
          <div class="box">
            
            <!-- /.box-header -->
            <div class="box-body">
              <div style="overflow:scroll;">
              
              <table id="holidayTable" class="table table-bordered table-striped" style="overflow:scroll;table-layout:fixed" width="100%">
                <thead>
                <tr>
                  <th>功能</th>
                  <th>状态</th>
                  <th>操作</th>
                </tr>
                </thead>
                <tbody>
                  <?php foreach($holiday_func as $k => $v):?>
                  <tr>
                  <?php foreach($v as $a => $b):?>
                    <?php if($a!='id'):?>
                      <?php if(strstr($b,'关闭')):?>
                      <td><font color='red'><?php echo $b;?></font></td>
                      <?php elseif(strstr($b,'开启')): ?>
                      <td><font color='green'><?php echo $b;?></font></td>
                      <?php elseif($a!='func_type'):?>
                      <td><?php echo $b;?></td>
                      <?php endif; ?>
                    <?php endif; ?>
                  <?php endforeach; ?>
                    <td>
                      <form action="<?php echo base_url('super_holiday/switch_function')?>" method="post" style="margin:0px;display:inline;">
                        <input type="hidden" name="func_name_on" value="<?php echo $v['name'];?>">
                        <button type="submit" class="btn btn-success">开启</button>
                      </form>
                      <form action="<?php echo base_url('super_holiday/switch_function')?>" method="post" style="margin:0px;display:inline;">
                        <input type="hidden" name="func_name_off" value="<?php echo $v['name'];?>">
                        <button type="submit" class="btn btn-danger">关闭</button>
                      </form>
                    </td>    
                  </tr>
                  <?php endforeach; ?>
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
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
 <script type="text/javascript">
    $(document).ready(function(){
      $('#switchMainMenu').addClass('active');
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
  </script>