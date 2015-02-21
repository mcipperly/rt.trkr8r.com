<?php include ( 'includes/header.php'); ?>

<div class="interior-header">
    <img src="assets/imgs/rt-logo_small.png" class="left">
</div>

<h1 class="center">Register</h1>

<form>
  <div class="row">
    <div class="six cols">
      <label for="exampleEmailInput">Your email</label>
      <input class="full-width" type="email" placeholder="test@mailbox.com" id="exampleEmailInput">
    </div>
    <div class="six cols">
      <label for="exampleRecipientInput">Reason for contacting</label>
      <select class="full-width" id="exampleRecipientInput">
        <option value="Option 1">Questions</option>
        <option value="Option 2">Admiration</option>
        <option value="Option 3">Can I get your number?</option>
      </select>
    </div>
  </div>
  <label for="exampleMessage">Message</label>
  <textarea class="full-width" placeholder="Hi Dave …" id="exampleMessage"></textarea>
  <label class="example-send-yourself-copy">
    <input type="checkbox">
    <span class="label-body">Send a copy to yourself</span>
  </label>
  <input class="button" type="submit" value="Submit">
</form>

</div>


<?php include ( 'includes/footer.php'); ?>