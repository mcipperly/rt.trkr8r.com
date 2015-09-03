<?php
include ('../includes/admin-header.php'); 
include('validate.php');
require_once('../db/db.php');
include ('../includes/admin-sidebar.php'); 

if($_REQUEST['toggle_status']) {
	toggle_event_status($_REQUEST['event_id']);
}

if($_REQUEST['preset_id']) {
	$element_ids = get_export_preset($_REQUEST['preset_id']);

	$search['event_id'] = $_REQUEST['event_id'];
	
	$file_name = export_csv($element_ids, $search);
	Header("Location: ../export/{$file_name}");
}

if($_REQUEST['update_all']) {
	if($_REQUEST['company_id'] >= 0)
		record_all_volunteer_company($_REQUEST['event_id'], $_REQUEST['company_id']);
	if((int) $_REQUEST['duration'] > 0)
		record_all_volunteer_time($_REQUEST['event_id'], $_REQUEST['duration']);
}

if($_REQUEST['update']) {
	foreach($_REQUEST as $key => $item) {
		$key_array = explode("_", $key);
		if($key_array[0] == "companyid")
			record_volunteer_company($key_array[1], $item);
		if($key_array[0] == "duration")
			record_volunteer_time($key_array[1], $_REQUEST['event_id'], $item);
	}
}

$presets = get_export_presets();
$event = get_event($_REQUEST['event_id']);

$orgs = get_organizations();

//testing($event);
?>

<div class="container">
	<div class="admin-content-wrapper">
		<h1 class="admin-page-title">
			<span class="fa fa-calendar"></span>&nbsp;
			<a href="manage-events.php">Manage Events</a>
			<span class="fa fa-angle-right"></span>&nbsp;
			<?php print($event['location']); ?>
		</h1>

		<div class="row">
			<div class="twelve cols callout">
				<h2 class="callout-title">Details <a href="#" class="add-event"><span class="fa fa-wrench"></span>&nbsp;Edit</a></h2>
                   <script>
                        $("a.add-event").click(eventEditMode);

                        function eventEditMode() {
                           $(".event_title").replaceWith("<input id=\"new_event_title\" type=\"text\" value=\"" + $(".event_title").text() + "\" class=\"full-width\">");
                           $(".event_desc").replaceWith("<textarea id=\"new_event_desc\" rows=\"4\" class=\"full-width\">" + $(".event_desc").text() + "</textarea>");
                           var eventDate = new Date($(".event_date").text());
                           $(".event_date").replaceWith("<span id=\"new_date_picker\"><input readonly type=\"text\" id=\"event_display\" value=\"" + $(".event_date").text() + "\">&nbsp;<input style=\"display: none;\" class=\"full-width\" type=\"text\" id=\"edp\" name=\"edp\" value=\"" + eventDate.toJSON().substring(0, eventDate.toJSON().indexOf("T")) + "\" /></span>");
                           $('#edp').datepicker({
                              showOn: "button",
                              buttonImage: "../assets/imgs/cal-icon.png",
                              buttonImageOnly: true,
                              buttonText: "Date selector",
                              showButtonPanel: true,
                              altField: "#event_display",
                              altFormat: "MM d, yy",
                              dateFormat: "yy-mm-dd",
                              showOtherMonths: true,
                              selectOtherMonths: true,
                              changeMonth: true,
                              changeYear: true,
                           });
                           $(".add-event").replaceWith("<a href=\"#\" class=\"add-event save-event\"><span class=\"fa fa-floppy-o\"></span>&nbsp;Save</a>");
                           $("a.save-event").click(function() {
                              var xhr = new XMLHttpRequest();
                              xhr.onreadystatechange = function() {
                                 if (xhr.readyState == 4 && xhr.status == 200) {
                                    if (xhr.responseText.indexOf('Success')) {
                                       console.log('success');
                                       eventReadMode();
                                    } else {
                                       console.log('failure');
                                    }
                                 }
                              }
                              xhr.open('POST', 'save-event.php', true);
                              xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                              xhr.send('event_id=<?php print($event['event_id ']); ?>&event_title=' + document.getElementById('new_event_title').value + '&event_desc=' + document.getElementById('new_event_desc').value + '&event_date=' + document.getElementById('edp').value);
                           });

                        }

                        function eventReadMode() {
                           $("#new_event_title").replaceWith("<h3 class=\"event_title\">" + document.getElementById('new_event_title').value + "</h3>");
                           $("#new_date_picker").replaceWith("<h4 class=\"event_date\">" + document.getElementById('event_display').value + "</h4>");
                           $("#new_event_desc").replaceWith("<p class=\"event_desc\">" + document.getElementById('new_event_desc').value + "</p>");
                           $(".save-event").replaceWith("<a href=\"#\" class=\"add-event save-event\">&nbsp;Update successful!&nbsp;<span class=\"fa fa-wrench\"></span>&nbsp;Edit</a>");
                           $("a.add-event").click(eventEditMode);
                        }
                    </script>

				<div class="row">
					<h3 class="event_title"><?php print($event['location']); ?></h3>
					<h4 class="event_date"><?php print(date("F j, Y", strtotime($event['date']))); ?></h4>
					<p class="event_desc"><?php print($event['note']); ?></p>
				</div>   
			</div>  
		</div>

		<div class="row">
			<div class="twelve cols callout">
				<h2 class="callout-title">Manage</h2>

				<div class="row">
					<div class="eight cols">
						<h3>Status</h3>
						<form method="POST">
							<input type="hidden" name="event_id" value="<?php print($event['event_id'])?>" />
							<input type="hidden" name="toggle_status" value="1" />
