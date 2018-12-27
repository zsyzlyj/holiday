

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        用户
        <small>设置</small>
      </h1>
      <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> Home</li>
        <li class="active">Setting</li>
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

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">修改密码</h3>
            </div>
            <!-- /.box-header -->
            <?php if(strstr($_SERVER['PHP_SELF'],'wage')):?>
            <form role="form" action="<?php base_url('auth/wage_setting') ?>" method="post">
            <?php endif; ?>
            <?php if(strstr($_SERVER['PHP_SELF'],'holiday')):?>
            <form role="form" action="<?php base_url('auth/holiday_setting') ?>" method="post">
            <?php endif; ?>
            
              <div class="box-body">

                <?php echo validation_errors(); ?>

                <div class="form-group">
                  <label for="username">用户名</label>
                  <input type="text" class="form-control" disabled="disabled" placeholder="Username" value="<?php echo $user_name ?>" autocomplete="off">
                  <input type="hidden" id="username" name="username" value="<?php echo $user_name ?>" />
                </div>

               

                <div class="form-group">
                  <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      如果不需要修改密码，请不要填写密码栏。点击返回回到主页。
                  </div>
                </div>

                <div class="form-group">
                  <label for="password">新密码</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="密码" autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="cpassword">确认新密码</label>
                  <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="确认密码" autocomplete="off">
                </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">保存修改</button>
                <a href="<?php echo base_url('holiday/staff') ?>" class="btn btn-warning">返回</a>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
       
      </div>
      <!-- /.row -->
      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script type="text/javascript">
    $(document).ready(function() {
      $("#changePassword").addClass('active');  
    });
    
  </script>
 
