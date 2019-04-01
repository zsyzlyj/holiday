<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>
        月度个税信息
      </h1>
    </section>

  <!-- Main content -->
  <section class="content">
  <br />  <br /> 
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
            <div>
              <form action="<?php echo base_url('super_wage/searchtax')?>" class="form-horizontal" method="post" role="form">
              <fieldset>
                <legend></legend>
                <div class="form-group">
                  <label for="dtp_input1" class="col-md-1 control-label">月份选择</label>
                  <div class="input-group date form_datetime col-md-5" data-date-format="yyyy-mm" data-link-field="dtp_input1">
                    <?php if($chosen_month):?>
                    <input class="form-control" name="chosen_month" size="16" type="text" value="<?php echo $chosen_month;?>" readonly>
                    <?php else:?>
                    <input class="form-control" name="chosen_month" size="16" type="text" value="<?php echo date('Y-m');?>" readonly>
                    <?php endif;?>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                    <span class="input-group-btn"><a href="<?php echo base_url('super_wage/wage_tax_import') ?>" class="btn btn-warning" style="width:80px;margin-left:5px">上传</a></span>
                    <span class="input-group-btn"><button class='btn btn-info' style="width:80px;margin-left:5px">查询</button></span>
                    </form>
                    <span class="input-group-btn"><a href="javascript:void(0)" class="btn btn-danger"  style="width:80px;margin-left:5px" data-toggle="modal" data-target="#myModal">删除</a></span>
                    <div class="modal-month fade" tabindex="-1" data-backdrop="false" role="dialog" id="myModal">
                      <div class="modal-content-month">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4>请确认</h4>
                        </div>
                        <div class="modal-body">
                          <h4 style="text-align:left">确认删除吗？</h4>
                        </div>
                        <div class="modal-footer">
                          <form action='<?php echo base_url('super_wage/wage_tax_delete')?>' method='POST'>
                          <?php if($chosen_month):?>
                          <input type='hidden' value="<?php echo $chosen_month;?>" name='time'/>
                          <?php else:?>
                          <input type='hidden' value="" name='time'/>
                          <?php endif;?>
                          <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                          <button type="submit" class="btn btn-success btn-danger">确认删除</a>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </fieldset>
            </div>
            <hr />
            <?php if($chosen_month): ?>
            <h4>中山联通<?php echo date_format(date_create($chosen_month),"Y年m月");?>个税信息明细</h4>
            <hr />
            <?php endif;?>
            <div style="overflow:scroll;">
              <fieldset>
              <?php if($wage_tax): ?>
              <?php $counter=0;?>
              <table id="wageTable"class="table table-striped table-bordered table-responsive" style="white-space:nowrap;text-align: center;border-color:silver;">
                <thead>
                  <tr>
                    <th style="text-align:center;border-color:silver;">序号</th>
                    <?php foreach($wage_tax_attr as $k => $v):?>
                    <?php if($v!="" and $k!="date_tag"):?>
                      <th style="text-align:center;border-color:silver;"><?php echo $v;$counter++;?></th>
                    <?php endif;?>
                    <?php endforeach;?>
                  </tr>
                </thead>
                <tbody>
                  <?php $counterdata=0;$colorcounter=0;?>
                  <?php foreach($wage_tax as $a => $b): ?>
                    <?php if($colorcounter%2==0):?>
                    <tr style="border-color:silver;">
                    <?php elseif($colorcounter%2==1):?>
                    <tr style="border-color:silver;" class="info">
                    <?php endif;$colorcounter++;?>
                    <td style="border-color:silver;"><?php echo $colorcounter;?></td>
                    <?php foreach($b as $k => $v): ?>
                      <?php if($k!='date_tag' and $counterdata<$counter):?>
                      <td style="border-color:silver;"><?php echo $v;?></td>
                      <?php endif;$counterdata++;?>
                    <?php endforeach; $counterdata=0?>
                  </tr>
                  <?php endforeach; ?>
                  
                </tbody>
              </table>
              <hr />
              <div>
              <h3><?php echo $notice['title'];?></h3>
              <br />
              <div style="font-size:15"><?php echo str_replace('class="ql-align-justify"','class="ql-align-justify" style="line-height:150%"',$notice['content']);?></div>
              </div>
              <?php elseif($chosen_month!=""): ?>
                无当月个税信息记录
              <?php endif; ?>
              </fieldset>
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
      $("#taxInfo").addClass('active');
      $("#searchtaxMainMenu").addClass('active');
      $(".form_datetime").datetimepicker({
        bootcssVer:3,
        format: 'yyyy-mm',
        startView:3,
        minView:3,
        startDate:"2019-01",
        autoclose:true,
        pickerPosition: "-left"
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
        },
        //"order":[[1,"desc"]],    
      });
    });
    
    
  </script>
