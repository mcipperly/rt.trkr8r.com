<?php
include ('../includes/admin-header.php'); 
include ('../includes/admin-sidebar.php'); 
require_once('../db/db.php');
include('validate.php');

foreach($_REQUEST as $key => $value) {
	if(substr_count($key, "remove_")) {
		$val_arr = explode('_', $key);
		invalidate_organization($val_arr[1]);
	}
	
	if(substr_count($key, "update_")) {
		$val_arr = explode('_', $key);
		update_organization($val_arr[1], $value);
	}
}


if($_REQUEST['organization']) {
	create_organization($_REQUEST['organization']);
}

$orgs = get_organizations();

//do this to remove the "no company" entry at the start of the array
array_shift($orgs);

$html = <<<EOS

<div class="container">
<div class="admin-content-wrapper">
<h1 class="admin-page-title"><span class="fa fa-th"></span>&nbsp;Manage Organizations</h1>
    <div class="row">
        <div class="twelve cols callout">
            <h2 class="callout-title">Create New Organization</h2>
                <form method="POST">
                    <div class="row">
                        <div class="eight cols">
                            <input autocomplete="off" type="text" class="full-width" id="organization" name="organization" value="" placeholder="Organization">
                        </div>
                
                        <div class="four cols">
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
                <table class="manage-table">
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
                        <td data-label="Organization" class="manage-table--orgs"><span class="manage-table--break">{$org['name']}</span></td>
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
<p><a href="org_detail.php">Sample Organization Detail Page</a></p>
</div>
EOS;
		print($html);
	}
}

include ('../includes/footer.php');
