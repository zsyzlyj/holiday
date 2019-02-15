

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        创建用户
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
              <h3 class="box-title"> </h3>
            </div>
            <form role="form" action="<?php base_url('super_wage/create') ?>" method="post">
              <div class="box-body">
                <div class="col-md-3 col-md-offset-4">
                  <?php echo validation_errors(); ?>
                  <div class="form-group">
                    <label for="username">姓名</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="姓名" autocomplete="off" required>
                  </div>

                  <div class="form-group">
                    <label for="email">身份证</label>
                    <input type="text" class="form-control" id="user_id" name="user_id" placeholder="身份证号码" maxlength="18" autocomplete="off" required>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <div class="col-md-6 col-md-offset-4">
                  <button type="submit" class="btn btn-primary">创建用户</button>
                  <a href="<?php echo base_url('super_wage/reset_pass') ?>" class="btn btn-warning">返回</a>
                </div>
              </div>
            </form>
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
    $("#groups").select2();

    $("#holidayUserNav").addClass('active');
    $("#wageUserNav").addClass('active');
    $("#createUserNav").addClass('active');
  
  });
</script>
