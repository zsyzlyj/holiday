



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      公告
    </h1>      
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div class="box">
          <div class="box-header">
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div>
              <div class="col-md-6 col-md-offset-3">
                <?php if($notice_data): ?> 
                <?php foreach ($notice_data as $notice): ?>
                <p><?php echo $notice['content'];?></p>
                <?php endforeach;?>
                <?php endif ?>
              </div>
            </div>
          </div>
      </div>
    </div>  

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
    $(document).ready(function() { 
      $("#wageNoticeMainMenu").addClass('active');
      $(".form_datetime").datetimepicker({
        //language: 'cn',
        format: 'yyyy-mm',
        startView:3,
        minView:3,
        startDate:"2017-12",
        autoclose:true
      });
    
    });
    
    
  </script>
