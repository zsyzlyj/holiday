

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
              <h3 class="box-title"><font color="red">薪酬文件：</font></h3>
                </br>              </br>
                <h4>
                  <?php foreach($wage_doc as $k => $v):?>
                    <a href='<?php echo base_url($v['doc_path']);?>' target="_blank"><?php echo $v['doc_name']?></a>
                    <br />
                  <?php endforeach; ?>
                </h4>
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
    });
      
    
  </script>
 