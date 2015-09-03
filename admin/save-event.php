<?php
include('../db/db.php');
header('Content-Type: application/json');

if (isset($_REQUEST['event_id'], $_REQUEST['event_date'], $_REQUEST['event_desc'], $_REQUEST['event_title'])) {
  update_event($_REQUEST['event_id'], $_REQUEST['event_date'], $_REQUEST['event_desc'], $_REQUEST['event_title']);
  print('Success');
} else {
  die('Missing required values');
}

?>
