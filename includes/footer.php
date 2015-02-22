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
    xhr.open('POST','admin_login.php',false);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send('user='+data.user+'&pass='+data.pass);
    if (xhr.responseText==1) {
      onsiteModeModal();
    } else {
      adminLoginFail();
    }
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
    xhr.open('POST','admin_login.php',false);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send('user='+data.user+'&pass='+data.pass);
    if (xhr.responseText==1) {
      onsiteModeModal();
    } else {
      adminLoginFail();
    }
  }
});
}
</script>
        <footer>
          <div class="row">
                <div class="twelve cols center">
                    <p>&copy;Rebuilding Together Pittsburgh 2015.&nbsp;&nbsp;/&nbsp;&nbsp; <a href="javascript:adminLogin()">Staff Login</a>&nbsp;&nbsp;/&nbsp;&nbsp;<a href="mailto:vjohnson@rtpittsburgh.org">Contact Us With Any Questions</a>
                    </p>
                </div>
        </footer>
    </div><!-- /container -->
</body>

</html>
