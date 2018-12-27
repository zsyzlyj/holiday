

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        公告历史
      </h1>
      <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> Home</li>
        <li class="active">Notification</li>
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
            
            <!-- /.box-header -->
            <div class="box-body">
              <div style="overflow:scroll;">
              
              <table id="wageTable" class="table table-bordered table-striped" style="overflow:scroll;" width="100%">
                <thead>
                <tr>
                  <th>发布时间</th>
                  <th>发布者</th>                
                  <th>标题</th>
                  <th>内容</th>
                  <th>分类</th>
                </tr>
                </thead>
                <tbody>
                  <?php if($notice_data): ?>                  
                    <?php foreach ($notice_data as $k => $v): ?>
                      <tr>
                        <td><?php echo $v['pubtime']; ?></td>
                        <td><?php echo $v['username']; ?></td>
                        <td><?php echo $v['title']; ?></td>
                        <td><?php echo $v['content']; ?></td>
                        <td><?php echo $v['type']; ?></td>

                        <td>
                            <!--<a href="<?php echo base_url('users/delete/'.$v['name']) ?>" class="btn btn-default"><i class="fa fa-trash"></i></a>-->
                        </td>

                      </tr>
                    <?php endforeach ?>
                  <?php endif; ?>
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
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
 <script type="text/javascript">
    $(document).ready(function() {

      $("#wageNoticeNav").addClass('active');
      $("#manage_wage_notice").addClass('active');
    });
  </script>