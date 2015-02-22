<?php 

Header("Content-type: text/plain");

require_once('db/db.php');
session_start();

if(isset($_POST['user']) && isset($_POST['pass'])) {
  if(process_login($_POST['user'], $_POST['pass'])) {
    $_SESSION['user'] = $_POST['user'];
    setcookie('onsite', $_POST['user']);
    print("1");
  } else {
    print("0");
  }
}

if(isset($_POST['mode']) && isset($_SESSION['user'])) {
  $_SESSION['mode'] = $_POST['mode'];
}

?>
