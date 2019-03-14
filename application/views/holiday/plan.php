  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        年假计划
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
          <div class="box" style="overflow:scroll;table-layout:fixed">
            <div class="box-header">

            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
              <div style="overflow:scroll;">
              <table id="planTable" class="table table-bordered table-striped" style="overflow:scroll;white-space: nowrap;">
                <thead>
                <tr>
                  <th>姓名</th>
                  <th style="white-space: nowrap">可休假总数</th>
                  <th>上年可休数</th>
                  <th>今年可休数</th>
                  <th>荣誉假期数</th>
                  <th>第一季度</th>
                  <th>第二季度</th>
                  <th>第三季度</th>
                  <th>第四季度</th>
                  <th>状态</th>
                  <th>操作</th>
                </tr>
                </thead>
                <tbody>
                  <?php if($plan_data): ?>
                    <?php foreach($plan_data as $k => $v): ?>
                      <tr>
                        <td><?php echo $v['name']; ?></td>
                        <td><?php echo $v['Totalday']; ?></td>
                        <td><?php echo $v['Lastyear']; ?></td>
                        <td><?php echo $v['Thisyear']; ?></td>
                        <td><?php echo $v['Bonus']; ?></td>
                        <td><?php echo $v['firstquater']; ?></td>
                        <td><?php echo $v['secondquater']; ?></td>
                        <td><?php echo $v['thirdquater']; ?></td>
                        <td><?php echo $v['fourthquater']; ?></td>
                        <?php if($v['submit_tag']=='已提交'):?>
                          <td><font color='green'><?php echo $v['submit_tag']; ?></font></td>
                        <?php endif; ?>
                        <?php if($v['submit_tag']=='未提交'):?>
                          <td><font color='red'><?php echo $v['submit_tag']; ?></font></td>
                        <?php endif; ?>
                        <td>
                        <form action="<?php echo base_url('holiday/change_submit')?>" method="post" style="margin:0px;display:inline;">
                        <input type="hidden" id='user_id' name='user_id' value="<?php echo $v['user_id'];?>"/>
                        <input type="hidden" id='submit_auth' name='submit_auth' value="1"/>
                        <input type="hidden" id='submit_revolt' name='submit_revolt' value="0"/>
                        <button class='btn btn-info'>允许重新填写</button>
                        </form>
                        <form action="<?php echo base_url('holiday/change_submit')?>" method="post" style="margin:0px;display:inline;">
                        <button class='btn btn-danger'>撤回填写权限</button>
                        <input type="hidden" id='user_id' name='user_id' value="<?php echo $v['user_id'];?>"/>
                        <input type="hidden" id='submit_auth' name='submit_auth' value="0"/>
                        <input type="hidden" id='submit_revolt' name='submit_revolt' value="1"/>
                        </form>
                        </td>
                      </tr>
                    <?php endforeach; ?>
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
      $('#planGatherMainMenu').addClass('active');
      $('#planTable').DataTable({
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
 