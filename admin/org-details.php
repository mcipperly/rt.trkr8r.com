<?php
include('validate.php');
include ('../db/db.php');

if($_REQUEST['remove']) {
        invalidate_organization($_REQUEST['org_id']);
        Header("Location: manage-orgs.php?deleted=success");
}

include ('../includes/admin-header.php');
include ('../includes/admin-sidebar.php');

if($_REQUEST['preset_id']) {
	Header("Location: csv-export.php");
}

$search['company_id'] = $_REQUEST['org_id'];

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

        <script>
                        $("a.edit-action").click(orgEditMode);

                        function orgEditMode() {
                           $(".org_title").replaceWith("<input id=\"new_org_title\" type=\"text\" value=\"" + $(".org_title").text() + "\" class=\"full-width\">");
                           $(".org_contact_name").replaceWith("<input id=\"new_org_contact_name\" type=\"text\" value=\"" + $(".org_contact_name").text() + "\" class=\"full-width\">");
                           $(".org_contact_details").replaceWith("<input id=\"new_org_contact_details\" type=\"text\" value=\"" + $(".org_contact_details").text() + "\" class=\"full-width\">");
                           $(".org_desc").replaceWith("<textarea id=\"new_org_desc\" rows=\"4\" class=\"full-width\" style=\"margin-top: 10px;\">" + $(".org_desc").text() + "</textarea>");
                           $("#remove_org").hide();

                           $(".edit-action").replaceWith("<a href=\"#\" class=\"edit-action save-org\"><span class=\"fa fa-floppy-o\"></span>&nbsp;Save</a>");
                           $("a.save-org").click(function() {
                              var xhr = new XMLHttpRequest();
                              xhr.onreadystatechange = function() {
                                 if (xhr.readyState == 4 && xhr.status == 200) {
                                    if (xhr.responseText.indexOf('Success') >= 0) {
                                       console.log('success');
                                       orgReadMode();
                                    } else {
                                       console.log('failure');
                                    }
                                 }
                              }
                              xhr.open('POST', 'save-org.php', true);
                              xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                              xhr.send('org_id=<?php print($org['company_id']); ?>&org_title=' + document.getElementById('new_org_title').value + '&org_desc=' + document.getElementById('new_org_desc').value + '&org_contact_name=' + document.getElementById('new_org_contact_name').value + '&org_contact_details=' + document.getElementById('new_org_contact_details').value);
                           });

                        }

                        function orgReadMode() {
                           $("#new_org_title").replaceWith("<h3 class=\"org_title\">" + document.getElementById('new_org_title').value + "</h3>");
                           $("#new_org_contact_name").replaceWith("<span class=\"org_contact_name\">" + document.getElementById('new_org_contact_name').value + "</span>");
                           $("#new_org_contact_details").replaceWith("<span class=\"org_contact_details\">" + document.getElementById('new_org_contact_details').value + "</span>");
                           $("#new_org_desc").replaceWith("<p class=\"org_desc\">" + document.getElementById('new_org_desc').value + "</p>");
                           $("#remove_org").show();
                           $(".save-org").replaceWith("<a href=\"#\" class=\"edit-action save-org\">&nbsp;<span class=\"success-msg\">Success!&nbsp;</span><span class=\"fa fa-wrench\"></span>&nbsp;Edit</a>");
                           $("a.edit-action").click(orgEditMode);
				$("span.success-msg").fadeOut(2400);
                        }
                    </script>

        <h3 class="org_title"><?php print($org['name']); ?></h3>
        <p style="margin-bottom: 0;"><label class="semibold" style="display: inline-block; margin-bottom: 6px;">Contact Name:</label> <span class="org_contact_name"><?php print($org['contact_name']); ?></span></p>
        <p><label class="semibold" style="display: inline-block; margin-bottom: 6px;">Contact Details:</label> <span class="org_contact_details"><?php print($org['contact_details']); ?></span></p>
        <p class="org_desc"><?php print($org['description']); ?></p>
		<br>
        <form method="POST" id="remove_org" style="margin-top:25px;">
			<input type="hidden" name="remove" value="1" />
			<input type="hidden" name="org_id" value="<?php print($_REQUEST['org_id']);?>" />
			<button type="submit" class="m-full-width btn-closed">Remove Organization</button>
		</form>
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
							<th class="print_details">Waiver</th>
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
							<td data-label="Print Details" class="print_details"><a href="javascript: w=window.open('../signature.php?view=1&vid={$ve['volunteer_id']}'); w.print()"><span class="fa fa-print fa-lg"></span></a></td>
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
