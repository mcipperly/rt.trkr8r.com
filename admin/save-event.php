<?php
include('validate.php');
include('../db/db.php');

if (isset($_REQUEST['event_date'], $_REQUEST['event_desc'], $_REQUEST['event_title'])) {
  if (isset($_REQUEST['event_id'])) {
    header('Content-Type: application/json');
    update_event($_REQUEST['event_id'], $_REQUEST['event_date'], $_REQUEST['event_desc'], $_REQUEST['event_title']);
    print('Success');
  } elseif (isset($_REQUEST['type']) && $_REQUEST['type'] == "Create" ) {
    $event_id = create_event($_REQUEST['event_date'], $_REQUEST['event_desc'], $_REQUEST['event_title']);
    header('Location: ./event-details.php?event_id=' . $event_id);
  }
} else {
  die('Missing required values');
}

?>
