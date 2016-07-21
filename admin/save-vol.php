<?php
include('validate.php');
include('../db/db.php');

if (isset(
    $_REQUEST['vol_first_name'],
    $_REQUEST['vol_last_name'],
    $_REQUEST['vol_age'],
    $_REQUEST['vol_email'],
    $_REQUEST['vol_phone'],
    $_REQUEST['vol_address1'],
    $_REQUEST['vol_address2'],
    $_REQUEST['vol_city'],
    $_REQUEST['vol_state'],
    $_REQUEST['vol_zip'],
    $_REQUEST['vol_skills'],
    $_REQUEST['vol_newsletter'],
    $_REQUEST['vol_opps'],
    $_REQUEST['volunteer_id']
    )) {
       header('Content-Type: application/json');
       update_volunteer(
           $_REQUEST['vol_first_name'],
           $_REQUEST['vol_last_name'],
           $_REQUEST['vol_age'],
           $_REQUEST['vol_email'],
           $_REQUEST['vol_phone'],
           $_REQUEST['vol_address1'],
           $_REQUEST['vol_address2'],
           $_REQUEST['vol_city'],
           $_REQUEST['vol_state'],
           $_REQUEST['vol_zip'],
           $_REQUEST['vol_skills'],
           $_REQUEST['vol_newsletter'],
           $_REQUEST['vol_opps']
       );
       print('Success');

       } else {
  die('Missing required values');
}

?>
