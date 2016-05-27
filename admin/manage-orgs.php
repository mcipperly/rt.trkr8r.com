<?php
include('validate.php');
require_once('../db/db.php');
include ('../includes/admin-header.php');
include ('../includes/admin-sidebar.php');

foreach($_REQUEST as $key => $value) {
	if(substr_count($key, "remove_")) {
		$val_arr = explode('_', $key);
		invalidate_organization($val_arr[1]);
		$org_deleted = 1;
	}
}

if($_REQUEST['org_name']) {
	$success = create_organization($_REQUEST['org_name'], $_REQUEST['contact_name'], $_REQUEST['contact_details'], $_REQUEST['description']);
}

$orgs = get_organizations();

//do this to remove the "no company" entry at the start of the array
array_shift($orgs);

if($success) {
    $success_html = <<<EOS
		<div class="row"><div class="twelve cols callout success">Organization sucessfully created.</div></div>
EOS;
}
elseif($_REQUEST['org_name'] && !$success) {
    $success_html = <<<EOS
		<div class="row"><div class="twelve cols callout failure">Organization not created. Please ensure all fields are properly filled in.</div></div>
EOS;
}
elseif(isset($org_deleted) || $_GET['deleted'] == "success") {
	$success_html = <<<EOS
	<div class="row"><div class="twelve cols callout success">Organization deleted!</div></div>
EOS;
}

$html = <<<EOS

<div class="container">
<div class="admin-content-wrapper">
<h1 class="admin-page-title"><span class="fa fa-th"></span>&nbsp;Manage Organizations</h1>
{$success_html}
    <div class="row">
        <div class="twelve cols callout">
            <h2 class="callout-title">Create New Organization</h2>
                <form method="POST">
                    <div class="row">
                        <div class="twelve cols">
                            <input autocomplete="off" type="text" class="full-width" id="org_name" name="org_name" value="" placeholder="Organization Name (Required)" required>
                        </div>
					</div>
					<div class="row">
                        <div class="six cols">
                            <input autocomplete="off" type="text" class="full-width" id="contact_name" name="contact_name" value="" placeholder="Contact Name">
                        </div>
                        <div class="six cols">
                            <input autocomplete="off" type="text" class="full-width" id="contact_details" name="contact_details" value="" placeholder="Contact Details (Phone #)">
                        </div>
					</div>
                    <div class="row">
                        <div class="twelve cols">
                            <textarea autocomplete="off" type="text" class="full-width" id="description" name="description" value="" placeholder="Organization Description"></textarea>
                        </div>
					</div>
					<div class="row">
                        <div class="twelve cols">
                            <input type="submit" value="Create" class="full-width no-min">
                        </div>
                    </div>
                </form>
        </div>
    </div>

EOS;
print($html);

foreach($orgs as $key => $org) {
	if($key == 0) {
		$html = <<<EOS
    <div class="row">
        <div class="twelve cols callout">
            <h2 class="callout-title">Current Organizations</h2>
            <form method="POST">
                <table class="respond manage-table">
                    <thead>
                        <tr>
                            <th class="manage-table--orgs">Organization</th>
                            <th class="manage-table--remove">Remove</th>
                        </tr>
                    </thead>

                    <tbody>
EOS;
		print($html);
	}

	$html = <<<EOS
                    <tr>
                        <td data-label="Organization" class="manage-table--orgs"><a href="org-details.php?org_id={$org['company_id']}"><span class="manage-table--break">{$org['name']}</span>&nbsp;&nbsp;<span class="fa fa-angle-right"></span></a></td>
                        <td data-label="Remove" class="manage-table--remove"><input type="checkbox" class="big" name="remove_{$org['company_id']}" size="1"></td>
                    </tr>
EOS;
	print($html);

	if($key + 1 == sizeof($orgs)) {
		$html = <<<EOS

                    </tbody>
                    </table>
                    <input type="submit" value="Remove Selected Organizations" class="right m-full-width">
</form>
</div>
</div>
EOS;
		print($html);
	}
}

include ('../includes/footer.php');
