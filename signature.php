<?php include ( 'includes/header.php'); ?>

<div class="row interior-header">
    <div class="eight cols">
        <h1>Confirm Your Details</h1>
    </div>

    <div class="four cols">
        <img src="assets/imgs/rt-logo_small.png" class="right">
    </div>
</div>
<div class="clear"></div>

<div class="row">
    <div class="six cols">
        <p>Details here!</p>
    </div>
    <div class="six cols">
        <p>Details here!</p>
    </div>

</div>

<h2>Waiver of Liability</h2>
<p class="justify">Text</p>

<h2>Media Release</h2>
<p class="justify">Text</p>

<h2>Your Signature</h2>
<p>By signing below, you confirm that your details listed above are accurate. You also accept our Waiver of Liability and Media Release terms.</p>

<div id="signature-pad" class="signature-pad-box">
    <div class="signature-pad-body">
        <canvas></canvas>
    </div>

</div>

<div class="signature-pad-footer">
    <form name="signature-pad" action="capture-signature.php" method="POST">
        <button class="button clear" data-action="clear">Clear</button>
        <input type="hidden" id="signature-b64" name="signature-b64" value=""></input>
        <input type="submit" class="button save" value="save" data-action="save"></input>
    </form>
</div>

<script src="assets/js/signature_pad.js"></script>
<script type="text/javascript">
    var wrapper = document.getElementById("signature-pad"),
        clearButton = wrapper.querySelector("[data-action=clear]"),
        saveButton = wrapper.querySelector("[data-action=save]"),
        canvas = wrapper.querySelector("canvas"),
        signaturePad;
    function resizeCanvas() {
        var ratio = window.devicePixelRatio || 1;
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
    }
    window.onresize = resizeCanvas;
    resizeCanvas();
    signaturePad = new SignaturePad(canvas);
    clearButton.addEventListener("click", function(event) {
        signaturePad.clear();
    });
    saveButton.addEventListener("click", function(event) {
        if (signaturePad.isEmpty()) {
            alert("Signature is required!");
        } else {
            var siginput = document.getElementById('signature-b64');
            siginput.setAttribute('value', signaturePad.toDataURL());
        }
    });
</script>

<?php include ( 'includes/footer.php'); ?>
