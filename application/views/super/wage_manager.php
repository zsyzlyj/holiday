

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        用户权限管理
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
          
          
            <a href="<?php echo base_url('super_holiday/manager_import') ?>" class="btn btn-primary">上传管理员角色</a>
            <br /> <br />
          


          <div class="box">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="userTable" class="table table-bordered table-striped mytdstyle">
                <thead>
                <tr>
                  <th>用户名</th>
                  <th>部门</th>
                  <th>角色</th>
                  <!--<th>操作</th>-->
                </tr>
                </thead>
                <tbody>
                  <?php if($manager_data): ?>                  
                    <?php foreach ($manager_data as $k => $v): ?>
                      <tr>
                        <td><?php echo $v['name']; ?></td>
                        <td><?php echo $v['dept']; ?></td>
                        <td><?php echo $v['role']; ?></td>
                        <!--
                        <?php if($v['permission']=='超级管理员'): ?>
                        <td><?php echo '不需要部门' ?></td>
                        <?php endif; ?>
                        
                        <?php if($v['permission']!='超级管理员'): ?>
                        <td><?php echo $v['dept']; ?></td>
                        <?php endif; ?>
                        
                        <form action="<?php echo base_url('users/update/') ?>" method="post">
                          
                        <td>
                          <input id="user_id" name="user_id" type="hidden" value="<?php echo $v['user_id'] ?>"/>
                          <select id="permit" name="permit">
                            <option value="<?php $v['permission'];?>"><?php echo $v['permission']; ?></option>
                            <?php foreach ($permission_set as $a => $b): ?>
                              <?php if($b != $v['permission']):?>
                                <option value="<?php echo $a; ?>"><?php echo $b; ?></option>
                              <?php endif ?>
                            <?php endforeach ?>
                          </select>
                        </div>
                        </td>
                        
                        <td>
                            <button class="btn btn-success" type="submit"><i class="fa fa-edit"> 提交</i></button>
                        </form>
                        
                            <a href="<?php echo base_url('users/delete/'.$v['user_id']) ?>" class="btn btn-danger"><i class="fa fa-trash"> 删除</i></a>
                        </td>
                        -->

                      </tr>
                    <?php endforeach ?>
                  <?php endif; ?>
                </tbody>
              </table>
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
      $("#wageUserNav").addClass('active');
      $("#manageHolidayUserNav").addClass('active');
      $('#userTable').DataTable({
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
