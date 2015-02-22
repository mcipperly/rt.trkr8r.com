<?php 

Header("Content-type: text/plain");

require_once('db/db.php');

if(isset($_POST['user']) && isset($_POST['pass'])) {
  if(process_login($_POST['user'], $_POST['pass'])) {
    session_start();
    $_SESSION['user'] = $_POST['user'];
    setcookie('onsite', $_POST['user']);
    print("1");
  } else {
    print("0");
  }
}

?>
