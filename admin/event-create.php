<?php
include('validate.php');
require_once('../db/db.php');
include ('../includes/admin-header.php');
include ('../includes/admin-sidebar.php');
?>

<div class="container">
	<div class="admin-content-wrapper">
		<h1 class="admin-page-title">
			<span class="fa fa-calendar"></span>&nbsp;
			<a href="event-create.php">Create Event</a>
		</h1>

		<div class="row">
			<div class="twelve cols callout">
				<h2 class="callout-title">Details </h2>
				<form action="./save-event.php" method="POST">
          <input name="event_title" type="text" placeholder="Event Location" class="full-width" />
          <textarea name="event_desc" rows="4" class="full-width" placeholder="Event Description"></textarea>
          <span id="date_picker"><input readonly type="text" id="event_display" placeholder="Date">&nbsp;<input style="display: none;" class="full-width" type="text" id="edp" name="event_date" /></span>
					<input type="submit" name="type" value="Create" class="right m-full-width" />
				</form>

				<script>
					$(document).ready(function() {
           $('#edp').datepicker({
              showOn: "button",
              buttonImage: "../assets/imgs/cal-icon.png",
              buttonImageOnly: true,
              buttonText: "Date selector",
              altField: "#event_display",
              altFormat: "MM d, yy",
              dateFormat: "yy-mm-dd",
              showOtherMonths: true,
              selectOtherMonths: true,
              changeMonth: true,
              changeYear: true,
           });
				 });
			 </script>
  			</div>
			</div>
		<div>
			<div class="left"><a href="manage-events.php"><span class="fa fa-calendar"></span> Back to Manage Events</a></div>
			<div class="clear"></div>
		</div>
	</div>
</div>
<?php include ('../includes/footer.php'); ?>
