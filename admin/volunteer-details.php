<?php
include('validate.php');
include ('../db/db.php');

if($_REQUEST['remove']) {
        delete_volunteer($_REQUEST['vol_id']);
        Header("Location: manage-volunteers.php");
}

include ('../includes/admin-header.php');
include ('../includes/admin-sidebar.php');

if($_REQUEST['preset_id']) {
	Header("Location: csv-export.php");
}

$search['volunteer_id'] = $_REQUEST['vol_id'];

$vol = get_volunteer_info($_GET['vid']);

$all_time_volunteers = number_format(get_volunteer_count($search));
$all_time_duration = number_format(get_duration_count($search), 2);

$presets = get_export_presets();

$volunteer = get_volunteer_info($_REQUEST['vid']);
$volunteer['waiver'] = get_form_responses($volunteer['volunteer_id'], 1);
$param['volunteer_id'] = $volunteer['volunteer_id'];
$volunteer['events'] = get_volunteer_events($param);

//testing($volunteer);
?>

<div class="container">
<div class="admin-content-wrapper">
<h1 class="admin-page-title"><span class="fa fa-heart"></span>&nbsp;<a href="manage-volunteers.php">Manage Volunteers</a> <span class="fa fa-angle-right"></span>&nbsp;<?php print($vol['firstname']);?> <?php print($vol['lastname']);?> </h1>
    
<div class="row flexbox">
    <div class="eight cols callout">
        <h2 class="callout-title">Details <a href="#" class="edit-action"><span class="fa fa-wrench"></span>&nbsp;Edit</a></h2>
            
        <script>
                        $("a.edit-action").click(volEditMode);

                        function volEditMode() {
                           $(".editable").each(function (name, field) {
                              cur = $(field).attr('class').split(' ')[0];
                              // here we test for the elusive radio button
                              if(!($(field).text() == "Yes") && !($(field).text() == "No")) { 
                                 $("." + cur).replaceWith("<input id=\"new_"+cur+"\" type=\"text\" value=\""+$("."+cur).text()+"\" class=\"min-full-width editing\">");
                              } else {
                                 // wow a radio button 
                                 curBool = $(field).text();
                                 $("." + cur).replaceWith("<input id=\"new_"+cur+"\" type=\"radio\" value=\"Yes\" class=\"editing\">&nbsp;Yes &nbsp; <input id=\"new_"+cur+"\" type=\"radio\" value=\"No\" class=\"editing\">&nbsp;No");
                                 $("#new_" + cur + "[value=\""+curBool+"\"]").prop("checked", true);
                              }
                           });
  
                           $("#remove_vol").hide();
                           
                           $(".edit-action").replaceWith("<a href=\"#\" class=\"edit-action save-vol\"><span class=\"fa fa-floppy-o\"></span>&nbsp;Save</a>");
                           $("a.save-vol").click(function() {
                              var xhrPostData = [];
                              $(".editing").each(function (name, field) { 
                                 // because who wants unchecked radio buttons?
                                 if(!($(field).attr('type') == "radio" && $(field).prop('checked') == false)) {
                                    xhrPostData.push($(field).attr('id').replace("new_","") + "=" + $(field).val());
                                 }
                              });
                              console.log(xhrPostData.join('&'));
                              var xhr = new XMLHttpRequest();
                              xhr.onreadystatechange = function() {
                                 if (xhr.readyState == 4 && xhr.status == 200) {
                                    if (xhr.responseText.indexOf('Success') >= 0) {
                                       console.log('success');
                                       volReadMode();
                                    } else {
                                       console.log('failure');
                                    }
                                 }
                              }
                              xhr.open('POST', 'save-vol.php', true);
                              xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                              xhr.send('volunteer_id=<?php print($vol['volunteer_id']); ?>&'+xhrPostData.join('&'));
                           });

                        }

                        function volReadMode() {
                           $("#new_vol_first_name").replaceWith("<span class=\"vol_first_name\">" + document.getElementById('new_vol_first_name').value + "</span>");
                           $("#new_vol_last_name").replaceWith("<span class=\"vol_last_name\">" + document.getElementById('new_vol_first_name').value + "</span>");
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
                           
                           
                           $("#remove_vol").show();
                           $(".save-vol").replaceWith("<a href=\"#\" class=\"edit-action save-vol\">&nbsp;<span class=\"success-msg\">Success!&nbsp;</span><span class=\"fa fa-wrench\"></span>&nbsp;Edit</a>");
                           $("a.edit-action").click(volEditMode);
				$("span.success-msg").fadeOut(2400);
                        }
                    </script>
        
        <h3><span class="vol_first_name editable"><?php echo $volunteer['firstname']; ?></span> <span class="vol_last_name editable"><?php echo $volunteer['lastname']; ?></span>, <span class="vol_age editable"><?php echo $volunteer['waiver'][2]['value']; ?></span></h3>
        <p> 
            <span class="vol_email editable" style="display:block"><?php echo $volunteer['email']; ?></span>
            <span class="vol_phone editable" style="display:block"><?php echo "(" . substr($volunteer['waiver'][4]['value'], 0, 3) . ") ". substr($volunteer['waiver'][4]['value'], 3, 3) . "-" . substr($volunteer['waiver'][4]['value'],6); ?></span>
        </p>
        
         <p> 
            <span class="vol_address1 editable" style="display:block"><?php echo $volunteer['waiver'][5]['value']; ?></span>
            <span class="vol_address2 editable" style="display:block"><?php echo $volunteer['waiver'][6]['value']; ?></span>
            <span style="display:block"><span class="vol_city editable"><?php echo $volunteer['waiver'][7]['value']; ?></span>, <span class="vol_state editable"><?php echo $volunteer['waiver'][8]['value']; ?></span> <span class="vol_zip editable"><?php echo $volunteer['waiver'][9]['value']; ?></span></span>
        </p>
        
        <p> 
            <strong>Skills:</strong> <span class="vol_skills editable"><?php echo $volunteer['waiver'][10]['value']; ?></span>
        </p>
        
        <p>
            <span style="display:block"><strong>Newsletter?</strong> <span class="vol_newsletter editable"><?php echo ($volunteer['waiver'][11]['value'] == 1) ? "Yes" : "No"; ?></span></span>
            <span style="display:block"><strong>Future Opportunities?</strong> <span class="vol_opps editable"><?php echo ($volunteer['waiver'][12]['value'] == 1) ? "Yes" : "No"; ?></span></span>
        </p>
        
        <form method="POST" id="remove_vol" style="margin-top:25px;">
			<input type="hidden" name="remove" value="1" />
			<input type="hidden" name="vol_id" value="<?php print($_REQUEST['vol_id']);?>" />
		</form>
    </div> 
    
    <div class="four cols callout">
        <h2 class="callout-title">Stats</h2>
        
        <h3><strong>Events Attended:</strong> ####</h3>
        <h3 style="margin-top:15px;margin-bottom:15px;padding-bottom:17px;padding-top:17px;border-bottom:1px dotted #A5A5A5;border-top:1px dotted #A5A5A5"><strong>Hours:</strong> #####</h3>
        <h3><strong>Quick Export</strong></h3>
						<form method="POST">
							<input type="hidden" name="vol_id" value="<?php print($_REQUEST['vol_id']); ?>" />
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

                    <tr>
                        <td data-label="Event">Event Name</td>
                        <td data-label="Hours">00.00</td>
                    </tr>

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
