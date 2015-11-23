<?php
require_once('db/db.php');
include ('includes/login-header.php');

?>

<script>
function doLogin() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange=function() {
      if (xhr.readyState==4 && xhr.status==200) {
        if (xhr.responseText==1) {
          $("p").css('color', 'black');
          onsiteModeModal();
        } else {
          $("p").css('color', 'red');
        }
      }
    }
    xhr.open('POST','/admin_login.php',true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send('user='+document.getElementById('username').value+'&pass='+document.getElementById('password').value);
  }
</script>

    <section>
        <img src="assets/imgs/PaperOut_Logo_Horizontal.svg" onerror="this.src='assets/imgs/PaperOut_Logo_Horizontal.png'">
        <h2><?php print($site_org) ?></h2>
        <form action="javascript:void(0);">
           <p>Username</p>
           <input autocomplete="off" type="text" class="full-width" id="username" name="username" value="" placeholder="">
           <p id="pwtxt">Password</p>
           <input autocomplete="off" type="password" class="full-width" id="password" name="password" value="" placeholder="">
           <br>
           <input type="submit" value="Login" class="full-width no-min" onclick="doLogin()">
        </form>

    </section>

<?php include ('includes/footer.php'); ?>
