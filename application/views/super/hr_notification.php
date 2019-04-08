  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        公告历史
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
            <!-- /.box-header -->
            <div class="box-body">
              <div style="overflow:scroll;">
              <table id="wageTable" class="table table-bordered table-striped" style="overflow:scroll;table-layout:fixed;border-color:silver;" width="100%">
                <thead>
                <tr style="border-color:silver;">
                  <th style="border-color:silver;" class="col-md-1">发布时间</th>
                  <th style="border-color:silver;" class="col-md-1">发布者</th>                
                  <th style="border-color:silver;" class="col-md-1">标题</th>
                  <th style="border-color:silver;">内容</th>
                  <th style="border-color:silver;" class="col-md-1">分类</th>
                  <th style="border-color:silver;" class="col-md-1">操作</th>
                </tr>
                </thead>
                <tbody>
                  <?php if($notice_data): ?>
                    <?php $counter=0;?>         
                    <?php foreach ($notice_data as $k => $v): ?>
                      <tr style="border-color:silver;">
                        <td style="border-color:silver;"><?php echo $v['pubtime']; ?></td>
                        <td style="border-color:silver;"><?php echo $v['username']; ?></td>
                        <td style="border-color:silver;"><?php echo $v['title']; ?></td>
                        <td style="border-color:silver;"><?php echo $v['content']; ?></td>
                        <td style="border-color:silver;"><?php echo $v['type']; ?></td>
                        <td style="border-color:silver;">
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
                                <form action='<?php echo base_url('super_hr/notification_delete')?>' method='POST'>
                                <input type='hidden' value="<?php echo $v['pubtime']; ?>" name='time'/>
                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                <button type="submit" class="btn btn-danger btn-ok">确认删除</a>
                                </form>
                              </div>
                            </div><!-- /.modal-content -->
                          </div><!-- /.modal -->
                        </td>
                      </tr>
                    <?php $counter++;?>
                    <?php endforeach ?>
                  <?php endif; ?>
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
      $("#hrNoticeNav").addClass('active');
      $("#manage_score_sum_notice").addClass('active');
      $('#wageTable').DataTable({
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