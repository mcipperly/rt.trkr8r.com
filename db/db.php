<?php


function setup_db() {
	require('db-config.php');
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

function create_user($email, $password) {
	// function to create user credentials
	$db_link = setup_db();
	
	if(!($email && $password))
		return FALSE;
	
	$email = mysqli_real_escape_string($db_link, $email);
	$password = mysqli_real_escape_string($db_link, $password);
	
	$query = <<<EOS
INSERT INTO `user`
(`email`, `password`, `last_updated`)
VALUES
('{$email}', MD5('{$password}'), NOW())
EOS;
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link)); 

	return TRUE;
}

function delete_user($user_id) {
	// function to delete user credentials
	$db_link = setup_db();
	
	if(!$user_id)
		return FALSE;
	
	$query = "DELETE FROM `user` WHERE `user_id` = {$user_id}";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link)); 

	return TRUE;
}

function get_users() {
	//function to return all existing users
	$db_link = setup_db();
	
	$query = "SELECT `user_id`, `email`, `permission_level` FROM `user`";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link)); 

	return _get_all($result);
}

function validate_user($email) {
	// function to validate existence of user credentials
	$db_link = setup_db();
	
	$email = mysqli_real_escape_string($db_link, $email);
	
	$query = "SELECT COUNT(1) FROM `user` WHERE `email` LIKE '{$email}'";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link)); 
	return _get_one($result);
}

function process_login($email, $password) {
	// function to validate user credentials, and if successful add them to PHP Session
	$db_link = setup_db();
	
	$email = mysqli_real_escape_string($db_link, $email);
	$password = mysqli_real_escape_string($db_link, $password);
	
	$query = <<<EOS
SELECT * FROM `user`
WHERE `email` LIKE '{$email}'
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

	$query = "SELECT LAST_INSERT_ID()";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	
	return _get_one($result);
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
	$volunteer['firstname'] = _get_one($result);
	
	$query = "SELECT `value` FROM `form_response` WHERE element_id = 2 AND volunteer_id = {$volunteer_id}";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	$volunteer['lastname'] = _get_one($result);

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
	
	foreach($responses as $name => $value) {
		$name = mysqli_real_escape_string($db_link, $name);
		$value = mysqli_real_escape_string($db_link, $value);
		
		$query = "SELECT `element_id` FROM `form_element` WHERE `name` LIKE '{$name}'";
		$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
		$element_id = _get_one($result);
		
		$query = <<<EOS
INSERT INTO `form_response`
(volunteer_id, element_id, value, date_added, time_added)
VALUES
({$volunteer_id}, {$element_id}, '{$value}', CURRENT_DATE(), CURRENT_TIME())
EOS;
		$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	}
	
	$query = "UPDATE `volunteer` SET `status_id` = 2 WHERE `status_id` < 2 AND `volunteer_id` = {$volunteer_id}";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

	return TRUE;
}

function get_form_responses($volunteer_id) {
	//function to fetch waiver form responses for a given volunteer.
	$db_link = setup_db();

	if(!$volunteer_id)
		return FALSE;
	
	$query = <<<EOS
SELECT `response_id`, `element_id`, `name`, `value`
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

	if(!($volunteer_id && $file_name && file_exists("/usr/local/www/sub/rt.trkr8r.com/signatures/" . $file_name)))
		return FALSE;
	
	$file_name = mysqli_real_escape_string($db_link, $file_name);
	
	$query = <<<EOS
INSERT INTO `volunteer_signature`
(`volunteer_id`, `signature_date`, `file_name`)
VALUES
({$volunteer_id}, CURRENT_DATE(), '{$file_name}')
EOS;
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

	$query = "UPDATE `volunteer` SET `status_id` = 3 WHERE `status_id` < 3 AND `volunteer_id` = {$volunteer_id}";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	
	return TRUE;
}

function get_volunteer_signature($volunteer_id) {
	//function to grab most recent signature data for a volunteer
	$db_link = setup_db();
	
	if(!$volunteer_id)
		return FALSE;

	$query = "SELECT * FROM `volunteer_signature` WHERE `volunteer_id` = {$volunteer_id} ORDER BY `signature_date` DESC LIMIT 0, 1";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	return _get_row($result);
}

function get_volunteers_of_day($service_date = null) {
	//function to grab all volunteers with a signature for a given day (today by default)
	$db_link = setup_db();
	
	$service_date = ($service_date) ? $service_date : date("Y-m-d");
	
	$service_date = mysqli_real_escape_string($db_link, $service_date);

	$query = "SELECT `volunteer_id` FROM `volunteer_signature` WHERE `signature_date` = '{$service_date}'";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	$volunteer_ids = _get_col($result);
	
	foreach($volunteer_ids as $volunteer_id) {
		$volunteer = get_volunteer_info($volunteer_id);
		$query = "SELECT `duration` FROM `volunteer_time` WHERE `service_date` = '{$service_date}' AND volunteer_id = {$volunteer_id}";
		$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
		$volunteer['duration'] = _get_one($result);
		$volunteers[] = $volunteer;
	}
	
	return $volunteers;
}

function record_volunteer_time($volunteer_id, $duration, $service_date = null) {
	//function to record the start and end times for a volunteer
	//defaulting to the current date
	$db_link = setup_db();
	
	if(!($volunteer_id && $duration))
		return FALSE;
	
	$service_date = ($service_date) ? $service_date : date("Y-m-d");
	
	$service_date = mysqli_real_escape_string($db_link, $service_date);

	$query = "DELETE FROM `volunteer_time` WHERE `service_date` = '{$service_date}' AND `volunteer_id` = {$volunteer_id}";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	
	$query = <<<EOS
INSERT INTO `volunteer_time`
(`volunteer_id`, `service_date`, `duration`)
VALUES
({$volunteer_id}, '{$service_date}', {$duration})
EOS;
	
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	
	return TRUE;
}

function get_export_preset($preset_id) {
	//function to return the pre-set list of fields for a CSV export
	$db_link = setup_db();
	
	if(!$preset_id)
		return FALSE;
	
	$query = "SELECT `element_id` FROM `preset_element` WHERE `preset_id` = {$preset_id} ORDER BY `ord`"; 
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	return _get_col($result);
}

function export_csv($element_ids, $service_date) {
	//function to build a csv string, storing in appropriately named file
	$db_link = setup_db();
echo "<PRE>"; print_r($element_ids); echo "</PRE>";
	$fp = fopen("/usr/local/www/sub/rt.trkr8r.com/export/{$service_date}.csv", "w");
	
	foreach($element_ids as $element_id) {
		$query = "SELECT `name` FROM `form_element` WHERE `element_id` = {$element_id}";
		$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
		$header_array[] = _get_one($result);
	}
	fputcsv($fp, $header_array);

	$volunteers = get_volunteers_of_day($service_date);
	
	foreach($volunteers as $volunteer) {
		$line_array = array();
		foreach($element_ids as $element_id) {
			$query = "SELECT `value` FROM `form_response` WHERE `volunteer_id` = {$volunteer_id} AND element_id = {$element_id}";
			$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
			$value = _get_one($result);
			$value = str_replace(",", "", $value);
			$line_array[] = $value;
		}
		fputcsv($fp, $line_array);
	}
	
	fclose($fp);
	
	return "{$service_date}.csv";
}

?>
