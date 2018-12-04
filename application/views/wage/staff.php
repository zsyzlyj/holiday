

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        工资信息
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Wage</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><font color="red">公告说明：</font></h3>
                </br>              </br>
                <h4>
                </h4>
                <?php if($permission == 3 or $permission == 2 or $permission == 1): ?>
                <h4><font color="blue">点击已休假数可以查看每个月已休明细</font></h4>
                <?php endif ?>
            </div>
              <!-- /.box-header -->

            <div class="box-body">
              <div style="overflow:scroll;">
                <table id="wageTable"class="table table-striped" style="white-space: nowrap;word-break:  keep-all;text-align: center;">
                  <thead>
                  <?php if($wage_data): ?>
                    <?php foreach($wage_data as $k =>$v):?>
                      <th><?php echo $v;?></th>
                    <?php endforeach; ?>
                    <?php endif; ?>
                  </thead>
                  <tbody>
                    <tr>
                    <?php if($wage_data): ?>
                    <?php foreach($wage_data as $k =>$v):?>
                      <td><?php echo $v;?></td>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
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
      $("#wageMainMenu").addClass('active');
      
    
  </script>
 