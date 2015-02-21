<?php include ('includes/header.php'); ?>

<script type="text/javascript">
function getEmail() {
vex.dialog.prompt({
  message: 'Please enter your email address:',
  placeholder: 'Email Address',
  callback: function(value) {
    return console.log(value);
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
            <button onclick="getEmail()">Register</button>
        </a>
    </div>
</div>


<?php include ('includes/footer.php'); ?>
