<?php

session_start();
unset($_SESSION['user']);
Header("HTTP/1.1 302 Moved Temporarily");
Header("Location: /");

?>
