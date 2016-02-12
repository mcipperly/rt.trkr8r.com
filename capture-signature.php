<?php
session_start();
require_once('db/db.php');

if(!isset($_SESSION['mode'])) {
  Header("HTTP/1.1 302 Moved Temporarily");
  Header("Location: /index.php?thanks=2");
}
 
$data_pieces = explode(",", $_REQUEST['signature-b64']);
$encoded_image = $data_pieces[1];
$decoded_image = base64_decode($encoded_image);
$filename = "Signature-" . $_REQUEST['firstname'] . $_REQUEST['lastname'] . "-" . date("Ymd") . ".png";
$result = file_put_contents(getcwd() . "/signatures/" . $filename, $decoded_image);

if($result)
	$result = (int) add_signature($_REQUEST['vid'], $_REQUEST['event_id'], $filename);

Header("HTTP/1.1 302 Moved Temporarily");
Header("Location: ./index.php?thanks=1");

?>
