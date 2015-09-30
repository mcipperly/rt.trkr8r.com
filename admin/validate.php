<?php

session_start();

if(isset($_SESSION['lastact']) && (time() - $_SESSION['lastact']) > 43200) {
  $_SESSION['lastact'] = time();
  Header("HTTP/1.1 302 Moved Temporarily");
  Header("Location: /admin/logout.php");
} else {
  $_SESSION['lastact'] = time();
  if($_SESSION['mode'] != "adminpage") {
    Header("HTTP/1.1 302 Moved Temporarily");
    Header("Location: logout.php");
  }
}

?>
