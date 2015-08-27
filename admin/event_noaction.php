<?php
include ('../includes/admin-header.php'); 
include('validate.php');
require_once('../db/db.php');
include ('../includes/admin-sidebar.php'); 

if($_REQUEST['toggle_status']) {
	toggle_event_status($_REQUEST['id']);
}

if($_REQUEST['preset_id']) {
	$element_ids = get_export_preset($_REQUEST['preset_id']);

	$search['event_id'] = $_REQUEST['event_id'];
	
	$file_name = export_csv($element_ids, $search);
	Header("Location: ../export/{$file_name}");
}

$presets = get_export_presets();
$event = get_event($_REQUEST['id']);

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
                        $("a.add-event").click(function() {
                          $(".event_title").replaceWith("<input type=\"text\" value=\"" + $(".event_title").text() + "\" class=\"full-width\">");
                          $(".event_desc").replaceWith("<textarea rows=\"4\" class=\"full-width\">" + $(".event_desc").text() + "</textarea>");
                          $(".event_date").replaceWith("<input readonly type=\"text\" id=\"event_display\" value=\"" + $(".event_date").text() + "\">&nbsp;<input style=\"display: none;\" class=\"full-width\" type=\"text\" id=\"edp\" name=\"edp\" value=\"\"/>");
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
                                xhr.onreadystatechange=function() {
                                        if(xhr.readyState==4 && xhr.status==200) {
                                        if (data=='success') {
                                                        console.log('success');
                                                } else {
                                                        console.log('failure');
                                                }
                                        }
                                }
                                xhr.open('POST','save-event.php',true);
                                xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                                xhr.send('test');
                          });

                });
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
							<input type="hidden" name="id" value="<?php print($event['event_id'])?>" />
							<input type="hidden" name="toggle_status" value="1" />
<?php
if($event['status_id'] == 1) {
	$html = <<<EOS
							<button class="btn-open" style="cursor: default" disabled>Event is Open</button>
							<button type="submit" class="btn-closed-outline">Mark as Complete</button></a>
							<p><small><em>
								Marking this event as complete will add it to the Completed Events page. You will no longer be able to make additional changes unless you reopen the event.
							</em></small></p>
EOS;
}
else {
	$html = <<<EOS
							<button class="btn-closed" style="cursor: default" disabled>Event is Completed</button>
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
							<button onclick="document.getElementById('preset_id').value={$preset['preset_id']}" type="submit">Export {$preset['name']}</button>
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

				<div class="row">
					<p>This event hasn’t happened yet! Check back after your event date to view volunteers for this event and
						manage their affiliations and hours.</p>
				</div>   
			</div>  
		</div>

		<div>
			<div class="left"><a href="manage-events.php"><span class="fa fa-calendar"></span> Back to Manage Events</a></div>
			<div class="clear"></div>
		</div>  
	</div>
</div>
<?php include ('../includes/footer.php'); ?>
