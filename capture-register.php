<html>
<body>
<?php
require_once('db/db.php');
$volunteer_id = create_volunteer($_POST['email']);

$responses = array();
foreach($_POST as $name => $response) {
  $responses[$name] = $response;
}
add_form_responses($volunteer_id, $responses);

Header("HTTP/1.1 302 Moved Temporarily");
Header("Location: ./index.php?thanks=1");

print_r($responses); ?>
</body>
</html>
