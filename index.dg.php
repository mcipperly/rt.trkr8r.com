<?php include ( 'includes/header.php'); ?>

<div class="center">
    <img src="assets/imgs/rt-logo.png" class="logo">
</div>

<script type="text/javascript">

function getPreEmail() {
vex.dialog.prompt({
  message: 'Please enter your email address:',
  placeholder: 'Email Address',
  callback: function(value) {
    return console.log(value);
  }
});
}
</script>

<h1 class="center">Welcome! Choose Which Fits You Best</h1>
<div class="container">
<div class="row center welcome">
    <div class="one-third col">
        <a href="#">
            <button>I am Registering On-Site</button>
        </a>
    </div>

    <div class="one-third col">
        <a href="#">
            <button>I am Pre-Registering</button>
        </a>
    </div>

    <div class="one-third col">
        <a href="#">
            <button onclick="getPreEmail()">I Already Pre-Registered</button>
        </a>
    </div>
</div>

</div>


<?php include ( 'includes/footer.php'); ?>
