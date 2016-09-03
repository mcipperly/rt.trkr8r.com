<?php
include('validate.php');
include('../db/db.php');

if (isset(
    $_REQUEST['firstname'],
    $_REQUEST['lastname'],
    $_REQUEST['birthdate'],
    $_REQUEST['email'],
    $_REQUEST['phone'],
    $_REQUEST['address1'],
    $_REQUEST['address2'],
    $_REQUEST['city'],
    $_REQUEST['state'],
    $_REQUEST['postalcode'],
    $_REQUEST['skills'],
    $_REQUEST['newsletter'],
    $_REQUEST['future_interest']
    )) {
      header('Content-Type: application/json');
        foreach($_POST as $name => $response) {
          if(is_array($response)) {
            $responses[$name] = implode('; ', $response);
          } else {
            $responses[$name] = $response;
          }
        }
      add_form_responses($_POST['volunteer_id'], 1, $responses);
      print('Success');
} else {
   die('Missing required values');
}

?>
