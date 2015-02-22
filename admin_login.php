<?php 

require_once('db/db.php');

if(process_login($_POST['user'], $_POST['pass'])) {
  session_start();
  $_SESSION['user'] = $_POST['user'];
  setcookie('onsite', $_POST['user']);
  print("1");
} else {
  print("0");
}

?>
