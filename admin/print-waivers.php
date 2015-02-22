<?php
include ('../includes/header.php');
require_once('../db/db.php');

if($_REQUEST['email']) {
	$volunteer_id = validate_volunteer_email($_REQUEST['email']);
	if($volunteer_id)
		Header("Location: ../signature.php?view=1&vid={$volunteer_id}");
}
?>

<div class="row interior-header">

    <div class="visible-phone">
        <div class="four cols sml-logo">
            <img src="../assets/imgs/rt-logo.png">
        </div>

        <div class="eight cols">
            <h1>Admin <br><span>Print Signed Waivers</span></h1>
        </div>
    </div>

    <div class="hidden-phone">
        <div class="eight cols">
            <h1 class="left">Admin <span>Print Signed Waivers</span></h1>
        </div>

        <div class="four cols">
            <img src="../assets/imgs/rt-logo_small.png" class="right">
        </div>
    </div>
</div>
<div class="clear"></div>
<h4><a href="/admin/">&laquo; Back to Admin Page</a></h4>

<h2>Email Look Up</h2>
<form style="margin-top:15px" method="POST">
    <div class="row">
        <div class="nine cols">
        <input type="email" class="full-width" name="email">
        </div>
   
        <div class="three cols">
        <input type="submit" value="Search" class="full-width no-min" style="margin-top: -5px;">
        </div> 
    </div>
</form>

<?php include ('../includes/footer.php'); ?>