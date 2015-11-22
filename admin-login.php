<?php
require_once('db/db.php');
include ('includes/login-header.php');

$search['date'] = date("Y-m-d");
$events = get_events($search);

?>

    <section>
        <img src="assets/imgs/PaperOut_Logo_Horizontal.svg" onerror="this.src='assets/imgs/PaperOut_Logo_Horizontal.png'">
        <form method="POST">
            Username
            <br>
            <input autocomplete="off" type="text" class="m-full-width" id="username" name="username" value="" placeholder="">
            <br> Password
            <br>
            <input autocomplete="off" type="password" class="m-full-width" id="password" name="password" value="" placeholder="">
            <br>
            <input type="submit" value="Login" class="m-full-width no-min">
        </form>

    </section>

<?php include ('includes/footer.php'); ?>