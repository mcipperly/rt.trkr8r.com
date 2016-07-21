<?php
include('validate.php');
include ('../db/db.php');

if($_REQUEST['remove']) {
        invalidate_organization($_REQUEST['org_id']);
        Header("Location: manage-orgs.php");
}

include ('../includes/admin-header.php');
include ('../includes/admin-sidebar.php');

if($_REQUEST['preset_id']) {
	Header("Location: csv-export.php");
}

$search['company_id'] = $_REQUEST['org_id'];

$vol = get_volunteer_info($_GET['vid']);

$all_time_volunteers = number_format(get_volunteer_count($search));
$all_time_duration = number_format(get_duration_count($search), 2);

$presets = get_export_presets();

$volunteer = get_volunteer_info($_REQUEST['vid']);
$volunteer['waiver'] = get_form_responses($volunteer['volunteer_id'], 1);
$param['volunteer_id'] = $volunteer['volunteer_id'];
$volunteer['events'] = get_volunteer_events($param);

$volunteer['total_duration'] = 0;
foreach($volunteer['events'] as $event) {
	$volunteer['total_duration'] += $event['duration'];
}

//testing($volunteer);
?>

<div class="container">
<div class="admin-content-wrapper">
<h1 class="admin-page-title"><span class="fa fa-heart"></span>&nbsp;<a href="manage-volunteers.php">Manage Volunteers</a> <span class="fa fa-angle-right"></span>&nbsp;<?php print($vol['firstname']);?> <?php print($vol['lastname']);?> </h1>
    
