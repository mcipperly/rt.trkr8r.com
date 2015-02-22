<?php
require_once('db/db.php');

$data_pieces = explode(",", $_REQUEST['signature-b64']);
$encoded_image = $data_pieces[1];
$decoded_image = base64_decode($encoded_image);
file_put_contents( "/usr/local/www/sub/rt.trkr8r.com/signatures/Signature-".$_REQUEST['firstname'] . $_REQUEST['lastname'] . "-" . date("Ymd") . ".png",$decoded_image);

Header("HTTP/1.1 302 Moved Temporarily");
Header("Location: ./index.php?thanks=1");

?>
