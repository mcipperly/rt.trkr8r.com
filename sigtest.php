<html>
<head>
	<title>Signature Test Page</title>
	<link rel="stylesheet" href="signature.css">
</head>
<body>
	<div id="signature-pad" class="signature-pad-box">
		<div class="signature-pad-body">
			<canvas></canvas>
		</div>
		<div class="signature-pad-footer">
			<div class="description">Please Sign</div>
			<form name="signature-pad" action="capture-signature.php" method="POST">
				<button class="button clear" data-action="clear">Clear</button>
				<input type="hidden" id="signature-b64" name="signature-b64" value=""></input>
				<input type="submit" class="button save" value="save" data-action="save"></input>
			</form>
		</div>
	</div>
	<script src="signature_pad.js"></script>
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
        alert("Signature is required!");
    } else {
	var siginput = document.getElementById('signature-b64');
	siginput.setAttribute('value', signaturePad.toDataURL());
    }
});


        </script>

</body>
</html>
