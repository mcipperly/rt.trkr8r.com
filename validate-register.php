<?php
include('db/db.php');

$form_id = 1; //Hard-coded for now, until ability to choose forms is available
$form = get_form($form_id);

$req_elements = array();

foreach($form['elements'] as $element) {
  if($element['required'] == 1) {
    $req_elements[$element['name']] = $element['label']; 
  }
}

foreach($req_elements as $name => $label) {
  if(!isset($_POST[$name])) {
    print($label);
    exit(0);
  }
}

?>
