<?php
include ('../includes/header.php');
require_once('../db/db.php');

$users = get_users();

$html = <<<EOS
<div class="row interior-header">

    <div class="visible-phone">
        <div class="four cols sml-logo">
            <img src="../assets/imgs/rt-logo.png">
        </div>

        <div class="eight cols">
            <h1>Admin <br><span>User Administration</span></h1>
        </div>
    </div>

    <div class="hidden-phone">
        <div class="eight cols">
            <h1 class="left">Admin <span>User Administration</span></h1>
        </div>

        <div class="four cols">
            <img src="../assets/imgs/rt-logo_small.png" class="right">
        </div>
    </div>
</div>

<div class="clear"></div>
<h4><a href="index.php">&laquo; Back to Admin Page</a></h4>

<h2>Create New User</h2>
<form method="POST">
	<p>Email: </p><input type="email" id="email" name="email" value=""/>
        <p>Password: </p><input type="password" id="password" name="password" value=""/>
	<input type="submit" value="OK" />
</form>
EOS;
print($html);

foreach($users as $key => $user) {
	if($key == 0) {
		$html = <<<EOS
<form style="margin-top:30px">
    <h3 class="left"><b>User</b></h3>
    <h3 class="right"><b>Remove</b></h3>
    <div class="clear"></div>
    <br />
EOS;
		print($html);
	}
	
	$html = <<<EOS
    <div class="log_vol-name">
        <span class="left">{$user['email']}</span>
        <input type="checkbox" class="right" name="remove_{$user['user_id']}" size="1">
    </div>
    <hr class="clear">
EOS;
	print($html);

	if($key + 1 == sizeof($users)) {
		$html = <<<EOS
    <input type="submit" value="Apply" class="right">
    <div class="clear"></div>
</form>
EOS;
		print($html);
	}
}

include ('../includes/footer.php');
