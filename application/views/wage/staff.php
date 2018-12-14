

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        工资信息
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Wage</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><font color="red">薪酬文件：</font></h3>
                </br>              </br>
                <h4>
                  <?php foreach($wage_doc as $k => $v):?>
                    <a href='<?php echo base_url($v['doc_path']);?>' target="_blank"><?php echo $v['doc_name']?></a>
                    <br />
                  <?php endforeach; ?>
                </h4>
            </div>
              <!-- /.box-header -->

            <div class="box-body">
              <div style="overflow:scroll;">
                <table id="wageTable"class="table table-striped table-bordered table-responsive" style="white-space: nowrap;word-break:  keep-all;text-align: center;">
                  <thead>
                  <?php if($wage_attr): ?>
                    <?php foreach($wage_attr as $k =>$v):?>
                      <th style="text-align:center;"><?php echo $v;?></th>
                    <?php endforeach; ?>
                    <?php endif; ?>
                  </thead>
                  <tbody>
                    
                    <?php if($wage_data): ?>
                    <tr>
                    <?php foreach($wage_data as $k =>$v):?>
                      <?php if($wage_attr[$k]=='月度绩效工资小计'):?>
                      <td>
                      <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal1"><font color='red'><?php echo $v['content'];?></font></a>
                      <!-- 模态框（Modal） -->
                      <div class="modal fade" id="myModal1" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        
                          <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel"><?php echo $v['type'];?></h4>
                            </div>
                            <div class="modal-body" style="overflow:scroll;">
                            <table class="table table-bordered table-responsive">
                              <thead>
                              <tr>
                              <?php foreach($fold_attr as $a => $b):?>
                              <?php if($b['type']==$v['type']):?>
                                <th style="text-align:center;"><?php echo $b['content'];?></th>
                              <?php endif; ?>
                              <?php endforeach; ?>
                              </tr>
                              </thead>
                              
                              <tbody>
                                <tr>
                                  <?php foreach($fold_data as $a => $b):?>
                                  <?php if($b['type']==$v['type']):?>
                                    <td><?php echo $b['content'];?></td>
                                  <?php endif; ?>
                                  
                                  <?php endforeach; ?>
                                </tr>
                              </tbody>
                            </table>
                            </div>
                          </div><!-- /.modal-content -->
                        </div><!-- /.modal -->
                      </div>
                      </td>
                      
                      <?php elseif($wage_attr[$k]=='省核专项奖励小计'):?>
                      <td>
                      <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal2"><font color='red'><?php echo $v['content'];?></font></a>
                      <!-- 模态框（Modal） -->
                      <div class="modal fade" id="myModal2" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        
                          <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel"><?php echo $v['type'];?></h4>
                            </div>
                            <div class="modal-body" style="overflow:scroll;">
                            <table class="table table-bordered table-responsive">
                              <thead>
                              <tr>
                              <?php foreach($fold_attr as $a => $b):?>
                              <?php if($b['type']==$v['type']):?>
                                <th style="text-align:center;"><?php echo $b['content'];?></th>
                              <?php endif; ?>
                              <?php endforeach; ?>
                              </tr>
                              </thead>
                              
                              <tbody>
                                <tr>
                                  <?php foreach($fold_data as $a => $b):?>
                                  <?php if($b['type']==$v['type']):?>
                                    <td><?php echo $b['content'];?></td>
                                  <?php endif; ?>
                                  
                                  <?php endforeach; ?>
                                </tr>
                              </tbody>
                            </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                <button type="button" class="btn btn-primary">提交更改</button>
                            </div>
                          </div><!-- /.modal-content -->
                        </div><!-- /.modal -->
                      </div>
                      </td>
                      <?php elseif($wage_attr[$k]=='分公司专项奖励小计'):?>
                      <td>
                      <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal3"><font color='red'><?php echo $v['content'];?></font></a>
                      <!-- 模态框（Modal） -->
                      <div class="modal fade" id="myModal3" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        
                          <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel"><?php echo $v['type'];?></h4>
                            </div>
                            <div class="modal-body" style="overflow:scroll;">
                            <table class="table table-bordered table-responsive">
                              <thead>
                              <tr>
                              <?php foreach($fold_attr as $a => $b):?>
                              <?php if($b['type']==$v['type']):?>
                                <th style="text-align:center;"><?php echo $b['content'];?></th>
                              <?php endif; ?>
                              <?php endforeach; ?>
                              </tr>
                              </thead>
                              
                              <tbody>
                                <tr>
                                  <?php foreach($fold_data as $a => $b):?>
                                  <?php if($b['type']==$v['type']):?>
                                    <td><?php echo $b['content'];?></td>
                                  <?php endif; ?>
                                  
                                  <?php endforeach; ?>
                                </tr>
                              </tbody>
                            </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                <button type="button" class="btn btn-primary">提交更改</button>
                            </div>
                          </div><!-- /.modal-content -->
                        </div><!-- /.modal -->
                      </div>
                      </td>
                      <?php elseif($wage_attr[$k]=='其他小计'):?>
                      <td>
                      <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal4"><font color='red'><?php echo $v['content'];?></font></a>
                      <!-- 模态框（Modal） -->
                      <div class="modal" id="myModal4" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel"><?php echo $v['type'];?></h4>
                            </div>
                            <div class="modal-body" style="overflow:scroll;">
                              <table class="table table-bordered table-responsive">
                                <thead>
                                <tr>
                                <?php foreach($fold_attr as $a => $b):?>
                                <?php if($b['type']==$v['type']):?>
                                  <th style="text-align:center;"><?php echo $b['content'];?></th>
                                <?php endif; ?>
                                <?php endforeach; ?>
                                </tr>
                                </thead>
                                
                                <tbody>
                                  <tr>
                                    <?php foreach($fold_data as $a => $b):?>
                                    <?php if($b['type']==$v['type']):?>
                                      <td><?php echo $b['content'];?></td>
                                    <?php endif; ?>
                                    
                                    <?php endforeach; ?>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <div class="modal-footer">
                            </div>
                          </div><!-- /.modal-content -->
                        </div><!-- /.modal -->
                      </div>
                      </td>
                      <?php elseif($wage_attr[$k]=='教育经费小计'):?>
                      <td>
                      <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal5"><font color='red'><?php echo $v['content'];?></font></a>
                      <!-- 模态框（Modal） -->
                      <div class="modal fade" id="myModal5" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        
                          <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel"><?php echo $v['type'];?></h4>
                            </div>
                            <div class="modal-body" style="overflow:scroll;">
                            <table class="table table-bordered table-responsive" >
                              <thead>
                              <tr>
                              <?php foreach($fold_attr as $a => $b):?>
                              <?php if($b['type']==$v['type']):?>
                                <th style="text-align:center;"><?php echo $b['content'];?></th>
                              <?php endif; ?>
                              <?php endforeach; ?>
                              </tr>
                              </thead>
                              
                              <tbody>
                                <tr>
                                  <?php foreach($fold_data as $a => $b):?>
                                  <?php if($b['type']==$v['type']):?>
                                    <td><?php echo $b['content'];?></td>
                                  <?php endif; ?>
                                  
                                  <?php endforeach; ?>
                                </tr>
                              </tbody>
                            </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                <button type="button" class="btn btn-primary">提交更改</button>
                            </div>
                          </div><!-- /.modal-content -->
                        </div><!-- /.modal -->
                      </div>
                      </td>
                      <?php elseif($wage_attr[$k]=='福利费小计'):?>
                      <td>
                      <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal6"><font color='red'><?php echo $v['content'];?></font></a>
                      <!-- 模态框（Modal） -->
                      <div class="modal fade" id="myModal6" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        
                          <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel"><?php echo $v['type'];?></h4>
                            </div>
                            <div class="modal-body" style="overflow:scroll;">
                            <table class="table table-bordered table-responsive">
                                <thead>
                                <tr>
                                <?php foreach($fold_attr as $a => $b):?>
                                <?php if($b['type']==$v['type']):?>
                                  <th style="text-align:center;"><?php echo $b['content'];?></th>
                                <?php endif; ?>
                                <?php endforeach; ?>
                                </tr>
                                </thead>
                                
                                <tbody>
                                  <tr>
                                    <?php foreach($fold_data as $a => $b):?>
                                    <?php if($b['type']==$v['type']):?>
                                      <td><?php echo $b['content'];?></td>
                                    <?php endif; ?>
                                    
                                    <?php endforeach; ?>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                <button type="button" class="btn btn-primary">提交更改</button>
                            </div>
                          </div><!-- /.modal-content -->
                        </div><!-- /.modal -->
                      </div>
                      </td>
                      <?php elseif($wage_attr[$k]=='扣款小计'):?>
                      <td>
                      <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal7"><font color='red'><?php echo $v['content'];?></font></a>
                      <!-- 模态框（Modal） -->
                      <div class="modal fade" id="myModal7" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        
                          <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel"><?php echo $v['type'];?></h4>
                            </div>
                            <div class="modal-body" style="overflow:scroll;">
                            <table class="table table-bordered table-responsive">
                                <thead>
                                <tr>
                                <?php foreach($fold_attr as $a => $b):?>
                                <?php if($b['type']==$v['type']):?>
                                  <th style="text-align:center;"><?php echo $b['content'];?></th>
                                <?php endif; ?>
                                <?php endforeach; ?>
                                </tr>
                                </thead>
                                
                                <tbody>
                                  <tr>
                                    <?php foreach($fold_data as $a => $b):?>
                                    <?php if($b['type']==$v['type']):?>
                                      <td><?php echo $b['content'];?></td>
                                    <?php endif; ?>
                                    
                                    <?php endforeach; ?>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                <button type="button" class="btn btn-primary">提交更改</button>
                            </div>
                          </div><!-- /.modal-content -->
                        </div><!-- /.modal -->
                      </div>
                      </td>
                      <?php else: ?>
                      <td><?php echo $v['content'];?></td>
                      <?php endif; ?>

                    <?php endforeach; ?>
                    </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
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
    $(document).ready(function() {
      $("#wageMainMenu").addClass('active');
    });
      
    
  </script>
 