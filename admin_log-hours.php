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
<form>
    <div class="row">
        <div class="eight cols">
            <h2><b>Volunteer Name</b></h2>
        </div>
        <div class="four cols">
            <h2><b>Hours</b></h2>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="eight cols log_vol-name">
            Amy DePalma
        </div>

        <div class="four cols">
            <input type="text" class="full-width" name="hours">
        </div>
    </div>
<hr>
    <div class="row">
        <div class="eight cols log_vol-name">
            Rob Collini
        </div>

        <div class="four cols">
            <input type="text" class="full-width" name="hours">
        </div>
    </div>
<hr>
    <div class="row">
        <div class="eight cols log_vol-name">
            Matthew Cipperly
        </div>

        <div class="four cols">
            <input type="text" class="full-width" name="hours">
        </div>
    </div>
<hr>
    <div class="row">
        <div class="eight cols log_vol-name">
            First Last
        </div>

        <div class="four cols">
            <input type="text" class="full-width" name="hours">
        </div>
    </div>

    <input type="submit" value="Log Hours" class="right">
</form>

<?php include ('includes/footer.php'); ?>