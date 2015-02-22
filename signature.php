<?php 
include('includes/header.php'); 
require_once('db/db.php');
if(!isset($_COOKIE['onsite']) || !validate_user($_COOKIE['onsite'])) {
  Header("HTTP/1.1 302 Moved Temporarily");
  Header("Location: /index.php?thanks=2");
} 
$form_responses = get_form_responses($_GET['vid']);
$volunteer_info = get_volunteer_info($_GET['vid']);
?>

<?php

function get_response($response) {
	global $search_element_id;
	return ($response['element_id'] == $search_element_id);
}

$elements = get_form_elements();
$responses = get_form_responses($_GET['vid']);

$col_count = 0;
foreach($elements as $key => $element) {
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
    <h3>Details</h3>
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

	if($key + 1 == sizeof($elements)) {
		if($_REQUEST['view'])
			$html = "<br />";
		else
			$html = <<<EOS
        <a href="register.php?edit=1&email={$volunteer_info['email']}">
            <button class="no-min">Make Changes</button>
        </a>
EOS;
		$html .= <<<EOS
    <h3>Waiver of Liability</h3>
    <p class="justify">In consideration of the opportunity afforded me to assist on a voluntary basis with Rebuilding Together Pittsburgh, a project in which the homes of disadvantaged persons will be repaired by volunteers, and in light of the aims and purposes of the community service provided by Rebuilding Together Pittsburgh in organizing this project from which any liability may or could accrue against Rebuilding Together Pittsburgh, or any of their respective officers and directors collectively or individually or any project homeowners. Without limiting the generality of the foregoing, I agree that this waiver and release shall include any rights, claims, or causes of action resulting from personal injury to me or damage to my property sustained in connection with any activities in a Rebuilding Together Pittsburgh event or project.</p>

    <h3>Media Release</h3>
    <p class="justify">I understand that photographs and/or videotapes may be taken of me during workday. I hereby assign and authorize Rebuilding Together Pittsburgh to use these photographs and/or videotapes for publicity purposes. I, therefore, release and discharge all parties associated with Rebuilding Together Pittsburgh, its agents, servants, and employees from any liability, which may arise now or in the future or develop from such activity as described.</p>
</div>
EOS;
		print($html);
	}
}

?>

<h2>Your Signature</h2>
<p>By signing below, you confirm that your details listed above are accurate. You also accept our Waiver of Liability and Media Release terms.</p>
<div class="row">
    <div class="six cols">
        <p>Name: <?php print($volunteer_info['firstname'] . ' ' . $volunteer_info['lastname']); ?></p>
    </div>
    <div class="six cols">
        <p>Date: <?php print(date('F jS, Y')); ?></p>
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
        <input type="hidden" name="firstname" value="<?php print($volunteer_info['firstname']['value']); ?>"></input>
        <input type="hidden" name="lastname" value="<?php print($volunteer_info['lastname']['value']); ?>"></input>
        <input type="hidden" name="vid" value="<?php print($_GET['vid']); ?>"></input>
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

<?php include ('includes/footer.php'); ?>
