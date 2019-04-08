<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      积点确认
    </h1>
  </section>
 <!-- Main content -->
  <section class="content">
    
    <a href="<?php echo base_url('super_hr/hr_score_import');?>" class="btn btn-info">上传积分信息</a>
    <a href="javascript:void(0)" class="btn btn-danger" data-toggle="modal" data-target="#myModal">重置确认信息</a>
    <div class="modal-month fade" tabindex="-1" data-backdrop="false" role="dialog" id="myModal">
      <div class="modal-content-month">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4>请确认</h4>
        </div>
        <div class="modal-body">
          <h4 style="text-align:left">确认重置？</h4>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
          <form action="<?php echo base_url('super_hr/reset_confirm');?>" style="display:inline" method="POST">
            <button type="submit" class="btn btn-danger">重置</a>
          </form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal -->
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div class="box">
          <div class="box-header">
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="hrTable" class="table table-bordered table-striped table-hover" style="table-layout:fixed;border-color:silver;">
              <thead>
                <tr style="border-color:silver;">
                  <th style="border-color:silver;">序号</th>
                  <th style="border-color:silver;">ERP编号</th>
                  <th style="border-color:silver;">姓名</th>
                  <th style="border-color:silver;">状态</th>
                </tr>
              </thead>
              <tbody>
                <?php $counter=1;?>
                <?php foreach($score_list as $k => $v):?>
                <tr style="border-color:silver;">
                <td style="border-color:silver;"><?php echo $counter++;?></td>
                <?php foreach($v as $a => $b):?>
                <td style="border-color:silver;"><?php echo $b;?></td>
                <?php endforeach;?>
                </tr>
                <?php endforeach;?>
              </tbody>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>  
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
    $(document).ready(function(){ 
      $("#scoreMainMenu").addClass('active');
      $('#hrTable').DataTable({
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
