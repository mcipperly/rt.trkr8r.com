<html>
<body>
<?php
require_once('db/db.php');

foreach($_POST as $name => $response) {
 print($name);
 print($response);
}
// add_form_responses(

//Header("HTTP/1.1 302 Moved Temporarily");
// Header("Location: ./index.php?thanks=1");

?>
</body>
</html>
