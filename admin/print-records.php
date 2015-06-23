<?php
include ('../includes/admin-header.php'); 
include ('../includes/admin-sidebar.php'); 
require_once('../db/db.php');
include('validate.php');

if($_REQUEST['email']) {
	$volunteer_id = validate_volunteer_email($_REQUEST['email']);
	if($volunteer_id)
		Header("Location: ../signature.php?view=1&vid={$volunteer_id}");
}
?>

<div class="container">
<div class="admin-content-wrapper">
<h1 class="admin-page-title"><span class="fa fa-print"></span>&nbsp;Print Records</h1>
<div class="row">
    <div class="twelve cols callout">
        <h2 class="callout-title">Records Lookup</h2>
        
        <h3>Lookup by Name</h3>
        <form method="POST">
            <div class="row">
                <div class="five cols">
                <input type="text" class="full-width" name="firstname" value="First">
                </div>
                
                <div class="five cols">
                <input type="text" class="full-width" name="lastname" value="Last">
                </div>

                <div class="two cols">
                <input type="submit" value="Search" class="full-width no-min">
                </div> 
            </div>
        </form>
        
        <h3>Lookup by Email</h3>
        <form method="POST">
            <div class="row">
                <div class="ten cols">
                <input type="email" class="full-width" name="email">
                </div>

                <div class="two cols">
                <input type="submit" value="Search" class="full-width no-min">
                </div> 
            </div>
        </form>
    </div>
    </div>


<?php include ('../includes/footer.php'); ?>
