



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>
        薪酬统计
      </h1>
      
        
        
      
    </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-chart-area"></i>
                        Area Chart Example</div>
                    <div class="card-body">
                        <canvas id="myAreaChart" width="100%" height="30"></canvas>
                    </div>
                    <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-chart-bar"></i>
                            Bar Chart Example</div>
                        <div class="card-body">
                            <canvas id="myBarChart" width="100%" height="50"></canvas>
                        </div>
                        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-chart-pie"></i>
                            Pie Chart Example</div>
                        <div class="card-body">
                            <canvas id="myPieChart" width="100%" height="100"></canvas>
                        </div>
                        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid">
    </div>
    <!-- /.container-fluid -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
    $(document).ready(function() { 
      $("#wagechartMainMenu").addClass('active');
    
    });
  </script>
  
  <script src="<?php echo base_url('assets/dist/vendor/jquery/jquery.min.js')?>"></script>
  <script src="<?php echo base_url('assets/dist/vendor/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
  <script src="<?php echo base_url('assets/dist/vendor/jquery-easing/jquery.easing.min.js')?>"></script>
  <script src="<?php echo base_url('assets/dist/vendor/chart.js/Chart.min.js')?>"></script>
  <script src="<?php echo base_url('assets/dist/js/data-chart/chart-area-demo.js')?>"></script>
  <script src="<?php echo base_url('assets/dist/js/data-chart/chart-bar-demo.js')?>"></script>
  <script src="<?php echo base_url('assets/dist/js/data-chart/chart-pie-demo.js')?>"></script>
