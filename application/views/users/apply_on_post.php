

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        开具在职证明
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
              <table class="table table-striped table-responsive table-hover table-bordered">
                <thead>
                  <th>序号</th>
                  <th>名称</th>
                  <th>详情</th>
                  <th>提交状态</th>
                  <th>审核状态</th>
                </thead>
                <tbody>
                  <?php for($i=0;$i<count($name);$i++):?>
                  <tr>
                    <td><?php echo $i+1;?></td>
                    <td><?php echo $name[$i]?></td>
                    <td>
                      <!--
                      <?php if(!empty($status)):?>
                        <?php if($status[$i]):?>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal<?php echo $i;?>" class="btn btn-info">浏览</a>
                        <?php else:?>
                        <a disabled href="javascript:void(0)" data-toggle="modal" data-target="#myModal<?php echo $i;?>" class="btn btn-info">浏览</a>
                        <?php endif;?>
                      <?php else:?>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal<?php echo $i;?>" class="btn btn-info">浏览</a>
                      <?php endif;?>
                      -->
                      <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal<?php echo $i;?>" class="btn btn-info">浏览</a>
                      <!-- 弹窗 -->
                      <div id="myModal<?php echo $i;?>" class="modal-apply fade" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <!-- 弹窗内容 -->
                        <div class="modal-content-apply">
                          <div class="modal-header">
                            <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true" ><font color="black">×</font></button>
                            <h3><font color="black">样式预览</font></h3>
                            -->
                            <div style="text-align:right">
                            <form action="<?php base_url('wage/apply_wage_proof') ?>" style="margin:0px;display:inline;" method="post">
                              <input type="hidden" name="type" value="<?php echo $name[$i];?>"/>
                              <?php if(!empty($status)):?>
                                <?php if($status[$i]):?>
                                <button type="submit" class="btn btn-success">提交申请</button>
                                <?php else:?>
                                <button disabled type="submit" class="btn btn-success">提交申请</button>
                                <?php endif;?>
                              <?php else:?>
                              <button type="submit" class="btn btn-success">提交申请</button>
                              <?php endif;?>
                            </form>
                            <button class="btn btn-info" data-dismiss="modal" aria-hidden="true">关闭</button>
                            </div>
                          </div>
                          <!-- model-headerifram-apply -->
                          <div class="modal-body">
                            <iframe width="600" height="800" src="<?php echo base_url($url[$i]);?>"></iframe>
                          </div>
                          <!-- model-body-apply -->
                          <!-- model-footer-apply -->
                        </div>
                        <!-- model-content-apply -->
                      </div>
                      <!-- model-apply -->
                    </td>
                    <?php if(strstr($submit_status[$i],'已')):?>
                    <td><font color="green"><?php echo $submit_status[$i];?></font></td>
                    <?php elseif(strstr($submit_status[$i],'未')):?>
                    <td><font color="black"><?php echo $submit_status[$i];?></font></td>
                    <?php else:?>
                      <td>未提交</td>
                    <?php endif;?>
                    <?php if(strstr($feedback_status[$i],'已')):?>
                    <td><font color="green"><?php echo $feedback_status[$i]?></font></td>
                    <?php elseif(strstr($feedback_status[$i],'未')):?>
                    <td><font color="black">请于周三或周五下午前往人力部领取</font></td>
                    <?php else:?>
                      <td>未审核</td>
                    <?php endif;?>
                    
                  </tr>
                  <?php endfor;?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->  
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
      $("#applyProofMainMenu").addClass('active');
      $("#applyOnPostProof").addClass('active');
    });
    
  </script>