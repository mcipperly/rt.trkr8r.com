<?php

session_start();
if(isset($_SESSION['mode']) && isset($_SESSION['user'])) {
   $_SESSION['mode'] = 'onsite';
}
Header("HTTP/1.1 302 Moved Temporarily");
Header("Location: /");

?>
