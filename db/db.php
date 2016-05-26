<?php
include_once('db-config.php');

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

function testing($text) {
	echo "<PRE>"; print_r($text); echo "</PRE>";
	exit;
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

function merge_duplicate_volunteers($duplicate_ids, $master_id) {
	//function to merge one or more duplicate volunteers into a master volunteer
	$db_link = setup_db();
	
	if(!($duplicate_ids && $master_id))
		return FALSE;
	
	foreach($duplicate_ids as $volunteer_id) {
		$query = "UPDATE `volunteer_event` SET `volunteer_id` = {$master_id} WHERE `volunteer_id` = {$volunteer_id}";
		mysqli_query($db_link, $query) or die(mysqli_error($db_link));
		
		delete_volunteer($volunteer_id);
	}
	
	return TRUE;
}

function delete_volunteer($volunteer_id) {
	//function to delete volunteer (remove them from any searches or reports)
	$db_link = setup_db();

	if(!$volunteer_id)
		return FALSE;
	
	$query = "UPDATE `volunteer` SET `status_id` = 4 WHERE `volunteer_id` = {$volunteer_id}";
	mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	
	return TRUE;
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
	mysqli_query($db_link, $query) or die(mysqli_error($db_link));

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
	if(_get_one($query))
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

function get_organizations($offset = 0, $count = 0) {
	// function to return all active company affiliations
	$db_link = setup_db();

	$query = "SELECT * FROM `company` WHERE `active` = 1 ORDER BY `name`";

	if($count) {
		$query .= " LIMIT {$offset}, {$count}";
	}
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

	$companies = _get_all($result);
	$no_company[] = array("company_id" => 0, "name" => "No Affiliation");

	return array_merge($no_company, $companies);
}

function get_organization($company_id) {
	//function to return info about a given organization
	$db_link = setup_db();

	if(!$company_id)
		return array();

	$query = "SELECT * FROM `company` WHERE `company_id` = {$company_id}";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	$org = _get_row($result);

	$query = <<<EOS
SELECT `volunteer_id`, `event_id`, `location`, `duration`
FROM `volunteer_event`
JOIN `volunteer` USING (`volunteer_id`)
JOIN `event` USING (`event_id`)
WHERE `company_id` = {$company_id}
AND `event`.`status_id` <> 3 #Deleted Events
AND `volunteer`.`status_id` <> 4 #Deleted Volunteers
EOS;
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	$org['volunteer_events'] = _get_all($result);

	foreach($org['volunteer_events'] as &$ve) {
		$ve = array_merge($ve, get_volunteer_info($ve['volunteer_id']));
	}
	unset($ve);

	return $org;
}

function create_organization($name, $contact_name, $contact_details, $description) {
	//function to create a new organization

	if(!trim($name))
		return FALSE;

	$db_link = setup_db();

	$name = mysqli_real_escape_string($db_link, trim($name));
	$contact_name = mysqli_real_escape_string($db_link, $contact_name);
	$contact_details = mysqli_real_escape_string($db_link, $contact_details);
	$description = mysqli_real_escape_string($db_link, $description);

	$query = <<<EOS
INSERT INTO `company`
(`name`, `contact_name`, `contact_details`, `description`, `date_added`)
VALUES
('{$name}', '{$contact_name}', '{$contact_details}', '{$description}', CURRENT_DATE())
EOS;
	mysqli_query($db_link, $query) or die(mysqli_error($db_link));

	return TRUE;
}

function update_organization($company_id, $contact_name, $contact_details, $desc, $name) {
	//function to update an organization's name

	if(!($company_id && $name))
		return FALSE;

	$db_link = setup_db();

	$contact_name = mysqli_real_escape_string($db_link, $contact_name);
	$contact_details = mysqli_real_escape_string($db_link, $contact_details);
	$desc = mysqli_real_escape_string($db_link, $desc);
    $name = mysqli_real_escape_string($db_link, $name);
    

	$query = "UPDATE `company` SET `name` = '{$name}', `contact_name` = '{$contact_name}', `contact_details` = '{$contact_details}', `description` = '{$desc}' WHERE `company_id` = {$company_id}";
	mysqli_query($db_link, $query) or die(mysqli_error($db_link));

	return TRUE;
}

function invalidate_organization($company_id) {
	//function to remove org from appearing in org list
	//while preserving its data where it's already used

	if(!$company_id)
		return FALSE;

	$db_link = setup_db();

	$query = "UPDATE `company` SET `active` = 0 WHERE `company_id` = {$company_id}";

	mysqli_query($db_link, $query) or die(mysqli_error($db_link));

	return TRUE;
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

function get_volunteer_count($search=array()) {
	//function to get a count of all signed-in volunteers in range
	$db_link = setup_db();

	foreach($search as &$search_item) {
		$search_item = mysqli_real_escape_string($db_link, $search_item);
	}
	unset($search_item);

	if($search['start_date'] && $search['end_date'])
		$date_query = "AND date BETWEEN '{$search['start_date']}' AND '{$search['end_date']}'";
	elseif($search['start_date'])
		$date_query = "AND date >= '{$search['start_date']}'";
	elseif($search['end_date'])
		$date_query = "AND date <= '{$search['end_date']}'";

	if($search['company_id'])
		$org_query = "AND company_id = {$search['company_id']}";

	$query = <<<EOS
SELECT COUNT(1) FROM `volunteer_event`
JOIN `event` USING (`event_id`)
JOIN `volunteer` USING (`volunteer_id`)
WHERE `event`.`status_id` <> 3 #Deleted Events
AND `volunteer`.`status_id` <> 4 #Deleted Volunteers
{$date_query}
{$org_query}
EOS;
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

	return _get_one($result);
}

function get_duration_count($search=array()) {
	//function to get a count of all unique signed-in volunteers in range
	$db_link = setup_db();

	foreach($search as &$search_item) {
		$search_item = mysqli_real_escape_string($db_link, $search_item);
	}
	unset($search_item);

	if($search['start_date'] && $search['end_date'])
		$date_query = "AND date BETWEEN '{$search['start_date']}' AND '{$search['end_date']}'";
	elseif($search['start_date'])
		$date_query = "AND date >= '{$search['start_date']}'";
	elseif($search['end_date'])
		$date_query = "AND date <= '{$search['end_date']}'";

	if($search['company_id'])
		$org_query = "AND company_id = {$search['company_id']}";

	$query = <<<EOS
SELECT SUM(`duration`) FROM `volunteer_event`
JOIN `event` USING (`event_id`)
JOIN `volunteer` USING (`volunteer_id`)
WHERE `event`.`status_id` <> 3 #Deleted Events
AND `volunteer`.`status_id` <> 4 #Deleted Volunteers
{$date_query}
{$org_query}
EOS;
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

	return _get_one($result);
}

function find_volunteers($search) {
	//function to return an array of  volunteer_ids based on search criteria
	$db_link = setup_db();

	foreach($search as &$search_item) {
		$search_item = mysqli_real_escape_string($db_link, $search_item);
	}
	unset($search_item);

	if($search['firstname']) {
		$query = "SELECT `volunteer_id` FROM `form_response` JOIN `volunteer` USING (`volunteer_id`) WHERE `fe_id` = 1 AND `value` LIKE '%{$search['firstname']}%' AND `status_id` <> 4 ORDER BY `volunteer_id`";
		$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
		$firstname_results = _get_col($result);
	}

	if($search['lastname']) {
		$query = "SELECT `volunteer_id` FROM `form_response` JOIN `volunteer` USING (`volunteer_id`) WHERE `fe_id` = 2 AND `value` LIKE '%{$search['lastname']}%' AND `status_id` <> 4 ORDER BY `volunteer_id`";
		$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
		$lastname_results = _get_col($result);
	}

	if($search['firstname'] && $search['lastname'])
		$search_results = array_intersect($firstname_results, $lastname_results);
	elseif($search['firstname'])
		$search_results = $firstname_results;
	elseif($search['lastname'])
		$search_results = $lastname_results;
	else
		$search_results = array();

	return $search_results;
}

function get_top_volunteers($count = 5) {
	//function to get a ranking of the $count volunteers with the most hours logged
	$db_link = setup_db();

	$query = <<<EOS
SELECT `volunteer_id`, SUM(`duration`) AS `total_duration`
FROM `volunteer_event`
JOIN `event` USING (`event_id`)
WHERE `event`.`status_id` <> 3 #Deleted Events
GROUP BY `volunteer_id`
ORDER BY `total_duration` DESC
LIMIT 0, {$count}
EOS;
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

	$volunteers = _get_all($result);

	foreach($volunteers as &$volunteer) {
		$volunteer = array_merge($volunteer, get_volunteer_info($volunteer['volunteer_id']));
	}
	unset($volunteer);

	return $volunteers;
}

function get_top_orgs($count = 5) {
	//function to get a ranking of the $count organizations with the most hours logged
	$db_link = setup_db();

	$query = <<<EOS
SELECT `company_id`, SUM(`duration`) AS `total_duration`
FROM `volunteer_event`
JOIN `volunteer` USING (`volunteer_id`)
JOIN `event` USING (`event_id`)
WHERE `company_id` <> 0
AND `event`.`status_id` <> 3 #Deleted Events
AND `volunteer`.`status_id` <> 4 #Deleted Volunteers
GROUP BY `company_id`
HAVING `total_duration` > 0
ORDER BY `total_duration` DESC
LIMIT 0, {$count}
EOS;
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

	$orgs = _get_all($result);

	foreach($orgs as &$org) {
		$query = "SELECT * FROM `company` WHERE `company_id` = {$org['company_id']}";
		$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

		$org = array_merge($org, _get_row($result));
	}
	unset($org);

	return $orgs;
}

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

function get_export_presets() {
	//function to return all export presets
	$db_link = setup_db();

	$query = "SELECT * FROM `export_preset` ORDER BY `ord`";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

	$presets = _get_all($result);

	foreach($presets as &$preset) {
		$preset['fields'] = get_export_preset($preset['preset_id']);
	}
	unset($preset);

	return $presets;
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

function export_csv($element_ids, $search) {
	//function to build a csv string and return it
	$db_link = setup_db();

	foreach($element_ids as $element_id) {
		$query = "SELECT `name` FROM `element` WHERE `element_id` = {$element_id}";
		$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
		$name = _get_one($result);
		$name = str_replace(",", "", $name);
		$header_array[] = $name;
	}

	$results = search_responses($element_ids, $search);
	$results_array = array();

	foreach($results as $line) {
		foreach($line as &$value) {
			$value = str_replace(",", "", $value);
		}
                unset($value);
                $results_array[] = implode(",", $line);
	}

	return implode(",", $header_array) . "\n" . implode("\n", $results_array);
}

function search_responses($element_ids, $search) {
	//return the search results for $element_ids given parameters $search
	$db_link = setup_db();

	$search_results = array();

	if(!$element_ids)
		return $search_results;

	foreach($element_ids as $element_id) {
		$query = "SELECT `type` FROM `element` WHERE `element_id` = {$element_id}";
		$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
		$element_type = _get_one($result);

		if($search['org_ids'] || $search['company_id'])
			$org_join_query = "JOIN `volunteer` ON `volunteer`.`volunteer_id` = `volunteer_event`.`volunteer_id`\nJOIN `company` USING (`company_id`)";

		$query = <<<EOS
SELECT `volunteer_event`.`volunteer_id`, `value`
FROM `form_response`
JOIN `form_element` USING (`fe_id`)
JOIN `volunteer_event` USING (`volunteer_id`)
JOIN `event` USING (`event_id`)
{$org_join_query}
WHERE `element_id` = {$element_id}
AND `event`.`status_id` <> 3 #Deleted Events

EOS;

		if($search['date'])
			$search['start_date'] = $search['end_date'] = $search['date'];

		if($search['start_date'] && $search['end_date'])
			$query .= "AND `event`.`date` BETWEEN '{$search['start_date']}' AND '{$search['end_date']}'\n";

		if($search['event_id'])
			$query .= "AND `event_id` = {$search['event_id']}\n";

		if(isset($search['org_ids'])) {
			$org_id_list = implode(",", $search['org_ids']);
			$query .= "AND `company`.`company_id` IN ({$org_id_list})\n";
		}

		if($search['company_id'])
			$query .= "AND `company`.`company_id` = {$search['company_id']}\n";

		$query .= "ORDER BY `volunteer_id`";

		$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
		$element_results = _get_all($result);
		foreach($element_results as &$element_result) {
			//select elements are stored as one or more se_id values, we need to translate them to their proper text
			if($element_type == "select" && $element_result['value']) {
				$value_array = explode("; ", $element_result['value']);
				$text_array = array();
				foreach($value_array as $se_id) {
					$query = "SELECT `text` FROM `select_element` WHERE `se_id` = {$se_id}";
					$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
					$text_array[] = _get_one($result);
				}
				$element_result['value'] = implode("; ", $text_array);
			}
			$search_results[$element_result['volunteer_id']][$element_id] = $element_result['value'];
		}
		unset($element_result);
	}

	return $search_results;
}

function get_events($search = null) {
	//function to grab all events, filtered by supplied search criteria
	$db_link = setup_db();

	$query = "SELECT `event_id` FROM `event` WHERE `status_id` <> 3\n";

	if($search['status_id'])
		$query .= "AND `status_id` = {$search['status_id']}\n";

	if($search['date'])
		$search['start_date'] = $search['end_date'] = $search['date'];

	if($search['start_date'] && $search['end_date'])
		$query .= "AND `date` BETWEEN '{$search['start_date']}' AND '{$search['end_date']}'\n";

	$sort_dir = ($search['sort_dir']) ? "DESC" : "ASC";

	$query .= "ORDER BY `date` {$sort_dir}, `event_id`";

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

	$query = "SELECT `name` FROM `event_status` WHERE `status_id` = {$event['status_id']}";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	$event['status_name'] = _get_one($result);

	$query = "SELECT * FROM `volunteer_event` WHERE `event_id` = {$event_id}";

	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));
	$event['volunteers'] = _get_all($result);

	$event['totals']['volunteers'] = 0;
	$event['totals']['duration'] = 0;

	foreach($event['volunteers'] as &$volunteer) {
		$volunteer_info = get_volunteer_info($volunteer['volunteer_id']);
		$volunteer = array_merge($volunteer, $volunteer_info);
		$event['totals']['volunteers']++;
		$event['totals']['duration'] += $volunteer['duration'];
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

	$query = "SELECT LAST_INSERT_ID()";
	$result = mysqli_query($db_link, $query) or die(mysqli_error($db_link));

	return _get_one($result);
}

function update_event($event_id, $date, $note, $location) {
	//function to update an existing event
	$db_link = setup_db();

	if(!($event_id && $date && $location))
		return FALSE;

	$date = mysqli_real_escape_string($db_link, $date);
	$note = mysqli_real_escape_string($db_link, $note);
	$location = mysqli_real_escape_string($db_link, $location);

	$query = "UPDATE `event` SET `date` = '{$date}', `note` = '{$note}', `location` = '{$location}' WHERE `event_id` = {$event_id}";
	mysqli_query($db_link, $query) or die(mysqli_error($db_link));

	return TRUE;
}

function delete_event($event_id) {
	//Function to remove given event
	$db_link = setup_db();
	
	if(!$event_id)
		return FALSE;
	
	$query = "UPDATE `event` SET `status_id` = 3 WHERE `event_id` = {$event_id}";
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
