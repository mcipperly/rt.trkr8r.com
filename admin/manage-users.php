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

if(isset($_POST['username']) && isset($_POST['password'])) {
  create_user($_POST['username'], $_POST['password'], 0);
}

$users = get_users();

$html = <<<EOS

<div class="container">
<div class="admin-content-wrapper">
<h1 class="admin-page-title"><span class="fa fa-group"></span>&nbsp;Manage Users</h1>
    <div class="row">
        <div class="twelve cols callout">
            <h2 class="callout-title">Create New User</h2>
                <form method="POST">
                    <div class="row">
                        <div class="five cols">
                            <input autocomplete="off" type="text" class="full-width" id="username" name="username" value="" placeholder="Username">
                        </div>
                        
                        <div class="five cols">
                            <input autocomplete="off" type="password" class="full-width" id="password" name="password" value="" placeholder="Password">
                        </div>
                        
                        <div class="two cols">
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
            <h2 class="callout-title">Current Users</h2>

            <form method="POST">
                <table class="manage-table">
                    <thead>
                        <tr>
                            <th class="manage-table--user" style="text-transform: uppercase;">User</th>
                            <th class="manage-table--remove">Remove</th>
                        </tr>
                    </thead>

                    <tbody>
EOS;
		print($html);
	}
	
	$html = <<<EOS
                    <tr>
                        <td data-label="User" class="manage-table--user"><span class="manage-table--break">{$user['email']}</span></td>
                        <td data-label="Remove" class="manage-table--remove"><input type="checkbox" class="big" name="remove_{$user['user_id']}" size="1"></td>
                    </tr>
EOS;
	print($html);

	if($key + 1 == sizeof($users)) {
		$html = <<<EOS
    
                    </tbody>
                    </table>
                    <input type="submit" value="Remove Selected Users" class="right">
</form>
</div>
</div>
EOS;
		print($html);
	}
}

include ('../includes/footer.php');
