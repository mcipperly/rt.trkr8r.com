<?php

session_start();
if($_SESSION['mode'] != "adminpage") {
  Header("HTTP/1.1 302 Moved Temporarily");
  Header("Location: logout.php");
}

?>
