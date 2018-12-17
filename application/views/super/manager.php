

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        用户权限管理
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Managers</li>
      </ol>
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
          
          
            <a href="<?php echo base_url('super/manager_import') ?>" class="btn btn-primary">上传管理员角色</a>
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
    $(document).ready(function() {
      $('#userTable').DataTable();

      $("#mainUserNav").addClass('active');
      $("#manageUserNav").addClass('active');
    });
  </script>
