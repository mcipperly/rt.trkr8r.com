<?php
include ('../includes/admin-header.php'); 
include('validate.php');
include ('../includes/admin-sidebar.php'); 
require_once('../db/db.php');

if($_REQUEST['element_ids'] || $_REQUEST['preset_id']) {
	$element_ids = ($_REQUEST['preset_id']) ? get_export_preset($_REQUEST['preset_id']) : $_REQUEST['element_ids'];

	if($_REQUEST['event_id'])
		$search['event_id'] = $_REQUEST['event_id'];
	
	if(isset($_REQUEST['org_ids']) && !($_REQUEST['event_id'] || $_REQUEST['start_date']))
		$search['org_ids'] = $_REQUEST['org_ids'];
	
	if($_REQUEST['start_date'] && $_REQUEST['end_date']) {
		$search['start_date'] = $_REQUEST['start_date'];
		$search['end_date'] = $_REQUEST['end_date'];
	}

	$file_name = export_csv($element_ids, $search);
	Header("Location: ../export/{$file_name}");
}

$presets = get_export_presets();

$orgs = get_organizations();

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
					<div class="four cols">
						<input type="radio" name="primary_filter" value="by_date" class="big"><label>&nbsp;&nbsp;By Date Range</label>
					</div>
					<div class="four cols">
						<input type="radio" name="primary_filter" value="by_event" class="big"><label>&nbsp;&nbsp;By Event</label>
					</div>
					<div class="four cols">
						<input type="radio" name="primary_filter" value="by_org" class="big"><label>&nbsp;&nbsp;By Organization</label>
					</div>
				</div>
			</div>
		</div>
        <script>
            $(document).ready(function(){
                $('#show-by-date').hide();
                $('#show-by-event').hide();
                $('#show-by-org').hide();
                $('#show-by-all').hide();

                $("input[value=\"by_date\"]").click(function(){
                    $("#show-by-all").show();
                    $("#show-by-date").show();
                    $("#show-by-event").hide();
                    $("#show-by-org").hide();
                });
                
                $("input[value=\"by_event\"]").click(function(){
                    $("#show-by-all").show();
                    $("#show-by-event").show();
                    $("#show-by-date").hide();
                    $("#show-by-org").hide();
                });
                
                $("input[value=\"by_org\"]").click(function(){
                    $("#show-by-all").show();
                    $("#show-by-org").show();
                    $("#show-by-date").hide();
                    $("#show-by-event").hide();
                });

            });
        </script>
        
<!-- DONT SHOW THIS BOX UNTIL A PRIMARY FILTER IS CHOSEN, THEN DISPLAY WITH THE CORRESPONDING FILTER OPTION.
ALWAYS DISPLAY THE QUICK AND CUSTOM EXPORTS -->
		<form method="POST">					
            <div id="show-by-all">
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
                    <div id="show-by-date">
					<h3>Select Date Range</h3>
                        <div class="input_fields_wrap">
                            <input readonly type="text" class="date-picker-select" id="start_display" value="" placeholder="Start Date"/><input style="display: none;" type="text" id="start_date" name="start_date" value=""/><br>
                            <input readonly type="text" class="date-picker-select" id="end_display" value="" placeholder="End Date"/><input style="display: none;" type="text" id="end_date" name="end_date" value=""/><br><br>
                        </div>
                    </div>
                    
                    <div id="show-by-event">
					<!-- DISPLAYS IF THE PRIMARY FILTER CHOSEN IS BY EVENT -->
					<h3>Select Event</h3>
					<select class="full-width" name="event_id" id="event_id">
						<option value="0">--</option>
<?php

foreach($events as $key => $event) {
	$html = <<<EOS
						<option value="{$event['event_id']}">{$event['date']} - {$event['location']}</option>
EOS;
	print($html);
}
?>
					</select>
                    </div>
                    
                    <div id="show-by-org">
					<!-- DISPLAYS IF THE PRIMARY FILTER CHOSEN IS BY ORG -->
					<h3>Select Organization(s)</h3>
                          
                
                        <div class="input_fields_wrap" id="by_org_wrap">
                        <select name="org_ids[]" id="first_org_id" class="input_fields_input">
<?php
foreach($orgs as $org) {
	$html = <<<EOS
							<option value="{$org['company_id']}">{$org['name']}</option>
EOS;
	print($html);
}
?>
                        </select>
                   &nbsp;&nbsp;<img src="../assets/imgs/add-icon.png" class="add-input">
               </div>
                     <br>                      
<script type="text/javascript">
$(document).ready(function() {
    var max_fields      = 25; //maximum input boxes allowed
    var wrapper         = $("#by_org_wrap"); //Fields wrapper
    var add_button      = $(".add-input"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment

			var wrapper_for_clone = $('<div>');
			var my_clone = $('#first_org_id').clone();
			my_clone.attr('id', x + '_org_id');
			my_clone.appendTo($(wrapper_for_clone));
			$(wrapper_for_clone).append('&nbsp;&nbsp;<img src="../assets/imgs/remove-icon.png" class="remove-input">');
			$(wrapper_for_clone).appendTo($(wrapper));
        }
    });
    
    $(wrapper).on("click",".remove-input", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});                    
</script>
</div>
                    

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
						<button class="m-full-width" onclick="document.getElementById('preset_id').value={$preset['preset_id']}">Export {$preset['name']}</button>
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
        <h3><small>Or</small> Custom Export</h3>
            <form method="GET">
            <input type="hidden" name="export" value="true"></input>
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
                <input type="checkbox" name="element_ids[]" value="4">&nbsp;Organization
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
            <input type="submit" value="Export" class="m-full-width">
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
    </div>
<?php include ('../includes/footer.php'); ?>
