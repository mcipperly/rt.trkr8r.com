<?php
include ('../includes/admin-header.php'); 
include('validate.php');
include ('../includes/admin-sidebar.php'); 
?>

<div class="container">
<div class="admin-content-wrapper">

<h1>Dashboard</h1>
    
<div class="row">
    <div class="four cols callout">
        <p class="number">2500</p>
        <p class="text"><span class="fa fa-user"></span> Volunteers in the Last Month</p>
    </div>

    <div class="four cols callout">
        <p class="number">2500</p>
        <p class="text"><span class="fa fa-user"></span> Volunteers in the Last Year</p>
    </div>  
    
    <div class="four cols callout">
        <p class="number">2500</p>
        <p class="text"><span class="fa fa-user"></span> Volunteer Hours to Date</p>
    </div> 
    <div class="clear"></div>
</div>

<div class="row">
    <div class="six cols">
    <h2>Active Events</h2>
        <ul class="list-group">
            <li>Item</li>
            <li>Item</li>
            <li>Item</li>
            <li>Item</li>
            <li>Item</li>
        </ul>
    </div>   
    
    <div class="six cols">
    <h2>Active Forms</h2>
        <ul class="list-group">
            <li>Item</li>
            <li>Item</li>
            <li>Item</li>
            <li>Item</li>
            <li>Item</li>
        </ul>
    </div>    
</div>   

    </div>

<?php include ('../includes/footer.php'); ?>
