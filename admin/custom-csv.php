<?php
include ('../includes/header.php'); 
include('validate.php');
require_once('../db/db.php');

if($_REQUEST['today'] || $_REQUEST['export']) {
	if($_REQUEST['preset_id'])
		$preset_id = $_REQUEST['preset_id'];
	elseif($_REQUEST['today'])
		$preset_id = 1;
	else
		$preset_id = 0;
	
	$element_ids = ($preset_id) ? get_export_preset($preset_id) : $_REQUEST['element_ids'];

	if($_REQUEST['service_date'])
		$service_date = $_REQUEST['service_date'];
	elseif($_REQUEST['today'])
		$service_date = date("Y-m-d");
	else
		$service_date = date("Y-m-d");
	
	$file_name = export_csv($element_ids, $service_date);
	Header("Location: ../export/{$file_name}");
}

?>

<div class="row interior-header">

    <div class="visible-phone">
        <div class="four cols sml-logo">
            <img src="../assets/imgs/rt-logo.png">
        </div>

        <div class="eight cols">
            <h1>Admin <br><span>Export Custom .CSV</span></h1>
        </div>
    </div>

    <div class="hidden-phone">
        <div class="eight cols">
            <h1 class="left">Admin <span>Export Custom .CSV</span></h1>
        </div>

        <div class="four cols">
            <img src="../assets/imgs/rt-logo_small.png" class="right">
        </div>
    </div>
</div>
<div class="clear"></div>
<h4><a href="/admin/">&laquo; Back to Admin Page</a></h4>

<h2>Select Which Details Include in the .CSV File</h2>

<form method="GET" style="margin-top:15px">
    <input type="hidden" name="export" value="true"></input>
    <div class="row">
        <div class="four cols">
        <input type="checkbox"> Check All
        </div>
        <div class="four cols">
        <input type="checkbox"> For MailChimp
        </div>
        <div class="four cols">
        <input type="checkbox"> For Mailing
        </div>
    </div>
    <h3 style="margin:10px 0 6px 0;font-weight:600; text-transform: uppercase">Custom Selection</h3>
    <div class="row">
        <div class="four cols">
        <input type="checkbox" name="firstname"> First Name
        </div>
        <div class="four cols">
        <input type="checkbox" name="lastname"> Last Name
        </div>
        <div class="four cols">
        <input type="checkbox" name="age"> Age
        </div>
    </div>
    
    <div class="row">
        <div class="four cols">
        <input type="checkbox" name="phone"> Phone
        </div>
        <div class="four cols">
        <input type="checkbox" name="email"> Email
        </div>
        <div class="four cols">
        <input type="checkbox" name="future_interest"> Future Interest
        </div>
    </div>
    
    <div class="row">
        <div class="four cols">
        <input type="checkbox" name="address1"> Address
        </div>
        <div class="four cols">
        <input type="checkbox" name="address2"> Apt/Suite/Floor
        </div>
        <div class="four cols">
        <input type="checkbox" name="city"> City
        </div>
    </div>
    
    
    <div class="row">
        <div class="four cols">
        <input type="checkbox" name="state"> State
        </div>
        <div class="four cols">
        <input type="checkbox" name="postalcode"> ZIP
        </div>
        <div class="four cols">
        <input type="checkbox" name="company"> Affiliation or Company
        </div>
    </div>
    
    <div class="row">
        <div class="four cols">
        <input type="checkbox" name="skills"> Skills
        </div>
        <div class="four cols">
        </div>
        <div class="four cols">
        </div>
    </div>
    <input type="submit" value="Export">
</form>

<?php include ('../includes/footer.php'); ?>
