  <!-- Content Wrapper. Contains page content -->
  <!--<div class="content-wrapper" style="background:url('<?php echo base_url('assets/images/dashboardbg.jpg')?>');background-attachment:fix;background-repeat:norepeat;background-size:cover;);">-->
  
  <div class="content-wrapper" style="background:url('<?php echo base_url('assets/images/dashboardx.png')?>');background-attachment:fix;background-repeat:no-repeat;background-size:cover;);">
    <section class="content">
      <!--
      <div class="row">
        <div class="col-lg-3 col-xs-6 col-lg-offset-4">
          <!--<div class="small-box bg-aqua" style="cursor:pointer"  onclick="window.open('<?php echo base_url('holiday/staff');?>','_self')">
          -->
          <!--
          <div class="small-box bg-purple" style="cursor:pointer"  onclick="window.open('<?php echo base_url('holiday/staff');?>','_self')">
            <div class="inner">
              <h3>年假查询</h3>
              <p>Total Holiday</p>
            </div>
            <div class="icon">
              <i class="ion ion-home"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3 col-xs-6 col-lg-offset-4">
          <div class="small-box bg-red" style="cursor:pointer" onclick="window.open('<?php echo base_url('wage/staff');?>','_self')">
            <div class="inner">
              <h3>工资查询</h3>
              <p>Total Wage</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3 col-xs-6 col-lg-offset-4">
          <div class="small-box bg-yellow" style="cursor:pointer" onclick="window.open('<?php echo base_url('users/profile');?>','_self')">
            <div class="inner">
              <h3>个人信息</h3>
              <p>Personal Information</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-people"></i>
            </div>
          </div>
        </div>
      </div>
-->
      <div class="row" style="text-align:center;margin:30px auto 50px;"><img src="<?php echo base_url('assets/images/logo-left.png');?>" style="width:180px;height:100px;vertical-align:middle"><span style="vertical-align:bottom;font-size:36px">中山联通人力资源信息查询系统</span></div>
      <div class="row">
          <div class="mu-hero-featured-content">
            <div class="mu-event-counter-area">
              <!---->
              <span class="mu-event-counter-block div1 enlargeMe1 bg-aqua" style="margin-right:70px;cursor:pointer" onclick="window.open('<?php echo base_url('holiday/staff');?>','_self')"><span><font size="10px"><i class="fa fa-calendar"></i></font></span><span><p>年假查询</p></span></span>
              <span class="mu-event-counter-block div2 enlargeMe2 bg-green" style="margin-right:70px;cursor:pointer;" onclick="window.open('<?php echo base_url('wage/staff');?>','_self')"><span><font size="10px"><i class="fa fa-calculator"></i></font></span><span><p>工资查询</p></span></span>
              
              <span class="mu-event-counter-block div3 enlargeMe3 bg-orange" style="margin-right:70px;cursor:pointer" onclick="window.open('<?php echo base_url('users/profile');?>','_self')"><span><font size="10px"><i class="fa fa-users"></i></font></span><span><p>个人信息</p></span></span>
              <span class="mu-event-counter-block div4 enlargeMe4 bg-purple" style="cursor:pointer" onclick="javascript:void(0);"><span><font size="10px"><i class="fa fa-check-square-o"></i></font></span><span><p>积分确认</p></span></span>
              <!--<span class="mu-event-counter-block div4 enlargeMe4 bg-purple" style="cursor:pointer" onclick="window.open('<?php echo base_url('hr/confirm');?>','_self')"><span><font size="10px"><i class="fa fa-check-square-o"></i></font></span><span><p>积分确认</p></span></span>
              -->
            </div>
          </div>
      </div>
    </section>
  <!-- /.content -->
  <!--</div>-->

</div>
  <!-- /.content-wrapper -->
  
  <script type="text/javascript">
    $(document).ready(function() {
      $('.div1').on('mouseenter', function() {
        $('.enlargeMe1').css({
          '-webkit-transform' : 'scale(1.3)',
          '-moz-transform'    : 'scale(1.3)',
          '-ms-transform'     : 'scale(1.3)',
          '-o-transform'      : 'scale(1.3)',
          'transform'         : 'scale(1.3)',
        });
      });
      $('.div1').on('mouseleave', function() {
        $('.enlargeMe1').css({
          '-webkit-transform' : 'scale(1)',
          '-moz-transform'    : 'scale(1)',
          '-ms-transform'     : 'scale(1)',
          '-o-transform'      : 'scale(1)',
          'transform'         : 'scale(1)',
        });
      });
      $('.div2').on('mouseenter', function() {
        $('.enlargeMe2').css({
          '-webkit-transform' : 'scale(1.3)',
          '-moz-transform'    : 'scale(1.3)',
          '-ms-transform'     : 'scale(1.3)',
          '-o-transform'      : 'scale(1.3)',
          'transform'         : 'scale(1.3)',
        });
      });
      $('.div2').on('mouseleave', function() {
        $('.enlargeMe2').css({
          '-webkit-transform' : 'scale(1)',
          '-moz-transform'    : 'scale(1)',
          '-ms-transform'     : 'scale(1)',
          '-o-transform'      : 'scale(1)',
          'transform'         : 'scale(1)',
        });
      });
      $('.div3').on('mouseenter', function() {
        $('.enlargeMe3').css({
          '-webkit-transform' : 'scale(1.3)',
          '-moz-transform'    : 'scale(1.3)',
          '-ms-transform'     : 'scale(1.3)',
          '-o-transform'      : 'scale(1.3)',
          'transform'         : 'scale(1.3)',
        });
      });
      $('.div3').on('mouseleave', function() {
        $('.enlargeMe3').css({
          '-webkit-transform' : 'scale(1)',
          '-moz-transform'    : 'scale(1)',
          '-ms-transform'     : 'scale(1)',
          '-o-transform'      : 'scale(1)',
          'transform'         : 'scale(1)',
        });
      });
      $('.div4').on('mouseenter', function() {
        $('.enlargeMe4').css({
          '-webkit-transform' : 'scale(1.3)',
          '-moz-transform'    : 'scale(1.3)',
          '-ms-transform'     : 'scale(1.3)',
          '-o-transform'      : 'scale(1.3)',
          'transform'         : 'scale(1.3)',
        });
      });
      $('.div4').on('mouseleave', function() {
        $('.enlargeMe4').css({
          '-webkit-transform' : 'scale(1)',
          '-moz-transform'    : 'scale(1)',
          '-ms-transform'     : 'scale(1)',
          '-o-transform'      : 'scale(1)',
          'transform'         : 'scale(1)',
        });
      });
    });
  </script>
  <!-- Event Counter -->
  
