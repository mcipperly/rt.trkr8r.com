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
	
	$query = "SELECT `user_id` FROM `user` WHERE `email` LIKE '{$email}'";
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

	$query = "SELECT * FROM `volunteer` WHERE `volunteer_id` = {$volunteer_id}";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

	$volunteer = _get_row($result);

	$query = "SELECT `value` FROM `form_response` WHERE fe_id = 1 AND volunteer_id = {$volunteer_id}";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	$volunteer['firstname'] = _get_one($result);
	
	$query = "SELECT `value` FROM `form_response` WHERE fe_id = 2 AND volunteer_id = {$volunteer_id}";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	$volunteer['lastname'] = _get_one($result);
	
	if($volunteer['company_id']) {
		$query = "SELECT * FROM company WHERE company_id = {$volunteer['company_id']}";
		$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
		$volunteer['company'] = _get_row($result);
	}

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

function get_companies($offset = 0, $count = 0) {
	// function to return all active company affiliations
	$db_link = setup_db();
	
	$query = "SELECT * FROM `company` WHERE `active` = 1 ORDER BY `name`";

	if($count) {
		$query .= " LIMIT {$offset}, {$count}";
	}
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	
	$companies = _get_all($result);
	$no_company[] = array("company_id" => 0, "name" => "--");
	
	return array_merge($no_company, $companies);
}

