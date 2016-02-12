<?php
require_once('db/db.php');
include ('includes/header.php');

$search['date'] = date("Y-m-d");
$events = get_events($search);

?>

<script type="text/javascript">
function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
} 
function getEmail() {
vex.dialog.prompt({
  message: 'Please enter your email address:',
  // placeholder: 'Email Address',
  input: '<input name="email" type="email" class="vex-dialog-prompt-input" placeholder="email@example.com" value=""><input type="checkbox" name="under18" id="under18" value="true"><label style="display:inline" for="under18"> <b>Under 18?</b> Check here to print our waiver!</label>',
  callback: function(value) {
    if(value.email||value.under18) {
      if(value.under18 === "true") {
        window.location.assign("/under-18.php");
      } else {
        if(validateEmail(value.email)) {
          window.location.assign("/register.php?email="+encodeURIComponent(value.email));
        } else {
          invalidEmail(value.email);
        }
      }
    }
  }
});
}
function invalidEmail(email) {
vex.dialog.prompt({
  message: '<div style="color:#FF0000">Please enter a valid email address:</div>',
  placeholder: 'Email Address',
  input: '<input name="email" type="email" class="vex-dialog-prompt-input" placeholder="email@example.com" value=""><input type="checkbox" name="under18" id="under18" value="true"><label style="display:inline" for="under18"> <b>Under 18?</b> Check here to print our waiver!</label>',
  callback: function(value) {
    if(value.email||value.under18) {
      if(value.under18 === "true") {
        window.location.assign("/under-18.php");
      } else {
        if (validateEmail(value.email)) {
          window.location.assign("/register.php?email="+encodeURIComponent(value.email));
        } else { 
          invalidEmail(value.email);
        }
      }
    }
  }
});
}
</script>

<?php if(isset($_GET['thanks'])) {
  ?>
<script type="text/javascript">
var vexdiag = vex.dialog.alert('<?php if($_GET['thanks'] == 1) { ?>Thanks for registering for <?php print($site_org) ?>!');
setTimeout(function() {
   vex.close(vexdiag.data().vex.id); }, 3000);<?php } elseif($_GET['thanks'] == 2) { ?>Thanks for registering with <?php print($site_org) ?>! Please visit the registration table upon arrival at your event!');<?php } else { ?>We\'ve already pre-registered you for <?php print($site_org) ?> - please check in with an event coordinator upon arrival to your event. Thank you!');<?php } ?>
</script>  
<?php } ?>

<div class="center">
    <img src="assets/imgs/rt-logo.png" class="logo">
</div>

<div class="row center welcome">
    <div class="twelve cols">
        <input name="email" type="email" placeholder="email@example.com" value="" class="register-email">
      
        <a href="#">
            <button onclick="getEmail()"><?php if(isset($_SESSION['mode'])) { print('Check In'); } else { print('Pre-register'); } ?></button>
        </a>
        
        <br>
        <a href="/under-18.php" class="under-18">
            <b>Under 18?</b> Click here to print our waiver!
        </a>
    </div>
</div>


<?php include ('includes/footer.php'); ?>
