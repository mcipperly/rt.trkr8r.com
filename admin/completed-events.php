<?php
include('validate.php');
include '../db/db.php';
include ('../includes/admin-header.php');
include ('../includes/admin-sidebar.php');
?>

<div class="container">
<div class="admin-content-wrapper">
<h1 class="admin-page-title"><span class="fa fa-calendar"></span>&nbsp;<a href="manage-events.php">Manage Events</a> <span class="fa fa-angle-right"></span>&nbsp;Completed Events</h1>

<div class="row">
    <div class="twelve cols callout">
        <h2 class="callout-title">Completed Events</h2>
            <table class="respond">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Date</th>
                        <th>Vols.</th>
                        <th>Hours</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
<?php
$page = (int) $_REQUEST['page'];

if($_REQUEST['toggle_event_id']) {
	toggle_event_status($_REQUEST['toggle_event_id']);
}

//Find the twelve oldest (second twelve oldest etc) completed events
$search['status_id'] = 2; //Closed
$search['sort_dir'] = 1; //DESC
$search['count'] = 12;
$search['offset'] = 12 * $page;
$events = get_events($search);

//If there are no events for this non-first page, go back a page
if(!$events && $page > 0) {
	$prev_page = $page - 1;

	Header("HTTP/1.1 302 Moved Temporarily");
	Header("Location: /admin/completed-events.php?page={$prev_page}");
}

foreach($events as $event) {
	$event_date = date("m/d/Y", strtotime($event['date']));
	$event_vols = number_format($event['totals']['volunteers']);
	$event_dur = number_format($event['totals']['duration'], 2);
	$html = <<<EOS
                    <tr>
                        <td data-label="Event">{$event['location']}</td>
                        <td data-label="Date">{$event_date}</td>
                        <td data-label="Volunteers">{$event_vols}</td>
                        <td data-label="Hours">{$event_dur}</td>
                        <td data-label="Details"><a href="event-details.php?event_id={$event['event_id']}"><button>View</button></a></td>
                    </tr>
EOS;
	print($html);
}
?>
                </tbody>
            </table>
<?php
$show_left_link = ($page > 0);
$show_right_link = (sizeof($events) == 12);

if($show_left_link || $show_right_link) {
	$html = <<<EOS
            <div>
EOS;
	print($html);
}

if($show_left_link) {
	$html = <<<EOS
                <div class="left"><a href="#"><span class="fa fa-arrow-circle-left"></span> View Newer</a></div>
EOS;
	print($html);
}
if($show_right_link) {
	$html = <<<EOS
                <div class="right"><a href="#">View Older <span class="fa fa-arrow-circle-right"></span></a></div>
EOS;
	print($html);
}

if($show_left_link || $show_right_link) {
	$html = <<<EOS
                <div class="clear"></div>
            </div>
EOS;
	print($html);
}
?>
    </div>
            <div>
                <div class="left"><a href="manage-events.php"><span class="fa fa-calendar"></span> Back to Manage Events</a></div>
                <div class="clear"></div>
            </div>
</div>

<?php include ('../includes/footer.php'); ?>
