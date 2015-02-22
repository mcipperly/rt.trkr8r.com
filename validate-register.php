<?php
include('db/db.php');

$elements = get_form_elements();
$req_elements = array();

foreach($elements as $element) {
  if($element['required'] == 1) {
    $req_elements[$element['name']] = $element['label']; 
  }
}

?>
