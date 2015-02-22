<?php include ('../includes/header.php'); ?>

<div class="row interior-header">

    <div class="visible-phone">
        <div class="four cols sml-logo">
            <img src="../assets/imgs/rt-logo.png">
        </div>

        <div class="eight cols">
            <h1>Admin <br><span>Export Cutomized .CSV</span></h1>
        </div>
    </div>

    <div class="hidden-phone">
        <div class="eight cols">
            <h1 class="left">Admin <span>Export Cutomized .CSV</span></h1>
        </div>

        <div class="four cols">
            <img src="../assets/imgs/rt-logo_small.png" class="right">
        </div>
    </div>
</div>
<div class="clear"></div>
<h4><a href="/admin/">&laquo; Back to Admin Page</a></h4>

<h2>Select Details</h2>
<input type="text" id="datepicker">

<form style="margin-top:30px">
    <div class="row">
        <div class="three cols">
        <input type="checkbox"> First Name
        </div>
        <div class="three cols">
        <input type="checkbox"> Last Name
        </div>
        <div class="three cols">
        <input type="checkbox"> Email
        </div>
        <div class="three cols">
        <input type="checkbox"> Phone
        </div>
    </div>
    
    <div class="row">
        <div class="three cols">
        <input type="checkbox"> Age
        </div>
        <div class="three cols">
        <input type="checkbox"> Affiliation or Company
        </div>
        <div class="three cols">
        <input type="checkbox"> Skills
        </div>
        <div class="three cols">
        <input type="checkbox"> Future Interest
        </div>
    </div>
    
    <div class="row">
        <div class="two cols">
        <input type="checkbox"> Address
        </div>
        <div class="two cols">
        <input type="checkbox"> Apt/Suite/Floor
        </div>
        <div class="two cols">
        <input type="checkbox"> City
        </div>
        <div class="two cols">
        <input type="checkbox"> State
        </div>
        <div class="two cols">
        <input type="checkbox"> ZIP
        </div>
        <div class="two cols">
        </div>
    </div>
        
</form>

<?php include ('../includes/footer.php'); ?>