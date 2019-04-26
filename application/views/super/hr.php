
  <style name="silver-board" type="text/css">
    table,
    .tr {style="border-color:silver;"}
    .th {border-color:silver;}
    .td {border-color:silver;}
  </style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        人员信息
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
          
          <a href="<?php echo base_url('super_hr/hr_import') ?>" class="btn btn-primary">上传人员信息</a>
            <br /> <br />
          <div class="box">
            <div class="box-header">
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
              <h3>人员信息表</h3>
              <hr />
              <?php $counter=0;?>
              <?php if($column_name): ?>
              <table class="table">
                <thead></thead>
                <tbody>
                <tr>
                <?php foreach ($column_name as $k => $v): ?>
                <?php if($counter<$trueend):?>
                  <td><a href="javascript:void(0)" id="toggle-vis<?php echo $counter;?>" class="toggle-vis btn btn-default" data-column="<?php echo $counter;?>"><?php echo $v;?></a>
                  <?php if(($counter+1)%7==0):?>
                  </tr><tr>
                  <?php endif;?>
                  <?php $counter++;?>
                <?php endif; ?>
                <?php endforeach ?>
                </tr>
                </tbody>
              </table>
              <?php endif;?>
              <hr />
              <div style="overflow:scroll;">
              <table id="hrTable" class="table table-bordered table-striped silver-board display" style="overflow:scroll;word-break:keep-all;border-color:silver;">
              <thead>
                <tr style="border-color:silver;">
                  <?php $counter=0;?>
                  <?php if($column_name): ?>
                    <?php foreach ($column_name as $k => $v): ?>
                    <?php if($counter<$trueend):?>
                      <th style="border-color:silver;" class="hided"><?php echo $v;$counter++;?></th>
                    <?php endif;?>
                    <?php endforeach ?>
                  <?php endif;?>
                </tr>
                </thead>
                <tbody>
                  <?php $counter=0;?>
                  <?php if($hr_data): ?>                  
                    <?php foreach ($hr_data as $k => $v): ?>
                      <tr style="border-color:silver;">
                      <?php $counter=0;?>
                      <?php foreach($v as $a => $b):?>
                      <?php if($counter<$trueend):?>
                        <?php if($b!=''):?>
                        <td style="border-color:silver;" class="hided"><?php echo $b;$counter++;?></td>
                        <?php else:?>
                        <td style="border-color:silver;" class="hided"><?php $counter++;?></td>
                        <?php endif;?>
                      <?php endif;?>
                      <?php endforeach ?>
                      </tr>
                    <?php endforeach ?>
                  <?php endif; ?>
                <!---->
                </tbody>
              </table>
              </div>
              <!-- /.overflow:scroll -->
              <hr />
              <div class="col-md-12 col-xs-12">
                <h3>部门人数表</h3>
                <hr />
                <table id="deptTable" class="table table-bordered table-striped" style="overflow:scroll;word-break:  keep-all;">
                <thead>
                  <tr>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td></td>
                  </tr>
                </tbody>
                </table>
              </div>
              <hr />
              <div class="col-md-12 col-xs-12">
                <h3>入职/离职统计</h3>
                <hr />
                <table id="entryTable" class="table table-bordered table-striped" style="overflow:scroll;word-break:  keep-all;">
                <thead>
                  <tr>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td></td>
                  </tr>
                </tbody>
                </table>
              </div>
              <hr />
              <div class="col-md-12 col-xs-12">
                <h3>本月调动记录</h3>
                <hr />
                <table id="tranTable" class="table table-bordered table-striped" style="overflow:scroll;word-break:  keep-all;">
                <thead>
                  <tr>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td></td>
                  </tr>
                </tbody>
                </table>
              </div>
              <hr />
              <div class="col-md-12 col-xs-12">
                <h3>入职/离职统计</h3>
                <hr />
                <table>
                <thead>
                  <tr>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td></td>
                  </tr>
                </tbody>
                </table>
              </div>
              <hr />
              <div class="col-md-12 col-xs-12">
                <h3>统计图表</h3>
              </div>
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
    $(document).ready(function(){
      $("#hrMainMenu").addClass('active');
    
      var table=$('#hrTable').DataTable({
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
            },
        }
      });
      
      table.columns('.hided').visible(false);
      $("a.toggle-vis").on( 'click', function (e) {
          e.preventDefault();
          // Get the column API object
          var column = table.column( $(this).attr('data-column') );
          // Toggle the visibility
          column.visible( ! column.visible() );
          if($(this).attr('class').indexOf("info")!=-1){
            document.getElementById($(this).attr('id')).setAttribute('class','toggle-vis btn btn-default');
          }
          else{
            document.getElementById($(this).attr('id')).setAttribute('class','toggle-vis btn btn-info');
          }
      });
      
      $('#deptTable').DataTable({
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
      $('#entryTable').DataTable({
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
      $('#tranTable').DataTable({
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
 