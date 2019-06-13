  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        年度综合积分确认
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

          <div class="box col-md-12 col-xs-12">
            <div class="box-header">
            </div>
            <hr />
            <div class="box-body">
              <table class="table table-striped table-hover table-bordered" style="border-color:silver">
                <thead>
                </thead>
                <tbody>
                  <tr>
                    <td style="text-align:center;border-color:silver">姓名</td>
                    <td style="text-align:center;border-color:silver"><?php echo $user_data['content1'];?></td>
                    <td style="text-align:center;border-color:silver" colspan="2">部门</td>
                    <td style="text-align:center;border-color:silver" colspan="2"><?php echo $user_data['content3'];?></td>
                  </tr>
                  <tr>
                    <td style="text-align:center;border-color:silver">绩效积分</td>
                    <td style="text-align:center;border-color:silver">评定等级</td>
                    <td style="text-align:center;border-color:silver" colspan="2"><?php echo $user_data['content8'];?></td>
                    <td style="text-align:center;border-color:silver">绩效积分</td>
                    <td style="text-align:center;border-color:silver"><?php echo $user_data['content9'];?></td>
                  </tr>
                  <tr>
                    <td style="text-align:center;border-color:silver" rowspan="2">荣誉积分</td>
                    <td style="text-align:center;border-color:silver" colspan="5"><?php echo $user_data['content10'];?></td>
                    <!--<td style="text-align:center;border-color:silver" colspan="5">一星级荣誉<?php echo $user_data['content11'];?>分，二星级荣誉<?php echo $user_data['content12'];?>分，三星级荣誉<?php echo $user_data['content13'];?>分，四星级荣誉<?php echo $user_data['content14'];?>分，五星级荣誉<?php echo $user_data['content15'];?>分</td>
                  -->
                  </tr>
                  <tr>
                    <td style="text-align:center;border-color:silver" colspan="3">荣誉总积分</td>
                    <td style="text-align:center;border-color:silver" colspan="2"><?php echo $user_data['content16'];?></td>
                  </tr>
                  <tr>
                    <td style="text-align:center;border-color:silver" rowspan="4">专业能力认证积分</td>
                    <td style="text-align:center;border-color:silver">技术职称</td>
                    <td style="text-align:center;border-color:silver" colspan="2"><?php echo $user_data['content17'];?></td>
                    <td style="text-align:center;border-color:silver">认证积分</td>
                    <td style="text-align:center;border-color:silver"><?php echo $user_data['content18'];?></td>
                  </tr>
                  <tr>
                    <td style="text-align:center;border-color:silver">职业资格</td>
                    <td style="text-align:center;border-color:silver" colspan="2"><?php echo $user_data['content19'];?></td>
                    <td style="text-align:center;border-color:silver">认证积分</td>
                    <td style="text-align:center;border-color:silver"><?php echo $user_data['content20'];?></td>
                  </tr>
                  <tr>
                    <td style="text-align:center;border-color:silver">不同级认证</td>
                    <td style="text-align:center;border-color:silver" colspan="2"><?php echo $user_data['content21'];?></td>
                    <td style="text-align:center;border-color:silver">认证积分</td>
                    <td style="text-align:center;border-color:silver"><?php echo $user_data['content22'];?></td>
                  </tr>
                  <tr>
                    <td style="text-align:center;border-color:silver" colspan="3">专业能力认证总积分</td>
                    <td style="text-align:center;border-color:silver" colspan="2"><?php echo $user_data['content22'];?></td>
                  </tr>
                  <tr>
                    <td style="text-align:center;border-color:silver" rowspan="3">年度总积分</td>
                    <td style="text-align:center;border-color:silver" rowspan="2">总积分</td>
                    <td style="text-align:center;border-color:silver" colspan="4">其中</td>
                  </tr>
                  <tr>
                    <td style="text-align:center;border-color:silver">2017年度剩余积分</td>
                    <td style="text-align:center;border-color:silver">绩效积分</td>
                    <td style="text-align:center;border-color:silver">荣誉积分</td>
                    <td style="text-align:center;border-color:silver">认证积分</td>
                  </tr>
                  <tr>
                    <td style="text-align:center;border-color:silver"><?php echo $user_data['content23'];?></td>
                    <td style="text-align:center;border-color:silver"><?php echo $user_data['content7'];?></td>
                    <td style="text-align:center;border-color:silver"><?php echo $user_data['content9'];?></td>
                    <td style="text-align:center;border-color:silver"><?php echo $user_data['content16'];?></td>
                    <td style="text-align:center;border-color:silver"><?php echo $user_data['content22'];?></td>
                  </tr>
                  <tr>
                    <td style="text-align:center;border-color:silver" rowspan="8">员工确认</td>
                    <td style="text-align:center;border-color:silver" rowspan="8" colspan="5"><a href="javascript:void(0)" class="btn btn-success" data-toggle="modal" data-target="#myModal">我已阅知并确认上述结果</a></td>
                  </tr>
                </tbody>
              </table>
              <hr />
              <?php echo $notice['title'].'<br /><br />'.$notice['content'];?>
              <hr />
              
              <div class="modal-month fade" tabindex="-1" data-backdrop="false" role="dialog" id="myModal">
                <div class="modal-content-month">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4>请确认</h4>
                  </div>
                  <div class="modal-body">
                    信息确认无误？
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <form action="<?php echo base_url('hr/submit_confirm_sum');?>" style="margin:0px;display:inline;" method="POST">
                    <?php if($confirm_sum_status==NULL):?>
                    <button type="submit" class="btn btn-success btn-ok">信息确认无误</a>
                    <?php else:?>
                    <button disabled type="submit" class="btn btn-success btn-ok">信息确认无误</a>
                    <?php endif;?>
                    </form>
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal -->
            </div>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  
  <script type="text/javascript">
    $(document).ready(function() {
      $("#checksumscore").addClass('active');
    });
    
  </script>