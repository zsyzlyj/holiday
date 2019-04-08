

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        公告编辑（年度综合积分）
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
            <!-- /.box-header -->
            <form role="form" action="<?php base_url('super_hr/hr_publish_wage') ?>" method="post" id="quill_form">
              <div class="box-body">
                <?php echo validation_errors(); ?>
                <div class="form-group">
                  <label for="title"><h4 class="box-title">公告标题</h4></label>
                  <input type="text" class="form-control" id="title" name="title"  autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="content"><h4 class="box-title">公告内容</h4></label>
                  <!--<textarea class="form-control" rows="10" name="content"></textarea>-->
                  <!-- 创建工具栏组件 -->
                  <div id="standalone-container">
                    <div id="toolbar-container">
                      <!--
                      <span class="ql-formats">
                        <select class="ql-font"></select>
                        <select class="ql-size"></select>
                      </span>
                      -->
                      <span class="ql-formats">
                        <button class="ql-bold"></button>
                        <button class="ql-italic"></button>
                        <button class="ql-underline"></button>
                        <button class="ql-strike"></button>
                      </span>
                      <span class="ql-formats">
                        <select class="ql-color"></select>
                        <select class="ql-background"></select>
                      </span>
                      <span class="ql-formats">
                        <button class="ql-header" value="1"></button>
                        <button class="ql-header" value="2"></button>
                        <button class="ql-blockquote"></button>
                        <button class="ql-code-block"></button>
                      </span>
                      <!--
                      <span class="ql-formats">
                        <button class="ql-script" value="sub"></button>
                        <button class="ql-script" value="super"></button>
                      </span>
                      <span class="ql-formats">
                        <button class="ql-header" value="1"></button>
                        <button class="ql-header" value="2"></button>
                        <button class="ql-blockquote"></button>
                        <button class="ql-code-block"></button>
                      </span>
                      <span class="ql-formats">
                        <button class="ql-list" value="ordered"></button>
                        <button class="ql-list" value="bullet"></button>
                        <button class="ql-indent" value="-1"></button>
                        <button class="ql-indent" value="+1"></button>
                      </span>
                      <span class="ql-formats">
                        <button class="ql-direction" value="rtl"></button>
                        <select class="ql-align"></select>
                      </span>
                      <span class="ql-formats">
                        <button class="ql-link"></button>
                        <button class="ql-image"></button>
                        <button class="ql-video"></button>
                        <button class="ql-formula"></button>
                      </span>
                      
                      <span class="ql-formats">
                        <button class="ql-clean"></button>
                      </span>
                      -->
                    </div>

                    <div id="quillArea"></div>
                    <textarea name="content" style="display:none" id="hiddenArea"></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" onclick="t(this)" class="btn btn-success">发布</button>
                <a href="<?php echo base_url('super_hr/notification') ?>" class="btn btn-warning">返回</a>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <script type="text/javascript">
    
    $(document).ready(function() {
      $("#hrNoticeNav").addClass('active');
      $("#publish_hr_score_sum").addClass('active');
    });
    
    var quill = new Quill("#quillArea", {
      modules: {
        formula: true,
        syntax: true,
        toolbar: '#toolbar-container'
      },
      placeholder: '请输入公告内容...',
      theme: 'snow'
    });
    function t(object){
      document.getElementById("hiddenArea").value=quill.container.firstChild.innerHTML;
    }
</script>