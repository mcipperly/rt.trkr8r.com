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
    xhr.open('POST','admin_login.php',true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send('user='+data.user+'&pass='+data.pass);

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
