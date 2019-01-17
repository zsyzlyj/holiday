

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        开具收入证明
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
              <table class="table">
                <thead>
                  <th>序号</th>
                  <th>名称</th>
                  <th>详情</th>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>收入证明</td>
                    <td>
                      <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" class="btn btn-warning">浏览</a>
                      <!-- 弹窗 -->
                      <div id="myModal" class="modal-apply fade" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <!-- 弹窗内容 -->
                        <div class="modal-content-apply">
                          <div class="modal-header-apply">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" ><font color="black">×</font></button>
                            <h3><font color="black">样式预览</font></h3>
                          </div>
                          <!-- model-header-apply -->
                          <div class="modal-body-apply">
                            <table class="table">
                              <tbody>
                                <tr>
                                  <td style="align:center"> 
                                    <iframe width="600" height="450" src="<?php echo base_url('wage/show_wage_proof') ?>"></iframe>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                          <!-- model-body-apply -->
                          <div class="modal-footer">
                            <button class="btn btn-info" data-dismiss="modal" aria-hidden="true">关闭</button>
                            <form action="<?php base_url('wage/apply_wage_proof') ?>" style="margin:0px;display:inline;" method="post">
                              <input type="hidden" name="type" value="标准收入证明"/>
                              <button class="btn btn-success">提交申请</button>
                            </form>
                          </div>
                          <!-- model-footer-apply -->
                        </div>
                        <!-- model-content-apply -->
                      </div>
                      <!-- model-apply -->
                    </td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <form role="form" action="<?php base_url('users/setting') ?>" method="post">
                    <td>收入证明（农商银行）</td>
                    <td><a href="<?php echo base_url('wage/show_bank_wage_proof') ?>" target="_blank" class="btn btn-warning">浏览</a> </td>
                    <td><button type="submit" class="btn btn-primary">提交申请</button></td>
                    </form>
                  </tr>
                  <tr>
                    <td>3</td>
                    <form role="form" action="<?php base_url('users/setting') ?>" method="post">
                    <td>收入证明（公积金）</td>
                    <td><a href="<?php echo base_url('wage/show_fund_proof') ?>" target="_blank" class="btn btn-warning">浏览</a> </td>
                    <td><button type="submit" class="btn btn-primary">提交申请</button></td>
                    </form>
                  </tr>
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
      $("#applyWageProof").addClass('active');
    });
    
  </script>