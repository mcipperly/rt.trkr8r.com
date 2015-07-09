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
                <h4 class="left"><b>User</b></h4>
                <h4 class="right"><b>Remove</b></h4>
                <div class="clear"></div>
EOS;
		print($html);
	}
	
	$html = <<<EOS
    <div class="log_vol-name">
        <span class="left">{$user['email']}</span>
        <input type="checkbox" class="right big" name="remove_{$user['user_id']}" size="1">
    </div>
    <hr class="clear">
EOS;
	print($html);

	if($key + 1 == sizeof($users)) {
		$html = <<<EOS
    <input type="submit" value="Apply" class="right">
    <div class="clear"></div>
</form>
</div>
</div>
EOS;
		print($html);
	}
}

include ('../includes/footer.php');