<?php
if($event['status_id'] == 1) {
	$html = <<<EOS
							<button class="btn-open m-full-width active-status" disabled>Event is Open</button>
							<button type="submit" class="m-full-width btn-closed-outline">Mark as Complete</button></a>
							<p><small><em>
								Marking this event as complete will add it to the Completed Events page. You will no longer be able to make additional changes unless you reopen the event.
							</em></small></p>
EOS;
}
else {
	$html = <<<EOS
							<button class="btn-closed active-status" disabled>Event is Completed</button>
							<button type="submit" class="btn-open-outline">Re-open Event</button></a>
							<p><small><em>
								Re-opening this event will add it to the Open Events page. You will be able to make changes to it until you mark the event as Complete again.
							</em></small></p>
EOS;
}
print($html);
?>
						</form>
					</div>

					<div class="four cols">
						<h3 class="phone-space-top">Quick Export</h3>
						<form method="POST">
							<input type="hidden" name="event_id" value="<?php print($event['event_id']); ?>" />
							<input type="hidden" id="preset_id" name="preset_id" value="" />
<?php
foreach($presets as $preset) {
	$html = <<<EOS
							<button class="m-full-width" onclick="document.getElementById('preset_id').value={$preset['preset_id']}" type="submit">Export {$preset['name']}</button>
EOS;
print($html);
}
?>
						</form>
					</div>            
				</div>   
			</div>  
		</div>

		<div class="row">
			<div class="twelve cols callout">
				<h2 class="callout-title">Volunteers</h2>
<?php
if(strtotime(date("Y-m-d")) < strtotime($event['date'])) {
	$html = <<<EOS
				<div class="row">
					<p>This event hasn’t happened yet! Check back after your event date to view volunteers for this event and
						manage their affiliations and hours.</p>
				</div>   
EOS;
	print($html);
}
elseif(count($event['volunteers']) == 0) {
	$html = <<<EOS
				<div class="row">
					<p>There are currently no volunteers for this event.</p>
				</div>   
EOS;
	print($html);
}
elseif($event['status_id'] == 1) {
	$html = <<<EOS
				<div class="row">
				<h3>Update ALl Volunteer Stats</h3>
				<form method="POST">
					<input type="hidden" name="event_id" value="{$event['event_id']}" />
					<input type="hidden" name="update_all" value="1" />
					<div class="row">
						<div class="five cols">
							<select name="company_id" class="full-width">
								<option value="-1">Organization/Affiliation</option>
EOS;
	foreach($orgs as $org) {
		$html .= <<<EOS
								<option value="{$org['company_id']}">{$org['name']}</option>
EOS;
	}
	$html .= <<<EOS
							</select>
						</div>
						<div class="five cols">
							<input type="text" class="full-width" name="duration" value="" placeholder="Hours (example: 8.00)" />
						</div>
						<div class="two cols">
							<input type="submit" value="Apply" class="btn full-width no-min">
						</div>
					</div>
				</form>
EOS;
	print($html);
	
	$html = <<<EOS
				<h3><small>OR</small> Update Individual Volunteer Stats</h3>
				<form method="POST">
					<input type="hidden" name="event_id" value="{$event['event_id']}" />
					<input type="hidden" name="update" value="1" />
					<table class="right-input">
						<tbody>
EOS;
	print($html);
	foreach($event['volunteers'] as $volunteer) {
		$volunteer['duration'] = sprintf("%01.2f", $volunteer['duration']);
		$html = <<<EOS
							<tr>
								<td data-label="Print Details" class="print_details"><a href="#"><span class="fa fa-print fa-lg"></span></a></td>
								<td data-label="Volunteer Name">{$volunteer['firstname']} {$volunteer['lastname']}</td>
								<td data-label="Org/Affiliation">
									<select name="companyid_{$volunteer['volunteer_id']}">
EOS;
		foreach($orgs as $org) {
			$selected_html = ($org['company_id'] == $volunteer['company']['company_id']) ? "selected" : "";
			$html .= <<<EOS
										<option value="{$org['company_id']}" {$selected_html}>{$org['name']}</option>
EOS;
		}

		$html .= <<<EOS
									</select>
								</td>
								<td data-label="Hours">
									<input type="text" name="duration_{$volunteer['volunteer_id']}" value="{$volunteer['duration']}"/>
								</td>
							</tr>
EOS;
		print($html);
	}
	
	$html = <<<EOS
						</tbody>
					</table>
					<input type="submit" class="btn right" value="Update Stats">
				</form>
			</div>
EOS;
	print($html);
}
elseif($event['status_id'] == 2) {
	$html = <<<EOS
			<div class="row">
				<table>
					<thead>
						<tr>
							<th class="print_details"></th>
							<th>Volunteer Name</th>
							<th>Affiliation</th>
							<th>Hours</th>
						</tr>
					</thead>
					<tbody>
EOS;

	foreach($event['volunteers'] as $volunteer) {
		$volunteer['duration'] = sprintf("%01.2f", $volunteer['duration']);
		
		$html .= <<<EOS
						<tr>
							<td data-label="Print Details" class="print_details"><a href="#"><span class="fa fa-print fa-lg"></span></a></td>
							<td data-label="Volunteer Name">{$volunteer['firstname']} {$volunteer['lastname']}</td>
							<td data-label="Affiliation">{$volunteer['company']['name']}</td>
							<td data-label="Hours">{$volunteer['duration']}</td>
						</tr>
EOS;
	}
	
	$html .= <<<EOS
					</tbody>
				</table>
			</div>
EOS;

	print($html);
}
?>
			</div>  
		</div>

		<div>
			<div class="left"><a href="manage-events.php"><span class="fa fa-calendar"></span> Back to Manage Events</a></div>
			<div class="clear"></div>
		</div>  
	</div>
</div>
<?php include ('../includes/footer.php'); ?>
