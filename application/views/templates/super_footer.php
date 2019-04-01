
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 0.1.0
    </div>
    <strong>Copyright &copy; 2018-<?php echo date('Y') ?>.</strong> All rights reserved.
  </footer>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

</body>
<script language="javascript">   
  var myTime = setTimeout("Timeout()", 1800000);   
  function resetTime() {   
      clearTimeout(myTime);   
      myTime = setTimeout('Timeout()', 1800000);   
  }  
  function Timeout() {   
      alert("您的登录已超时, 请点确定后重新登录!");   
      document.location.href='<?php echo base_url("super_auth/logout");?>';   
  }   
  document.documentElement.onkeydown=resetTime;  
  document.documentElement.onclick=resetTime;  
</script>

</html>
