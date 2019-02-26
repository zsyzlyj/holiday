<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      薪酬文件汇总
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
        </div>
        <div class="box-body">
          <div style="overflow:scroll;">
            <table id="wageDocTable" class="table table-bordered table-striped" >
              <thead>
                <tr>
                  <th>序号</th>
                  <th>文件名</th>
                  <th>文件类型</th>
                  <th>文件内容</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody>
                <?php $counter=0;?>
                <?php foreach($wage_doc as $k => $v):?>
                <tr>
                  <td><?php echo $v['number'];?></td>
                  <td><?php echo $v['doc_name'];?></td>
                  <td><?php echo $v['doc_type'];?></td>
                  <td><a href='<?php echo base_url($v['doc_path']);?>' target="_blank">浏览</a></td>
                  <td>
                    <a href="javascript:void(0)" class="btn btn-danger" data-toggle="modal" data-target="#myModal<?php echo $counter;?>"><i class="fa fa-trash">删除</i></a>
                    <div class="modal-month fade" tabindex="-1" data-backdrop="false" role="dialog" id="myModal<?php echo $counter;?>">
                      <div class="modal-content-month">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4>请确认</h4>
                        </div>
                        <div class="modal-body">
                          <h4 style="text-align:left">确认删除吗？</h4>
                        </div>
                        <div class="modal-footer">   
                          <form action='<?php echo base_url('super_wage/wage_doc_delete')?>' method='POST'>
                          <input type='hidden' value="<?php echo $v['number']; ?>" name='time'/>
                          <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                          <button type="submit" class="btn btn-success btn-ok">确认删除</a>
                          </form>
                        </div>
                      </div><!-- /.modal-content -->
                    </div><!-- /.modal -->
                  </td>
                </tr>
                <?php $counter++;?>
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
      $("#uploadWageDoc").addClass('active');
      $("#showWageDocNav").addClass('active');
      $('#wageDocTable').DataTable({
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