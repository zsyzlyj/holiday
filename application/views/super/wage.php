

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        工资信息汇总
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
            </div>
            <!-- /.box-header -->

            <div class="box-body">
              <div style="overflow:scroll;">
              <table id="wageTable" class="table table-bordered table-striped" style="overflow:scroll;">
                <thead>
                <td colspan='4'>a</td>
                
                <tr>
                  <?php for($i=0;$i<$total_column;$i++): ?>
                  <th>&nbsp;</th>
                  <?php endfor; ?>
                </tr>
                </thead>
                <tbody> 
                <?php if($wage_data): ?>
                <?php foreach($wage_data as $k => $v): ?>
                  <?php $counter=0; ?>
                    <tr>
                    <?php foreach($v as $a => $b): ?>
                    <?php if($counter<$total_column):?>
                      <td style='white-space: nowrap; word-break:  keep-all;'><?php echo $b;$counter++;?></td>
                    <?php else: break;?>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    </tr>
                  
                  <?php $counter=0; ?>
                <?php endforeach; ?>
                <?php endif;?>
                </tbody>
              </table>
              </div>
              <!-- /.overflow:scroll -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- col-md-12 -->
      </div>
      <!-- /.row -->
      </section>
  </div>
  <!-- /.content-wrapper -->
  
  
  

  <script type="text/javascript">
    $(document).ready(function() {
      $('#wageGatherMainMenu').addClass('active');
      
      $('#wageTable').DataTable({
        language: 
        {
            "sProcessing": "处理中...",
            "sLengthMenu": "显示 _MENU_ 项",
            "sZeroRecords": "没有匹配结果",
            "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
            "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
            "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
            "sInfoPostFix": "",
            "sSearch": "搜索:",
            "sUrl": "",
            "sEmptyTable": "表中数据为空",
            "sLoadingRecords": "载入中...",
            "sInfoThousands": ",",
            "oPaginate": 
            {
                "sFirst": "首页",
                "sPrevious": "上页",
                "sNext": "下页",
                "sLast": "末页"
            },
            "oAria": 
            {
                "sSortAscending": ": 以升序排列此列",
                "sSortDescending": ": 以降序排列此列"
            }
        }      
      });
    });
  </script>
 