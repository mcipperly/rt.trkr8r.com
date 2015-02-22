<?php
require_once('db/db.php');

$data_pieces = explode(",", $_REQUEST['signature-b64']);
$encoded_image = $data_pieces[1];
$decoded_image = base64_decode($encoded_image);
$filename = "Signature-" . $_REQUEST['firstname'] . $_REQUEST['lastname'] . "-" . date("Ymd") . ".png";
file_put_contents("/usr/local/www/sub/rt.trkr8r.com/signatures/" . $filename);

Header("HTTP/1.1 302 Moved Temporarily");
Header("Location: ./index.php?thanks=1");

?>
