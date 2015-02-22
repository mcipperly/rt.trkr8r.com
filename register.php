<?php
require_once('db/db.php'); 
session_start(); 
$volunteer_id = validate_volunteer_email($_REQUEST['email']);
if(isset($_REQUEST['email']) && $volunteer_id && !$_REQUEST['edit'] && isset($_SESSION['mode'])) {
  Header("HTTP/1.1 302 Moved Temporarily");
  Header("Location: signature.php?vid=" . $volunteer_id);
} 
include ('includes/header.php'); 

function get_response($response) {
	global $search_element_id;
	return ($response['element_id'] == $search_element_id);
}

$elements = get_form_elements();
if($volunteer_id)
	$responses = get_form_responses($volunteer_id);

$col_count = 0;
$asterisk_count = 0;
foreach($elements as $key => $element) {
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

<form action="capture-register.php" method="POST">
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
	$filtered_responses = array_filter($responses, 'get_response');

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
			if($element['plural']) {
				$skills_array = explode("; ", $value);
				$value = "";
				$class_html = "";
				$plural_html_a = <<<EOS
            <div class="multi-field-wrapper">
                <div class="multi-fields">
                    <div class="multi-field">
EOS;
				$plural_html_b = "[]";
				$plural_html_c = <<<EOS
                        <button type="button" class="remove-field no-min">Remove</button>
                    </div>
                </div><button type="button" id="add" class="add-field no-min">Add More Skills</button>
            </div>
            <script src="assets/js/add_inputs.js"></script>
EOS;
			}
			else {
				$class_html = "full-width";
				$plural_html_a = $plural_html_b = $plural_html_c = "";
			}
			$html = <<<EOS
        <div class="{$cols} cols">
            <label for="{$element['name']}">{$element['label']}<sup class="sml">{$asterisk_string}</sup></label>
{$plural_html_a}
            <input class="{$class_html}" type="{$element['type']}" placeholder="" name="{$element['name']}{$plural_html_b}"{$required_html} value="{$value}" />
{$plural_html_c}
			</div>
EOS;
			break;
		case "checkbox":
			$checked_html = ($value == "Yes" || !isset($value)) ? "checked" : ""; 
			$html = <<<EOS
        <div class="{$cols} cols">
            <label for="{$element['name']}" style="display:inline">{$element['label']}</label>
			<input type="{$element['type']}" name="{$element['name']}" value="1" {$required_html} {$checked_html} />
        </div>
EOS;
			break;
		case "select":
			$state_id = $value;
			$html = <<<EOS
        <div class="{$cols} cols">
            <label for="{$element['name']}">{$element['label']}</label>
            <select class="full-width" name="{$element['name']}">
                <option value="PA" id="PA">PA</option>
                <option value="AL" id="AL">AL</option>
                <option value="AK" id="AK">AK</option>
                <option value="AZ" id="AZ">AZ</option>
                <option value="AR" id="AR">AR</option>
                <option value="CA" id="CA">CA</option>
                <option value="CO" id="CO">CO</option>
                <option value="CT" id="CT">CT</option>
                <option value="DE" id="DE">DE</option>
                <option value="DC" id="DC">DC</option>
                <option value="FL" id="FL">FL</option>
                <option value="GA" id="GA">GA</option>
                <option value="HI" id="HI">HI</option>
                <option value="ID" id="ID">ID</option>
                <option value="IL" id="IL">IL</option>
                <option value="IN" id="IN">IN</option>
                <option value="IA" id="IA">IA</option>
                <option value="KS" id="KS">KS</option>
                <option value="KY" id="KY">KY</option>
                <option value="LA" id="LA">LA</option>
                <option value="ME" id="ME">ME</option>
                <option value="MD" id="MD">MD</option>
                <option value="MA" id="MA">MA</option>
                <option value="MI" id="MI">MI</option>
                <option value="MN" id="MN">MN</option>
                <option value="MS" id="MS">MS</option>
                <option value="MO" id="MO">MO</option>
                <option value="MT" id="MT">MT</option>
                <option value="NE" id="NE">NE</option>
                <option value="NV" id="NV">NV</option>
                <option value="NH" id="NH">NH</option>
                <option value="NJ" id="NJ">NJ</option>
                <option value="NM" id="NM">NM</option>
                <option value="NY" id="NY">NY</option>
                <option value="NC" id="NC">NC</option>
                <option value="ND" id="ND">ND</option>
                <option value="OH" id="OH">OH</option>
                <option value="OK" id="OK">OK</option>
                <option value="OR" id="OR">OR</option>
                <option value="RI" id="RI">RI</option>
                <option value="SC" id="SC">SC</option>
                <option value="SD" id="SD">SD</option>
                <option value="TN" id="TN">TN</option>
                <option value="TX" id="TX">TX</option>
                <option value="UT" id="UT">UT</option>
                <option value="VT" id="VT">VT</option>
                <option value="VA" id="VA">VA</option>
                <option value="WA" id="WA">WA</option>
                <option value="WV" id="WV">WV</option>
                <option value="WI" id="WI">WI</option>
                <option value="WY" id="WY">WY</option>
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

	if($key + 1 == sizeof($elements)) {
		$html = <<<EOS
    <input type="submit" value="Submit">

</form>
EOS;
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
foreach($elements as $element) {
	if($element['description']) {
		$asterisk_count++;
		$asterisk_string = "";

		for($i = 0; $i < $asterisk_count; $i++)
			$asterisk_string .= "*";
		
		$html = <<<EOS
<p class="sml"><sup>{$asterisk_string}</sup><em>{$element['description']}</em></p>
EOS;
		print($html);
	}
}

?>
<?php if(isset($_REQUEST['email'])) { ?>
<script type="text/javascript">
  var emailForm = document.getElementsByName('email');
  emailForm[0].value = "<?php print(htmlentities($_REQUEST['email'])); ?>";

  var stateElement = document.getElementById('<?php print(htmlentities($state_id)) ?>');
  stateElement.selected = 'selected';
  
  var addButton = document.getElementById('add');
  <?php
	for($i = 0; $i < sizeof($skills_array); $i++) {
		if($i != 0)
			echo "addButton.click();\n";
		echo "document.getElementsByName('skills[]')[{$i}].value='{$skills_array[$i]}';\n";
	}
  ?>
  
 </script>
<?php } ?>

<?php include ( 'includes/footer.php'); ?>
