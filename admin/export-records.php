<?php
include ('../includes/admin-header.php'); 
include('validate.php');
include ('../includes/admin-sidebar.php'); 
require_once('../db/db.php');

if($_REQUEST['element_ids'] || $_REQUEST['preset_id']) {
	$element_ids = ($_REQUEST['preset_id']) ? get_export_preset($_REQUEST['preset_id']) : $_REQUEST['element_ids'];

	if($_REQUEST['event_id'])
		$search['event_id'] = $_REQUEST['event_id'];
	
	if($_REQUEST['start_date'] && $_REQUEST['end_date']) {
		$search['start_date'] = $_REQUEST['start_date'];
		$search['end_date'] = $_REQUEST['end_date'];
	}
	
	$file_name = export_csv($element_ids, $search);
	Header("Location: ../export/{$file_name}");
}

$presets = get_export_presets();

$event_search = array("status_id" => 2, "sort_dir" => 1);
$events = get_events($event_search);
?>

<div class="container">
	<div class="admin-content-wrapper">
		<h1 class="admin-page-title"><span class="fa fa-file-excel-o"></span>&nbsp;Export Records</h1>
		<div class="row">
			<div class="twelve cols callout">
				<h2 class="callout-title">Choose Filter Method</h2>
				<div class="row">
					<div class="six cols">
						<input type="radio" name="primary_filter" value="by_date" class="big"><label>&nbsp;&nbsp;By Date Range</label>
					</div>
					<div class="six cols">
						<input type="radio" name="primary_filter" value="by_event" class="big"><label>&nbsp;&nbsp;By Event</label>
					</div>
				</div>
			</div>
		</div>
<!-- DONT SHOW THIS BOX UNTIL A PRIMARY FILTER IS CHOSEN, THEN DISPLAY WITH THE CORRESPONDING FILTER OPTION.
ALWAYS DISPLAY THE QUICK AND CUSTOM EXPORTS -->
		<form method="POST">
			<div class="row">
				<div class="twelve cols callout">
					<h2 class="callout-title">Create .CSV File</h2>
					<!-- DISPLAYS IF THE PRIMARY FILTER CHOSEN IS BY DATE -->
					<script type="text/javascript">
$(function() {
	$('#start_date').datepicker({
		showOn: "button",
		buttonImage: "../assets/imgs/cal-icon.png",
		buttonImageOnly: true,
		buttonText: "Date selector",
		showButtonPanel: true,

		altField: "#start_display",
		altFormat: "MM d, yy",

		dateFormat: "yy-mm-dd",
		
		showOtherMonths: true,
		selectOtherMonths: true,
		changeMonth: true,
		changeYear: true,
	});
	$('#end_date').datepicker({
		showOn: "button",
		buttonImage: "../assets/imgs/cal-icon.png",
		buttonImageOnly: true,
		buttonText: "Date selector",
		showButtonPanel: true,

		dateFormat: "yy-mm-dd",
		
		altField: "#end_display",
		altFormat: "MM d, yy",

		showOtherMonths: true,
		selectOtherMonths: true,
		changeMonth: true,
		changeYear: true,
   });
});
					</script>
					<h3>Select Date Range</h3>
					<div class="row">
						<div class="four cols">
							<input readonly class="full-width" type="text" id="start_display" value=""/>
						</div>
						<div class="one cols">
							<input style="display: none;" class="full-width" type="text" id="start_date" name="start_date" value=""/>
						</div>
						<div class="two cols">
							<p style="text-align: center;">to</p>            
						</div>
						<div class="four cols">
							<input readonly class="full-width" type="text" id="end_display" value=""/>
						</div>
						<div class="one cols">
							<input style="display: none;" class="full-width" type="text" id="end_date" name="end_date" value=""/>
						</div>
					</div>
					<!-- DISPLAYS IF THE PRIMARY FILTER CHOSEN IS BY EVENT -->
					<h3>Select Event</h3>
