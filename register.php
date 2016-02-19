<?php
require_once('db/db.php');
session_start();

$volunteer_id = validate_volunteer_email($_REQUEST['email']);
if(isset($_REQUEST['email']) && $volunteer_id && !$_REQUEST['edit'] && isset($_SESSION['mode'])) {
  Header("HTTP/1.1 302 Moved Temporarily");
  Header("Location: signature.php?vid=" . $volunteer_id . "&event_id=" . $_REQUEST['event_id']);
} elseif($volunteer_id && !isset($_SESSION['mode'])) {
  Header("HTTP/1.1 302 Moved Temporarily");
  Header("Location: index.php?thanks=3");
}

include('includes/header.php');


function get_response($response) {
	global $search_element_id;
	return ($response['element_id'] == $search_element_id);
}

$form_id = 1; //Hard-coded for now, until ability to choose forms is available

$form = get_form($form_id);

// 2015-06-23 mcipperly - update to use form_id on get_form_responses, only let us pull info is mode is set
if(isset($_SESSION['mode']) && $volunteer_id) {
        $responses = get_form_responses($volunteer_id, $form_id);
}

$col_count = 0;
$asterisk_count = 0;
foreach($form['elements'] as $key => $element) {
	if($key == 0) {
		$html = <<<EOS
<div class="row interior-header">

    <div class="visible-phone">
        <div class="four cols sml-logo">
            <img src="assets/imgs/rt-logo.png">
        </div>

        <div class="eight cols">
            <h1>Register</h1>
        </div>
    </div>

    <div class="hidden-phone">
        <div class="eight cols">
            <h1 class="left">Register</h1>
        </div>

        <div class="four cols">
            <img src="assets/imgs/rt-logo_small.png" class="right">
        </div>
    </div>
</div>
<div class="clear"></div>
<script src='https://www.google.com/recaptcha/api.js'></script>

<form action="capture-register.php" method="POST" autocomplete="off">
	<input type="hidden" name="event_id" value="{$_REQUEST['event_id']}" />
EOS;
		print($html);
	}

	if($col_count % 12 == 0) {
		$html = <<<EOS
    <div class="row">
EOS;
		print($html);
	}

	switch($element['cols'])
	{
		case 1:
			$cols = "one";
			break;
		case 2:
			$cols = "two";
			break;
		case 3:
			$cols = "three";
			break;
		case 4:
			$cols = "four";
			break;
		case 5:
			$cols = "five";
			break;
		case 6:
			$cols = "six";
			break;
		case 7:
			$cols = "seven";
			break;
		case 8:
			$cols = "eight";
			break;
		case 9:
			$cols = "nine";
			break;
		case 10:
			$cols = "ten";
			break;
		case 11:
			$cols = "eleven";
			break;
		case 12:
			$cols = "twelve";
			break;
	}

	$asterisk_string = "";
	if($element['description']) {
		$asterisk_count++;

		for($i = 0; $i < $asterisk_count; $i++)
			$asterisk_string .= "*";
	}

	$search_element_id = $element['element_id'];
  if(isset($responses)) {
	   $filtered_responses = array_filter($responses, 'get_response');
   }

	if($filtered_responses)
		$this_response = array_shift($filtered_responses);
	else
		$this_response = array();

	if($element['type'] == "checkbox" && $this_response)
		$value = ($this_response['value']) ? "Yes" : "No";
	else
		$value = $this_response['value'];

	$required_html = ($element['required']) ? " required" : "";

	switch($element['type']) {
		case "text":
		case "number":
			$html = <<<EOS
        <div class="{$cols} cols">
            <label for="{$element['name']}">{$element['label']}<sup>{$asterisk_string}</sup></label>
            <input class="full-width" type="{$element['type']}" placeholder="" name="{$element['name']}"{$required_html} value="{$value}" />
			</div>
EOS;
			break;
		case "checkbox":
			$checked_html = ($value == "Yes" || !isset($value)) ? "checked" : "";
			$html = <<<EOS
        <div class="{$cols} cols">
            <label for="{$element['name']}" style="display:inline">{$element['label']}</label>
			<input type="hidden" id="hidden_{$element['name']}" name="{$element['name']}" value="0" disabled="disabled" />
			<input type="{$element['type']}" name="{$element['name']}" value="1" {$required_html} {$checked_html} />
        </div>
EOS;
			break;
		case "select":
			$selected_text = $value;
			$select_size = sizeof($element['select_elements']);
			$multi_html_a = ($element['plural']) ? "[]" : "";
			$multi_html_b = ($element['plural']) ? "multiple size='{$select_size}'" : "";
			$multi_html_c = ($element['plural']) ? "&nbsp;<small>(On desktop, hold Ctrl+Shift to select multiple options)</small>" : "";
			$multi_html_d = ($element['plural']) ? "<input type=\"hidden\" id=\"hidden_{$element['name']}\" name=\"{$element['name']}\" value=\"\" disabled=\"disabled\" />" : "";

			$html = <<<EOS
	<div class="{$cols} cols">
		<label for="{$element['name']}">{$element['label']}{$multi_html_c}</label>
		{$multi_html_d}
		<select class="full-width" name="{$element['name']}{$multi_html_a}" {$multi_html_b}>
EOS;
			foreach($element['select_elements'] as $option) {
				if($selected_text)
					$selected_html = ($option['text'] == $selected_text) ? "selected" : "";
				else
					$selected_html = ($option['default_option']) ? "selected" : "";
				
				$html .= <<<EOS
			<option value="{$option['se_id']}" {$selected_html}>{$option['text']}</option>
EOS;
			}
			$html .= <<<EOS
        </select>
    </div>
EOS;
			break;
		default:
			$html = "";
			break;
	}

	print($html);

	$col_count += $element['cols'];

	if($col_count % 12 == 0) {
		$html = <<<EOS
    </div>
EOS;
		print($html);
	}

	if($key + 1 == sizeof($form['elements'])) {
		$html = <<<EOS
    <br><input type="submit" value="Submit">

</form>
EOS;
    if(!isset($_SESSION['mode'])) { ?><div class="g-recaptcha" data-sitekey="6Lfk0AQTAAAAANW4KIOuZsfwsY-cd0CrZKPf3dem"></div><?php }
		print($html);
	}
}

	$asterisk_string = "";
	if($element['description']) {
		$asterisk_count++;

		for($i = 0; $i < $asterisk_count; $i++)
			$asterisk_string .= "*";
	}


