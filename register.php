<?php include ( 'includes/header.php'); ?>
<?php require_once( 'db/db.php'); ?>

<?php if(isset($_COOKIE[ 'onsite']) && validate_onsite($_COOKIE[ 'onsite'])) { if(isset($_REQUEST[ 'email']) && validate_volunteer_email($_REQUEST[ 'email'])) { ?>
<form name="registered" action="signature.php" method="POST">
    <input type="hidden" name="email" value="">
</form>
<script type="text/javascript">
    window.onload = function() {
        document.registered.submit();
    }
</script>
<?php } else { $submit_url="capture-register.php" ; } } else { $submit_url="capture-register.php" ; } ?>


<div class="row interior-header">
    <div class="eight cols">
        <h1>Register</h1>
    </div>

    <div class="four cols">
        <img src="assets/imgs/rt-logo_small.png" class="right">
    </div>
</div>
<div class="clear"></div>

<form action="<?php print($submit_url); ?>" method="POST">
    <div class="row">
        <div class="six cols">
            <label for="lastname">First Name</label>
            <input class="full-width" type="text" placeholder="" name="firstname">
        </div>
        <div class="four cols">
            <label for="firstname">Last Name</label>
            <input class="full-width" type="text" placeholder="" name="lastname">
        </div>

        <div class="two cols">
            <label for="age">Age<sup class="sml">*</sup>
            </label>
            <input class="full-width" type="text" placeholder="" name="age">
        </div>

    </div>

    <div class="row">
        <div class="four cols">
            <label for="email">Email</label>
            <input class="full-width" type="email" placeholder="" name="email" <?php if(isset($_REQUEST[ 'email'])) print( "value='".$_REQUEST[ 'email']. "'"); ?>>
        </div>
        <div class="three cols">
            <label for="phone">Phone</label>
            <input class="full-width" type="text" placeholder="" name="phone">
        </div>
        <div class="five cols">
            <label for="company">Affiliation or Company</label>
            <input class="full-width" type="text" placeholder="" name="company">
        </div>
    </div>



    <div class="row">
        <div class="nine cols">
            <label for="address1">Address</label>
            <input class="full-width" type="text" placeholder="" name="address1">
        </div>
        <div class="three cols">

            <label for="address2">Apt/Suite/Floor</label>
            <input class="full-width" type="text" placeholder="" name="address2">
        </div>
    </div>

    <div class="row">
        <div class="seven cols">
            <label for="ciry">City</label>
            <input class="full-width" type="text" placeholder="" name="city">
        </div>
        <div class="two cols">
            <label for="state">State</label>
            <select class="full-width" name="state">
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
                <option value="PA">PA</option>
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
        <div class="three cols">
            <label for="postalcode">Zip</label>
            <input type="text" class="full-width" name="postalcode">
        </div>
    </div>
    <script src="assets/js/add_inputs.js"></script>

    <div class="row">
        <div class="twelve cols">
            <label for="skills">Please List Any Home Repair Skills</label>
            
            <div class="multi-field-wrapper">
                <div class="multi-fields">
                    <div class="multi-field">
                        <input type="text" name="stuff[]">
                        <button type="button" class="remove-field">Remove</button>
                    </div>
                </div>
                <button type="button" class="add-field">Add field</button>
            </div>
            
        </div>

        <div class="row">
            <div class="twelve cols">
                <label for="future_interest">Are you interested in receiving information about future volunteer opportunities?</label>
                <input type="checkbox"><span class="label-body">&nbsp;Yes</span>
                <span style="padding-left: 20px;"><input type="checkbox"><span class="label-body">&nbsp;No</span></span>

            </div>
        </div>

        <input type="submit" value="Submit">

</form>

<p class="sml"><sup>*</sup><em>If you are under 18 years of age you must also complete a Parental Permission Form</em>
</p>


<?php include ( 'includes/footer.php'); ?>