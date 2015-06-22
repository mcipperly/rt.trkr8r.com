<?php
include ('../includes/admin-header.php'); 
include('validate.php');
include ('../includes/admin-sidebar.php'); 
require_once('../db/db.php');

$readable_service_date = ($_REQUEST['service_date']) ? $_REQUEST['service_date'] : date("m/d/Y");
$service_date = date("Y-m-d", strtotime($readable_service_date));

if($_REQUEST['record']) {
	foreach($_REQUEST as $name => $value) {
		if(substr_count($name, "duration")) {
			$name_array = explode("_", $name);
			$volunteer_id = $name_array[1];
			record_volunteer_time($volunteer_id, $value, $service_date);
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
            <div class="row">
                <div class="five cols">
                    <h3>By Service Date</h3>
                        <script>
                        $(function() {
                        $( "#datepicker" ).datepicker();
                        });
                        </script>

                    <form method="POST">
                        <input class="u-full-width" type="text" id="datepicker" name="service_date" value="{$readable_service_date}"/>
                        <input type="submit" value="OK" />
                    </form>
                </div>
                
                <div class="seven cols">
                    <h3>By Volunteer Name</h3>

                    <form method="POST">
                        <input class="u-full-width" type="text" id="firstname" name="firstname" value="First" />
                        <br><input class="u-full-width" type="text" id="lastname" name="lastname" value="Last" />
                        <input type="submit" value="OK" />
                    </form>
                </div>
            </div>

EOS;
print($html);


foreach($volunteers as $key => $volunteer) {
	if($key == 0) {
		$html = <<<EOS
<form method="POST">
	<input type="hidden" name="record" value="1" />
	<input type="hidden" name="service_date" value="{$service_date}" />
    <h3 class="left">Volunteer Name</h3>
    <h3 class="right">Hours</h3>
    <div class="clear"></div>
    <br />
EOS;
		print($html);
	}
	
	$html = <<<EOS
    <div class="log_vol-name">
        <span class="left">{$volunteer['firstname']} {$volunteer['lastname']}</span>
        <input type="text" class="right" name="duration_{$volunteer['volunteer_id']}" size="3" value="{$volunteer['duration']}">
    </div>
    <hr class="clear">
EOS;
	print($html);

	if($key + 1 == sizeof($volunteers)) {
		$html = <<<EOS
    <input type="submit" value="Log Hours" class="right">
    <div class="clear"></div>
</form>
</div>
</div>
EOS;
		print($html);
	}
}

include ('../includes/footer.php');

?>
