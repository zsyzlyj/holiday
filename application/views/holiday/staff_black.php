

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
              <h3 class="box-title" col><font color="red">公告：</font></h3>
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
                  <br /><br />
                <?php endforeach; ?>
              </h4>
            </div>
            <br />
            <!-- /.box-header -->
            <div class="box-body">
              <div style="overflow:scroll;">
                <table id="holidayTable" class="table table-bordered table-striped" style="overflow:scroll;text-align: center;border-color:black;">
                <thead>
                <tr style="text-align: center;border-color:black;">
                  <th style="text-align: center;border-color:black;">姓名</th>
                  <th style="text-align: center;border-color:black;">部门</th>                
                  <th style="text-align: center;border-color:black;">社会工龄</th>
                  <th style="text-align: center;border-color:black;">公司工龄</th>
                  <th style="text-align: center;border-color:black;">休假总数</th>
                  <th style="text-align: center;border-color:black;">上年可休数</th>
                  <th style="text-align: center;border-color:black;">今年可休数</th>
                  <th style="text-align: center;border-color:black;">荣誉假期</th>
                  <th style="text-align: center;border-color:black;">已休假数</th>
                  <th style="text-align: center;border-color:black;">剩下休假数</th>
                  <!--<th style="text-align: center;border-color:black;">操作</th>-->
                </tr>
                </thead>
                <tbody>
                  <?php if($holiday_data): ?>                  
                    <?php $v=$holiday_data ?>
                      <tr style="text-align: center;border-color:black;">
                        <td style="text-align: center;border-color:black;"><?php echo $v['name']; ?></td>
                        <td style="text-align: center;border-color:black;"><?php echo $v['department']; ?></td>
                        <td style="text-align: center;border-color:black;"><?php echo $v['Totalage']; ?></td>
                        <td style="text-align: center;border-color:black;"><?php echo $v['Companyage']; ?></td>
                        <td style="text-align: center;border-color:black;"><?php echo $v['Totalday']; ?></td>
                        <td style="text-align: center;border-color:black;"><?php echo $v['Lastyear']; ?></td>
                        <td style="text-align: center;border-color:black;"><?php echo $v['Thisyear']; ?></td>
                        <td style="text-align: center;border-color:black;"><?php echo $v['Bonus']; ?></td>
                        <td style="text-align: center;border-color:black;">    
                          <!-- 打开弹窗按钮 -->
                          <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal"><font color='red'><u><?php echo $v['Used']; ?></u></font></a>
                          
                          <!-- 弹窗 -->
                          <div id="myModal" class="modal fade" tabindex="-1" data-backdrop="false" data-keyboard="true" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            
                            <!-- 弹窗内容 -->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h3>已休假明细</h3>
                              </div>

                              <div class="modal-body">
                              <table id="MonthTable" class="table table-bordered table-striped" style="text-align: center;border-color:black;">
                                <thead>
                                  <tr style="text-align:center;border-color:black;">
                                    <th style="text-align:center;border-color:black;">一月</th>
                                    <th style="text-align:center;border-color:black;">二月</th>
                                    <th style="text-align:center;border-color:black;">三月</th>
                                    <th style="text-align:center;border-color:black;">四月</th>
                                    <th style="text-align:center;border-color:black;">五月</th>
                                    <th style="text-align:center;border-color:black;">六月</th>
                                    <th style="text-align:center;border-color:black;">七月</th>
                                    <th style="text-align:center;border-color:black;">八月</th>
                                    <th style="text-align:center;border-color:black;">九月</th>
                                    <th style="text-align:center;border-color:black;">十月</th>
                                    <th style="text-align:center;border-color:black;">十一月</th>
                                    <th style="text-align:center;border-color:black;">十二月</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                      <tr style="text-align: center;border-color:black;">
                                        <td style="text-align: center;border-color:black;"><?php echo $v['Jan']; ?></td>
                                        <td style="text-align: center;border-color:black;"><?php echo $v['Feb']; ?></td>
                                        <td style="text-align: center;border-color:black;"><?php echo $v['Mar']; ?></td>
                                        <td style="text-align: center;border-color:black;"><?php echo $v['Apr']; ?></td>
                                        <td style="text-align: center;border-color:black;"><?php echo $v['May']; ?></td>
                                        <td style="text-align: center;border-color:black;"><?php echo $v['Jun']; ?></td>
                                        <td style="text-align: center;border-color:black;"><?php echo $v['Jul']; ?></td>
                                        <td style="text-align: center;border-color:black;"><?php echo $v['Aug']; ?></td>
                                        <td style="text-align: center;border-color:black;"><?php echo $v['Sep']; ?></td>
                                        <td style="text-align: center;border-color:black;"><?php echo $v['Oct']; ?></td>
                                        <td style="text-align: center;border-color:black;"><?php echo $v['Nov']; ?></td>
                                        <td style="text-align: center;border-color:black;"><?php echo $v['Dece']; ?></td>
                                      </tr>
                                  </tbody>
                              </table>
                              </div>
                            </div>
                          </div>
                        </td>
                        <td style="text-align: center;border-color:black;"><?php echo $v['Rest']; ?></td>

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
 