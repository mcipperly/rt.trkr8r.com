<?php
include ('../includes/admin-header.php'); 
include('validate.php');
require_once('../db/db.php');
include ('../includes/admin-sidebar.php'); 

if($_REQUEST['toggle_status']) {
	toggle_event_status($_REQUEST['id']);
}


$event = get_event($_REQUEST['id']);


?>

<div class="container">
	<div class="admin-content-wrapper">
		<h1 class="admin-page-title">
			<span class="fa fa-calendar"></span>&nbsp;
			<a href="manage-events.php">Manage Events</a>
			<span class="fa fa-angle-right"></span>&nbsp;
			This Event Is <?php print($event['status_name']); ?>
		</h1>

		<div class="row">
			<div class="twelve cols callout">
				<h2 class="callout-title">Details <a href="#" class="add-event"><span class="fa fa-wrench"></span>&nbsp;Edit</a></h2>

				<div class="row">
					<h3>This Event Is <?php print($event['status_name']); ?></h3>
					<h4><?php print(date("F j, Y", strtotime($event['date']))); ?> &bull; <?php print($event['location']); ?></h4>
					<p><?php print($event['note']); ?></p>
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
						<a href="#"><button>All Fields</button></a> <a href="#"><button>Postal Fields</button></a> <a href="#"><button>Email Fields</button></a>
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