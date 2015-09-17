<?php
include ('../includes/admin-header.php'); 
include('validate.php');
include ('../includes/admin-sidebar.php'); 
include ('../db/db.php');

$search['company_id'] = $_REQUEST['org_id'];

if($_REQUEST['preset_id']) {
	$element_ids = get_export_preset($_REQUEST['preset_id']);

	$file_name = export_csv($element_ids, $search);
	Header("Location: ../export/{$file_name}");
}

$org = get_organization($_REQUEST['org_id']);

$all_time_volunteers = number_format(get_volunteer_count($search));
$all_time_duration = number_format(get_duration_count($search), 2);

$presets = get_export_presets();

?>

<div class="container">
<div class="admin-content-wrapper">
<h1 class="admin-page-title"><span class="fa fa-th"></span>&nbsp;<a href="manage-orgs.php">Manage Organizations</a> <span class="fa fa-angle-right"></span>&nbsp;<?php print($org['name']); ?></h1>
    
<div class="row flexbox">
    <div class="eight cols callout">
        <h2 class="callout-title">Details <a href="#" class="edit-action"><span class="fa fa-wrench"></span>&nbsp;Edit</a></h2>
            
            <h3><?php print($org['name']); ?></h3>
            <h4><strong>Contact Name:</strong> <?php print($org['contact_name']); ?> &bull; <strong>Contact Details:</strong> <?php print($org['contact_details']); ?></h4>
            <p><?php print($org['description']); ?></p>
    </div> 
    
    <div class="four cols callout">
        <h2 class="callout-title">Stats</h2>
        
        <h3><strong>Volunteers:</strong> <?php print($all_time_volunteers); ?></h3>
        <h3 style="margin-top:15px;margin-bottom:15px;padding-bottom:17px;padding-top:17px;border-bottom:1px dotted #A5A5A5;border-top:1px dotted #A5A5A5"><strong>Hours:</strong> <?php print($all_time_duration); ?></h3>
        <h3><strong>Quick Export</strong></h3>
						<form method="POST">
							<input type="hidden" name="org_id" value="<?php print($_REQUEST['org_id']); ?>" />
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
    
    
<div class="row">
    <div class="twelve cols callout">
        <h2 class="callout-title">Volunteers</h2>

<?php

if(count($org['volunteer_events']) == 0) {
	$html = <<<EOS
				<div class="row">
					<p>No volunteers associated with this organization have yet volunteered for an event.</p>
				</div>   
EOS;
	print($html);

}
else {
		$html = <<<EOS
			<div class="row">
				<table class="respond">
					<thead>
						<tr>
							<th class="print_details"></th>
							<th>Volunteer Name</th>
							<th>Event</th>
							<th>Hours</th>
						</tr>
					</thead>
					<tbody>
EOS;

	foreach($org['volunteer_events'] as $ve) {
		$ve['duration'] = number_format($ve['duration'], 2);
		
		$html .= <<<EOS
						<tr>
							<td data-label="Print Details" class="print_details"><a href="#"><span class="fa fa-print fa-lg"></span></a></td>
							<td data-label="Volunteer Name">{$ve['firstname']} {$ve['lastname']}</td>
							<td data-label="Affiliation">{$ve['location']}</td>
							<td data-label="Hours">{$ve['duration']}</td>
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
    <div class="left"><a href="manage-orgs.php"><span class="fa fa-th"></span> Back to Manage Organizations</a></div>
    <div class="clear"></div>
</div>  
    
<?php include ('../includes/footer.php'); ?>