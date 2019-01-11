

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        年假计划
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
              <h3 class="box-title"><font color="red">公告说明：</font></h3>
                </br>              </br>
              <h4>
              <?php if($notice_data): ?> 
              <?php foreach ($notice_data as $notice): ?>
              <?php echo $notice['content'];?>
              <?php endforeach;?>
              <?php endif ?>
              </h4>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
              <div style="overflow:scroll;">
              <?php if($plan_data): ?>  
                <h3>状态：
                <?php echo validation_errors(); ?>
                <?php if(validation_errors()): ?>
                  填写规范有误
                <?php endif; ?>
                <?php if($plan_data['submit_tag']==1):?>
                  <font color='blue'>已填写</font>
                <?php endif ?>
                <?php if($plan_data['submit_tag']==0):?>
                  <font color='red'>未填写</font>
                <?php endif ?>
                </h3>
                <br />
                <br />
                <table id="planTable" class="table table-bordered table-striped" style="overflow:scroll;text-align:center;border-color:black;" width="120%">
                <thead>
                <tr style="text-align:center;border-color:black;">
                  <th style="text-align:center;border-color:black;">姓名</th>
                  <th style="text-align:center;border-color:black;">上年可休数</th>
                  <th style="text-align:center;border-color:black;">今年可休数</th>
                  <th style="text-align:center;border-color:black;">荣誉假期数</th>
                  <th style="text-align:center;border-color:black;">可休假总数</th>
                  <th style="text-align:center;border-color:black;">第一季度</th>
                  <th style="text-align:center;border-color:black;">第二季度</th>
                  <th style="text-align:center;border-color:black;">第三季度</th>
                  <th style="text-align:center;border-color:black;">第四季度</th>
                  <th style="text-align:center;border-color:black;">操作</th>
                </tr>
                </thead>
                <tbody>
                                  
                    <?php $v=$plan_data ?>
                      <tr style="text-align:center;border-color:black;">
                      
                        <td style="text-align:center;border-color:black;"><font size="3"><?php echo $v['name']; ?></font></td>
                        <td style="text-align:center;border-color:black;"><font size="4"><?php echo $v['Lastyear']; ?></font></td>
                        <td style="text-align:center;border-color:black;"><font size="4"><?php echo $v['Thisyear']; ?></font></td>
                        <td style="text-align:center;border-color:black;"><font size="4"><?php echo $v['Bonus']; ?></font></td>
                        <td style="text-align:center;border-color:black;"><font size="4"><?php echo $v['Totalday']; ?></font></td>
                        <?php if($v['submit_tag']==1):?>
                        <td style="text-align:center;border-color:black;"><?php echo $v['firstquater']; ?></td>
                        <td style="text-align:center;border-color:black;"><?php echo $v['secondquater']; ?></td>
                        <td style="text-align:center;border-color:black;"><?php echo $v['thirdquater']; ?></td>
                        <td style="text-align:center;border-color:black;"><?php echo $v['fourthquater']; ?></td>
                        <td style="text-align:center;border-color:black;">
                              <button disabled class="btn btn-success " type="submit"><i class="fa fa-check-circle"></i></button>
                          </td>
                        <?php endif; ?>
                        <?php if($v['submit_tag']==0):?>
                        <form role="form" action="<?php echo base_url('holiday/update_plan')?>" method="post" id="updateForm">
                          <input type="hidden" id="total" name="total" value="<?php echo $v['Totalday']; ?>"/>
                          <td style="text-align:center;border-color:black;"><input type="text" style="width:100px;" id='firstquater' name='firstquater' value="<?php echo $v['firstquater']; ?>"></td>
                          <td style="text-align:center;border-color:black;"><input type="text" style="width:100px;" id='secondquater' name='secondquater' value="<?php echo $v['secondquater']; ?>"></td>
                          <td style="text-align:center;border-color:black;"><input type="text" style="width:100px;" id='thirdquater' name='thirdquater' value="<?php echo $v['thirdquater']; ?>"></td>
                          <td style="text-align:center;border-color:black;"><input type="text" style="width:100px;" id='fourthquater' name='fourthquater' value="<?php echo $v['fourthquater']; ?>"></td>
                          <td style="text-align:center;border-color:black;">
                              <button class="btn btn-success" type="submit"><i class="fa fa-check-circle"></i></button>
                          </td>
                        </form>
                        <?php endif; ?>
                      </tr>
                  <!-- end plan_data -->
                  <?php endif; ?>
                </tbody>
                
              </table>
              <hr />
              <div>
              <h5><font color="red">（温馨提示：年假计划只能填写一次，提交后不可修改）</font></h5>
              </div>
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
      $("#planMainMenu").addClass('active');
      /*
      $('#planTable').DataTable({
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
      */
    });
    
    
  </script>
 