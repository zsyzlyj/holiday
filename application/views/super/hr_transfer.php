<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      人员信息高级搜索
    </h1>
  </section>
 <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <a href="<?php echo base_url('super_hr/hr_transfer_import') ?>" class="btn btn-primary">上传人员信息</a>
        <div class="box">
          <div class="box-header">
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <hr />
            <form action="<?php echo base_url('super_hr/hr_transfer_search')?>" method="post">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-4">姓名：
                  <input name="name" type="text"/>
                </div>
              </div>
              <!-- /.row -->
            <hr />
            <div class="row">
            </div>
            <div class="row">
            <div class="col-md-12">
              <button class="btn btn-primary">搜索</button>
            </div>
            </div>
            </form>           
            </div>
            
          </div>
          <!-- /.box-body -->
        </div>
        <div class="box">
          <div class="box-header">
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <hr />
            <div class="col-md-12 col-xs-12">
              <div style="overflow:scroll;">
                <?php if($hr_data): ?>
                <table id="hrTable" class="table table-bordered table-striped" style="overflow:scroll;word-break:  keep-all;border-color:silver;">
                <thead>
                  <tr style="border-color:silver;">
                    <?php $counter=0;?>
                    <?php if($column_name): ?>
                      <?php foreach ($column_name as $k => $v): ?>
                      <?php if($counter<$trueend):?>
                          <th style="border-color:silver;"><?php echo $v;?></th>
                      <?php endif; ?>
                      <?php $counter++;?>
                      <?php endforeach ?>
                    <?php endif;?>
                  </tr>
                  </thead>
                  <tbody>
                      <?php $row=0;?>            
                      <?php foreach ($hr_data as $k => $v): ?>
                        <tr style="border-color:silver;">
                        <?php $counter=0;?>
                        <td style="border-color:silver;"><?php echo $row+1;?></td>
                        <?php foreach($v as $a => $b):?>
                        <?php if($counter<$trueend):?>
                        <td style="border-color:silver;"><?php echo $b;?></td>
                        <?php endif; ?>
                        <?php $counter++;?>
                        <?php endforeach ?>
                        </tr>
                        <?php $row++;?>
                      <?php endforeach ?>
                    
                  </tbody>
                </table>
                <?php endif; ?>
              </div>
              <hr />
            </div>
          </div>
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
<!-- /.row --><!--

              <!-- /.row -->

<script type="text/javascript">
    $(document).ready(function(){ 
      $("#hrTransferMenu").addClass('active');
      
      $('.selectpicker').selectpicker();

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
    function submitForm(){
    //获取form表单对象
        var form = document.getElementById("user_details");
        form.submit();//form表单提交
    }
  </script>
