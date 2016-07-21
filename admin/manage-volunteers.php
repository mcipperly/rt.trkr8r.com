<?php
include('validate.php');
require_once('../db/db.php');

include ('../includes/admin-header.php');
include ('../includes/admin-sidebar.php');

?>

<script>
$(document).ready(function() {
	$('.source').click(function() {
		var thisId = $(this).attr('id');
		var thisIdArray = thisId.split('_');
		
		var volunteer_id = thisIdArray[1];
		
		$('#target_' + volunteer_id).prop('checked', false);
	});
	
	$('.target').click(function() {
		var thisId = $(this).attr('id');
		var thisIdArray = thisId.split('_');
		
		var volunteer_id = thisIdArray[1];
		
		$('#source_' + volunteer_id).prop('checked', false);
	});

});
</script>
<div class="container">
<div class="admin-content-wrapper">
<h1 class="admin-page-title"><span class="fa fa-heart"></span>&nbsp;Manage Volunteers</h1>
<?php
if($_REQUEST['submit'] == "Merge Selected Volunteers") {
    merge_duplicate_volunteers($_REQUEST['source'], $_REQUEST['target']);
}

if($_REQUEST['submit']) {
    $search['firstname'] = $_REQUEST['firstname'];
    $search['lastname'] = $_REQUEST['lastname'];

    $volunteer_ids = find_volunteers($search);
    if(!$volunteer_ids) {
        $html = <<<EOS
<div class="row"><div class="twelve cols callout failure">No Volunteers Found With Those Search Terms</div></div>
EOS;
        print($html);
    }
}
?>
<div class="row">
    <div class="twelve cols callout">
        <h2 class="callout-title">Find a Volunteer</h2>
        <form method="POST">
            <div class="row">
                <div class="five cols">
                <input type="text" class="full-width" name="firstname" placeholder="First Name" value="<?php echo $_REQUEST['firstname'] ?>" />
                </div>

                <div class="five cols">
                <input type="text" class="full-width" name="lastname" placeholder="Last Name" value="<?php echo $_REQUEST['lastname'] ?>" />
                </div>

                <div class="two cols">
                <input type="submit" name="submit" value="Search" class="full-width no-min">
                </div>
            </div>
        </form>

    </div>
</div>

<div class="row">
    <div class="twelve cols callout">
        <h2 class="callout-title">Search Results</h2>
        <form method="POST">
            <input type="hidden" name="firstname" value="<?php echo $_REQUEST['firstname'] ?>" />
            <input type="hidden" name="lastname" value="<?php echo $_REQUEST['lastname'] ?>" />
        <table class="respond manage-table">
                <thead>
                    <tr>
                        <th class="print_details">Waiver</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Merge This</th>
                        <th>Into This</th>
                    </tr>
                </thead>
                <tbody>
<?php
if($volunteer_ids) {
    foreach($volunteer_ids as $volunteer_id) {
        $volunteer = get_volunteer_info($volunteer_id);
        $html = <<<EOS
                    <tr>
                        <td data-label="Waiver" class="print_details"><a href="javascript: w=window.open('../signature.php?view=1&vid={$volunteer['volunteer_id']}&event_id={$event['event_id']}'); w.print()"><span class="fa fa-print fa-lg"></span></a></td>
                        <td data-label="Name"><a href="volunteer-details.php?vid={$volunteer['volunteer_id']}"><span class="manage-table--break">{$volunteer['firstname']} {$volunteer['lastname']}</span>&nbsp;&nbsp;<span class="fa fa-angle-right"></span></a></td>
                        <td data-label="Email">{$volunteer['email']}</td>
                        <td data-label="Merge This"><input name="source[]" value="{$volunteer['volunteer_id']}" id="source_{$volunteer['volunteer_id']}" class="source" type="checkbox" /></td>
                        <td data-label="Into This"><input name="target" value="{$volunteer['volunteer_id']}" id="target_{$volunteer['volunteer_id']}" class="target" type="radio" /></td>
                    </tr>
EOS;
        print($html);
    }
}
?>

                </tbody>
            </table>
        <input type="submit" name="submit" class="right m-full-width" value="Merge Selected Volunteers" />
        </form>
    </div>
</div>

<?php include ('../includes/footer.php'); ?>