<div class="row flexbox">
    <div class="eight cols callout">
        <h2 class="callout-title">Details <a href="#" class="edit-action"><span class="fa fa-wrench"></span>&nbsp;Edit</a></h2>
            
        <script>
                        $("a.edit-action").click(orgEditMode);

                        function orgEditMode() {
                           $(".vol_name_first").replaceWith("<input id=\"new_vol_name_first\" type=\"text\" value=\"" + $(".vol_name_first").text() + "\" class=\"min-full-width\">");
                           $(".vol_name_last").replaceWith("<input id=\"new_vol_name_last\" type=\"text\" value=\"" + $(".vol_name_last").text() + "\" class=\"min-full-width\">");
                           $(".vol_age").replaceWith("<input id=\"new_vol_age\" type=\"text\" value=\"" + $(".vol_age").text() + "\" class=\"min-full-width\">");
                           $(".vol_email").replaceWith("<input id=\"new_vol_email\" type=\"text\" value=\"" + $(".vol_email").text() + "\" class=\"min-full-width\">");
                           $(".vol_phone").replaceWith("<input id=\"new_vol_phone\" type=\"text\" value=\"" + $(".vol_phone").text() + "\" class=\"min-full-width\">");
                           $(".vol_address1").replaceWith("<input id=\"new_vol_address1\" type=\"text\" value=\"" + $(".vol_address1").text() + "\" class=\"min-full-width\">");
                           $(".vol_address2").replaceWith("<input id=\"new_vol_address2\" type=\"text\" value=\"" + $(".vol_address2").text() + "\" class=\"min-full-width\">");
                           $(".vol_city").replaceWith("<input id=\"new_vol_city\" type=\"text\" value=\"" + $(".vol_city").text() + "\" class=\"min-full-width\">");
                           $(".vol_state").replaceWith("<input id=\"new_vol_state\" type=\"text\" value=\"" + $(".vol_state").text() + "\" class=\"min-full-width\">");
                           $(".vol_zip").replaceWith("<input id=\"new_vol_zip\" type=\"text\" value=\"" + $(".vol_zip").text() + "\" class=\"min-full-width\">");
                           $(".vol_skills").replaceWith("<input id=\"new_vol_skills\" type=\"text\" value=\"" + $(".vol_skills").text() + "\" class=\"min-full-width\">");
                           $(".vol_newsletter").replaceWith("<input id=\"new_vol_newsletter\" type=\"radio\" value=\"\">&nbsp;Yes &nbsp; <input id=\"new_vol_newsletter\" type=\"radio\" value=\"\">&nbsp;No");
                           $(".vol_opps").replaceWith("<input id=\"new_vol_opps\" type=\"radio\" value=\"\">&nbsp;Yes &nbsp; <input id=\"new_vol_opps\" type=\"radio\" value=\"\">&nbsp;No");
                            
                            
  
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
                           $("#new_vol_name_first").replaceWith("<span class=\"vol_name_first\">" + document.getElementById('new_vol_name_first').value + "</span>");
                           $("#new_vol_name_last").replaceWith("<span class=\"vol_name_last\">" + document.getElementById('new_vol_name_first').value + "</span>");
                           $("#new_vol_age").replaceWith("<span class=\"vol_age\">" + document.getElementById('new_vol_age').value + "</span>");
                           $("#new_vol_email").replaceWith("<span class=\"vol_email\" style=\"display:block\">" + document.getElementById('new_vol_email').value + "</span>");
                           $("#new_vol_phone").replaceWith("<span class=\"vol_phone\" style=\"display:block\">" + document.getElementById('new_vol_phone').value + "</span>");
                           $("#new_vol_address1").replaceWith("<span class=\"vol_address1\" style=\"display:block\">" + document.getElementById('new_vol_address1').value + "</span>");
                           $("#new_vol_address2").replaceWith("<span class=\"vol_address2\" style=\"display:block\">" + document.getElementById('new_vol_address2').value + "</span>");
                           $("#new_vol_city").replaceWith("<span class=\"vol_city\">" + document.getElementById('new_vol_city').value + "</span>");
                           $("#new_vol_state").replaceWith("<span class=\"vol_state\">" + document.getElementById('new_vol_state').value + "</span>");
                           $("#new_vol_zip").replaceWith("<span class=\"vol_zip\">" + document.getElementById('new_vol_zip').value + "</span>");
                           $("#new_vol_skills").replaceWith("<span class=\"vol_skills\">" + document.getElementById('new_vol_skills').value + "</span>");
                           $("#new_vol_newsletter").replaceWith("<span class=\"vol_newsletter\" style=\"display:block\">" + document.getElementById('new_vol_newsletter').value + "</span>");
                           $("#new_vol_opps").replaceWith("<span class=\"vol_opps\" style=\"display:block\">" + document.getElementById('new_vol_opps').value + "</span>");
                           
                           
                           $("#remove_org").show();
                           $(".save-org").replaceWith("<a href=\"#\" class=\"edit-action save-org\">&nbsp;<span class=\"success-msg\">Success!&nbsp;</span><span class=\"fa fa-wrench\"></span>&nbsp;Edit</a>");
                           $("a.edit-action").click(orgEditMode);
				$("span.success-msg").fadeOut(2400);
                        }
                    </script>
        
        <h3><span class="vol_name_first"><?php echo $volunteer['firstname']; ?></span> <span class="vol_name_last"><?php echo $volunteer['lastname']; ?></span>, <span class="vol_age"><?php echo $volunteer['waiver'][2]['value']; ?></span></h3>
        <p> 
            <span class="vol_email" style="display:block"><?php echo $volunteer['email']; ?></span>
            <span class="vol_phone" style="display:block"><?php echo "(" . substr($volunteer['waiver'][4]['value'], 0, 3) . ") ". substr($volunteer['waiver'][4]['value'], 3, 3) . "-" . substr($volunteer['waiver'][4]['value'],6); ?></span>
        </p>
        
         <p> 
            <span class="vol_address1" style="display:block"><?php echo $volunteer['waiver'][5]['value']; ?></span>
            <span class="vol_address2" style="display:block"><?php echo $volunteer['waiver'][6]['value']; ?></span>
            <span style="display:block"><span class="vol_city"><?php echo $volunteer['waiver'][7]['value']; ?></span>, <span class="vol_state"><?php echo $volunteer['waiver'][8]['value']; ?></span> <span class="vol_zip"><?php echo $volunteer['waiver'][9]['value']; ?></span></span>
        </p>
        
        <p> 
            <strong>Skills:</strong> <span class="vol_skills"><?php echo $volunteer['waiver'][10]['value']; ?></span>
        </p>
        
        <p>
            <span style="display:block"><strong>Newsletter?</strong> <span class="vol_newsletter"><?php echo ($volunteer['waiver'][11]['value'] == 1) ? "Yes" : "No"; ?></span></span>
            <span style="display:block"><strong>Future Opportunities?</strong> <span class="vol_opps"><?php echo ($volunteer['waiver'][12]['value'] == 1) ? "Yes" : "No"; ?></span></span>
        </p>
        
        <form method="POST" id="remove_org" style="margin-top:25px;">
			<input type="hidden" name="remove" value="1" />
			<input type="hidden" name="volunteer_id" value="<?php print($_REQUEST['vid']);?>" />
		</form>
    </div> 
    
    <div class="four cols callout">
        <h2 class="callout-title">Stats</h2>
        
        <h3><strong>Events Attended:</strong> <?php echo sizeof($volunteer['events']); ?></h3>
        <h3 style="margin-top:15px;margin-bottom:15px;padding-bottom:17px;padding-top:17px;border-bottom:1px dotted #A5A5A5;border-top:1px dotted #A5A5A5"><strong>Hours:</strong> <?php echo $volunteer['total_duration']; ?></h3>
        <h3><strong>Quick Export</strong></h3>
						<form method="POST">
							<input type="hidden" name="volunteer_id" value="<?php print($_REQUEST['vid']); ?>" />
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
        <h2 class="callout-title">Participation</h2>

        <table class="respond">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Hours</th>
                    </tr>
                </thead>
                <tbody>
<?php
if(!$volunteer['events']) {
	$html = <<<EOS
					<tr>
						<td colspan="2">No Events</td>
					</tr>
EOS;
	echo $html;
}
foreach($volunteer['events'] as $event) {
	$html = <<<EOS
                    <tr>
                        <td data-label="Event">{$event['event']['location']}</td>
						<td data-label="Hours">{$event['duration']}</td>
                    </tr>
EOS;
	echo $html;
}
?>
                </tbody>
            </table>

    </div>  
</div>
    
<div>
    <button class="right btn-alert"><span class="fa fa-trash-o" aria-hidden="true"></span> Delete Volunteer</button>
    <div class="left"><a href="manage-volunteers.php"><span class="fa fa-heart"></span> Back to Manage Events</a></div>
    <div class="clear"></div>
</div>
    
<?php include ('../includes/footer.php'); ?>
