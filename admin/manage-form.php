<?php include ( '../includes/admin-header.php'); 
include( 'validate.php'); 
include ( '../includes/admin-sidebar.php'); 
?>

<div class="container">
    <div class="admin-content-wrapper">
        <h1 class="admin-page-title"><span class="fa fa-gear"></span>&nbsp;Manage Form</h1>

     
        
        <div class="row">
            <div class="twelve cols callout">
                <h2 class="callout-title">Update Form Labels <a href="#" class="add-event"><span class="fa fa-wrench"></span>&nbsp;Edit</a></h2>
                   <script>
                        $( "a.add-event" ).click(function() {  
                          $( "label" ).replaceWith( "<input type=\"text\" value=\"First Name\" class=\"full-width\">" );
                        });
                    </script>
                <form>
                <div class="row">
                    <div class="six cols">
                        <label>First Name<sup></sup>
                        </label>
                        <input class="full-width" type="text" disabled />
                    </div>
                    <div class="four cols">
                        <label for="lastname">Last Name<sup></sup>
                        </label>
                        <input class="full-width" type="text" disabled />
                    </div>
                    <div class="two cols">
                        <label for="age">Age<sup>*</sup>
                        </label>
                        <input class="full-width" type="text" disabled />
                    </div>
                </div>
                <div class="row">
                    <div class="seven cols">
                        <label for="email">Email<sup></sup>
                        </label>
                        <input class="full-width" type="text" disabled />
                    </div>
                    <div class="five cols">
                        <label for="phone">Phone<sup></sup>
                        </label>
                        <input class="full-width" type="text" disabled />
                    </div>
                </div>
                <div class="row">
                    <div class="nine cols">
                        <label for="address1">Address<sup></sup>
                        </label>
                        <input class="full-width" type="text" disabled />
                    </div>
                    <div class="three cols">
                        <label for="address2">Apt/Suite/Floor<sup></sup>
                        </label>
                        <input class="full-width" type="text" disabled />
                    </div>
                </div>
                <div class="row">
                    <div class="seven cols">
                        <label for="city">City<sup></sup>
                        </label>
                        <input class="full-width" type="text" disabled />
                    </div>
                    <div class="two cols">
                        <label for="state">State</label>
                        <input class="full-width" type="text" disabled />
                    </div>
                    <div class="three cols">
                        <label for="postalcode">ZIP<sup></sup>
                        </label>
                        <input class="full-width" type="text" disabled />
                    </div>
                </div>
                <div class="row">
                    <div class="twelve cols">
                        <label for="skills">Home Repair Skills</label>
                        <input class="full-width" type="text" disabled />
                    </div>
                </div>
                <div class="row">
                    <div class="twelve cols">
                        <label for="future_interest" style="display:inline">Click here to receive information about future volunteer events</label>
                        <input type="checkbox" checked disabled />
                    </div>
                </div>
                <input type="submit" value="Update" class="right m-full-width">

                </form>
            </div>
        </div>

              <div class="row">
            <div class="twelve cols callout">
                <h2 class="callout-title">Update Waiver Text</h2>
                <form>
                    <textarea class="full-width">Prefilled with the current waiver text</textarea>
                    <input type="submit" value="Update" class="right m-full-width">
                </form>
            </div>
        </div>
        
        <div class="clear"></div>

    </div>

    <?php include ( '../includes/footer.php'); ?>