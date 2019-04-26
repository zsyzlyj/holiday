

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        个人基本信息
      </h1>

    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">
          <div class="box">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form action="<?php echo base_url('super_hr/user_edit');?>" method="post">
              <?php $counter=0;?>
              <?php if($column_name): ?>
              <table class="table" style="font-size:17px;font-family:微软雅黑;">
                <table class="table">
                  <thead></thead>
                  <tbody>
                  <tr style="height:60px;">
                  <?php foreach ($data as $k => $v): ?>
                  <?php if($counter<$trueend):?>
                    <td style="width:200px"><?php echo $column_name['attr'.($counter+1)];?>：<input name="<?php echo $k;?>" value="<?php echo $v;?>"></td>
                    <?php if(($counter+1)%3==0):?>
                    </tr><tr style="height:60px;">
                    <?php endif;?>
                    <?php $counter++;?>
                  <?php endif; ?>
                  <?php endforeach ?>
                  </tr>
                  </tbody>
                </table>
              <?php endif;?>
              <hr />
              <button type="submit" class="btn btn-success">提交修改</button>         
              <a href="javascript:void(0)" class="btn">返回</a>
              </form>
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
      $("#userProfile").addClass('active');
    });
  </script>
 
