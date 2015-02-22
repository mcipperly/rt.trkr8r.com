<?php
require_once('db/db.php');
print($_POST['email']);
$volunteer_id = validate_volunteer_email($_POST['email']);

print($volunteer_id);

if(!$volunteer_id) {
	$volunteer_id = create_volunteer($_POST['email']);
}

$responses = array();

foreach($_POST as $name => $response) {
  if(is_array($response)) {
    $responses[$name] = implode(', ', $response);
  } else {
    $responses[$name] = $response;
  }
}

add_form_responses($volunteer_id, $responses);

Header("HTTP/1.1 302 Moved Temporarily");
//if(isset($_COOKIE['onsite']) && validate_onsite($_COOKIE['onsite'])) { 
  Header("Location: signature.php?vid=" . $volunteer_id); 
//} else {
//  Header("Location: index.php?thanks=2");
//}
?>
