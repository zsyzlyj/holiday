

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      年假文件汇总
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">holiday</li>
    </ol>
  </section>
  <br />
  <br />

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">
      <div id="messages"></div>

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
        <div class="box-body">
          <div style="overflow:scroll;">
            <table id="holidayDocTable" class="table table-striped" >
              <thead>
                <tr>
                  <th>日期</th>
                  <th>文件名</th>
                  <th>文件内容</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody>
                
                <?php foreach($holiday_doc as $k => $v):?>
                <tr>
                  <form action='<?php echo base_url('super_holiday/holiday_doc_delete')?>' method='POST'>
                  <td><?php echo $v['number'];?></td>
                  <td><?php echo $v['doc_name'];?></td>
                  <td><a href='<?php echo base_url($v['doc_path']);?>' target="_blank">浏览</a></td>  
                  <input type='hidden' value="<?php echo $v['doc_name']; ?>" name='doc_name'/>
                  <td><button class="btn btn-danger"><i class="fa fa-trash"> 删除</i></a></td>
                  </form>
                </tr>
                <?php endforeach;?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      </div>
    </div>  

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
    $(document).ready(function() { 
      $("#showHolidayDocNav").addClass('active');
      $("#uploadHolidayDoc").addClass('active');
      $('#holidayDocTable').DataTable({
        language: 
        {
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
            "oPaginate": 
            {
                "sFirst": "首页",
                "sPrevious": "上页",
                "sNext": "下页",
                "sLast": "末页"
            },
            "oAria": 
            {
                "sSortAscending": ": 以升序排列此列",
                "sSortDescending": ": 以降序排列此列"
            }
        }      
      });
    });
    
  </script>