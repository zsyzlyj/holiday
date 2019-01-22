

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        修改密码
      </h1>
    </section>
    <br />

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
              <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  如果不需要修改密码，请不要填写密码栏。点击返回回到主页。
              </div>
            </div>
            <!-- /.box-header -->
            <?php if(strstr($_SERVER['PHP_SELF'],'wage')):?>
            <form role="form" action="<?php base_url('super_auth/wage_setting') ?>" method="post">
            <?php endif; ?>
            <?php if(strstr($_SERVER['PHP_SELF'],'holiday')):?>
            <form role="form" action="<?php base_url('super_auth/holiday_ setting') ?>" method="post">
            <?php endif; ?>
              <div class="box-body">
                <div class="col-md-4 col-md-offset-4">
                <?php echo validation_errors(); ?>

                <div class="form-group">
                  <label for="username">用户名</label>
                  <input type="text" class="form-control" disabled="disabled" placeholder="Username" value="<?php echo $user_name ?>" autocomplete="off">
                  <input type="hidden" id="username" name="username" value="<?php echo $user_name ?>" />
                </div>
                <div class="form-group">
                  <label for="password">原密码</label>
                  <input type="password" class="form-control" id="opassword" name="opassword" placeholder="密码" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="password">新密码</label>
                  <input type="password" class="form-control" id="npassword" name="npassword" placeholder="" autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="cpassword">确认新密码</label>
                  <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="" autocomplete="off">
                </div>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <div class="col-md-4 col-md-offset-4">
                <a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal" data-target="#myModal">保存修改</a>
                <div class="modal-month fade" tabindex="-1" data-backdrop="false" role="dialog" id="myModal">
                  <div class="modal-content-month">
                    <div class="modal-header">
                      <h4>请确认</h4>
                    </div>
                    <div class="modal-body">
                      <h4 style="text-align:left">确认修改吗？</h4>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                      <button type="submit" class="btn btn-success btn-ok">确认修改</a>
                    </div>
                  </div><!-- /.modal-content -->
                </div><!-- /.modal -->
                <?php if(strstr($_SERVER['PHP_SELF'],'wage')):?>
                <a href="<?php echo base_url('super_wage/search') ?>" class="btn btn-warning">返回</a>
                <?php endif; ?>
                <?php if(strstr($_SERVER['PHP_SELF'],'holiday')):?>
                <a href="<?php echo base_url('super_holiday/') ?>" class="btn btn-warning">返回</a>
                <?php endif; ?>
                </div>
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
      $('#userTable').DataTable();

      $("#settingMenu").addClass('active');
    });
  </script>

 
