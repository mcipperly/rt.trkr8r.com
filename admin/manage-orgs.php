<?php
include ('../includes/admin-header.php'); 
include ('../includes/admin-sidebar.php'); 
require_once('../db/db.php');
include('validate.php');

foreach($_POST as $key => $value) {
  if(substr($key, 0, 7) == "remove_") {
    $val_arr = explode('_', $key);
    if($val_arr[1] != validate_user($_SESSION['user'])) {
      delete_user($val_arr[1]);
    } else {
      ?><script type="text/javascript">
        vex.dialog.alert('Unable to delete yourself!');
        </script><?php
    }
  }
}

if(isset($_POST['email']) && isset($_POST['password'])) {
  create_user($_POST['email'], $_POST['password'], 0);
}

$users = get_users();

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

foreach($users as $key => $user) {
	if($key == 0) {
		$html = <<<EOS
    <div class="row">
        <div class="twelve cols callout">
            <h2 class="callout-title">Current Organizations</h2>

            <form method="POST">
                <table class="manage-users-table">
                    <thead>
                        <tr>
                            <th class="manage-users-table--user">Organization</th>
                            <th class="manage-users-table--remove">Remove</th>
                        </tr>
                    </thead>

                    <tbody>
EOS;
		print($html);
	}
	
	$html = <<<EOS
                    <tr>
                        <td data-label="Organization" class="manage-users-table--user"><span class="manage-users-table--user-break">{$user['email']}</span></td>
                        <td data-label="Remove" class="manage-users-table--remove"><input type="checkbox" class="big" name="remove_{$user['user_id']}" size="1"></td>
                    </tr>
EOS;
	print($html);

	if($key + 1 == sizeof($users)) {
		$html = <<<EOS
    
                    </tbody>
                    </table>
                    <input type="submit" value="Remove Selected Organizations" class="right">
</form>
</div>
</div>
EOS;
		print($html);
	}
}

include ('../includes/footer.php');
