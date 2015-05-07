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

	if(!$volunteer_id)
		return FALSE;

	$query = "SELECT `volunteer_id`, `email` FROM `volunteer` WHERE `volunteer_id` = {$volunteer_id}";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

	$volunteer = _get_row($result);

	$query = "SELECT `value` FROM `form_response` WHERE fe_id = 1 AND volunteer_id = {$volunteer_id}";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	$volunteer['firstname'] = _get_one($result);
	
	$query = "SELECT `value` FROM `form_response` WHERE fe_id = 2 AND volunteer_id = {$volunteer_id}";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	$volunteer['lastname'] = _get_one($result);

	return $volunteer;
}

function create_form($name, $title = "", $signature = 0) {
	//function to create a new, blank form
	$db_link = setup_db();

	if(!$name)
		return FALSE;
	
	$name = mysqli_real_escape_string($db_link, $name);
	$title = ($title) ? mysqli_real_escape_string($db_link, $title) : $name;
	$signature = (int) mysqli_real_escape_string($db_link, $signature);
	
	$query = "INSERT INTO `form` (`name`, `title`, `signature`) VALUES ('{$name}', '{$title}', {$signature})";
	$mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	
	return TRUE;
}

function update_form($form_id, $name, $title = "", $signature = 0, $active = 0) {
	//function to update basic form data
	$db_link = setup_db();

	if(!($form_id && $name))
		return FALSE;
	
	$name = mysqli_real_escape_string($db_link, $name);
	$title = ($title) ? mysqli_real_escape_string($db_link, $title) : $name;
	
	$query = <<<EOS
UPDATE `form`
SET `name` = '{$name}', `title` = '{$title}', `signature` = {$signature}, `valid` = {$active}
WHERE `form_id` = {$form_id}
EOS;
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	
	return TRUE;
}

function delete_form($form_id) {
	//function to delete a form
	$db_link = setup_db();

	if(!$form_id)
		return FALSE;
	
	//don't delete a form that contains entered responses
	$query = "SELECT COUNT(1) FROM `form_response` JOIN `form_element` USING (`fe_id`) WHERE `form_id` = {$form_id}";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	if(_get_one($result))
		return FALSE;
	
	//delete all form elements associated with the form
	$query = "DELETE FROM `form_element` WHERE `form_id` = {$form_id}";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

	$query = "DELETE FROM `form` WHERE `form_id` = {$form_id}";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	
	return TRUE;
}

function add_element($label, $description, $type, $cols, $plural) {
	//function to add a new entry to the list available elements
	$db_link = setup_db();
	
	if(!($label && $type))
		return FALSE;
	
	$label = mysqli_real_escape_string($db_link, $label);
	$cols = ($cols) ? (int) $cols : 12;
	$plural = ($plural) ? (int) $plural : 0;

	$name = str_replace(" ", "_", $label);
	$name = substr($name, 0, 50);
	
	$query = <<<EOS
INSERT INTO `element`
(`name`, `label`, `description`, `type`, `cols`, `plural`)
VALUES
('{$name}', '{$label}', '{$description}', '{$type}', {$cols}, {$plural})
EOS;
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	
	return TRUE;
}

function update_element($element_id, $name, $label, $description, $type, $cols, $plural) {
	//function to update info about a form element
	$db_link = setup_db();
	
	if(!($element_id && $name && $label && $type))
		return FALSE;
	
	$name = mysqli_real_escape_string($db_link, $name);
	$label = mysqli_real_escape_string($db_link, $label);
	$cols = ($cols) ? (int) $cols : 12;
	$plural = ($plural) ? (int) $plural : 0;
	
	$query = <<<EOS
UPDATE `element`
SET `name` = '{$name}', `label` = '{$label}', `description` = '{$description}',
`type`, = '{$type}', `cols` = {$cols}, `plural` = {$plural}
WHERE `element_id` = {$element_id}
EOS;
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	
	return TRUE;
}

function delete_element($element_id) {
	//function to delete a form element
	$db_link = setup_db();
	
	if(!$element_id)
		return FALSE;
	
	//don't delete an element currently used in a form
	$query = "SELECT COUNT(1) FROM `form_element` WHERE `element_id` = {$element_id}";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	if(_get_one($sql))
		return FALSE;
	
	$query = "DELETE FROM `element` WHERE `element_id` = {$element_id}";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	
	return TRUE;
}

