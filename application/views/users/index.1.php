

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        用户权限管理
        <small>Users</small>
      </h1>
      <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> Home</li>
        <li class="active">Users</li>
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
          
          
            <a href="<?php echo base_url('users/create') ?>" class="btn btn-primary">Add User</a>
            <br /> <br />
          


          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Manage Users</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="userTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>编号</th>
                  <th>用户名</th>
                  <th>权限</th>
                  <th>操作</th>
                </tr>
                </thead>
                <tbody>
                  <?php $count=0; ?>
                  <?php if($user_data): ?>                  
                    <?php foreach ($user_data as $k => $v): ?>
                      <tr>
                        <td><?php echo ++$count; ?></td>
                        <td><?php echo $v['username']; ?></td>
                        <td><?php echo $v['permission']; ?></td>

                        <td>
                            <a href="<?php echo base_url('users/edit/'.$v['user_id']) ?>" class="btn btn-default"><i class="fa fa-edit"></i></a>

                            <a href="<?php echo base_url('users/delete/'.$v['user_id']) ?>" class="btn btn-default"><i class="fa fa-trash"></i></a>
                        </td>

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

      $("#holidayUserNav").addClass('active');
      $("#manageHolidayUserNav").addClass('active');
    });
  </script>
