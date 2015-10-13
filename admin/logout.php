<?php

session_start();
unset($_SESSION['user'], $_SESSION['mode'], $_SESSION['event_id']);
Header("HTTP/1.1 302 Moved Temporarily");
Header("Location: /");

?>
