<?php
include ('../includes/admin-header.php'); 
include('validate.php');
include ('../includes/admin-sidebar.php'); 
include('../db/db.php');

if($_REQUEST['preset_id']) {
	$element_ids = get_export_preset($_REQUEST['preset_id']);

	$search['date'] = $_REQUEST['date'];
	
	$file_name = export_csv($element_ids, $search);
	Header("Location: ../export/{$file_name}");
}

$search['start_date'] = date("Y-m-01");

$month_volunteers = number_format(get_volunteer_count($search));
$month_duration = number_format(get_duration_count($search), 2);

$all_time_volunteers = number_format(get_volunteer_count());
$all_time_duration = number_format(get_duration_count(), 2);

$month_name = date("M");

$top_volunteers = get_top_volunteers();
$top_orgs = get_top_orgs();

$search = array();
$search['status_id'] = 1;
$search['count'] = 3;
$search['start_date'] = date("Y-m-d", strtotime("-10 year"));
$search['end_date'] = date("Y-m-d", strtotime("-1 day"));
$pending_events = get_events($search);

$search = array();
$search['status_id'] = 1;
$search['count'] = 3;
$search['start_date'] = date("Y-m-d");
$search['end_date'] = date("Y-m-d", strtotime("+10 year"));
$open_events = get_events($search);

$search = array();
$search['status_id'] = 2;
$search['count'] = 3;
$search['sort_dir'] = 1;
$closed_events = get_events($search);

$today = date("Y-m-d");
$yesterday = date("Y-m-d", strtotime("-1 day"));
$presets = get_export_presets();

?>

<div class="container">
<div class="admin-content-wrapper">
<h1 class="admin-page-title"><span class="fa fa-home"></span>&nbsp;Dashboard</h1>

<div class="row flexbox">
    <div class="six cols callout">
        <h2 class="callout-title">Volunteers In <?php print($month_name); ?></h2>
        <p class="text"><span class="fa fa-user left dash"></span><span class="right stroke-text"><?php print($month_volunteers); ?></span></p>
    </div>

    
    <div class="six cols callout">
        <h2 class="callout-title">Hours Logged In <?php print($month_name); ?></h2>
        <p class="text"><span class="fa fa-clock-o dash left"></span><span class="right stroke-text"><?php print($month_duration); ?></span></p>
    </div> 
    <div class="clear"></div>
</div>

<div class="row flexbox">
    <div class="six cols callout">
        <h2 class="callout-title">Volunteers To-Date</h2>
        <p class="text"><span class="fa fa-users left dash "></span><span class="right stroke-text"><?php print($all_time_volunteers); ?></span></p>
    </div>  
    
    <div class="six cols callout">
        <h2 class="callout-title">Hours Logged To-Date</h2>
        <p class="text"><span class="fa fa-clock-o dash left"></span><span class="right stroke-text"><?php print($all_time_duration); ?></span></p>
    </div> 
    <div class="clear"></div>
</div>
    
<div class="row flexbox">
    <div class="six cols callout">
    <h2 class="callout-title">Top Volunteers</h2>
        <ol class="list-group">
<?php
foreach($top_volunteers as $volunteer) {
	print("<li>{$volunteer['firstname']} {$volunteer['lastname']} ({$volunteer['total_duration']} hours)</li>");
}
?>
        </ol>
    </div>   
    
    <div class="six cols callout">
    <h2 class="callout-title">Top Organizations</h2>
        <ol class="list-group">
<?php
foreach($top_orgs as $org) {
	print("<li>{$org['name']} ({$org['total_duration']} hours)</li>");
}
?>
        </ol>
    </div>   
</div>  

<div class="row">
 <div class="twelve cols callout">
    <h2 class="callout-title">Your Events</h2>
    <div class="row">
        <div class="four cols">
        <h3>Pending Completion</h3>
            <ul class="list-group">
<?php
foreach($pending_events as $event) {
	$event['date'] = date("m/d/Y", strtotime($event['date']));
	$html = <<<EOS
<li class="dash_eventlist"><a href="event-details.php?event_id={$event['event_id']}">{$event['location']}<br><span class="dash_eventdate">{$event['date']}</span></a></li>
EOS;
	print($html);
}
?>
            </ul>
         </div>
        <div class="four cols">
        <h3>Future Events</h3>
            <ul class="list-group">
<?php
foreach($open_events as $event) {
	$event['date'] = date("m/d/Y", strtotime($event['date']));
	$html = <<<EOS
<li class="dash_eventlist"><a href="event-details.php?event_id={$event['event_id']}">{$event['location']}<br><span class="dash_eventdate">{$event['date']}</span></a></li>
EOS;
	print($html);
}
?>
            </ul>
         </div>
        
        <div class="four cols">
        <h3>Completed</h3>
            <ul class="list-group">
<?php
foreach($closed_events as $event) {
	$event['date'] = date("m/d/Y", strtotime($event['date']));
	$html = <<<EOS
<li class="dash_eventlist"><a href="event-details.php?event_id={$event['event_id']}">{$event['location']}<br><span class="dash_eventdate">{$event['date']}</span></a></li>
EOS;
	print($html);
}
?>
            </ul>
         </div>
    </div>
    </div>     
</div>   

    <div class="row">
    <div class="twelve cols callout">
    <h2 class="callout-title">Quick Export</h2>
    <div class="row">
        <div class="six cols">
            <h3>Today's Data</h3>
						<form method="POST">
							<input type="hidden" name="date" value="<?php print($today); ?>" />
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
        <div class="six cols">
            <h3>Yesterday's Data</h3>
						<form method="POST">
							<input type="hidden" name="date" value="<?php print($yesterday); ?>" />
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
    
    </div>

<?php include ('../includes/footer.php'); ?>
