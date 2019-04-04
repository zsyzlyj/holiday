  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        文件下载
      </h1>      
    </section>
    <!-- Main content -->
    <section class="content">
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
            <div class="box-body">
              <div>
                <form class="form-horizontal" action="<?php echo base_url('super_wage/wage_export')?>" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
                  <fieldset>
                    <div id="legend" class="">
                      <legend class=""></legend>
                    </div>
                    <div class="form-group">
                      <label for="dtp_input1" class="col-md-1 control-label">开始月份</label>
                      <div class="input-group date form_datetime col-md-2" data-date="1979-09-16T05:25:07Z" data-date-format="yyyy-mm" data-link-field="dtp_input1">
                        <?php if($chosen_month):?>
                        <input class="form-control" id="datetimeStart" name="start_month" size="12" type="text" value="<?php echo $chosen_month;?>" readonly>
                        <?php else:?>
                        <input class="form-control" id="datetimeStart" name="start_month" size="12" type="text" value="单击选择月份" readonly>
                        <?php endif;?>
                      </div>
                      <label for="dtp_input1" class="col-md-1 control-label">结束月份</label>
                      <div class="input-group date form_datetime col-md-2" data-date="1979-09-16T05:25:07Z" data-date-format="yyyy-mm" data-link-field="dtp_input1">
                        <?php if($chosen_month):?>
                        <input class="form-control" id="datetimeEnd" name="end_month" size="12" type="text" value="<?php echo $chosen_month;?>" readonly>
                        <?php else:?>
                        <input class="form-control" id="datetimeEnd" name="end_month" size="12" type="text" value="单击选择月份" readonly>
                        <?php endif;?>
                      </div>
                      <!-- /.input-group -->               
                    </div>
                    
                    <p id="dept_options"></p>
                    <!-- Multiple Checkboxes -->
                    <div class="form-group" id="check_dept">
                      <label class="control-label col-md-1">选择部门</label>
                      <label class="control-label col-md-2">
                        <input class="input-group" type="checkbox" value="" onclick="checkdeptOnclick(this)">
                      </label>  
                    </div>
                    <div class="form-group" id="select_dept" style="display:none">
                      <!-- Select Basic -->
                      <label class="control-label col-md-1">选择部门</label>
                      <div class="input-group">
                        <select name="selected_dept" class="form-control">
                          <option value="all">全部部门</option>
                          <?php foreach($dept_set as $k => $v):?>
                          <option value="<?php echo $v['dept_name'];?>"><?php echo $v['dept_name'];?></option>
                          <?php endforeach; ?>                          
                        </select>
                      </div>
                    </div>
                    <div class="form-group" id="check_user">
                      <label class="control-label col-md-1">导入人员名单</label>
                      <label class="control-label col-md-2">
                        <input class="input-group" type="checkbox" value="" onclick="checkimportOnclick(this)">
                      </label>
                    </div>
                    
                    <div class="form-group" id="select_file" style="display:none">
                      <label class="control-label col-md-1">选择文件</label>
                      <div class="input-group">
                        <input class="" name="selected_user" id="fileInput" type="file" accept=".xls,.xlsx"/>
                      </div>
                    </div>
                    <hr />
                    <div>
                      <div class="input-group">
                        <button class="btn btn-success">下载</button>
                        <a class="btn btn-info" href="<?php echo base_url($path) ?>">人员名单模板下载</a>
                      </div>
                    </div>
                  </fieldset>
                </form>
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
      $("#downloadWageNav").addClass('active');
      
      $("#datetimeStart").datetimepicker({
          bootcssVer:3,
          format: "yyyy-mm",
          startView:3,
          minView:3,
          startDate:"2017-01",
          autoclose:true  
        }).on("changeDate",function(ev){
          if(ev.date){
              $("#datetimeEnd").datetimepicker('setStartDate', new Date(ev.date.valueOf()));
          }else{
              $("#datetimeEnd").datetimepicker('setStartDate',null);
          }
        });
      
      $("#datetimeEnd").datetimepicker({
        bootcssVer:3,
        format: "yyyy-mm",
        startView:3,
        minView:3,
        startDate:"2017-01",
        autoclose:true  
      }).on("changeDate",function(ev){
           //选择的日期不能小于第一个日期控件的日期
           if(ev.date){
                $("#datetimeStart").datetimepicker('setEndDate', new Date(ev.date.valueOf()));
           }else{
                $("#datetimeStart").datetimepicker('setEndDate',new Date());
           }
        });  
      });
      function checkdeptOnclick(checkbox){
        if (checkbox.checked == true){
          //Action for checked
          var ui = document.getElementById("select_dept");
          ui.style.display="";
          var ui = document.getElementById("check_user");
          ui.style.display="none";
          var ui = document.getElementById("select_user");
          ui.style.display="none";
        }else{
          //Action for not checked
          var ui = document.getElementById("select_dept");
          ui.style.display="none";
          var ui = document.getElementById("check_user");
          ui.style.display="";
        }  
      }
      function checkimportOnclick(checkbox){
        if (checkbox.checked == true){
          //Action for checked
          var ui = document.getElementById("check_dept");
          ui.style.display="none";
          var ui = document.getElementById("select_dept");
          ui.style.display="none";
          var ui = document.getElementById("select_file");
          ui.style.display="";
        }else{
          //Action for not checked
          var ui = document.getElementById("select_file");
          ui.style.display="none";
          var ui = document.getElementById("check_dept");
          ui.style.display="";
          var ui = document.getElementById("select_dept");
          ui.style.display="none";
        }
      }
  </script>