<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      人员信息高级搜索
    </h1>
  </section>
 <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <a href="<?php echo base_url('super_hr/hr_transfer_import') ?>" class="btn btn-primary">上传人员信息</a>
        <div class="box">
          <div class="box-header">
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <p style="font-size:25px"><b>高级搜索</b></p>
            <hr />
            <form action="<?php echo base_url('super_hr/hr_transfer')?>" method="post">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-4">姓名：
                  <input name="name" type="text"/>
                </div>
                <!--
                <div class="col-md-4">性别：
                  <select class="selectpicker show-tick" multiple name="selected_gender[]"  data-actions-box="true" data-max-options="1">
                    <?php if($current_gender!=""):?>
                    <option value="<?php $current_gender;?>" selected="selected"><?php echo $current_gender;?></option>
                    <?php endif;?>
                    <?php foreach($gender_options as $k => $v):?>
                    <option value="<?php echo $v['attr4'];?>"><?php echo $v['attr4'];?></option>
                    <?php endforeach;?>
                  </select> 
                </div>
                <div class="col-md-4">部门：
                  <select id="selected_dept" name="selected_dept[]" class="selectpicker show-tick" multiple data-live-search="true" data-actions-box="true">
                  <?php if($current_dept!=""):?>
                  <option value="<?php $current_dept;?>" selected="selected"><?php echo $current_dept;?></option>
                  <?php endif;?>
                  <?php foreach($dept_options as $k => $v):?>
                    <option value="<?php echo $v['attr10'];?>"><?php echo $v['attr10'];?></option>
                  <?php endforeach;?>
                  </select>
                </div>
              </div>
              <br />
              <div class="row">
                <div class="col-md-4">科室：
                  <select id="selected_sect" name="selected_sect[]" class="selectpicker show-tick" multiple data-live-search="true" data-actions-box="true">
                  <?php if($current_sect!=""):?>
                  <option value="<?php $current_sect;?>" selected="selected"><?php echo $current_sect;?></option>
                  <?php endif;?>
                  <?php foreach($section_options as $k => $v):?>
                    <option value="<?php echo $v['attr11'];?>"><?php echo $v['attr11'];?></option>
                  <?php endforeach;?>
                  </select>
                </div>
                
                <div class="col-md-4">岗位：
                  <select id="selected_post" name="selected_post[]" class="selectpicker show-tick" multiple data-live-search="true" data-actions-box="true">
                  <?php if($current_post!=""):?>
                  <option value="<?php $current_post;?>" selected="selected"><?php echo $current_post;?></option>
                  <?php endif;?>
                  <?php foreach($post_options as $k => $v):?>
                    <option value="<?php echo $v['attr12'];?>"><?php echo $v['attr12'];?></option>
                  <?php endforeach;?>
                  </select>
                </div>
                
                <div class="col-md-4">婚育信息：
                  <select id="selected_marry" name="selected_marry[]" class="selectpicker show-tick" multiple data-actions-box="true" data-max-options="1">
                    <?php if($current_marry!=""):?>
                    <option value="<?php $current_marry;?>" selected="selected"><?php echo $current_marry;?></option>
                    <?php endif;?>
                    <?php foreach($marry_options as $k => $v):?>
                      <option value="<?php echo $v['attr11'];?>"><?php echo $v['attr11'];?></option>
                    <?php endforeach;?>
                  </select>
                </div>
                
              </div>
               
              <br />
              <div class="row">
                <div class="col-md-4">学历：
                  <select id="selected_degree" name="selected_degree[]" class="selectpicker show-tick" multiple data-live-search="true" data-actions-box="true">
                  <?php if($current_degree!=""):?>
                  <option value="<?php $current_degree;?>" selected="selected"><?php echo $current_degree;?></option>
                  <?php endif;?>
                  <?php foreach($degree_options as $k => $v):?>
                    <option value="<?php echo $v['attr44'];?>"><?php echo $v['attr44'];?></option>
                  <?php endforeach;?>
                  </select>
                </div>
                <div class="col-md-4">在职学历：
                  <select id="selected_equ_degree" name="selected_equ_degree[]" class="selectpicker show-tick" multiple data-live-search="true" data-actions-box="true">
                  <?php if($current_equ_degree!=""):?>
                  <option value="<?php echo $current_equ_degree;?>" selected="selected"><?php echo $current_equ_degree;?></option>
                  <?php endif;?>
                  <?php foreach($equ_degree_options as $k => $v):?>
                    <option value="<?php echo $v['attr51'];?>"><?php echo $v['attr51'];?></option>
                  <?php endforeach;?>
                  </select>
                </div>
                <div class="col-md-4">政治面貌：
                  <select id="selected_party" name="selected_party[]" class="selectpicker show-tick" multiple data-live-search="true" data-actions-box="true">
                    <?php if($current_party!=""):?>
                    <option value="<?php echo $current_party;?>"><?php echo $current_party;?></option>
                    <?php endif;?>
                    <?php foreach($party_options as $k => $v):?>
                      <option value="<?php echo $v['attr33'];?>"><?php echo $v['attr33'];?></option>
                    <?php endforeach;?>
                  </select>
                </div>
              </div>
              <br />
              <div class="row">
                <div class="col-md-4">岗位分类：
                  <select id="selected_post_type" name="selected_post_type[]" class="selectpicker show-tick" multiple data-live-search="true" data-actions-box="true">
                  <?php if($current_post_type!=""):?>
                  <option value="<?php $current_post_type;?>" selected="selected"><?php echo $current_post_type;?></option>
                  <?php endif;?>
                  <?php foreach($post_type_options as $k => $v):?>
                    <option value="<?php echo $v['attr18'];?>"><?php echo $v['attr18'];?></option>
                  <?php endforeach;?>
                  </select>
                </div>
                <div class="col-md-4">在职学历：
                  <select id="selected_equ_degree" name="selected_equ_degree[]" class="selectpicker show-tick" multiple data-live-search="true" data-actions-box="true">
                  <?php if($current_equ_degree!=""):?>
                  <option value="<?php echo $current_equ_degree;?>" selected="selected"><?php echo $current_equ_degree;?></option>
                  <?php endif;?>
                  <?php foreach($equ_degree_options as $k => $v):?>
                    <option value="<?php echo $v['attr51'];?>"><?php echo $v['attr51'];?></option>
                  <?php endforeach;?>
                  </select>
                </div>
                <div class="col-md-4">政治面貌
                  <select id="selected_party" name="selected_party[]" class="selectpicker show-tick" multiple data-live-search="true" data-actions-box="true">
                    <?php if($current_party!=""):?>
                    <option value="<?php echo $current_party;?>"><?php echo $current_party;?></option>
                    <?php endif;?>
                    <?php foreach($party_options as $k => $v):?>
                      <option value="<?php echo $v['attr33'];?>"><?php echo $v['attr33'];?></option>
                    <?php endforeach;?>
                  </select>
                </div>
                -->
              </div>
              <!-- /.row -->
            <hr />
            <div class="row">
            <!--
            <div class="col-md-12">
              <?php $counter=0;?>
              <?php if($column_name): ?>
                <table class="table">
                <thead></thead>
                <tbody>
                <tr>
                <?php foreach ($column_name as $k => $v): ?>
                <?php if($counter<$trueend):?>

                  <?php if(($counter+1)%6==0):?>
                  </tr><tr>
                  <?php else:?>
                  <td><input type="checkbox" value="<?php echo $v;?>"/><?php echo $v;?></td>
                  <?php endif;?>
                  <?php $counter++;?>
                <?php endif; ?>
                <?php endforeach ?>
                </tr>
                </tbody>
                </table>
              <?php endif;?>
              
            </div>
            -->
            </div>
            <div class="row">
            <div class="col-md-12">
              <button class="btn btn-primary">搜索</button>
            </div>
            </div>
            </form>           
            </div>
            
          </div>
          <!-- /.box-body -->
        </div>
        <div class="box">
          <div class="box-header">
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <hr />
            <div class="col-md-12 col-xs-12">
              <div style="overflow:scroll;">
                <table id="hrTable" class="table table-bordered table-striped" style="overflow:scroll;word-break:  keep-all;border-color:silver;">
                <thead>
                  <tr style="border-color:silver;">
                    <?php $counter=0;?>
                    <?php if($column_name): ?>
                      <?php foreach ($column_name as $k => $v): ?>
                      <?php if($counter<$trueend):?>
                        <?php if($v=='序号' or $v=='用工形式' or $v=='员工姓名' or $v=='身份证号码' or $v=='性别' or $v=='所在部门'):?>      
                          <?php if($v=='所在部门'):?>
                          <th style="border-color:silver;"><?php echo $v;?></th>
                          <th style="border-color:silver;">操作</th>
                          <?php break;?>
                          <?php else:?>
                          <th style="border-color:silver;"><?php echo $v;?></th>
                          <?php endif;?>
                        <?php endif;?>
                      <?php endif; ?>
                      <?php $counter++;?>
                      <?php endforeach ?>
                    <?php endif;?>
                  </tr>
                  </thead>
                  <tbody>
                    <?php if($hr_data): ?>                  
                      <?php foreach ($hr_data as $k => $v): ?>
                        <tr style="border-color:silver;">
                        <?php $counter=0;?>
                        <?php foreach($v as $a => $b):?>
                        <?php if($counter<$trueend):?>
                          <?php if($column_name['attr'.($counter+1)]=='序号' or $column_name['attr'.($counter+1)]=='用工形式' or $column_name['attr'.($counter+1)]=='员工姓名' or $column_name['attr'.($counter+1)]=='身份证号码' or $column_name['attr'.($counter+1)]=='性别' or $column_name['attr'.($counter+1)]=='所在部门'):?>      
                            <?php if($column_name['attr'.($counter+1)]=='身份证号码'):?>
                            <?php $user_id=$b;?>
                            <?php endif;?>
                            <?php if($column_name['attr'.($counter+1)]=='所在部门'):?>
                            <td style="border-color:silver;"><?php echo $b;?></td>
                            <td style="border-color:silver;">
                              <!--                              -->
                              <form id="user_details" action="<?php echo base_url('super_hr/user_details');?>" target="_blank" method="post">
                              <a href='javascript:void(0);' onclick="submitForm();">详细信息</a>

                              <input type="hidden" name="user_id" value="<?php echo $user_id;?>"/>
                              <!--
                              <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" onclick="submitForm();">详细信息</a>
                              <div class="modal-month fade" tabindex="-1" data-backdrop="false" role="dialog" id="myModal">
                                <div class="modal-content-month">
                                  <div class="modal-header" style="overflow:scroll;">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><font color="black">×</font></button>
                                    <h4 class="modal-title">详细信息</h4>
                                    </div>
                                  <div class="modal-body" style="">

                                    <h4 style="text-align:left">确认提交吗？</h4>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                    <button type="submit" class="btn btn-success btn-ok">确认提交</a>
                                  </div>
                                </div>
                              </div>
                              -->
                              </form>
                              <!---->
                            </td>
                            <?php break;?>
                            <?php else:?>
                            <td style="border-color:silver;"><?php echo $b;?></td>
                            <?php endif;?>
                          <?php endif;?>
                        <?php endif; ?>
                        <?php $counter++;?>
                        <?php endforeach ?>
                        </tr>
                      <?php endforeach ?>
                    <?php endif; ?>
                    
                  <!---->
                  </tbody>
                </table>
              </div>
                <!-- /.overflow:scroll -->
              </div>
              <hr />
            </div>
          </div>
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
<!-- /.row --><!--

              <!-- /.row -->

<script type="text/javascript">
    $(document).ready(function(){ 
      $("#hrTransferMenu").addClass('active');
      
      $('.selectpicker').selectpicker();

      $('#hrTable').DataTable({
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
    function submitForm(){
    //获取form表单对象
        var form = document.getElementById("user_details");
        form.submit();//form表单提交
    }
  </script>
