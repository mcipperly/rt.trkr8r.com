<?php include ('includes/header.php'); ?>

<script type="text/javascript">
function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
} 
function getEmail() {
vex.dialog.prompt({
  message: 'Please enter your email address:',
  placeholder: 'Email Address',
  callback: function(value) {
    if(value) {
      if(validateEmail(value)) {
        window.location.assign("/register.php?email="+encodeURIComponent(value));
      } else {
        invalidEmail(value);
      }
    }
  }
});
}
function invalidEmail(email) {
vex.dialog.prompt({
  message: '<div style="color:#FF0000">Please enter a valid email address:</div>',
  placeholder: 'Email Address',
  callback: function(value) {
    if(value) { 
      if (validateEmail(value)) {
        window.location.assign("/register.php?email="+encodeURIComponent(value));
      } else { 
        invalidEmail(value);
      }
    }
  }
});
}
</script>

<?php if(isset($_GET['thanks']) && $_GET['thanks'] == 1) {
  ?>
<script type="text/javascript">
var vexdiag = vex.dialog.alert('Thanks for registering for Rebuilding Together!');
setTimeout(function() {
   vex.close(vexdiag.data().vex.id); }, 3000);
  
</script>
<?php } ?>

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
