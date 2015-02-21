<html>
<head>
	<title>captured</title>
</head>
<body>
<?php

$data_pieces = explode(",", $_REQUEST['signature-b64']);
$encoded_image = $data_pieces[1];
$decoded_image = base64_decode($encoded_image);
file_put_contents( "/usr/local/www/sub/rt.trkr8r.com/signature.png",$decoded_image);

?>
<p>i saved your image:</p>
<img src="signature.png" />
</body>
</html>
