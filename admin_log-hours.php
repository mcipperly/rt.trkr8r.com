<?php include ('includes/header.php'); ?>

<div class="row interior-header">

    <div class="visible-phone">
        <div class="four cols sml-logo">
            <img src="assets/imgs/rt-logo.png">
        </div>

        <div class="eight cols">
            <h1>Admin <br><span>Log Volunteer Hours</span></h1>
        </div>
    </div>

    <div class="hidden-phone">
        <div class="eight cols">
            <h1 class="left">Admin <span>Log Volunteer Hours</span></h1>
        </div>

        <div class="four cols">
            <img src="assets/imgs/rt-logo_small.png" class="right">
        </div>
    </div>
</div>


<div class="clear"></div>
<h4><a href="admin.php">&laquo; Back to Admin Page</a></h4>

<form style="margin-top:30px">
    <h2 class="left"><b>Volunteer Name</b></h2>
    <h2 class="right"><b>Hours</b></h2>
    <div class="clear"></div>
    <br>
    <div class="log_vol-name">
        <span class="left">Amy DePalma</span>
        <input type="text" class="right" name="hours" size="1">
    </div>
    <hr class="clear">
    <div class="log_vol-name">
        <span class="left">Robert Collini</span>
        <input type="text" class="right" name="hours" size="1">
    </div>
    <hr class="clear">
    <div class="log_vol-name">
        <span class="left">Matthew Cipperly</span>
        <input type="text" class="right" name="hours" size="1">
    </div>
    <hr class="clear">
    <div class="log_vol-name">
        <span class="left">First Last</span>
        <input type="text" class="right" name="hours" size="1">
    </div>
    <hr class="clear">
    <div class="log_vol-name">
        <span class="left">Joe Bob</span>
        <input type="text" class="right" name="hours" size="1">
    </div>
    <div class="clear"></div>
    <input type="submit" value="Log Hours" class="right">
    <div class="clear"></div>
</form>

<?php include ('includes/footer.php'); ?>