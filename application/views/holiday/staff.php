

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        年假信息
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Holiday</li>
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
              <h3 class="box-title" col><font color="red">公告说明：</font></h3>
              </br>              </br>

              <h4>
                <?php if( $notice_data): ?> 
                <?php foreach ($notice_data as $notice): ?>
                <?php echo $notice['content'];?>
                <?php endforeach;?>
                <?php endif ?>
              </h4>
              <h4><font color="blue">点击已休假数可以查看每个月已休明细</font></h4>
              </br>

              <h3 class="box-title"><font color="red">年假文件：</font></h3>
              <h4>
                <?php foreach($holiday_doc as $k => $v):?>
                  <a href='<?php echo base_url($v['doc_path']);?>' target="_blank"><?php echo $v['doc_name']?></a>
                  <br />
                  <br />
                <?php endforeach; ?>
              </h4>
            </div>
            <br />
            <!-- /.box-header -->
            <div class="box-body">
              <div style="overflow:scroll;">
                <table id="holidayTable" class="table table-bordered table-striped mytdstyle" style="overflow:scroll;">
                <thead>
                <tr>
                  <th>姓名</th>
                  <th>部门</th>                
                  <th>社会工龄</th>
                  <th>公司工龄</th>
                  <th>休假总数</th>
                  <th>上年可休数</th>
                  <th>今年可休数</th>
                  <th>荣誉假期</th>
                  <th>已休假数</th>
                  <th>剩下休假数</th>
                  <!--<th>操作</th>-->
                </tr>
                </thead>
                <tbody>
                  <?php if($holiday_data): ?>                  
                    <?php $v=$holiday_data ?>
                      <tr>
                        <td><?php echo $v['name']; ?></td>
                        <td><?php echo $v['department']; ?></td>
                        <td><?php echo $v['Totalage']; ?></td>
                        <td><?php echo $v['Companyage']; ?></td>
                        
                        <td><?php echo $v['Totalday']; ?></td>
                        <td><?php echo $v['Lastyear']; ?></td>
                        <td><?php echo $v['Thisyear']; ?></td>
                        <td><?php echo $v['Bonus']; ?></td>
                        <td>
                          
                          <!-- 打开弹窗按钮 -->
                          <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal"><font color='red'><?php echo $v['Used']; ?></font></a>
                          
                          <!-- 弹窗 -->
                          <div id="myModal" class="modal fade" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            
                            <!-- 弹窗内容 -->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h3>每月已休假明细</h3>
                              </div>

                              <div class="modal-body">
                              <table id="MonthTable" class="table table-bordered table-striped">
                                <thead>
                                  <tr>
                                    <th style="text-align:center;">一月</th>
                                    <th style="text-align:center;">二月</th>
                                    <th style="text-align:center;">三月</th>
                                    <th style="text-align:center;">四月</th>
                                    <th style="text-align:center;">五月</th>
                                    <th style="text-align:center;">六月</th>
                                    <th style="text-align:center;">七月</th>
                                    <th style="text-align:center;">八月</th>
                                    <th style="text-align:center;">九月</th>
                                    <th style="text-align:center;">十月</th>
                                    <th style="text-align:center;">十一月</th>
                                    <th style="text-align:center;">十二月</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                      <tr>
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
                                      </tr>
                                      </tbody>
                              </table>
                              </div>
                            </div>
                            
                          </div>
 
                          
 
                        </td>

                        <td><?php echo $v['Rest']; ?></td>

                        <!--
                        <td>
                            <a href="<?php echo base_url('holiday/edit/'.$v['name']) ?>" class="btn btn-default"><i class="fa fa-edit"></i></a>

                            <a href="<?php echo base_url('holiday/delete/'.$v['name']) ?>" class="btn btn-default"><i class="fa fa-trash"></i></a>
                        </td>
                        -->
                      </tr>
                  <?php endif; ?>
                </tbody>
              </table>
              <br />
              <br />
              <br />
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
    $(document).ready(function() {
      /*
      $('#holidayTable').DataTable({
  
      language: {
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
          "oPaginate": {
              "sFirst": "首页",
              "sPrevious": "上页",
              "sNext": "下页",
              "sLast": "末页"
          },
          "oAria": {
              "sSortAscending": ": 以升序排列此列",
              "sSortDescending": ": 以降序排列此列"
          }
      }
    });*/



    
    $("#holidayMainMenu").addClass('active');
    
      
    });
    
  </script>
 