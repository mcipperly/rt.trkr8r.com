<?php

function setup_db() {
	include('db-config.php');
	$db_link = mysqli_connect($db_host,$db_user,$db_pass,$db_name) or die(mysqli_error($link));

	return $db_link;
}

function _get_one($result) {

	$row = mysqli_fetch_row($result);
	return $row[0];
}

function _get_row($result) {
	return mysqli_fetch_assoc($result);
}

function _get_col($result) {
	$return_array = array();

	while($row = mysqli_fetch_row($result)) {
		$return_array[] = $row[0];
	}
	return $return_array;
}

function _get_all($result) {
	$return_array = array();

	while($row = mysqli_fetch_assoc($result)) {
		$return_array[] = $row;
	}
	return $return_array;
}

function process_login($username, $password) {
	// function to validate user credentials, and if successful add them to PHP Session
	$db_link = setup_db();
	
	$username = mysqli_real_escape_string($db_link, $username);
	$password = mysqli_real_escape_string($db_link, $password);
	
	$query = <<<EOS
SELECT * FROM `user`
WHERE (`username` LIKE '{$username}' OR `email_address` LIKE '{$username}')
AND `password` LIKE MD5('{$password}')
EOS;
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link)); 

	$user_info = _get_row($result);
	if($user_info) {
		$_SESSION['info'] = $user_info;
		return TRUE;
	}
	else
		return FALSE;
}

function create_volunteer($email, $preregistered = 0) {
	//function to create a volunteer, using email address as the identifying info
	$db_link = setup_db();

	if(!$email)
		return FALSE;
	
	$email = mysqli_real_escape_string($db_link, $email);

	$query = "SELECT COUNT(1) FROM `volunteer` WHERE `email` LIKE '{$email}'";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	if(_get_one($result))
		return FALSE;
	
	$query = <<<EOS
INSERT INTO `volunteer`
(email, preregistered, date_added, time_added)
VALUES
('{$email}', {$preregistered}, CURRENT_DATE(), CURRENT_TIME())
EOS;
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	return TRUE;
}

function validate_volunteer_email($email) {
	//function to validate via email address that a pre-registered volunteer exists in the system
	$db_link = setup_db();

	if(!$email)
		return 0;
	
	$email = mysqli_real_escape_string($db_link, $email);

	$query = "SELECT `volunteer_id` FROM `volunteer` WHERE `email` LIKE '{$email}'";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

	return (int) _get_one($result);
}

function get_volunteer_info($volunteer_id) {
	//function to return vital volunteer info (name, email address)
	$db_link = setup_db();

	if(!$volunteer_id )
		return FALSE;

	$query = "SELECT `volunteer_id`, `email` FROM `volunteer` WHERE `volunteer_id` = {$volunteer_id}";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

	$volunteer = _get_row($result);

	$query = "SELECT `value` FROM `form_response` WHERE element_id = 1 AND volunteer_id = {$volunteer_id}";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	$volunteer['firstname'] = _get_row($result);
	
	$query = "SELECT `value` FROM `form_response` WHERE element_id = 2 AND volunteer_id = {$volunteer_id}";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	$volunteer['lastname'] = _get_row($result);

	return $volunteer;
}


function get_form_elements() {
	// function to return all valid wavier form elements, in order
	$db_link = setup_db();
	
	$query = "SELECT * FROM `form_element` ORDER BY `ord` ASC";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

	return _get_all($result);
}

function add_form_responses($volunteer_id, $responses) {
	//function to store waiver form responses for a given volunteer.
	//this will erase previous responses
	$db_link = setup_db();

	if(!($volunteer_id && $responses))
		return FALSE;
	
	$query = "DELETE FROM `form_response` WHERE `volunteer_id` = {$volunteer_id}";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	
	foreach($responses as $response) {
		$value = mysqli_real_escape_string($db_link, $response['value']);
		
		$query = <<<EOS
INSERT INTO `form_response`
(volunteer_id, element_id, value, date_added, time_added)
VALUES
({$volunteer_id}, {$response['element_id']}, '{$value}', CURRENT_DATE(), CURRENT_TIME())
EOS;
		$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	}
	
	return TRUE;
}

function get_form_responses($volunteer_id) {
	//function to fetch waiver form responses for a given volunteer.
	$db_link = setup_db();

	if(!$volunteer_id)
		return FALSE;
	
	$query = <<<EOS
SELECT `response_id`, `name`, `value`
FROM `form_response`
JOIN `form_element` USING (element_id)
WHERE `volunteer_id` = {$volunteer_id}
ORDER BY `ord`
EOS;
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

	return _get_all($result);
}

function add_signature($volunteer_id, $file_name) {
	//function to store volunteer signature file info
	$db_link = setup_db();

	if(!$volunteer_id)
		return FALSE;
	
	if
}

?>
