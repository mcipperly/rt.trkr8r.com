<?php
require_once('db/db.php');
session_start();

if(isset($_SESSION['lastact']) && (time() - $_SESSION['lastact']) > 43200) {
  $_SESSION['lastact'] = time();
  Header("HTTP/1.1 302 Moved Temporarily");
  Header("Location: /admin/logout.php");
  exit(0);
} else {

  $_SESSION['lastact'] = time();
  $volunteer_id = validate_volunteer_email($_POST['email']);

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

  $event_id = (int) $_REQUEST['event_id'];

  Header("HTTP/1.1 302 Moved Temporarily");
  if(isset($_SESSION['mode'])) { 
    Header("Location: signature.php?vid=" . $volunteer_id . "&event_id=". $event_id); 
  } else {
    Header("Location: index.php?thanks=2");
  }
}
?>
