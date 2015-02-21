<?php include ( 'includes/header.php'); ?>

<div class="interior-header">
    <img src="assets/imgs/rt-logo_small.png" class="left">
</div>
<div class="clear"></div>

<h1>Register</h1>

<form>
    <div class="row">
        <div class="six cols">
            <label for="lastname">Last Name</label>
            <input class="full-width" type="text" placeholder="" name="lastname">
        </div>
        <div class="six cols">
            <label for="firstname">First Name</label>
            <input class="full-width" type="text" placeholder="" name="firstname">
        </div>
    </div>

    <div class="row">
        <div class="twelve cols">
            <label for="address1">Home Address</label>
            <input class="full-width" type="text" placeholder="" name="address1">
            <input class="full-width" type="text" placeholder="" name="address2">
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
                <input type="text"  class="full-width" name="postalcode">
            </div>
        </div>

    </div>

</form>


</div>


<?php include ( 'includes/footer.php'); ?>