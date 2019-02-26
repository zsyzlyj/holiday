

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        计划提交情况
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

            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
              <div style="overflow:scroll;">
              
              <table id="holidayTable" class="table table-bordered table-striped" style="overflow:scroll;table-layout:fixed" width="100%">
                <thead>
                <tr>
                  <th>部门</th>
                  <th>提交状态</th>
                  <th>审核结果</th>
                </tr>
                </thead>
                <tbody>
                  <?php if($feedback): ?>                  
                    <?php foreach ($feedback as $k => $v): ?>
                      <tr>
                        <td><?php echo $k; ?></td>
                        <td>
                        <?php if(strstr($v['submit_status'],'已')):?>
                        <font color='blue'><?php echo $v['submit_status'];?></font>
                        <?php else: ?>
                        <font color='red'><?php echo $v['submit_status'];?></font>
                        <?php endif; ?>
                        </td>
                        <td>
                        <?php if(strstr($v['feedback_status'],'已')):?>
                        <font color='green'><?php echo $v['feedback_status'];?></font>
                        <!-- 打开弹窗按钮 -->
                        <a href="javascript:void(0)" id="myBtn" data-toggle="modal" data-target="#myModal"><font color='orange'>反馈意见</font></a>
                        <div class="modal-month fade" tabindex="-1" data-backdrop="false" role="dialog" id="myModal">
                          <div class="modal-content-month">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>  
                              <h4>反馈意见</h4>
                            </div>
                            <div class="modal-body">
                                <?php if($feedback[$v['department']]['content']==""):?>
                                <h3>无</h3>
                                <?php else: ?>
                                <?php echo $feedback[$v['department']]['content'];?>
                                <?php endif;?>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                            </div>
                          </div><!-- /.modal-content -->
                        </div><!-- /.modal -->

                        <?php else: ?>
                        <font color='red'><?php echo $v['feedback_status'];?></font>
                        <?php endif; ?>
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
      $("#myDomainPlanMainMenu").addClass('active');
      $("#SubmitStatusNav").addClass('active');
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
 