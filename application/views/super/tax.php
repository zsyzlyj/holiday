

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
        <form action="<?php echo base_url('super_wage/tax_counter') ?>" method="post">
            <div>
            <fieldset>
              <div id="legend" class="">
                <legend class="">个税信息填写</legend>
              </div>
              <div class="control-group">
                <!-- Text input-->
                <label class="control-label" for="input01">每月偿还贷款金额</label>
                <div class="controls">
                  <input type="text" placeholder="" class="input-xlarge">
                  <p class="help-block">Supporting help text</p>
                </div>
              </div>
              <div class="control-group">
                <!-- Text input-->
                <label class="control-label" for="input01">子女教育费用</label>
                <div class="controls">
                  <input type="text" placeholder="placeholder" class="input-xlarge">
                  <p class="help-block">Supporting help text</p>
                </div>
              </div>
              <div class="control-group">
                <!-- Text input-->
                <label class="control-label" for="input01">继续教育费用</label>
                <div class="controls">
                  <input type="text" placeholder="placeholder" class="input-xlarge">
                  <p class="help-block">Supporting help text</p>
                </div>
              </div>
              <div class="control-group">
                <!-- Text input-->
                <label class="control-label" for="input01">大病医疗</label>
                <div class="controls">
                  <input type="text" placeholder="placeholder" class="input-xlarge">
                  <p class="help-block">Supporting help text</p>
                </div>
              </div>
              <div class="control-group">
                <!-- Prepended checkbox -->
                <label class="control-label">独生子女</label>
                <div class="controls">
                  <div class="input-prepend">
                    <span class="add-on">
                      <label class="checkbox">
                        <input type="checkbox" class="">
                      </label>
                    </span>
                    <input class="span2" placeholder="placeholder" type="text">
                  </div>
                  <p class="help-block">Supporting help text</p>
                </div>
              </div>
              <div class="control-group">
                <!-- Select Basic -->
                <label class="control-label">赡养老人数</label>
                <div class="controls">
                  <select class="input-xlarge">
                    <option>1</option>
                    <option>2</option>
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label"></label>

                <!-- Button -->
                <div class="controls">
                  <button class="btn btn-success">提交</button>
                </div>
              </div>
            </fieldset>
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
      $("#taxCounterMenu").addClass('active');
      $("#taxCounterNav").addClass('active');
    });
    
  </script>