<?php
require_once('db/db.php');
include ('includes/login-header.php');

$search['date'] = date("Y-m-d");
$events = get_events($search);

?>

    <section>
        <img src="assets/imgs/PaperOut_Logo_Horizontal.svg" onerror="this.src='assets/imgs/PaperOut_Logo_Horizontal.png'">
        <h2><?php print($site_org) ?></h2>
        <form method="POST">
            <p>Username</p>
            <input autocomplete="off" type="text" class="full-width" id="username" name="username" value="" placeholder="">
            <p>Password</p>
            <input autocomplete="off" type="password" class="full-width" id="password" name="password" value="" placeholder="">
            <br>
            <input type="submit" value="Login" class="full-width no-min">
        </form>

    </section>

<?php include ('includes/footer.php'); ?>