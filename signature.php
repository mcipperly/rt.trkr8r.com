<?php include ( 'includes/header.php'); 
require_once('db/db.php');
$form_responses = get_form_responses($_GET['vid']);
$volunteer_info = get_volunteer_info($_GET['vid']);
?>

<?php

$elements = get_form_elements();
$responses = get_form_responses($_GET['vid']);

$col_count = 0;
foreach($elements as $key => $element) {
	if($key == 0) {
		$html = <<<EOS
<div class="row interior-header">
    <div class="eight cols">
        <h1>Confirmation</h1>
    </div>

    <div class="four cols">
        <img src="assets/imgs/rt-logo_small.png" class="right">
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
	
	switch($element['type']) {
		case "text":
			$html = <<<EOS
        <div class="{$cols} cols">
            <label for="{$element['name']}">{$element['label']}</label>
            <span class="full-width" name="{$element['name']}"></span>
		</div>
EOS;
			break;
		case "checkbox":
			
			$html = <<<EOS
        <div class="{$cols} cols">
            <label for="{$element['name']}" style="display:inline">{$element['label']}</label>
			<input type="{$element['type']}" name="{$element['name']} value="1" {$required_html}/>
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

?>

<div class="row interior-header">
    <div class="eight cols">
        <h1>Confirmation</h1>
    </div>

    <div class="four cols">
        <img src="assets/imgs/rt-logo_small.png" class="right">
    </div>
</div>
<div class="clear"></div>
<div class="details">
    <h3>Details</h3>
    <div class="row">

    <?php print_r($form_responses); foreach($form_elements as $element) {
      foreach($form_responses as $response) {
        if($response['name'] == $element['name']) {
?>    <div class="six cols">
            <p><?php print($element['label'] . ": " . $response['value']); ?></p>
        </div>
    <?php } } } ?>

    </div>

    <h3>Waiver of Liability</h3>
    <p class="justify">In consideration of the opportunity afforded me to assist on a voluntary basis with Rebuilding Together Pittsburgh, a project in which the homes of disadvantaged persons will be repaired by volunteers, and in light of the aims and purposes of the community service provided by Rebuilding Together Pittsburgh in organizing this project from which any liability may or could accrue against Rebuilding Together Pittsburgh, or any of their respective officers and directors collectively or individually or any project homeowners. Without limiting the generality of the foregoing, I agree that this waiver and release shall include any rights, claims, or causes of action resulting from personal injury to me or damage to my property sustained in connection with any activities in a Rebuilding Together Pittsburgh event or project.</p>

    <h3>Media Release</h3>
    <p class="justify">I understand that photographs and/or videotapes may be taken of me during workday. I hereby assign and authorize Rebuilding Together Pittsburgh to use these photographs and/or videotapes for publicity purposes. I, therefore, release and discharge all parties associated with Rebuilding Together Pittsburgh, its agents, servants, and employees from any liability, which may arise now or in the future or develop from such activity as described.</p>
</div>

<h2>Your Signature</h2>
<p>By signing below, you confirm that your details listed above are accurate. You also accept our Waiver of Liability and Media Release terms.</p>
<div class="row">
    <div class="six cols">
        <p>Name: <?php print($volunteer_info['firstname']['value'] . ' ' . $volunteer_info['lastname']['value']); ?></p>
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
    <button data-action="clear">Clear</button>
    <button data-action="save">Save</button>
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

<?php include ( 'includes/footer.php'); ?>
