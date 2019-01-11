

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    
    
      

    
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <form action="<?php echo base_url('super_wage/tax_counter') ?>" method="post">
            <div>
                <?php echo $result;?>
            </div>
        </form>
      </div>
    </div>  

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
    $(document).ready(function() {
      $("#taxCounterMenu").addClass('active');
      $("#taxCounterNav").addClass('active');
    });
    
  </script>