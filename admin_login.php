<?php 
session_start();

if(isset($_SESSION['lastact']) && (time() - $_SESSION['lastact']) > 43200) {
  $_SESSION['lastact'] = time();
  Header("HTTP/1.1 302 Moved Temporarily");
  Header("Location: /admin/logout.php");
} else {
  $_SESSION['lastact'] = time();
  Header("Content-type: text/plain");

  require_once('db/db.php');

  if(isset($_POST['user']) && isset($_POST['pass'])) {
    if(process_login($_POST['user'], $_POST['pass'])) {
      $_SESSION['user'] = $_POST['user'];
      print("1");
    } else {
      print("0");
    }
  }

  if(isset($_POST['user']) && isset($_POST['event_id']) && isset($_SESSION['mode']) && $_SESSION['mode'] == 'onsite' ) {
    $_SESSION['event_id'] = $_POST['event_id'];
  }

  if(isset($_POST['mode']) && isset($_SESSION['user'])) {
    $_SESSION['mode'] = $_POST['mode'];
  }
}
?>
