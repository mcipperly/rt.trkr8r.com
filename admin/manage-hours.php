<?php
include ('../includes/admin-header.php'); 
include('validate.php');
include ('../includes/admin-sidebar.php'); 
require_once('../db/db.php');

$readable_service_date = ($_REQUEST['service_date']) ? $_REQUEST['service_date'] : date("m/d/Y");
$service_date = date("Y-m-d", strtotime($readable_service_date));

$companies = get_companies();

if($_REQUEST['record']) {
	if($_REQUEST['use_all']) {
		if($_REQUEST['duration_all'])
			record_all_volunteer_time($_REQUEST['duration_all'], $service_date);
		if($_REQUEST['company_id_all'])
			record_all_volunteer_company($_REQUEST['company_id_all'], $service_date);
	}
	else
		foreach($_REQUEST as $name => $value) {
			if(substr_count($name, "duration")) {
				$name_array = explode("_", $name);
				if($name_array[1] == "all")
					continue;
				$volunteer_id = $name_array[1];
				record_volunteer_time($volunteer_id, $value, $service_date);
			}
		
			if(substr_count($name, "company_id")) {
				$name_array = explode("_", $name);
				if($name_array[2] == "all")
					continue;
				$volunteer_id = $name_array[2];
				record_volunteer_company($volunteer_id, $value);
			}
		}
}

$volunteers = get_volunteers_of_day($service_date);

$html = <<<EOS
<div class="container">
<div class="admin-content-wrapper">
<h1 class="admin-page-title"><span class="fa fa-book"></span>&nbsp;Manage Hours</h1>
<div class="row">
    <div class="twelve cols callout">
        <h2 class="callout-title">Choose Management Method</h2>
            <h3>By Service Date</h3>
                <script>
                $(function() {
                $( "#datepicker" ).datepicker();
                });
                </script>

            <form method="POST">
            <div class="row">
                <div class="ten cols">
                <input class="full-width" type="text" id="datepicker" name="service_date" value="{$readable_service_date}"/>
                </div>
                <div class="two cols">
                <input type="submit" value="Go" class="full-width no-min">
                </div>
            </div>
            </form>

            <h3>By Name</h3>

            <form method="POST">
            <div class="row">
                <div class="five cols">
                <input class="full-width" type="text" id="firstname" name="firstname" value="First" />
                </div>
                <div class="five cols">
                <input class="full-width" type="text" id="lastname" name="lastname" value="Last" />
                </div>
                <div class="two cols">
                <input type="submit" value="Go" class="full-width no-min">
                </div>
            </div>    
            </form>

EOS;
print($html);


foreach($volunteers as $key => $volunteer) {
	if($key == 0) {
		$html = <<<EOS
        <div class="clear"></div>
        <h3>Today's Volunteers</h3>
<form method="POST">
	<input type="hidden" name="record" value="1" />
	<input type="hidden" name="service_date" value="{$service_date}" />
	<input type="hidden" name="use_all" id="use_all" value="" />
    <h4 class="left">Volunteer Name</h4>
    <h4 class="center">Affiliation</h4>
    <h4 class="right" style="padding-right:10px">Hours</h4>
    <div class="clear"></div>
EOS;
		print($html);
	}
	
	$html = <<<EOS
    <div class="log_vol-name">
        <span class="left">{$volunteer['firstname']} {$volunteer['lastname']}</span>
EOS;
	print($html);
	
	foreach($companies as $comp_key => $company) {
		if($comp_key == 0) {
			$html = <<<EOS
		<select name="company_id_{$volunteer['volunteer_id']}" class="">
EOS;
			print($html);
		}
		
		$selected_html = ($company['company_id'] == $volunteer['company_id']) ? "selected" : "";
		
		$html = <<<EOS
			<option label="{$company['name']}" value="{$company['company_id']}" {$selected_html}>{$company['name']}</option>
EOS;
		print($html);
		
		if($comp_key + 1 == sizeof($companies)) {
			$html = <<<EOS
		</select>
EOS;
		print($html);
		}
	}
	
	$html = <<<EOS
        <input type="text" class="right" name="duration_{$volunteer['volunteer_id']}" size="3" value="{$volunteer['duration']}">
    </div>
    <br class="clear">

EOS;
	print($html);

	if($key + 1 == sizeof($volunteers)) {
		$html = <<<EOS
    <input type="submit" value="Log Hours" class="right">
    <br class="clear">
    <div class="log_vol-name">
        <span class="left">Update All Volunteers</span>
EOS;
		print($html);
	
		foreach($companies as $comp_key => $company) {
			if($comp_key == 0) {
				$html = <<<EOS
		<select name="company_id_all" class="">
EOS;
				print($html);
			}
		
			$html = <<<EOS
			<option label="{$company['name']}" value="{$company['company_id']}">{$company['name']}</option>
EOS;
			print($html);
		
			if($comp_key + 1 == sizeof($companies)) {
				$html = <<<EOS
		</select>
EOS;
			print($html);
			}
		}
	
		$html = <<<EOS
        <input type="text" class="right" name="duration_all" size="3" value="">
    </div>
    <br class="clear">
    <input type="submit" value="Log Hours For All" onclick="document.getElementById('use_all').value=1;return true;" class="right">
    <div class="clear"></div>
</form>
</div>
</div>
</div>
EOS;
		print($html);
	}
}

include ('../includes/footer.php');

?>
