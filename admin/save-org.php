<?php
include('validate.php');
include('../db/db.php');

if (isset($_REQUEST['org_contact_name'], $_REQUEST['org_contact_details'], $_REQUEST['org_desc'], $_REQUEST['org_title'])) {
  if (isset($_REQUEST['org_id'])) {
    header('Content-Type: application/json');
    update_org($_REQUEST['org_id'], $_REQUEST['org_contact_name'], $_REQUEST['org_contact_details'], $_REQUEST['org_desc'], $_REQUEST['org_title']);
    print('Success');
  } elseif (isset($_REQUEST['type']) && $_REQUEST['type'] == "Create" ) {
    $org_id = create_org($_REQUEST['org_contact_name'], $_REQUEST['org_contact_details'], $_REQUEST['org_desc'], $_REQUEST['org_title']);
    header('Location: ./org-details.php?org_id=' . $org_id);
  }
} else {
  die('Missing required values');
}

?>
