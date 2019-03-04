

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
  </section>

  <!-- Main content -->
  <section class="content">
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
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div class="box">
          <div class="box-body">
            <div class="row">
              <div class="col-md-6 col-xs-6">
              <form action="<?php echo base_url('super_wage/wage_doc_import') ?>" method="post"
                  name="frmPDFImport" id="frmPDFImport" enctype="multipart/form-data">
                  <div>
                      <label><h4>选择上传文件</h4></label> 
                      <hr />
                      <select id="groups" name="selected_type" onclick="t(this)">
                        <option value="">选择类别</option>
                        <?php foreach ($type_option as $k => $v): ?>
                          <option value="<?php echo $v['doc_type'] ?>"><?php echo $v['doc_type'] ?></option> 
                        <?php endforeach ?>
                        <option value="-1">自定义</option>
                      </select>
                      <input name="selected_type_input" id="select_custom" style="display:none"/>
                      <hr />
                      <h5><input type="file" name="file" id="file" accept=".pdf"/></h5>
                      <br />
                      <button type="submit" id="submit" name="import" class="btn btn-warning" >导入</button>
                  </div>
              </form>
              </div>
              <h4>文件类型列表</h4>
              <div class="col-md-6 col-xs-6">
              <hr />
              <?php if($wage_doc_order):?>
              <?php $option_order=$wage_doc_order;?>
              <?php else:?>            
              <?php $option_order=$type_option;?>
              <?php endif;?>
              <form id="type_form">
              <table id="type_table" class="table table-bordered table-striped" style="overflow:scroll;border-color:black;">
                <thead>
                  <th style="border-color:black;">序号</th>
                  <th style="border-color:black;">类别名</th>
                </thead>
                <tbody>
                  <?php foreach ($option_order as $k => $v): ?>
                  <tr style="cursor:move;border-color:black;">
                    <td style="border-color:black;"><?php echo $k+1;?></td>
                    <td id="doc_type<?php echo $k+1;?>" style="border-color:black;"><?php echo $v['doc_type']; ?></td>
                  </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
              <button name="ajax_submit" onclick="new_order()" class="btn btn-success" type="button">提交新顺序</button>
              </form>
              </div>
            </div>
            <hr />
            
            <?php foreach ($option_order as $k => $v): ?>
                <hr />
                <h3><?php echo $v['doc_type'];?><br/></h3>
                <hr />
                <div>
                <table id="wageDocTable<?php echo $k;?>" class="table table-bordered table-striped" style="overflow:scroll;" style="border-color:black;">
                  <thead>
                    <tr>
                      <th class="col-md-1">序号</th>
                      <th class="col-md-6">文件名</th>
                      <th class="col-md-3">上传时间</th>
                      <th class="col-md-2">操作</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $counter=0;?>
                    <?php $counter1=0;?>
                    <?php foreach($wage_doc as $a => $b):?>
                    <?php if($v['doc_type']==$b['doc_type']):?>
                    <?php $counter1++;?>
                    <tr>
                      <td><?php echo $counter1;?></td>
                      <td><a href='<?php echo base_url($b['doc_path']);?>' target="_blank"><?php echo $b['doc_name'];?></a></td>
                      <td><?php echo $b['number'];?></td>
                      <td>
                        <a href="javascript:void(0)" class="btn btn-danger" data-toggle="modal" data-target="#myModal<?php echo $counter;?>"><i class="fa fa-trash">删除</i></a>
                        <div class="modal-month fade" tabindex="-1" data-backdrop="false" role="dialog" id="myModal<?php echo $counter;?>">
                          <div class="modal-content-month">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4>请确认</h4>
                            </div>
                            <div class="modal-body">
                              <h4 style="text-align:left">确认删除吗？</h4>
                            </div>
                            <div class="modal-footer">   
                              <form action='<?php echo base_url('super_wage/wage_doc_delete')?>' method='POST'>
                              <input type='hidden' value="<?php echo $b['number']; ?>" name='time'/>
                              <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                              <button type="submit" class="btn btn-success btn-ok">确认删除</a>
                              </form>
                            </div>
                          </div><!-- /.modal-content -->
                        </div><!-- /.modal -->
                      </td>
                    </tr>
                    <?php endif;?>
                    <?php $counter++;?>
                  <?php endforeach;?>

                  </tbody>
                </table>
              </div>
            
              <?php endforeach;?>
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
        $("#uploadWageDoc").addClass('active');
        $("#uploadWageDocNav").addClass('active');
        $('tbody').sortable();
        $('.sorted_table').sortable();
        /*
          $('#wageDocTable'+$type_option).DataTable({
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
        
        }*/
        
    });
    function t(obj){
      if(obj.options[obj.selectedIndex].value == "-1")
        document.getElementById("select_custom").style.display="";
      else 
        document.getElementById("select_custom").style.display="none";
    }
    function post(URL, PARAMS){
        var temp = document.createElement("form");
        temp.action = URL;
        temp.method = "post";
        temp.style.display = "none";
        for (var x in PARAMS)
        {
            var opt = document.createElement("textarea");
            opt.name = x;
            opt.value = PARAMS[x];
            // alert(opt.name)
            temp.appendChild(opt);
        }
        document.body.appendChild(temp);
        temp.submit();
        return temp;
    } 
    function new_order(obj){
      var tb=document.getElementById('type_table');
      var rows=tb.rows;
      var type_array=new Array();
      for(var i=1;i<rows.length;i++){
        var cells=rows[i].cells;
        console.log(cells[1].innerHTML);
        //document.getElementById("type_form").innerHTML="<input name='order"+i+"' value='"+cells[1].innerHTML+"' type='hidden'/>";
        document.getElementById("type_form").innerHTML+="<input name='order"+i+"' value='"+cells[1].innerHTML+"' type='hidden'/>";
        //document.getElementById("type_form").innerHTML("<input name='order"+i+"' value='"+cells[1].innerHTML+"' type='hidden'/>");
        //建一个数组把这些数据存起来，最后放到post中传到后台，完成！
        type_array[i]=cells[1].innerHTML;

      }
      post('<?php echo base_url("super_wage/wage_doc_order")?>', type_array);
    }
  </script>