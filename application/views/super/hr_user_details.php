

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
              <form action="">
              <table class="table" style="font-size:17px;font-family:微软雅黑;">
                <tr style="height:60px;">
                  <th style="font-size:25px" colspan="3">基本信息</th>
                </tr>
                <tr style="height:40px;">
                  <td style="width:300px">姓名：<input name="user_name" value="<?php echo $hr_data['content4'];?>"></td>
                  <td style="width:300px">婚姻信息：<input name="marry" value="<?php echo $hr_data['content11'];?>"></td>
                  <!--<td style="width:300px">入司时间：<?php echo $user_info['indate'];?></td>-->
                </tr>
                
                
              </table>
              <hr />
              <button type="submit" class="btn btn-success">提交修改</button>         
              <a href="javascript:void(0)" class="btn">返回</button>
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
 
