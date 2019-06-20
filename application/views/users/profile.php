
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
              <table class="table" style="font-size:17px;font-family:微软雅黑;">
                <tr style="height:60px;">
                  <th style="font-size:25px" colspan="3">基本信息</th>
                </tr>
                <tr style="height:40px;">
                  <td style="width:300px">姓名：<?php echo $user_info['name'];?></td>
                  <td style="width:300px">性别：<?php echo $user_info['gender'];?></td>
                  <!--<td style="width:300px">入司时间：<?php echo $user_info['indate'];?></td>-->
                </tr>
                
                <tr style="border:none;height:40px;">
                  <td style="border:none;">部门：<?php echo $user_info['dept'];?></td>
                  <td style="border:none;">科室：<?php echo $user_info['office'];?></td>
                  <td style="border:none;;">岗位：<?php echo $user_info['position'];?></td>
                </tr>
                <tr style="border:none;height:40px;">
                  <td style="border:none;" colspan="3">合同签订公司：<?php echo $user_info['company'];?></td>
                </tr>
                <tr style="height:20px;"></tr>
                <tr style="height:60px;">
                  <th style="font-size:25px" colspan="3">婚育信息</th>
                </tr>
                <tr style="height:40px;">
                  <td style="width:300px">婚姻状态：<?php echo $user_info['marry'];?></td>
                  <!--<td style="width:300px">生育状况：<?php echo $user_info['child'];?></td>-->
                  <td style="width:300px"></td>
                </tr>
                
                <tr style="height:20px;"></tr>
                <tr style="height:60px;">
                  <th style="font-size:25px" colspan="3">教育信息</th>
                </tr>
                <tr style="height:40px;">
                  <td style="width:300px">全日制最高学历：<?php echo $user_info['ft_highest_qualification'];?></td>
                  <td style="width:300px">全日制最高学位：<?php echo $user_info['ft_highest_degree'];?></td>
                  <td style="width:300px"></td>
                </tr>
                <tr style="border:none;height:40px;">
                  <td style="border:none;">最高学历：<?php echo $user_info['highest_qualification'];?></td>
                  <td style="border:none;">最高学位：<?php echo $user_info['highest_degree'];?></td>
                  <td style="border:none;"></td>
                </tr>
                <tr style="height:20px;"></tr>
                <tr style="height:60px;">
                  <th style="font-size:25px" colspan="3">积分信息</th>
                </tr>
                <tr style="height:40px;">
                  <td style="width:300px">职级薪档：<?php echo $user_info['wage_level'];?></td>
                  <td style="width:300px">职级调整时间：<?php echo $user_info['wage_adjust_stamp'];?></td>
                  <td style="width:300px">薪档调整时间：<?php echo $user_info['level_adjust_stamp'];?></td>
                </tr>
                <?php if(strstr($func[0]['status'],'开启')):?>
                <tr>
                  <td style="border:none;">上年剩余积分：<?php echo $user_info['accumulation'];?></td>
                </tr>
                <?php endif;?>
                <tr style="height:20px;"></tr>
                <tr style="height:60px;">
                  <th style="font-size:25px" colspan="3">考核信息</th>
                </tr>
                <tr style="height:20px;">
                  <td style="width:300px">近三年考核结果：</td>
                  <td style="width:300px"></td>
                  <td style="width:300px"></td>
                </tr>
                <tr style="height:20px;">
                  <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                    <th style="text-align:center;"><?php echo date("Y")-3;?>年年度考核结果</th>
                    <th style="text-align:center;"><?php echo date("Y")-2;?>年年度考核结果</th>
                    <th style="text-align:center;"><?php echo date("Y")-1;?>年年度考核结果</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                    <td style="width:300px;text-align:center;"><?php echo $user_info['qian3'];?></td>
                    <td style="width:300px;text-align:center;"><?php echo $user_info['qian2'];?></td>
                    <td style="width:300px;text-align:center;"><?php echo $user_info['qian1'];?></td>
                    </tr>
                  </tbody>
                  </table>
                </tr>
                
              </table>
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
 
