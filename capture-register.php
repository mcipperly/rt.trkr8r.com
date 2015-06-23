<?php
require_once('db/db.php');
session_start();
$volunteer_id = validate_volunteer_email($_POST['email']);

//print($volunteer_id);

if(!$volunteer_id) {
	$volunteer_id = create_volunteer($_POST['email']);
}

$responses = array();

foreach($_POST as $name => $response) {
  if(is_array($response)) {
    $responses[$name] = implode('; ', $response);
  } else {
    $responses[$name] = $response;
  }
}

$form_id = 1; //Hard-coded for now, until ability to choose forms is available

add_form_responses($volunteer_id, $form_id, $responses);

Header("HTTP/1.1 302 Moved Temporarily");
if(isset($_SESSION['mode'])) { 
  Header("Location: signature.php?vid=" . $volunteer_id); 
} else {
  Header("Location: index.php?thanks=2");
}
?>
