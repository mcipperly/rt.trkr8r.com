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
            <h2>Name</h2>
        </div>
        <div class="four cols center">
            <h2>Hours</h2>
        </div>
    </div>
    <div class="row">
        <div class="eight cols">
            <b>Amy DePalma</b>
        </div>

        <div class="four cols center">
            <input type="text" class="full-width" name="hours">
        </div>
    </div>

    <div class="row">
        <div class="eight cols">
            <b>Rob Collini</b>
        </div>

        <div class="four cols center">
            <input type="text" class="full-width" name="hours">
        </div>
    </div>

    <div class="row">
        <div class="eight cols">
            <b>Matthew Cipperly</b>
        </div>

        <div class="four cols center">
            <input type="text" class="full-width" name="hours">
        </div>
    </div>

    <div class="row">
        <div class="eight cols">
            <b>First Last</b>
        </div>

        <div class="four cols center">
            <input type="text" class="full-width" name="hours">
        </div>
    </div>

    <input type="submit" value="Submit">
</form>

<?php include ('includes/footer.php'); ?>