

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        部门年假计划
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
              <br/>
                <form action='<?php echo base_url('holiday/mydeptplan' )?>' method="post" id="selected_dept_form">
                <select id="selected_dept" name="selected_dept" onchange="submitForm();">
                  <?php if($current_dept==""):?>
                    <option value="">选择部门</option>
                  <?php else:?>
                    <option value="<?php $current_dept;?>"><?php echo $current_dept;?></option>
                  <?php endif; ?>
                  <?php foreach($dept_options as $k => $v):?>
                  <?php if($current_dept!=$v):?>
                    <option value="<?php echo $v;?>"><?php echo $v;?></option>
                  <?php endif;?>
                  <?php endforeach;?>
                </select>
                </form>
            </div>
            <div>
            <?php if($current_dept=='营业中心'):?>
              <h3>
                提交进度：<?php echo '<font color="green">'.$submitted.'</font> / '.count($domain)?>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <?php if(!strstr($submit_status,'已')):?>
                <?php if($submitted==count($domain)):?>
                <form style="margin:0px;display:inline;" action='<?php echo base_url('holiday/submit_to_audit') ?>' method='post'>
                  <input type='hidden' name='current_dept' value="<?php echo $current_dept;?>"/>
                  <a href="javascript:void(0)" class="btn btn-success" data-toggle="modal" data-target="#myModal">提交</a>
                  <div class="modal-month fade" tabindex="-1" data-backdrop="false" role="dialog" id="myModal">
                    <div class="modal-content-month">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><font color="black">×</font></button>
                          <h4 class="modal-title">审    核</h4>
                          </div>
                      <div class="modal-body">
                        <h4 style="text-align:left">确认提交吗？</h4>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-success btn-ok">确认提交</a>
                      </div>
                    </div><!-- /.modal-content -->
                  </div><!-- /.modal -->
                </form>
                <?php endif; ?>
                <?php if($submitted!=count($domain)):?>
                <button disabled class="btn btn-success disabled">提交</button>
                <?php endif; ?>
                <?php endif; ?>
                <?php if(strstr($submit_status,'已')):?>
                <button disabled class="btn btn-success disabled">提交</button>
                <?php endif; ?>

                
                <form style="margin:0px;display:inline;" action='<?php echo base_url('super_holiday/export_mydeptplan') ?>' method='post'>
                  <input type='hidden' name='current_dept' value="<?php echo $current_dept;?>"/>
                  <?php if(strstr($feedback['confirm_status'],'不同意')):?>
                  <button disabled class="btn btn-warning">导出</button>
                  <?php else:?>
                  <button class="btn btn-warning">导出</button>
                  <?php endif; ?>
                </form>
                </h3>
            <?php else: ?>
            <?php if($plan_data): ?>  
                <h3>
                提交进度：<?php echo '<font color="green">'.$submitted.'</font> / '.count($plan_data)?>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <?php if(!strstr($submit_status,'已')):?>
                
                <?php if($submitted==count($plan_data)):?>
                <form style="margin:0px;display:inline;" action='<?php echo base_url('holiday/submit_to_audit') ?>' method='post'>
                  <input type='hidden' name='current_dept' value="<?php echo $current_dept;?>"/>
                  <button class="btn btn-success">提交</button>
                </form>
                <?php endif; ?>
                <?php if($submitted!=count($plan_data)):?>
                <button disabled class="btn btn-success">提交</button>
                <?php endif; ?>
                <?php endif; ?>
                <?php if(strstr($submit_status,'已')):?>
                
                <button disabled class="btn btn-success">提交</button>
                <?php endif; ?>

                <form style="margin:0px;display:inline;" action='<?php echo base_url('super_holiday/export_mydeptplan') ?>' method='post'>
                  <input type='hidden' name='current_dept' value="<?php echo $current_dept;?>"/>
                  <?php if(strstr($feedback['confirm_status'],'同意')):?>
                  <button class="btn btn-warning">导出</button>
                  <?php else:?>
                  <button disabled class="btn btn-warning">导出</button>
                  <?php endif; ?>
                </form>
                </h3>
            <?php endif;?>
            <?php endif;?>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
              <div style="overflow:scroll;">
              <?php if($current_dept=='营业中心'):?>
              <table id="planTable" class="table table-bordered table-striped" style="overflow:scroll;table-layout:fixed">
                <thead>
                <tr>
                  <th>部门</th>
                  <th>负责人</th>
                  <th>进度</th>
                  <th>状态</th>
                </tr>
                </thead>
                <tbody>
                <?php if($domain):?>
                
                <?php foreach($domain as $k => $v):?>
                <tr>
                  <td><?php echo $v['dept'];?></td>
                  <td><?php echo $v['manager'];?></td>
                  <td style="align:center"><div class="progress"><?php echo $v['total'].' / '.$v['submitted'];?><div class="progress-bar" style="width:<?php echo ($v['submitted']/$v['total']).'%';?>;"></div></div></td>
                  <?php if(strstr($v['submit_status'],'未')):?>
                    <td><font color='red'><?php echo $v['submit_status'];?></font></td>
                  <?php elseif(strstr($v['submit_status'],'已')):?>
                    <td><font color='green'><?php echo $v['submit_status'];?></font></td>
                  <?php endif; ?>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
              </table>
              <?php else: ?>
              <?php if($plan_data):?>
              <table id="planTable" class="table table-bordered table-striped" style="overflow:scroll;table-layout:fixed">
                <thead>
                <tr>
                  <th>姓名</th>
                  <th>可休假总数</th>
                  <th>上年可休数</th>
                  <th>今年可休数</th>
                  <th>荣誉假期数</th>
                  <th>第一季度</th>
                  <th>第二季度</th>
                  <th>第三季度</th>
                  <th>第四季度</th>
                  <th>状态</th>
                  <th>操作</th>
                </tr>
                </thead>
                <tbody>
                
                    <?php foreach($plan_data as $k => $v): ?>
                      <tr>
                      
                        <td><?php echo $v['name']; ?></td>
                        <td><?php echo $v['Totalday']; ?></td>
                        <td><?php echo $v['Lastyear']; ?></td>
                        <td><?php echo $v['Thisyear']; ?></td>
                        <td><?php echo $v['Bonus']; ?></td>
                        <td><?php echo $v['firstquater']; ?></td>
                        <td><?php echo $v['secondquater']; ?></td>
                        <td><?php echo $v['thirdquater']; ?></td>
                        <td><?php echo $v['fourthquater']; ?></td>
                        
                        <?php if(strstr($v['submit_tag'],'已')):?>
                          <td><font color='green'><?php echo $v['submit_tag']; ?></font></td>
                        <?php else:?>
                          <td><font color='red'><?php echo $v['submit_tag']; ?></font></td>
                        <?php endif; ?>
                        <td>
                        <form action="<?php echo base_url('holiday/change_submit_mydeptplan')?>" method="post" style="float:left">
                        <input type="hidden" id='user_id' name='user_id' value="<?php echo $v['user_id'];?>"/>
                        <input type="hidden" id='submit_auth' name='submit_auth' value="1"/>
                        <input type="hidden" id='submit_revolt' name='submit_revolt' value="0"/>
                        <?php if(strstr($submit_status,'已') or strstr($v['submit_tag'],'未')):?>
                        <button  disabled class='btn btn-info'>允许重新填写</button>
                        <?php else:?>
                        <button class='btn btn-info'>允许重新填写</button>
                        <?php endif; ?>
                        </form>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  
                </tbody>
              </table>
              <?php endif;?>
              <?php endif;?>
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
      $('#myDeptPlanNav').addClass('active');
      $('#mydeptPlanMainMenu').addClass('active');
      $('#planTable').DataTable({
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
    
    function submitForm(){
    //获取form表单对象
        var form = document.getElementById("selected_dept_form");
        form.submit();//form表单提交
    }
    
  </script>
 