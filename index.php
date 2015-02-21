<?php include ('includes/header.php'); ?>

<script type="text/javascript">
function getEmail() {
vex.dialog.prompt({
  message: 'Please enter your email address:',
  placeholder: 'Email Address',
  callback: function(value) {
    var emin = document.getElementById('email');
    emin.setAttribute('value', value);
    document.register.submit();
  }
});
}
</script>

<div class="center">
    <img src="assets/imgs/rt-logo.png" class="logo">
</div>

<div class="row center welcome">
    <div class="twelve cols">
        <a href="#">
            <form name="register" action="/register.php" method="POST">
                <button onclick="getEmail()">Register</button>
                <input type="hidden" name="email" id="email" value="">
            </form>
        </a>
    </div>
</div>


<?php include ('includes/footer.php'); ?>
