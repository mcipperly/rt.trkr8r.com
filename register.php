<?php
require_once('db/db.php'); 
 
// if(isset($_COOKIE['onsite']) && validate_onsite($_COOKIE['onsite'])) {
	$volunteer_id = validate_volunteer_email($_REQUEST['email']);
  if(isset($_REQUEST['email']) && $volunteer_id) {
    Header("HTTP/1.1 302 Moved Temporarily");
    Header("Location: signature.php?vid=" . $volunteer_id);
//  } 
} 
include ( 'includes/header.php'); 

$elements = get_form_elements();
if($volunteer_id)
	$responses = get_form_responses($volunteer_id);

$col_count = 0;
$asterisk_count = 0;
foreach($elements as $key => $element) {
	if($key == 0) {
		$html = <<<EOS
<div class="interior-header">
        <h1 class="left">Register</h1>
        <img src="assets/imgs/rt-logo_small.png" class="right">
    <div class="clear"></div>
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

	$required_html = ($element['required']) ? " required" : "";
	
	switch($element['type']) {
		case "text":
			if($element['plural']) {
				$class_html = "";
				$plural_html_a = <<<EOS
            <div class="multi-field-wrapper">
                <div class="multi-fields">
                    <div class="multi-field">
EOS;
				$plural_html_b = "[]";
				$plural_html_c = <<<EOS
                        <button type="button" class="remove-field">Remove</button>
                    </div>
                </div><button type="button" class="add-field">Add More Skills</button>
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
            <input class="{$class_html}" type="{$element['type']}" placeholder="" name="{$element['name']}{$plural_html_b}"{$required_html}>
{$plural_html_c}
			</div>
EOS;
			break;
		case "checkbox":
			$html = <<<EOS
        <div class="{$cols} cols">
            <label for="{$element['name']}" style="display:inline">{$element['label']}</label>
			<input type="{$element['type']}" name="{$element['name']} value="1" {$required_html} checked />
        </div>
EOS;
			break;
		case "select":
			$html = <<<EOS
        <div class="{$cols} cols">
            <label for="{$element['name']}">{$element['label']}</label>
            <select class="full-width" name="{$element['name']}">
                <option value="PA">PA</option>
                <option value="AL">AL</option>
                <option value="AK">AK</option>
                <option value="AZ">AZ</option>
                <option value="AR">AR</option>
                <option value="CA">CA</option>
                <option value="CO">CO</option>
                <option value="CT">CT</option>
                <option value="DE">DE</option>
                <option value="DC">DC</option>
                <option value="FL">FL</option>
                <option value="GA">GA</option>
                <option value="HI">HI</option>
                <option value="ID">ID</option>
                <option value="IL">IL</option>
                <option value="IN">IN</option>
                <option value="IA">IA</option>
                <option value="KS">KS</option>
                <option value="KY">KY</option>
                <option value="LA">LA</option>
                <option value="ME">ME</option>
                <option value="MD">MD</option>
                <option value="MA">MA</option>
                <option value="MI">MI</option>
                <option value="MN">MN</option>
                <option value="MS">MS</option>
                <option value="MO">MO</option>
                <option value="MT">MT</option>
                <option value="NE">NE</option>
                <option value="NV">NV</option>
                <option value="NH">NH</option>
                <option value="NJ">NJ</option>
                <option value="NM">NM</option>
                <option value="NY">NY</option>
                <option value="NC">NC</option>
                <option value="ND">ND</option>
                <option value="OH">OH</option>
                <option value="OK">OK</option>
                <option value="OR">OR</option>
                <option value="RI">RI</option>
                <option value="SC">SC</option>
                <option value="SD">SD</option>
                <option value="TN">TN</option>
                <option value="TX">TX</option>
                <option value="UT">UT</option>
                <option value="VT">VT</option>
                <option value="VA">VA</option>
                <option value="WA">WA</option>
                <option value="WV">WV</option>
                <option value="WI">WI</option>
                <option value="WY">WY</option>
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
</script>
<?php } ?>

<?php include ( 'includes/footer.php'); ?>
