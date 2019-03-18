<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      人员明细查询
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
            <div class="col-md-12">
              <div>
                <form action="<?php echo base_url('super_wage/search')?>" class="form-horizontal" method="post" role="form">   
                  <input type="">
                </form>
              </div>
              <hr />
              <?php if($attr_data and $wage_data): ?>
              <div style="overflow:scroll;">
                <fieldset>
                <table id="wageTable"class="table table-striped table-bordered table-responsive" style="white-space:nowrap;text-align:center;border-color:silver;">
                  <thead>
                    <?php $counter=0;?>
                    <tr>
                      <?php foreach($attr_data as $k =>$v):?>

                      <?php endforeach; ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $counter=0;$colorcounter=0;?>
                    <?php foreach($wage_data as $k => $v): ?>
                      <?php if($colorcounter%2==0):?>
                      <tr style="border-color:silver;">
                      <?php elseif($colorcounter%2==1):?>
                      <tr style="border-color:silver;" class="info">
                      <?php endif;$colorcounter++;?>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
                </fieldset>
              </div>
              <?php endif; ?>
            </div>
            <!-- /.container -->
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
<!-- /.content-wrapper -->
<script type="text/javascript">
    $(document).ready(function(){ 
      $("#searchwageGetherMainMenu").addClass('active');
      $(".form_datetime").datetimepicker({
        bootcssVer:3,
        format: "yyyy-mm",
        startView:3,
        minView:3,
        startDate:"2017-01",
        autoclose:true  
      });
      $('#wageTable').DataTable({
        language:{
            "sProcessing": "处理中...",
            "sLengthMenu": "显示 _MENU_ 项",
            "sZeroRecords": "没有匹配结果",
            "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
            "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
            "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
            "sInfoPostFix": "",
            "sSearch": "搜索:",
            "sUrl": "",
            "sEmptyTable": "表中数据为空",
            "sLoadingRecords": "载入中...",
            "sInfoThousands": ",",
            "oPaginate":{
                "sFirst": "首页",
                "sPrevious": "上页",
                "sNext": "下页",
                "sLast": "末页"
            },
            "oAria":{
                "sSortAscending": ": 以升序排列此列",
                "sSortDescending": ": 以降序排列此列"
            }
        }      
      });
    
    }); 
  </script>
