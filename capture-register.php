<html>
<body>
<?php
require_once('db/db.php');

$responses = array();
foreach($_POST as $name => $response) {
  $responses[$name] = $response;
}
// add_form_responses(

//Header("HTTP/1.1 302 Moved Temporarily");
// Header("Location: ./index.php?thanks=1");

print_r($responses); ?>
</body>
</html>
