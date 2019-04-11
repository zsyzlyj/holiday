<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      证明人员搜索
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
              <form action="<?php echo base_url('super_wage/wage_proof');?>" method="post">
                <label>请输入要搜索的姓名</label>
                <input name="user_name"  value=""/>
                <button class='btn btn-info'><i class="fa fa-search"></i></button>
              </form>
              <hr />
              <?php if($keyword): ?>
                  <div style="overflow:scroll;">
                    <table id="wageTable"class="table table-bordered table-responsive" style="white-space:nowrap;text-align:center;border-color:silver;">
                      <thead>
                        <tr style="border-color:silver;">
                          <th style="border-color:silver;">姓名</th>
                          <th style="border-color:silver;">身份证</th>
                          <th style="border-color:silver;">证明类型选择</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($user_info as $k => $v): ?>
                        <tr style="border-color:silver;">
                          <?php foreach($v as $a => $b):?>
                            <td style="border-color:silver;"><?php echo $b;?></td>
                          <?php endforeach; ?>
                          <td style="border-color:silver;">
                            <form action="<?php echo base_url('super_wage/proof_creator');?>" method="POST" target="_blank" style="display:inline">
                            <input name="user_id" type="hidden" value="<?php echo $v['user_id'];?>">
                            <input name="type" type="hidden" value="收入证明">
                            <button class="btn">收入证明</button>
                            </form>
                            <form action="<?php echo base_url('super_wage/proof_creator');?>" method="POST" target="_blank" style="display:inline">
                            <input name="user_id" type="hidden" value="<?php echo $v['user_id'];?>">
                            <input name="type" type="hidden" value="收入证明（农商银行）">
                            <button class="btn">收入证明（农商银行）</button>
                            </form>
                            <form action="<?php echo base_url('super_wage/proof_creator');?>" method="POST" target="_blank" style="display:inline">
                            <input name="user_id" type="hidden" value="<?php echo $v['user_id'];?>">
                            <input name="type" type="hidden" value="收入证明（公积金）">
                            <button class="btn">收入证明（公积金）</button>
                            </form>
                          </td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                    <?php elseif($keyword!=""):?>
                    <h4>查无此人</h4>
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
      $("#wageProofMainMenu").addClass('active');

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
