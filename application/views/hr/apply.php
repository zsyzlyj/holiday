  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        弹性福利积分确认
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
                <tr style="border-color:silver">
                <?php $counter=1;?>
                <?php while($counter<=count($attr_data)):?>
                <?php if($attr_data['attr'.$counter]!=""):?>
                  <?php if(($counter-1)%3==0):?>
                  </tr><tr style="border-color:silver">
                  <?php endif;?>
                  <td style="border-color:silver"><?php echo $attr_data['attr'.$counter].'：'.$user_data['content'.$counter];?></td>
                <?php endif;?>
                <?php $counter++;?>
                <?php endwhile;?>
                </tr>
              </tbody>
            </table>
            <hr />
            <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" class="btn btn-info">提交申请</a>
            
            <!-- 弹窗 -->
            <div id="myModal" class="modal-apply fade" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <!-- 弹窗内容 -->
              <div class="modal-content-apply">
                <div class="modal-header">
                  <!--
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" ><font color="black">×</font></button>
                  -->
                  <div style="text-align:right">
                  <form action="<?php echo base_url('hr/submit_confirm');?>" style="margin:0px;display:inline;" method="POST">
                    <?php if($confirm_status==NULL):?>
                    <button type="submit" class="btn btn-success">提交申请</button>
                    <?php else:?>
                    <button disabled type="submit" class="btn btn-success">提交申请</button>
                    <?php endif;?>        
                  </form>
                  <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">关闭</button>
                  </div>
                </div>
                <!-- model-header-apply -->
                <div class="modal-body">
                  <iframe width="600" height="800" src="<?php echo base_url($url);?>"></iframe>
                </div>
                <!-- model-footer-apply -->
              </div>
              <!-- model-content-apply -->
            </div>
            <!-- model-apply -->
            
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
      $("#checkscore").addClass('active');
    });
    
  </script>