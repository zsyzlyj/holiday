

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        年假信息
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
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
              <div style="overflow:scroll;">
              <table id="holidayTable" class="table table-bordered table-striped" style="overflow:scroll;word-break:  keep-all;">
                <thead>
                <tr>
                  <th>姓名</th>
                  <th>部门</th>  
                  <th>开始工作年份</th>   
                  <th>社会工龄</th>
                  <th>入司年份</th> 
                  <th>公司工龄</th>
                  <th>可休假总数</th>
                  <th>荣誉假期</th>
                  <th>去年剩余年假天数</th>
                  <th>今年年假天数</th>
                  <th>一月</th>
                  <th>二月</th>
                  <th>三月</th>
                  <th>四月</th>
                  <th>五月</th>
                  <th>六月</th>
                  <th>七月</th>
                  <th>八月</th>
                  <th>九月</th>
                  <th>十月</th>
                  <th>十一月</th>
                  <th>十二月</th>
                  
                  <th>已休假数</th>
                  <th>剩下休假数</th>
                </tr>
                </thead>
                <tbody>
                  <?php if($holiday_data): ?>                  
                    <?php foreach ($holiday_data as $k => $v): ?>
                      <tr>
                        <td><?php echo $v['name'];?></td>
                        <td><?php echo $v['department']; ?></td>
                        <td><?php echo $v['initdate']; ?></td>
                        
                        <td><?php echo $v['Totalage']; ?></td>
                        <td><?php echo $v['indate']; ?></td>
                        <td><?php echo $v['Companyage']; ?></td>
                        
                        <td><?php echo $v['Totalday']; ?></td>
                        <td><?php echo $v['Bonus']; ?></td>
                        <td><?php echo $v['Lastyear']; ?></td>
                        <td><?php echo $v['Thisyear']; ?></td>
                        
                        <td><?php echo $v['Jan']; ?></td>
                        <td><?php echo $v['Feb']; ?></td>
                        <td><?php echo $v['Mar']; ?></td>
                        <td><?php echo $v['Apr']; ?></td>
                        <td><?php echo $v['May']; ?></td>
                        <td><?php echo $v['Jun']; ?></td>
                        <td><?php echo $v['Jul']; ?></td>
                        <td><?php echo $v['Aug']; ?></td>
                        <td><?php echo $v['Sep']; ?></td>
                        <td><?php echo $v['Oct']; ?></td>
                        <td><?php echo $v['Nov']; ?></td>
                        <td><?php echo $v['Dece']; ?></td>
                        
                        <td><?php echo $v['Used']; ?></td>
                        
                        <td><?php echo $v['Rest']; ?></td>
                      </tr>
                    <?php endforeach ?>
                    </tbody>
                  <?php endif; ?>
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
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script type="text/javascript">
    $(document).ready(function(){
      $("#holidayGatherMainMenu").addClass('active');
      $('#holidayTable').DataTable({
        language:{
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
            "oPaginate":{
                "sFirst": "首页",
                "sPrevious": "上页",
                "sNext": "下页",
                "sLast": "末页"
            },
            "oAria":{
                "sSortAscending": ": 以升序排列此列",
                "sSortDescending": ": 以降序排列此列"
            }
        }
      });
    });
    
  </script>
 