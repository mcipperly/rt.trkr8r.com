<?php
include('validate.php');
include('../db/db.php');

header('Content-type: application/json');

if (isset($_REQUEST['status_id'], $_REQUEST['count'])) {
  $get_events_opts = array(
    status_id => $_REQUEST['status_id'],
    count => $_REQUEST['count']
  );
} else {
  die('Missing required values status_id and count');
}

$possible_event_opts = array('date', 'start_date', 'end_date', 'offset');
foreach($possible_event_opts as $event_opt) {
  if(isset($_REQUEST[$event_opt])) {
    $get_events_opts[$event_opt] = $_REQUEST[$event_opt];
  }
}

$events = get_events($get_events_opts);
print(json_encode($events));
?>
