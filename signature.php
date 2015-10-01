<?php 
include('includes/header.php'); 
require_once('db/db.php');

if(!isset($_SESSION['mode'])) {
  Header("HTTP/1.1 302 Moved Temporarily");
  Header("Location: /index.php?thanks=2");
} 

$volunteer_info = get_volunteer_info($_GET['vid']);

if($_REQUEST['event_id']) {
	$event = get_event($_REQUEST['event_id']);
}
else {
	$search['date'] = date("Y-m-d");
	$todays_events = get_events($search);

	$event = $todays_events[0];
}

function get_response($response) {
	global $search_element_id;
	return ($response['element_id'] == $search_element_id);
}

$form_id = 1; //Hard-coded for now, until ability to choose forms is available
$form = get_form($form_id);

$responses = get_form_responses($_GET['vid'], $form_id);

$col_count = 0;
foreach($form['elements'] as $key => $element) {
	if($key == 0) {
		$html = <<<EOS
<div class="row interior-header">

    <div class="visible-phone">
        <div class="four cols sml-logo">
            <img src="assets/imgs/rt-logo.png">
        </div>

        <div class="eight cols">
            <h1>Confirmation</h1>
        </div>
    </div>

    <div class="hidden-phone">
        <div class="eight cols">
            <h1 class="left">Confirmation</h1>
        </div>
        
        <div class="four cols">
            <img src="assets/imgs/rt-logo_small.png" class="right">
        </div>
    </div>
</div>
<div class="clear"></div>
<div class="details">
    <h2>Details</h2>
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
	
	$search_element_id = $element['element_id'];
	$filtered_responses = array_filter($responses, 'get_response');

	if($filtered_responses)
		$this_response = array_shift($filtered_responses);
	else
		$this_response = array();
	
	if($element['type'] == "checkbox")
		$value = ($this_response['value']) ? "Yes" : "No";
	else
		$value = $this_response['value'];
	$html = <<<EOS
        <div class="{$cols} cols">
            <label for="{$element['name']}">{$element['label']}</label>
			<span class="full-width" name="{$element['name']}">{$value}</span>
		</div>
EOS;
	
	print($html);
	
	$col_count += $element['cols'];
	
	if($col_count % 12 == 0) {
		$html = <<<EOS
    </div>
EOS;
		print($html);
	}

	if($key + 1 == sizeof($form['elements'])) {
		if($_REQUEST['view'])
			$html = "<br />";
		else
			$html = <<<EOS
        <a href="register.php?edit=1&email={$volunteer_info['email']}">
            <button>Make Changes</button>
        </a>
EOS;
		$html .= <<<EOS
    <br><br><h2>Waiver of Liability</h2>
    <p class="justify">In consideration of the opportunity afforded me to assist on a voluntary basis with Rebuilding Together Pittsburgh, a project in which the homes of disadvantaged persons will be repaired by volunteers, and in light of the aims and purposes of the community service provided by Rebuilding Together Pittsburgh in organizing this project from which any liability may or could accrue against Rebuilding Together Pittsburgh, or any of their respective officers and directors collectively or individually or any project homeowners. Without limiting the generality of the foregoing, I agree that this waiver and release shall include any rights, claims, or causes of action resulting from personal injury to me or damage to my property sustained in connection with any activities in a Rebuilding Together Pittsburgh event or project.</p>

    <h2>Media Release</h2>
    <p class="justify">I understand that photographs and/or videotapes may be taken of me during workday. I hereby assign and authorize Rebuilding Together Pittsburgh to use these photographs and/or videotapes for publicity purposes. I, therefore, release and discharge all parties associated with Rebuilding Together Pittsburgh, its agents, servants, and employees from any liability, which may arise now or in the future or develop from such activity as described.</p>
</div>
EOS;
		print($html);
	}
}


if($_REQUEST['view']) {
	$signature_info = get_volunteer_signature($_GET['vid'], $event['event_id']);
	$signature_date = date("F jS, Y", strtotime($signature_info['signature_date']));
	$html = <<<EOS
<h2>Signature On File</h2>
<div class="row">
    <div class="six cols">
        <p><em>Name: {$volunteer_info['firstname']} {$volunteer_info['lastname']}</em></p>
    </div>
    <div class="six cols">
        <p><em>Date: {$event['date']}</em></p>
    </div>
</div>
<div class="row">
	<div class="twelve cols">
		<img src="signatures/{$signature_info['signature_file_name']}" />
	</div>
</div>
<button onclick="window.print();" class="no-min">Print</button>
EOS;
	print($html);
}
else {
	$signature_date = date("F jS, Y");
	$html = <<<EOS
<h2>Your Signature</h2>
<p>By signing below, you confirm that your details listed above are accurate. You also accept our Waiver of Liability and Media Release terms.</p>
<div class="row">
    <div class="six cols">
        <p><em>Name: {$volunteer_info['firstname']} {$volunteer_info['lastname']}</em></p>
    </div>
    <div class="six cols">
        <p><em>Date: {$signature_date}</em></p>
    </div>
</div>
<div id="signature-pad" class="signature-pad-box">
    <div class="signature-pad-body">
        <canvas></canvas>
    </div>
<div class="signature-pad-footer">
    <button data-action="clear" class="no-min">Clear</button>
    <button data-action="save" class="no-min">Save</button>
    <form name="signaturepad" action="capture-signature.php" method="POST">
        <input type="hidden" name="firstname" value="{$volunteer_info['firstname']}"></input>
        <input type="hidden" name="lastname" value="{$volunteer_info['lastname']}"></input>
        <input type="hidden" name="vid" value="{$_GET['vid']}"></input>
		<input type="hidden" name="event_id" value="{$event['event_id']}"></input>
        <input type="hidden" id="signature-b64" name="signature-b64" value=""></input>
    </form>
</div>
</div>

<script src="assets/js/signature_pad.js"></script>
<script type="text/javascript">
var wrapper = document.getElementById("signature-pad"),
    clearButton = wrapper.querySelector("[data-action=clear]"),
    saveButton = wrapper.querySelector("[data-action=save]"),
    canvas = wrapper.querySelector("canvas"),
    signaturePad;
function resizeCanvas() {
    var ratio =  window.devicePixelRatio || 1;
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
}
window.onresize = resizeCanvas;
resizeCanvas();
signaturePad = new SignaturePad(canvas);
clearButton.addEventListener("click", function (event) {
    signaturePad.clear();
});
saveButton.addEventListener("click", function (event) {
    if (signaturePad.isEmpty()) {
        vex.dialog.alert('Please complete the signature field');
    } else {
        var siginput = document.getElementById('signature-b64');
        siginput.setAttribute('value', signaturePad.toDataURL());
        document.signaturepad.submit();
    }
});
</script>
EOS;
	print($html);
}

?>


<?php include ('includes/footer.php'); ?>
