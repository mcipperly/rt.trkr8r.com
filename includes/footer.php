<?php session_start(); ?>
<script type="text/javascript">
function adminLogin() {
vex.dialog.open({
  message: 'Please Log in:',
  input: '<div class=\"vex-custom-input-wrapper\">\n<input name=\"user\" type=\"text\"></div><div class=\"vex-custom-input-wrapper\"><input name=\"pass\" type=\"password\"></div>',
  callback: function(data) {
    if (data === false) {
      return console.log('Cancelled');
    }
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange=function() {
      if (xhr.readyState==4 && xhr.status==200) {
        if (xhr.responseText==1) {
          onsiteModeModal();
        } else {
          adminLoginFail();
        }
      }
    }
    xhr.open('POST','/admin_login.php',true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send('user='+data.user+'&pass='+data.pass);
  }
});
}
function adminLoginFail() {
vex.dialog.open({
  message: '<div style="color:#FF0000">Authentication Failed, please try again:</div>',
  input: '<div class=\"vex-custom-input-wrapper\">\n<input name=\"user\" type=\"text\"></div><div class=\"vex-custom-input-wrapper\"><input name=\"pass\" type=\"password\"></div>',
  callback: function(data) {
    if (data === false) {
      return console.log('Cancelled');
    }
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange=function() {
      if (xhr.readyState==4 && xhr.status==200) {
        if (xhr.responseText==1) {
          onsiteModeModal();
        } else {
          adminLoginFail();
        }
      }
    }
    xhr.open('POST','/admin_login.php',true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send('user='+data.user+'&pass='+data.pass);
  }
});
}
function onsiteModeModal() {
vex.dialog.open({
  message: 'Login successful - select destination:',
  buttons: [
      $.extend({}, vex.dialog.buttons.NO, { className: 'vex-dialog-button-primary', text: 'Admin Page', click: function($vexContent, event) {
          $vexContent.data().vex.value = 'adminpage';
          vex.close($vexContent.data().vex.id);
      }}),
      $.extend({}, vex.dialog.buttons.NO, { className: 'vex-dialog-button-primary', text: 'On-site Mode', click: function($vexContent, event) {
          $vexContent.data().vex.value = 'onsite';
          vex.close($vexContent.data().vex.id);
      }}),
      vex.dialog.buttons.NO
  ],
  callback: function(data) {
    var xhra = new XMLHttpRequest();
    xhra.onreadystatechange=function() {
      if(xhra.readyState==4 && xhra.status==200) {
        if (data=='onsite') {
          document.location = "/";
        } else if (data=='adminpage') { 
          document.location = "/admin/";
        } else {
          return;
        }
      }
    }
    xhra.open('POST','/admin_login.php',true);
    xhra.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhra.send('mode='+data);
  }
});
}
  
</script>
        <footer>
          <div class="row">
                <div class="twelve cols center">
                    <p>&copy;Rebuilding Together Pittsburgh 2015&nbsp;&nbsp;/&nbsp;&nbsp; <a href="<?php if(isset($_SESSION['user']) && isset($_SESSION['mode']) && $_SESSION['mode'] == 'admin') { ?>javascript:onsiteModeModal()<?php } else { ?>javascript:adminLogin()<?php } ?>"><?php if(isset($_SESSION['user'])) { if(isset($_SESSION['mode'])) { if($_SESSION['mode'] == "onsite") { print('Onsite Mode: '); } else { print('Logged In: '); } } print($_SESSION['user']); } else { ?>Staff Login<?php } ?></a>&nbsp;&nbsp;/&nbsp;&nbsp;<a href="mailto:vjohnson@rtpittsburgh.org">Contact Us With Any Questions</a>
                    </p>
                </div>
        </footer>
    </div><!-- /container -->
</body>

</html>