function get_form_elements($form_id) {
	// function to return all valid given form elements, in order
	$db_link = setup_db();
	
	if(!$form_id)
		return FALSE;
	
	$query = "SELECT * FROM `element` JOIN `form_element` USING (element_id) WHERE `form_id` = {$form_id} ORDER BY `ord` ASC";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

	$elements = _get_all($result);

	foreach($elements as &$element) {
		if($element['type'] == "select") {
			$query = "SELECT * FROM select_element WHERE active = 1 AND element_id = {$element['element_id']} ORDER BY text";
			$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
			$select_elements = _get_all($result);
			if(!$element['plural'])
				$none_selected[] = array("se_id" => 0, "text" => "--");
			else
				$none_selected = array();
			$element['select_elements'] = array_merge($none_selected, $select_elements);
			unset($none_selected);
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
		
		if($fe_id) {
			$query = <<<EOS
INSERT INTO `form_response`
(volunteer_id, fe_id, value, date_added, time_added)
VALUES
({$volunteer_id}, {$fe_id}, '{$value}', CURRENT_DATE(), CURRENT_TIME())
EOS;
			$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
		}
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
SELECT `response_id`, `element_id`, `name`, `value`, `element`.`type`, `plural`
FROM `form_response`
JOIN `form_element` USING (fe_id)
JOIN `element` USING (element_id)
WHERE `volunteer_id` = {$volunteer_id}
AND `form_id` = {$form_id}
ORDER BY `ord`
EOS;

	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	$responses = _get_all($result);

	//Some responses require additional formatting (e.g. select-type results)
	foreach($responses as &$response) {
		if(!$response['value'])
			continue;
		
		switch($response['type']) {
			case "select":
				if($response['plural']) {
					$se_id_array = explode("; ", $response['value']);
					$se_id_list = implode(", ", $se_id_array);
					$query = "SELECT `text` FROM `select_element` WHERE `element_id` = {$response['element_id']} AND `se_id` IN ({$se_id_list})";
					$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
					$value_array = _get_col($result);
					$value = implode("; ", $value_array);
				}
				else {
					$query = "SELECT `text` FROM `select_element` WHERE `element_id` = {$response['element_id']} AND `se_id` = {$response['value']}";
					$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
					$value = _get_one($result);
				}
				break;
			default:
				$value = $response['value'];
				break;
		}
		
		$response['value'] = $value;
	}
	unset($response);
	
	return $responses;
}

function add_signature($volunteer_id, $event_id, $file_name) {
	//function to store volunteer signature file info
	$db_link = setup_db();

	if(!($volunteer_id && $event_id && $file_name && file_exists(getcwd() . "/signatures/" . $file_name)))
		return FALSE;
	
	$file_name = mysqli_real_escape_string($db_link, $file_name);
	
	$query = <<<EOS
INSERT INTO `volunteer_event`
(`volunteer_id`, `event_id`, `signature_file_name`)
VALUES
({$volunteer_id}, {$event_id}, '{$file_name}')
EOS;
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

	$query = "UPDATE `volunteer` SET `status_id` = 3 WHERE `status_id` < 3 AND `volunteer_id` = {$volunteer_id}";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	
	return TRUE;
}

function get_volunteer_signature($volunteer_id, $event_id) {
	//function to grab signature data for a given volunteer and event
	$db_link = setup_db();
	
	if(!($volunteer_id && $event_id))
		return FALSE;

	$query = "SELECT * FROM `volunteer_event` WHERE `volunteer_id` = {$volunteer_id} AND `event_id` = {$event_id}";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	return _get_row($result);
}

function volunteer_name_cmp($a, $b) {
	//function used to sort volunteers by lastname, firstname
	$a['lastname'] = strtoupper($a['lastname']);
	$a['firstname'] = strtoupper($a['firstname']);
	$b['lastname'] = strtoupper($b['lastname']);
	$b['firstname'] = strtoupper($b['firstname']);
	
	if(strcmp($a['lastname'], $b['lastname']) == 0) {
		if(strcmp($a['firstname'], $b['firstname']) == 0) {
			return ($a['volunteer_id'] < $b['volunteer_id']);
		}
		else
			return strcmp($a['firstname'], $b['firstname']);
	}
	else
		return strcmp($a['lastname'], $b['lastname']);
}

/*
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
	
	usort($volunteers, "volunteer_name_cmp");
	
	return $volunteers;
}
*/

function record_volunteer_time($volunteer_id, $event_id, $duration) {
	//function to record the hours worked for a volunteer
	//defaulting to the current date
	$db_link = setup_db();
	
	if(!($volunteer_id && $event_id && $duration))
		return FALSE;
	
	$query = "UPDATE `volunteer_event` SET `duration` = {$duration} WHERE `volunteer_id` = {$volunteer_id} AND `event_id` = {$event_id}";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	
	return TRUE;
}

function record_volunteer_company($volunteer_id, $company_id = 0) {
	//function to record the volunteer's company/affiliation
	$db_link = setup_db();
	
	if(!$volunteer_id)
		return FALSE;
	
	$query = "UPDATE `volunteer` SET `company_id` = {$company_id} WHERE `volunteer_id` = {$volunteer_id}";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	
	return TRUE;
}

function record_all_volunteer_time($event_id, $duration) {
	//function to record the hours worked for all volunteers of a given event
	$db_link = setup_db();
	
	if(!($event_id && $duration))
		return FALSE;
	
	$event = get_event($event_id);
	
	foreach($event['volunteers'] as $volunteer) {
		record_volunteer_time($volunteer['volunteer_id'], $event_id, $duration);
	}
	
	return TRUE;
}

function record_all_volunteer_company($event_id, $company_id) {
	//function to record all volunteers' company/affiliation of a given event
	$db_link = setup_db();

	if(!($event_id && $company_id))
		return FALSE;
	
	$event = get_event($event_id);
	
	foreach($event['volunteers'] as $volunteer) {
		record_volunteer_company($volunteer['volunteer_id'], $company_id);
	}
	
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

function get_events($search = null) {
	//function to grab all events, filtered by supplied search criteria
	$db_link = setup_db();

	$query = "SELECT `event_id` FROM `event` WHERE 1\n";
	
	if($search['status_id'])
		$query .= "AND `status_id` = {$search['status_id']}\n";
	
	if($search['date'])
		$search['start_date'] = $search['end_date'] = $search['date'];
	
	if($search['start_date'] && $search['end_date'])
		$query .= "AND `date` BETWEEN '{$search['start_date']}' AND '{$search['end_date']}'\n";
	
	
	$query .= "ORDER BY `date`, `event_id`"; 

	if($search['count']) {
		$search['offset'] = (int) $search['offset'];
		$query .= "\nLIMIT {$search['offset']}, {$search['count']}";
	}
	
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	$event_ids = _get_col($result);
	
	$events = array();
	foreach($event_ids as $event_id) {
		$events[] = get_event($event_id);
	}
	
	return $events;
}

function get_event($event_id) {
	//function to grab all relevant info for a given event
	$db_link = setup_db();
	
	if(!$event_id)
		return FALSE;
	
	$query = "SELECT * FROM `event` WHERE `event_id` = {$event_id}";

	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	$event = _get_row($result);
	
	$query = "SELECT * FROM `volunteer_event` WHERE `event_id` = {$event_id}";
	
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	$event['volunteers'] = _get_all($result);
	
	foreach($event['volunteers'] as &$volunteer) {
		$volunteer_info = get_volunteer_info($volunteer['volunteer_id']);
		$volunteer = array_merge($volunteer, $volunteer_info);
	}
	unset($volunteer);

	usort($event['volunteers'], "volunteer_name_cmp");	

	return $event;
}

function create_event($date, $note, $location) {
	//function to create a new event
	$db_link = setup_db();
	
	if(!($date && $location))
		return FALSE;
	
	$date = mysqli_real_escape_string($db_link, $date);
	$note = mysqli_real_escape_string($db_link, $note);
	$location = mysqli_real_escape_string($db_link, $location);
	
	$query = "INSERT INTO `event` (`date`, `note`, `location`) VALUES ('{$date}', '{$note}', '{$location}')";
	mysqli_query($db_link, $query) or die(mysqli_error($db_link));

	return TRUE;
}

function update_event($event_id, $date, $note, $location) {
	//function to update an existing event
	$db_link = setup_db();
	
	if(!($event_id && $date && $location))
		return FALSE;
	
	$date = mysqli_real_escape_string($db_link, $date);
	$note = mysqli_real_escape_string($db_link, $note);
	$location = mysqli_real_escape_string($db_link, $location);
	
	$query = "UPDATE `event` SET `date` = '{$date}', `note` = {$note}, `location` = {$location} WHERE `event_id` n = {$event_id}";
	mysqli_query($db_link, $query) or die(mysqli_error($db_link));

	return TRUE;
}

function toggle_event_status($event_id) {
	//Function to swap an event between "open" and "closed"
	$db_link = setup_db();
	
	if(!$event_id)
		return FALSE;
	
	$query = "SELECT `status_id` FROM `event` WHERE `event_id` = {$event_id}";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	
	$status_id = _get_one($result);
	
	$new_status_id = ($status_id == 2) ? 1 : 2;
	
	$query = "UPDATE `event` SET `status_id` = {$new_status_id} WHERE `event_id` = {$event_id}";
	mysqli_query($db_link, $query) or die(mysqli_error($db_link));

	return TRUE;
}

?>