$asterisk_count = 0;
foreach($form['elements'] as $element) {
	if($element['description']) {
		$asterisk_count++;
		$asterisk_string = "";

		for($i = 0; $i < $asterisk_count; $i++)
			$asterisk_string .= "*";

		$html = <<<EOS
<br><small><sup>{$asterisk_string}</sup><em>{$element['description']}</em></small>
EOS;
		print($html);
	}
}

?>
<script type="text/javascript">
$('input[type=checkbox]').on('click', function() {
	var checkbox_name = $(this).attr("name");
	if(this.checked) {
		$('#hidden_' + checkbox_name ).attr("disabled", true);
	}
	else {
		$('#hidden_' + checkbox_name ).removeAttr("disabled");
	}
});
$('input[type=submit]').click(function(event) {
	$.each($('select'), function(index, value) {
		if($(value).attr("multiple") == "multiple") {
			var select_name = $(value).attr("name").slice(0, -2);
			if($(value).val()) {
				$('#hidden_' + select_name ).attr("disabled", true);
			}
			else {
				$('#hidden_' + select_name ).removeAttr("disabled");
			}
		}
	});
});
$('form').submit(function(event) {
	var success = true;

	$.each($('input'), function(index, input_element) {
		console.log($(input_element).attr("required"));
		if($(input_element).attr("required") == "required") {
			if($(input_element).val() == null || $(input_element).val() == "") {
//				$(input_element).focus();
				success = false;
			}
		}
	});

	if(!success) {
		alert("Please fill out required fields.");
	}
	
	return success;
});
</script>
<?php if(isset($_REQUEST['email'])) { ?>
<script type="text/javascript">
  var emailForm = document.getElementsByName('email');
  emailForm[0].value = "<?php print(htmlentities($_REQUEST['email'])); ?>";
 </script>
<?php } ?>

<?php include ( 'includes/footer.php'); ?>