function get_forms() {
	//function to return all forms in existence
	$db_link = setup_db();

	$query = "SELECT `form_id` FROM `form`";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	$form_ids = _get_col($result);
	
	$forms = array();
	foreach($form_ids as $form_id)
		$forms[] = get_form($form_id);
	
	return $forms;
}

function get_form($form_id) {
	// function to return basic info and elements of given form
	$db_link = setup_db();
	
	if(!$form_id)
		return FALSE;

	$query = "SELECT * FROM `form` WHERE `form_id` = {$form_id}";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	$form = _get_row($result);
	
	if(!$form)
		return array();
	
	$form['elements'] = get_form_elements($form_id);
	
	return $form;
}

function get_form_elements($form_id) {
	// function to return all valid given form elements, in order
	$db_link = setup_db();
	
	if(!$form_id)
		return FALSE;
	
	$query = "SELECT * FROM `element` JOIN `form_element` USING (element_id) WHERE `form_id` = {$form_id} ORDER BY `ord` ASC";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

	$elements = _get_all($result);

//echo "<PRE>"; print_r($elements); echo "</PRE>"; exit;
	foreach($elements as &$element) {
		if($element['type'] == "select") {
			$query = "SELECT * FROM select_element WHERE active = 1 AND element_id = {$element['element_id']} ORDER BY text";
			$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
			$element['select_elements'] = _get_all($result);
		}
	}
	unset($element);

	return $elements;
}

function add_form_responses($volunteer_id, $form_id, $responses) {
	//function to store waiver form responses for a given volunteer.
	//this will erase previous responses
	$db_link = setup_db();

		if(!($volunteer_id && $form_id && $responses))
		return FALSE;
	
	$query = "DELETE `form_response` FROM `form_response` JOIN `form_element` USING (fe_id) WHERE `volunteer_id` = {$volunteer_id} AND `form_id` = {$form_id}";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	
	foreach($responses as $name => $value) {
		$name = mysqli_real_escape_string($db_link, $name);
		$value = mysqli_real_escape_string($db_link, $value);
		
		$query = "SELECT `form_element`.`fe_id` FROM `element` JOIN `form_element` USING (element_id) WHERE `name` LIKE '{$name}' AND `form_id` = {$form_id}";

		$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
		$fe_id = _get_one($result);
		
		$query = <<<EOS
INSERT INTO `form_response`
(volunteer_id, fe_id, value, date_added, time_added)
VALUES
({$volunteer_id}, {$fe_id}, '{$value}', CURRENT_DATE(), CURRENT_TIME())
EOS;
		$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	}
	
	$query = "UPDATE `volunteer` SET `status_id` = 2 WHERE `status_id` < 2 AND `volunteer_id` = {$volunteer_id}";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

	return TRUE;
}

function get_form_responses($volunteer_id, $form_id) {
	//function to fetch given form responses for a given volunteer.
	$db_link = setup_db();

	if(!($volunteer_id && $form_id))
		return FALSE;
	
	$query = <<<EOS
SELECT `response_id`, `element_id`, `name`, `value`
FROM `form_response`
JOIN `form_element` USING (fe_id)
JOIN `element` USING (element_id)
WHERE `volunteer_id` = {$volunteer_id}
AND `form_id` = {$form_id}
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
	$fp = fopen("/usr/local/www/sub/rt.trkr8r.com/export/{$service_date}.csv", "w");
	
	foreach($element_ids as $element_id) {
		$query = "SELECT `name` FROM `element` WHERE `element_id` = {$element_id}";
		$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
		$header_array[] = _get_one($result);
	}
	fputcsv($fp, $header_array);

	$volunteers = get_volunteers_of_day($service_date);
	
	foreach($volunteers as $volunteer) {
		$line_array = array();
		foreach($element_ids as $element_id) {
			$query = "SELECT `value` FROM `form_response` WHERE `volunteer_id` = {$volunteer['volunteer_id']} AND element_id = {$element_id}";
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
