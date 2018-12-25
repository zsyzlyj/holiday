



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    
    <ol class="breadcrumb">
      <li><i class="fa fa-dashboard"></i> Home</li>
      <li class="active">Import</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <form action="<?php echo base_url('super_wage/wage_import') ?>" method="post">
            <div class="col-lg-3 col-md-3"><!-- 这个控制input的宽高   -->
                <div>
                    <input id="adddate" class="form-control" placeholder="申请日期范围" /> 
                    <span class="input-group-addon"><i class="fa-calendar-o"></i></span>
                </div>
            </div>
                <input onclick="a()" type="button" value="提交"/>   <!--  自己用来测试input中的内容   -->
            </div>
        </form>
      </div>
    </div>  

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
    $(document).ready(function() { 
      $("#wageSearchMainMenu").addClass('active');
      $('#adddate').daterangepicker({

      )};
    });
    
  </script>
