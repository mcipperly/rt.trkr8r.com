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
function getEmail(email) {
  if(!validateEmail(email)) {
    document.getElementById('email').placeholder='Invalid email address entered';
    document.getElementById('email').value='';
    document.getElementById('email').style='border:1px solid red';
    return false
  }
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
      <form onsubmit="return getEmail(document.getElementById('email').value)" method="GET" action="/register.php">
        <input name="email" type="email" placeholder="email@example.com" id='email' value="" class="register-email">
        <button type="submit"><?php if(isset($_SESSION['mode'])) { print('Check In'); } else { print('Pre-register'); } ?></button>
      </form>
        <br>
        <a href="/under-18.php" class="under-18">
            <b>Under 18?</b> Click here to print our waiver!
        </a>
    </div>
</div>


<?php include ('includes/footer.php'); ?>
