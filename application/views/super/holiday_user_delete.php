

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <br />
      <h1>
        员工管理        
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

          <h1>确定删除吗 ?</h1>
          <br />
          <form action="<?php echo base_url('super_holiday/user_delete/') ?>" method="post">
            <input type="hidden" class="btn btn-primary" name="user_id2" value="<?php echo $user_id;?>">
            <input type="submit" class="btn btn-primary" name="confirm" value="确认">
            <a href="<?php echo base_url('super_holiday/users') ?>" class="btn btn-warning">取消</a>
          </form>

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
    $("#holidayUserNav").addClass('active');
    $("#UserNav").addClass('active');
  });
</script>