<?php

foreach($events as $key => $event) {
	if($key == 0) {
		$html = <<<EOS
					<select class="full-width" name="event_id" "id="event_id">
						<option value="0">--</option>
EOS;
		print($html);
	}
	
	$html = <<<EOS
						<option value="{$event['event_id']}">{$event['date']} - {$event['location']}</option>
EOS;
	print($html);
	
	if($key + 1 == sizeof($events)) {
		$html = <<<EOS
					</select>
EOS;
		print($html);
	}
}
?>
        
     <!-- FROM HERE DOWN, THESE DISPLAY WITH EITHER PRIMARY FILTER -->
					<h3>Quick Export</h3>
					<input type="hidden" name="preset_id" id="preset_id" value="" />
<?php
foreach($presets as $key => $preset) {
	if($key == 0) {
		$html = <<<EOS
					<div class="row">
EOS;
		print($html);
	}

	$html = <<<EOS
						<button onclick="document.getElementById('preset_id').value={$preset['preset_id']}">Export {$preset['name']}</button>
EOS;
	print($html);
	
	if($key + 1 == sizeof($presets)) {
		$html = <<<EOS
					</div>
EOS;
		print($html);
	}
}
?>
     <br>
        <h3>Or Custom Export</h3>
            <div class="row">
                <div class="four cols">
                <input type="checkbox" name="element_ids[]" value="1">&nbsp;First Name
                </div>
                <div class="four cols">
                <input type="checkbox" name="element_ids[]" value="2">&nbsp;Last Name
                </div>
                <div class="four cols">
                <input type="checkbox" name="element_ids[]" value="3">&nbsp;Age
                </div>
            </div>

            <div class="row">
                <div class="four cols">
                <input type="checkbox" name="element_ids[]" value="10">&nbsp;Phone
                </div>
                <div class="four cols">
                <input type="checkbox" name="element_ids[]" value="11">&nbsp;Email
                </div>
                <div class="four cols">
                <input type="checkbox" name="element_ids[]" value="13">&nbsp;Future Interest
                </div>
            </div>

            <div class="row">
                <div class="four cols">
                <input type="checkbox" name="element_ids[]" value="5">&nbsp;Address
                </div>
                <div class="four cols">
                <input type="checkbox" name="element_ids[]" value="6">&nbsp;Apt/Suite/Floor
                </div>
                <div class="four cols">
                <input type="checkbox" name="element_ids[]" value="7">&nbsp;City
                </div>
            </div>


            <div class="row">
                <div class="four cols">
                <input type="checkbox" name="element_ids[]" value="8">&nbsp;State
                </div>
                <div class="four cols">
                <input type="checkbox" name="element_ids[]" value="9">&nbsp;ZIP
                </div>
                <div class="four cols">
                <input type="checkbox" name="element_ids[]" value="4">&nbsp;Affiliation or Company
                </div>
            </div>

            <div class="row">
                <div class="four cols">
                <input type="checkbox" name="element_ids[]" value="12">&nbsp;Skills
                </div>
                <div class="four cols">
                    <input type="checkbox" name="element_ids[]" value="13">&nbsp;Hours
                </div>
                <div class="four cols">
                    <input type="checkbox" name="element_ids[]" value="14">&nbsp;Event
                </div>
            </div>
     <br>
            <input type="submit" value="Export">
        </form>
        <script type="text/javascript">
        function toggleAll() {
          var x = document.getElementsByName('element_ids[]');
          var cm = document.getElementById('checkmaster');
          var i;
          for (i = 0; i < x.length; i++) {
              if (x[i].type == "checkbox") {
                  x[i].checked = cm.checked;
              }
          }
        }
        function toggleOther(master,other) {
          var oth = document.getElementById(other);
          if(master.checked) {
            oth.checked = false;
          }
        }

        </script>
    </div>
    </div>
<?php include ('../includes/footer.php'); ?>
